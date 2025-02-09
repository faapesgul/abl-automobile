<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class BasicAuthFilter implements FilterInterface
{
    /**
     * Memeriksa Basic Authentication
     *
     * @param list<string>|null $arguments
     *
     * @return ResponseInterface|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil header Authorization
        $authHeader = $request->getHeaderLine('Authorization');
        if (empty($authHeader) || substr($authHeader, 0, 5) !== 'Basic') {
            return Services::response()->setStatusCode(401)
                ->setHeader('WWW-Authenticate', 'Basic realm="Restricted Area"')
                ->setJSON(['status' => 'failed', 'error' => 'Invalid Basic Auth']);
        }

        // Ambil dan decode kredensial
        $encodedCredentials = substr($authHeader, 6); // Menghapus 'Basic ' dari string
        $decodedCredentials = base64_decode($encodedCredentials);
        list($username, $password) = explode(':', $decodedCredentials);

        // Validasi kredensial
        if (!$this->isValidCredentials($username, $password)) {
            return Services::response()->setStatusCode(401)
                ->setJSON(['status' => 'failed', 'error' => 'Invalid basic auth (username or password)']);
        }

        return true; // Basic Auth valid
    }

    /**
     * Memeriksa kredensial Basic Auth
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    private function isValidCredentials($username, $password)
    {
        // Username dan password yang valid
        $validUsername = getenv('app.basicAuthUsername'); // Ganti dengan username yang valid
        $validPassword = getenv('app.basicAuthPassword'); // Ganti dengan password yang valid

        // Cek kecocokan username dan password
        return $username === $validUsername && $password === $validPassword;
    }

    /**
     * Tidak ada tindakan setelah request diproses
     *
     * @param list<string>|null $arguments
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan khusus setelah permintaan
    }
}
