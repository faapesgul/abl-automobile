<?php

namespace App\Controllers;

class Orders extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $query =  $db->query('select * from orders');
 
         var_dump($query->getResult()) ;
    }
}