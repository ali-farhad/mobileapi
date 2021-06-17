<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Support\Facades\Hash;


class HospitalController extends Controller
{
  
//REGISTER API
public function addHospital(Request $request)
{

    //validate
  
    $request->validate([
        "name" => "required",
        "address" => "required",
        "hours_opened"=> "required",
        "hasICU" => "required | boolean",
        "hasVentilator" => "required | boolean",
        "hasEmergency" => "required | boolean",
    ],
    [
        'hasICU.required' => 'the hasICU field is required',
    ]);

    $isUserAdmin = auth()->user()->isAdmin;

    if($isUserAdmin) {

    //create hospital
    $hospital = new Hospital();

    $hospital->name = $request->name;
    $hospital->address = $request->address;
    $hospital->hours_opened = $request->hours_opened;
    $hospital->hasICU = $request->hasICU;
    $hospital->hasVentilator = $request->hasVentilator;
    $hospital->hasEmergency = $request->hasEmergency;

    $hospital->save();


    //send response
    return response()->json([
        "status" => 1,
        "message" => "Hospital added succesfully!"
    ]);

    }

    else {

        return response()->json([
            "status" => 0,
            "message" => "Only Admins are allowed to do this operation!"
        ], 401);


    }
 
   
}

}
