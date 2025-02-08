<?php

namespace App\Controllers;

class Customers extends BaseController
{
    public function index()
    {
        $db = db_connect();
       $query =  $db->query('select * from users');

        var_dump($query->getResult()) ;
    }
}