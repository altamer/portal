<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->debug_to_console("Insur33");
            
        // Session::put('userid', \Auth::user()->id );        
      //  Session::put('stocktotal', 100000 );
      return view('home');     
    }

    public function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);
           
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }
    
}
