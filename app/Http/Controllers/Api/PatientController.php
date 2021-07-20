<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;

use Illuminate\Support\Facades\Hash;
use PhpParser\Comment\Doc;

class PatientController extends Controller
{
    //REGISTER API
    public function register(Request $request)
    {

        //validate
        $request->validate([
            "fullname" => "required",
            "email" => "required|email|unique:patients",
            "password" => "required|confirmed"
        ]);

        //create user
        $patient = new Patient();

        $patient->fullname = $request->fullname;
        $patient->email = $request->email;
        $patient->password = Hash::make($request->password);

        $patient->save();


        //send response
        return response()->json([
            "status" => 1,
            "message" => "User registered succesfully!"
        ]);
    }

    //LOGIN API
    public function login(Request $request)
    {
        //validate
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);


        //check patient
        $patient = Patient::where("email", "=", $request->email)->first();

        if (isset($patient->id)) {

            //check password
            if (Hash::check($request->password, $patient->password)) {

                //create a token
                $patient->is_logged_in = 1;
                $token = $patient->createToken("auth_token")->plainTextToken;

                $patient->save();

                //send response
                return response()->json([
                    "status" => 1,
                    "message" => "User logged in successfully",
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
                "message" => "This Email/user does not exist"
            ], 404);
        }
    }

    //PROFILE API
    public function profile()
    {
        return response()->json([
            "status" => 1,
            "message" => "User Profile information",
            "data" => auth()->user()
        ]);
    }

    //LOGOUT API
    public function logout()
    {


        $userId = auth()->user()->id;

        $patient = Patient::find($userId)->first();
        $doctor = Doctor::find($userId)->first();

        $patient->is_logged_in = 0;




        $doctor->is_logged_in = 0;


        $patient->save();
        $doctor->save();



        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 1,
            "message" => "User logged out successfully"
        ]);
    }


    public function isUserLoggedIn($id)
    {

        //find user


        if (isset(Patient::find($id)->id)) {

            $user = Patient::find($id)->first();

            //check status
            $status = $user->is_logged_in;

            if ($status) {

                return response()->json([
                    "status" => 1,
                    "message" => "user is logged in",
                    "isLoggedIn" => true
                ]);
            } else {

                return response()->json([
                    "status" => 0,
                    "message" => "user is logged out",
                    "isLoggedIn" => false
                ]);
            }
        }
        else {

            return response()->json([
                "status" => 0,
                "message" => "This id for User does not exist"
            ], 404);

        }
    }

    //get doctors appointed to patient by id
    public function doctorsAppointed() {
        
        $patientId = auth()->user()->id;

        $patient = Patient::find($patientId);
        $doctors = $patient->doctors()->get();

          //send response
          return response()->json([
            "status" => 1,
             "message" => "Doctors appointed with this patient",
             "data" => $doctors
          ]);

    }
}
