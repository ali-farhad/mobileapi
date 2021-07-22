<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FaqQuestion;


class FaqquestionController extends Controller
{
    //

    public function add(Request $request)
    {
        //validate
        $request->validate([
            "question" => "required",
        ]);

        $q = new FaqQuestion();
        $q->question = $request->question;
        $q->save();

        return response()->json([
            "status" => 1,
            "message" => "Question added Successfully!",
            "data" => $q
        ], 200);
    }

    //get all questions
    public function index()
    {
        $questions = FaqQuestion::all();

        return response()->json([
            "status" => 1,
            "message" => "All Questions",
            "data" => $questions
        ], 200);
    }


    //get answer using  1>1 relationship
    public function getAnswer($id)
    {
        //get question answer


        if (isset(FaqQuestion::find($id)->answer)) {

            $ans = FaqQuestion::find($id)->answer;

            return response()->json([
                "status" => 1,
                "message" => "answer",
                "data" => $ans
            ], 200);
        } else {

            return response()->json([
                "status" => 0,
                "message" => "This Question ID does not exist!",

            ], 400);
        }
    }


    //Delete all Questions
    public function delete($id)
    {


        if (isset(FaqQuestion::find($id)->id)) {
            $q =  FaqQuestion::where('id', $id)->first();
            $q = FaqQuestion::find($id);
            $q->delete();

            return response()->json([
                "status" => 1,
                "message" => "Question along with its answer deleted successfully!",

            ], 200);
        } else {

            return response()->json([
                "status" => 0,
                "message" => "This Question ID does not exist!",

            ], 400);
        }
    }
}
