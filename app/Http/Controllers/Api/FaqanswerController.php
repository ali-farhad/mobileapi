<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FaqAnswer;


class FaqanswerController extends Controller
{
    //
    public function add(Request $request)
    {
        //validate
        $request->validate([
            "answer" => "required",
            "question_id" => "required|unique:faq_answers",
        ]);

        $ans = new FaqAnswer();
        $ans->answer = $request->answer;
        $ans->question_id = $request->question_id;
        $ans->save();

        return response()->json([
            "status" => 1,
            "message" => "Answer added Successfully!",
            "data" => $ans
        ], 200);
    }


    //list all answers
    public function index() {
        $ans = FaqAnswer::all();

        return response()->json([
            "status" => 1,
            "message" => "All Answers",
            "data" => $ans
        ], 200);
    }



}
