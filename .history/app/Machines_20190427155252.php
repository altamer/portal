<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machines extends Model
{
    protected $table = 'machines';

public static function getLoadedProducts()
{ 
    return Products::all();
}


}
