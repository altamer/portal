<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KindlustusedController extends Controller
{
    public function insertinsurance()
    {

       $this->debug_to_console("Insur44");
       
        $insurance = array();
        $insurance[] = array("active" => '1', "notes" => "test1 ", "duedate" => '2018-09-25');
        /* 
        Kindlustused::insert($insurance);
       */
    }// end insertinsurance   

    public function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);
           
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }
}
