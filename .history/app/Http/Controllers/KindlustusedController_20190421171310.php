<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KindlustusedController extends Controller
{
    public function random_products()
    {
        $insurance = array();
        $insurance[] = array("active" => '1', "notes" => "test1 ", "duedate" => '2018-09-25');
        Products::insert($insurance);
    }// end random_products    
}
