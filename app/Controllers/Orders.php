<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Orders extends BaseController
{
    public function getOrderById($id)
    {
        $orders = new OrderModel();
        $orderDetails = $orders->find($id);
    $orderCars = $orders->getOrderWithCar($id);
    $orderCustomers = $orders->getOrderWithCustomer($id);
       

        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'orders_detail'=>$orderDetails,
                'customers'=>$orderCustomers,
                'cars'=> $orderCars
            ]
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
