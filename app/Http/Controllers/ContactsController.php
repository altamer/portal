<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Requests;


class ContactsController extends Controller
{
    public function index()
    {
        
       
    }

    public function get_contacts()
    {
        $url = 'https://localhost:5001/Contacts';
        
        $curlSession = curl_init();        
        curl_setopt($curlSession, CURLOPT_URL,  $url);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
        $jsonData = curl_exec($curlSession);
        curl_close($curlSession);   
    
        $data = json_decode($jsonData);

        return array($data);
       
    }

    public function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);
           
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    
}
