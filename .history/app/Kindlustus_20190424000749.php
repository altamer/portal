<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kindlustus extends Model
{
    protected $table = 'kindlustused';

    public static function DueDate()
    {        
        return Kindlustused::where('active', '=', 1)->where('duedate', '>=', date("Y-m-d"));
    }
    public static function Active()
    {        
        return Kindlustused::where('active', '=', 1);
    }
}
