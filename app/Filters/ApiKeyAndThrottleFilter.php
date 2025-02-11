<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class ApiKeyAndThrottleFilter implements FilterInterface
{
    /**
     * Memeriksa API Key dan melakukan throttling menggunakan cache.
     *
     * @param list<string>|null $arguments
     *
     * @return ResponseInterface|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil API Key dari header
        $apiKey = $request->getHeaderLine('x-api-key');
        $validApiKey = getenv('app.apiKey'); // Ambil API Key yang valid dari environment atau konfigurasi

        // Validasi API Key
        if ($apiKey !== $validApiKey) {
            return Services::response()->setStatusCode(401)->setJSON(['status' => 'failed', 'error' => 'Invalid API Key']);
        }

        // Menggunakan cache untuk throttling
        $cache = Services::cache(); // Menggunakan cache dengan file
        $IP = $request->getIPAddress();
        $cacheKey = "throttle_" . md5($request->getIPAddress());  // Menggunakan IP sebagai key untuk throttle

        $limit = 10; // Batas jumlah permintaan
        $timeWindow = 60; // Waktu jendela dalam detik (misalnya 1 menit)

        // Ambil data throttling dari cache
        $throttleData = $cache->get($cacheKey);

        // Jika data throttling tidak ditemukan, inisialisasi data baru
        if (!$throttleData) {
            $throttleData = [
                'count' => 1,  // Permintaan pertama
                'timestamp' => time(), // Waktu pertama kali permintaan dilakukan
            ];

            // Simpan data ke cache dengan waktu kedaluwarsa sesuai waktu jendela
            $cache->save($cacheKey, $throttleData, $timeWindow);
        } else {
            $currentTime = time();

            // Jika waktu jendela sudah lebih dari 1 menit (expired), reset
            if (($currentTime - $throttleData['timestamp']) > $timeWindow) {
                $throttleData = [
                    'count' => 1,
                    'timestamp' => $currentTime,
                ];
            } else {
                // Jika belum melewati waktu jendela, tambahkan jumlah permintaan
                $throttleData['count']++;
            }

            // Simpan kembali data ke cache
            $cache->save($cacheKey, $throttleData, $timeWindow);
        }

        // Cek apakah jumlah permintaan sudah melebihi batas
        if ($throttleData['count'] > $limit) {
            return Services::response()->setStatusCode(429)
                ->setHeader('Retry-After', $timeWindow)  // Menambahkan header Retry-After
                ->setJSON(['status' => 'failed', 'error' => 'Too Many Requests']);
        }

        // Jika API Key valid dan throttling berhasil, lanjutkan ke proses berikutnya
        return true;
    }

    /**
     * Tidak ada tindakan khusus setelah request diproses
     *
     * @param list<string>|null $arguments
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan yang perlu dilakukan setelah permintaan selesai
    }
}
