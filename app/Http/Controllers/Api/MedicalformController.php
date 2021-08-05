<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Patient;
use App\Models\Medicalform;



class MedicalformController extends Controller
{
    public function store(Request $request) {

        //  $form = new Medicalform();

        $userId = auth()->user()->id;

        if (Medicalform::where("patient_id", $userId)->exists()) {

            return response()->json([
                "status" => 0,
                "message" => "Medical form for this user already exists! please use update method"
            ], 400);

        }

        $request->request->add(['patient_id' => $userId]);


        $data = $request->all();

        $form = Medicalform::create($data);

        $form->save();

         //send response
         return response()->json([
            "status" => 1,
            "message" => "Patient's Medical form stored successfully!",
        ]);

    }


    //update medical form
    public function update(Request $request, $id) {

        // user id
        // course id
        // courses table
        $userId = auth()->user()->id;

        if (Medicalform::where([
            "id" => $id,
            "patient_id" => $userId
        ])->exists()) {

            $form = Medicalform::find($id);

            
             $request->request->add(['patient_id' => $userId]);
             $form->update( $request->all());
     
            //  $form = Medicalform::create($data);

          

            return response()->json([
                "status" => 1,
                "message" => "Medical Form Updated Successfully!"
            ]);
        } else {

            return response()->json([
                "status" => 0,
                "message" => "Medical Form Not Found"
            ]);
        }

    }

    //get Medical form

    public function index($id) {


        $userId = $id;

        if (Medicalform::where([
            "patient_id" => $userId
        ])->exists()) {

            $form = Medicalform::where("patient_id", $userId)->get();
            
            return response()->json([
                "status" => 1,
                "message" => "Medical form data",
                "data" => $form
            ]);

        } else {

            return response()->json([
                "status" => 0,
                "message" => "Medical form for this user does not exist!"
            ]);
        }
    }


}
