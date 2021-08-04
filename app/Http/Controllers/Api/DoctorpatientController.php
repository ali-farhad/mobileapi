<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;



use App\Models\Doctor;
use App\Models\DoctorPatient;
use App\Models\DoctorTiming;
use App\Models\Patient;

class DoctorpatientController extends Controller
{
    //
    function appointDoctor(Request $request,)
    {

         //validate
         $request->validate([
            "doctor_id" => "required",
            "appointed_at" => "required|date"
       
        ]);


        if (isset(Doctor::find($request->doctor_id)->id)) {
            $doctor_id = Doctor::find($request->doctor_id)->id;
            $user = auth()->user()->id;

            #find timeslot from doctor_timings
            $d = DoctorTiming::where('doctor_id', $doctor_id)->get();
            $timeslot = [];
            foreach ($d as $time) {
                $timeslot[] = $time->timeslot;
            }


           
            #if appointed_at exists in timeslot
            if (in_array($request->appointed_at, $timeslot)) {


                    try {

                
                #update d booked_at to 1
                DB::table('doctor_timings')->where('timeslot', $request->appointed_at)->update(['is_booked' => 1]);

                $appointment = new DoctorPatient();
                $appointment->doctor_id = $request->doctor_id;
                $appointment->patient_id = $user;
                $appointment->appointed_at = $request->appointed_at;
                $appointment->save();
            } catch (\Exception $e) {
                //send response
                return response()->json([
                    "status" => 0,
                    "message" => "This Doctor is already appointed to this patient"
                ], 405);
            }
            
            } else {
                return response()->json([
                    "status" => 0,
                    "message" => "This timeslot is not available",
              
                ]);
            
            }
        
            //  return response()->json([
            //     "status" => 1,
            //     "message" => "Doctor appointed succesfully!",
            //     "data" => $f
            // ]);
        

        

            // $appointment = new DoctorPatient();
            //     $appointment->doctor_id = $request->doctor_id;
            //     $appointment->patient_id = $user;
            //     $appointment->save();


            // send response
            return response()->json([
                "status" => 1,
                "message" => "Doctor appointed succesfully!"
            ]);
        } else {

            //send response
            return response()->json([
                "status" => 0,
                "message" => "this Doctor Does not exist"
            ], 404);
        }
    }

    function getDoctorPatients($id)
    {

        if (isset(Doctor::find($id)->id)) {


           $rec =  DoctorPatient::where("doctor_id", $id)->get();
           #get pateint_id from $rec
           $patients = [];
           foreach ($rec as $r) {
               $patients[] = Patient::find($r->patient_id)->fullname;
           }

            
            #get Doctor name by id
            $doctor = Doctor::find($id);
            $patient = Patient::find($id);
            $doctor_name = $doctor->fullname;
            $patient_name = $patient->fullname;

            #add docot name to rec  
            $index = 0;
            foreach ($rec as $r) {
                $r->doctor_name = $doctor_name;
                $r->patient_name = $patients[$index];
                $index++;
            }


           
            return response()->json([
                "status" => 1,
                "message" => "Patients appointed with doctor",
                "data" => $rec
            ]);
        

            //send response
           
        } else {
            //send response
            return response()->json([
                "status" => 1,
                "message" => "this Doctor Does not exist",
            ], 404);
        }
    }

    function unappointDoctor($drid, $ptid) {
        if (isset(Doctor::find($drid)->id)) {

           $appointment =  DoctorPatient::where([
                "doctor_id" => $drid,
                "patient_id" => $ptid
           ]);

            if (($appointment)->exists()) {

                $appointment->delete();
                DB::table('doctor_timings')->where('doctor_id', $drid)->update(['is_booked' => 0]);


                return response()->json([
                    "status" => 1,
                    "message" => "appointment Deleted/completed Successfully!",
                ], 404);

        } else {
            return response()->json([
                "status" => 0,
                "message" => "This appointment does not exist!",
            ], 404);
        }


    } else {
        return response()->json([
            "status" => 0,
            "message" => "This Doctor Does not Exist!",
        ], 404);
    }
}

}
