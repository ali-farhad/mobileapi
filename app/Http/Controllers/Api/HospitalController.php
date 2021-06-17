<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class HospitalController extends Controller
{

    //ADD NEW Hospital API
    public function addHospital(Request $request)
    {
        //validate
        $request->validate(
            [
                "name" => "required",
                "address" => "required",
                "hours_opened" => "required",
                "hasICU" => "required | boolean",
                "hasVentilator" => "required | boolean",
                "hasEmergency" => "required | boolean",
            ],
            [
                'hasICU.required' => 'the hasICU field is required',
            ]
        );

        $isUserAdmin = auth()->user()->isAdmin;

        if ($isUserAdmin) {

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
        } else {

            return response()->json([
                "status" => 0,
                "message" => "Only Admins are allowed to do this operation!"
            ], 401);
        }
    }


    //List all Hospital API
    public function listHospital()
    {

        $isUserAdmin = auth()->user()->isAdmin;

        if ($isUserAdmin) {

            $hospitals = Hospital::all();

            return response()->json([
                "status" => 1,
                "data" => $hospitals
            ]);
        } else {

            return response()->json([
                "status" => 0,
                "message" => "Only Admins are allowed to do this operation!"
            ], 401);
        }
    }

    //List single view hospital
    public function singleHospital($id)
    {

        $isUserAdmin = auth()->user()->isAdmin;

        if (Hospital::where("id", $id)->exists()) {

            if ($isUserAdmin) {

                $details = Hospital::find($id);


                return response()->json([
                    "status" => 1,
                    "message" => "Hospital Detail",
                    "data" => $details
                ]);
            } else {

                return response()->json([
                    "status" => 0,
                    "message" => "Only Admins are allowed to do this operation!"
                ], 401);
            }
        } else {

            return response()->json([
                "status" => 0,
                "message" => "Hospital not found"
            ], 404);
        }
    }
}
