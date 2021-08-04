<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\Models\DoctorTiming;


class DoctorTimingController extends Controller
{
    function addTiming(Request $request) {
        
         //validate
         $request->validate([
            "timeslot" => "required|date|unique:doctor_timings"
        ]);

        $doctor_id =  auth()->user()->id;

        #add new record
        $slot = new DoctorTiming();
        $slot->doctor_id = $doctor_id;
        $slot->timeslot = $request->timeslot;
        $slot->save();

         //send response
         return response()->json([
            "status" => 1,
            "message" => "Time slot added successfully!"
        ]);
    }

    //get Doctor slots
    function getTimings($id) {

        #if id exists in doctor_timings table
        if(DoctorTiming::where('doctor_id', $id)->count() > 0) {

            $slot = DoctorTiming::where([
                'doctor_id' => $id,
                'is_booked' => 0
                ])->get();
    
    
                  //send response
             return response()->json([
                "status" => 1,
                "message" => "Time slot available",
                "date" => $slot
            ]);
    

        } else {
        
              return response()->json([
                "status" => 1,
                "message" => "Timings for this Doctor Does not exis yet!",
            ], 404);
        }

      
    }

    public function delTimings($id) {

        if(DoctorTiming::where('id', $id)->count() > 0) {

            $slot = DoctorTiming::where('id', $id)->first();
            $slot->delete();

             return response()->json([
                "status" => 1,
                "message" => "Timeslot Deleted Successfully!",
            ]);


        } else {

            
            return response()->json([
                "status" => 1,
                "message" => "this id for timeslot does not exist",
            ], 404);
        }


    }

}
