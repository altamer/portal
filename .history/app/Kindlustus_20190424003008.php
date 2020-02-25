<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kindlustus extends Model
{
    protected $table = 'kindlustused';

    public static function DueDate()
    {   
        $dayAfter = (new DateTime(date("Y-m-d")))->modify('+30 day')->format('Y-m-d');     
        return Kindlustus::where('active', '=', 1)->where('duedate', '>=', $dayAfter)->get();
    }
    
}
