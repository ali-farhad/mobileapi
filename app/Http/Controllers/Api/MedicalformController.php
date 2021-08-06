<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Patient;
use App\Models\Medicalform;



class MedicalformController extends Controller
{
    public function store(Request $request)
    {

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
    public function update(Request $request, $id)
    {

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
            $form->update($request->all());

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

    public function index($id)
    {


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


    function addDisease(Request $request)
    {
        #accept array of values
        $data = $request->all();


        $values = array_values($data);
        try {

            $d = $values[0];
        } catch (\Exception $e) {

            return response()->json([
                "status" => 0,
                "error" => $e->getMessage()
            ]);
        }


        $rec = new Medicalform();
        $rec->patient_id = auth()->user()->id;

        foreach ($d as $value) {

            $rec->$value = 1;
        }
        # try and raise exceptio
        try {
            $rec->save();
        } catch (\Exception $e) {

            # catch e message


            if ($e->getCode() == 23000) {

                return response()->json([
                    "status" => 0,
                    "message" => "Disease Record for this User already exists!"
                ]);
            } elseif ($e->getCode() == '42S22') {

                return response()->json([
                    "status" => 0,
                    "message" => "Invalid Key Passed: Please enter correct disease"
                ]);
            } else {

                return response()->json([
                    "status" => 0,
                    "message" => $e
                ]);
            }
        }



        return response()->json([
            "status" => 1,
            "message" => "diseases added successfully!"
        ]);
    }

    function getDiseases($id) {

        #find the disease key which are true
        $diseases = Medicalform::where("patient_id", $id)->get();
       

            
  

     
     
       
      

       

        return response()->json([
            "status" => 1,
            "data" => $diseases
        ]);
    }
       
        
    
}
