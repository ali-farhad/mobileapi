<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\Doctor;
use App\Models\DoctorPatient;

class DoctorpatientController extends Controller
{
    //
    function appointDoctor(Request $request, $id)
    {


        if (isset(Doctor::find($id)->id)) {
            $doctor_id = Doctor::find($id)->id;
            $user = auth()->user()->id;

            try {
                $appointment = new DoctorPatient();
                $appointment->doctor_id = $doctor_id;
                $appointment->patient_id = $user;
                $appointment->save();
            } catch (\Exception $e) {
                //send response
                return response()->json([
                    "status" => 0,
                    "message" => "This Doctor is already appointed to this patient"
                ], 405);
            }




            //send response
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

            $doctor = Doctor::find($id);
            $patients = $doctor->patients()->get();
            //send response
            return response()->json([
                "status" => 1,
                "message" => "Patients appointed with doctor",
                "data" => $patients
            ]);
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

                return response()->json([
                    "status" => 1,
                    "message" => "appointment Deleted Successfully!",
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
