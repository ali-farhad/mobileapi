<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;




class DoctorController extends Controller
{
    //ADD NEW Doctor
    public function addDoctor(Request $request)
    {
          //validate
          $request->validate([
            "fullname" => "required",
            "email" => "required|email|unique:patients",
            "phone" => "required|numeric",
            "password" => "required|confirmed",
            "speacility" => "required|in:Allergy and immunology,Urology,Ophthalmology,Obstetrics and gynecology,Anesthesiology,Dermatology,Diagnostic radiology,Family medicine,Pathology,Pediatrics",
            "years_of_experience" => "required|integer"
        ]);

         //create Doctor
         $doctor = new Doctor();

         $doctor->fullname = $request->fullname;
         $doctor->email = $request->email;
         $doctor->phone = $request->phone;
         $doctor->password = Hash::make($request->password);
         $doctor->speacility = $request->speacility;
         $doctor->years_of_experience = $request->years_of_experience;

 
         $doctor->save();

          //send response
        return response()->json([
            "status" => 1,
            "message" => "Doctor registered succesfully!"
        ]);


    }

    //List all Doctors
    public function listDoctors()
    {



            $doctors = Doctor::all();

            return response()->json([
                "status" => 1,
                "data" => $doctors
            ]);
        } 

    
     //single view Doctor
     public function singleDoctor($id)
     {
 
 
         if (Doctor::where("id", $id)->exists()) {
            
            $details = Doctor::find($id);


            return response()->json([
                "status" => 1,
                "message" => "Doctor Detail",
                "data" => $details
            ]);
           
         } else {
 
             return response()->json([
                 "status" => 0,
                 "message" => "Doctor not found"
             ], 404);
         }
     }



     //login Doctor

     public function loginDoctor(Request $request) {


         //validate
         $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

         //check Doctor
         $doctor = Doctor::where("email", "=", $request->email)->first();
         
         if (isset($doctor->id)) {

            //check password
            if (Hash::check($request->password, $doctor->password)) {

                //update login status
                $doctor->is_logged_in = 1;

                //create a token
                $token = $doctor->createToken("auth_token")->plainTextToken;

                $doctor->save();

                //send response
                return response()->json([
                    "status" => 1,
                    "message" => "Doctor logged in successfully",
                    "access_token" => $token
                ]);
            } else {

                //incorrect password
                return response()->json([
                    "status" => 0,
                    "message" => "Password didn't match"
                ], 404);
            }
        } else {

            return response()->json([
                "status" => 0,
                "message" => "This Email/User for Doctor does not exist"
            ], 404);
        }


     }


     public function isDoctorLoggedIn($id) {

        //find user
     


        if (isset(Doctor::find($id)->id)) {

         $user = Doctor::find($id)->first();

          //check status
        $status = $user->is_logged_in;

        if($status) {

            return response()->json([
                "status" => 1,
                "message" => "Doctor is logged in",
                "isLoggedIn" => true
            ]);
        }

        else {

            return response()->json([
                "status" => 0,
                "message" => "Doctor is logged out",
                "isLoggedIn" => false
            ]);
        } 
            


        }  else {

            return response()->json([
                "status" => 0,
                "message" => "This id for Doctor does not exist"
            ], 404);

        }

       
    }



}
