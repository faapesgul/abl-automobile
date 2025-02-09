<?php

namespace App\Controllers;

use App\Models\UserModel;

class Customers extends BaseController
{
    public function index()
    {
        $user = new UserModel();
        return $this->response->setJSON($user->findAll());
    }
}