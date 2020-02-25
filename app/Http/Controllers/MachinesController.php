<?php

namespace App\Http\Controllers;

use App\Machines;
use App\Kindlustus;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function setmachinestatus(Request $request)
    {
        $id = 0;
        $active = 1;
        if($request->get('id'))
       {
          $id = $request->get('id');          
        } 

        if($request->get('active'))
       {
         $active = $request->get('active');           
          
          if($active == 1){
            $active = 0;
           }else{
            $active = 1;           
           }          

        } 
    
        Machines::where('id', $id)->update(array('active' => $active));
        Kindlustus::where('machineid', $id)->update(array('active' => $active));

        return response()->json(['success'=>'Machine updated.']);
    }    

    public function updatemachine(Request $request)
    {
        $id = 0;
        $vin = "";
        $year = 0;
        $machine = "";
        if($request->get('id'))
       {
          $id = $request->get('id');          
        } 

        if($request->get('vin'))
        {
           $vin = $request->get('vin');          
         }  
         if($request->get('year'))
        {
           $year = $request->get('year');
           
         }  
         if($request->get('machine'))
        {
           $machine = $request->get('machine');
           
         }
    
        Machines::where('id', $id)->update(array('vin' => $vin, 'year' => $year, 'machine' => $machine));        

        return response()->json(['success'=>'Machine data updated.']);
    }

    public function getmachines()
    {
        
        $allmachines = Machines::getAllMachines();
        $allinsurances = Kindlustus::getAllInsurances();
        
        return array($allmachines, $allinsurances);
    }

    public function addmachine(Request $request)
    {
        
        $active = 1;
        $vin = "";
        $year = 0;
        $machine = "";       
        
        if($request->get('vin'))
       {
          $vin = $request->get('vin');          
        }  
        if($request->get('year'))
       {
          $year = $request->get('year');
          
        }  
        if($request->get('machine'))
       {
          $machine = $request->get('machine');
          
        }    
        
        $machinedata = array();
        $machinedata[] = array("active" => $active, "vin" => $vin, "year" => $year, "machine" => $machine);
        // $machine[] = array("vin" => $vin, "year" => $year, "machine" => $machine, "notes" => "test");
        Machines::insert($machinedata);
              
        return response()->json(['success'=>'Machine saved.']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function show(Machines $machines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function edit(Machines $machines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machines $machines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machines $machines)
    {
        //
    }
}
