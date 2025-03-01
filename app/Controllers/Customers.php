<?php

namespace App\Controllers;

class Customers extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $query = $db->query('SELECT * FROM customers')->getResult();

        $response = [
            'status' => 'success',
            'data' => $query
        ];

        return $this->response->setJSON($response);
    }
}
