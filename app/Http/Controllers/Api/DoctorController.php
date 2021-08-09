<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Http;



use App\Models\Rating;


class DoctorController extends Controller
{
    //ADD NEW Doctor
    public function addDoctor(Request $request)
    {
          //validate
          $request->validate([
            "fullname" => "required",
            "email" => "required|email|unique:doctors",
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

            # fetch star value form Rating
            $rating = Rating::where("doctor_id", $id)->first();


            if(isset($rating)){
            
                $stars = $rating->stars;

            } else {
                $stars = 0;

            }


              #if $stars exist
              

            

          
            # add stars into details
            $details->stars = $stars;




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


    //search doctors
    public function findDoctors(Request $request) {

        if(isset($request->speacility)) {
            $doctors = Doctor::where("speacility", "=", $request->speacility)->get();

            return response()->json([
                "status" => 1,
                "message" => "Doctors by speacility",
                "data" => $doctors
            ]);
        }

        if(isset($request->email)) {
            $doctors = Doctor::where("email", "=", $request->email)->get();

            return response()->json([
                "status" => 1,
                "message" => "Doctors by email",
                "data" => $doctors
            ]);
        }

        if(isset($request->name)) {
            #find LIKE doctors
            $doctors = Doctor::where("fullname", "LIKE", "%".$request->name."%")->get();
          
            return response()->json([
                "status" => 1,
                "message" => "Doctors by fullname",
                "data" => $doctors
            ]);
        }
        

       


    }


    public function addFeedback(Request $request) {

          //validate
          $request->validate([
            "comment" => "required",
            "stars" => "required|numeric",
            "doctor_id" => "required",
           
        ]);

        $user_id = auth()->user()->id;


        if (isset(Doctor::find($request->doctor_id)->id)) {

            $res = Http::asForm()->post('http://text-processing.com/api/sentiment/', [
                'text' => $request->comment
              
            ]);

            #get label out of res
            $label = json_decode($res)->label;
            $neg = json_decode($res)->probability->neg;
            $pos = json_decode($res)->probability->pos;
            $neutral = json_decode($res)->probability->neutral;
            
    
            #add new record for Rating
            $rating = new Rating();
            $rating->comment = $request->comment;
            $rating->stars = $request->stars;
            $rating->doctor_id = $request->doctor_id;
            $rating->user_id = $user_id;
            $rating->label= $label;
            $rating->neg= $neg;
            $rating->pos= $pos;
            $rating->neutral= $neutral;
            $rating->save();
    
            return response()->json([
                "status" => 1,
                "message" => "feedback added Successfully!",
                "data" => $res->json()
            
            ]);

        } else  {

            return response()->json([
                "status" => 0,
                "message" => "This id for Doctor does not exist"
            ], 404);

        }
      
    

    }

    public function listFeedback() {
        
        #get all Rating
        $ratings = Rating::all();

        return response()->json([
            "status" => 1,
            "data" => $ratings
        ]);


    }

    public function singleFeedback($id) {
        #get rating by doctor id

        if (isset(Doctor::find($id)->id)) {

            $rating = Rating::where("doctor_id", "=", $id)->get();

            return response()->json([
                "status" => 1,
                "data" => $rating
            ]);

        } else {

            return response()->json([
                "status" => 0,
                "message" => "This id for Doctor does not exist"
            ], 404);

        }

        }
      



}
