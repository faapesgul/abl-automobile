<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Orders extends BaseController
{
    public function getOrderById($id)
    {
        $orders = new OrderModel();
        $order = $orders->find($id);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $order
        ]);
    }

    public function create()
    {
        $db = db_connect();
        $data = $this->request->getJSON();
        $db->table('orders')->insert($data);
        return $this->response->setJSON(['status' => 'success', 'data' => $data]);
    }
}
