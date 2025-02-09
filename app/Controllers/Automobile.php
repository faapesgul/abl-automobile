<?php

namespace App\Controllers;

class Automobile extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $query = $db->query('SELECT * FROM automobiles')->getResult();

        $response = [
            'status' => 'success',
            'data' => $query
        ];

        return $this->response->setJSON($response);
    }
}
