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

        #decode data
        $data = json_decode($data[0], true);
    
        
        $rec = new Medicalform();
        $rec->patient_id = auth()->user()->id;

        # for each item in data
        foreach ($data as $key => $value) {
            
            #for each key in value
            foreach ($value as $k => $v) {
                $rec->$v = 1;
        }
        }

        

        $rec->save();

         return response()->json([
            "status" => 1,
            "message" => "diseases added successfully!"
        ]);


       
             



     
        // foreach ($d as $value) {

        //     $rec->$value = 1;
        // }
        // # try and raise exceptio
        // try {
        //     $rec->save();
        // } catch (\Exception $e) {

        //     # catch e message


        //     if ($e->getCode() == 23000) {

        //         return response()->json([
        //             "status" => 0,
        //             "message" => "Disease Record for this User already exists!"
        //         ]);
        //     } elseif ($e->getCode() == '42S22') {

        //         return response()->json([
        //             "status" => 0,
        //             "message" => "Invalid Key Passed: Please enter correct disease"
        //         ]);
        //     } else {

        //         return response()->json([
        //             "status" => 0,
        //             "message" => $e
        //         ]);
        //     }
        // }



        // return response()->json([
        //     "status" => 1,
        //     "message" => "diseases added successfully!"
        // ]);
    }

    function getDiseases($id)
    {

        # check if user exists in Medicalform
        if (Medicalform::where([
            "patient_id" => $id
        ])->exists()) {

            #find the disease key which are true
            $diseases = Medicalform::where("patient_id", $id)->get();
            $values = ['anemia', 'arthritis', 'disease', 'clotting_disorder', 'ardinal_gland_surgey', 'appendectomy', 'bariatric_surgery', 'bladder_surgery', 'cesarean_section', 'cholecystectomy', 'medications', 'allergies', 'fm_cancer', 'fm_anemia', 'fm_diabetes', 'fm_blood_clots', 'fm_heart_disease', 'fm_stroke', 'fm_high_blood_pressure', 'fm_hepatitis'];
            $found = [];
            foreach ($diseases as $disease) {
                foreach ($values as $value) {
                    if ($disease->$value == 1) {
                        $found[] = $value;
                    }
                }
            }

            # get total values in $found
            $total = count($found);
            return response()->json([
                "status" => 1,
                "data" => $found,
                "total" => $total
            ]);
        } else {

            return response()->json([
                "status" => 0,
                "message" => "Medical form/record for this user not found."
            ], 404);
        }
    }
}
