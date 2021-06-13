<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;


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
                $token = $patient->createToken("auth_token")->plainTextToken;

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
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 1,
            "message" => "User logged out successfully"
        ]);
    }
}
