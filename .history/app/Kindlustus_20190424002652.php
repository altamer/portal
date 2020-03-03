<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kindlustus extends Model
{
    protected $table = 'kindlustused';

    public static function DueDate()
    {        
        return Kindlustus::where('active', '=', 1)->where('duedate', '>=', date("Y-m-d")+30)->get();
    }
    
}
