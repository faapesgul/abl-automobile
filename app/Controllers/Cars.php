<?php

namespace App\Controllers;

class Cars extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $query =  $db->query('select * from cars');
 
         var_dump($query->getResult()) ;
    }
}