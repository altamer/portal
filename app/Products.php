<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Products extends Model
{
    protected $guarded = [];

    public static function getUserProducts()
    {
        return Products::where('userid', '=', Session::get('userid'))->whereNull('truck')->orderBy('id')->get();
    }

    public static function getLoadedProducts()
    {        
        return Products::where('userid', '=', Session::get('userid'))->whereNotNull('truck')->orderBy('id')->get();
    }

    public static function LastTruck()
    {           
        return Products::where('userid', '=', Session::get('userid'))->max('truck') + 1;
    }

    public static function LoadProducts($id, $truck)
    {        
        return Products::where('id',$id)->update(['truck'=>$truck]);
    }
}
