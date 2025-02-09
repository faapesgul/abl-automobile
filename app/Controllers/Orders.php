<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Orders extends BaseController
{
    public function index()
    {
        $orders = new OrderModel();
        return $this->response->setJSON($orders->findAll());
    }
    public function getOrderById($id){
            $orders = new OrderModel();
            $order = $orders->find($id);
            return $this->response->setJSON($order);

    }
} 