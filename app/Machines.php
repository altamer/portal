<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machines extends Model
{
    protected $table = 'machines';

public static function getAllMachines()
{ 
    return Machines::all();
}


}
