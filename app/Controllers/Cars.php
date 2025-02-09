<?php

namespace App\Controllers;

use App\Models\CarModel;

class Cars extends BaseController
{
    public function index()
    {
        $cars = new CarModel();
        return $this->response->setJSON($cars->findAll());
    }

    
}