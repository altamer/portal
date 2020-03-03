<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kindlustus extends Model
{
    protected $table = 'kindlustused';

    public static function DueDate()
    {   
      //  $dayFuture = 30; // where here there is your calculation for now How many days
      // $dayToCheck = Carbon::now()->subDays($dayFuture);    
       // return Kindlustus::where('active', '=', 1)->where('duedate', '>=', $dayToCheck)->get();
      // $oldDate = date("Y-m-d");
      // $newDate = $oldDate->addDays($numDays);
         return Kindlustus::where('active', '=', 1)->where('duedate', '>=', date("Y-m-d"))->get();
    }
    
}
