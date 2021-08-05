<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\DoctorTimingController;
use App\Http\Controllers\Api\MedicalformController;
use App\Http\Controllers\Api\DoctorpatientController;
use App\Http\Controllers\Api\FaqquestionController;
use App\Http\Controllers\Api\FaqanswerController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("register", [PatientController::class, "register"]);
Route::post("login", [PatientController::class, "login"]);
Route::get("isUserLoggedIn/{id}", [PatientController::class, "isUserLoggedIn"]);


Route::group(["middleware" => ["auth:sanctum"]], function () {

    Route::get("profile", [PatientController::class, "profile"]);
    Route::get("logout", [PatientController::class, "logout"]);



    Route::post("add-hospital", [HospitalController::class, "addHospital"]);
    Route::get("list-hospitals", [HospitalController::class, "listHospital"]);
    Route::get("single-hospital/{id}", [HospitalController::class, "singleHospital"]);


    //medical form
    Route::post("add-medicalform", [MedicalformController::class, "store"]);
    Route::post("update-medicalform/{id}", [MedicalformController::class, "update"]);

    //Appointement

    Route::post("appoint-doctor", [DoctorpatientController::class, "appointDoctor"]);
    Route::get("list-patient-doctors", [PatientController::class, "doctorsAppointed"]);
    Route::get("unappoint-doctor/{drid}/{ptid}", [DoctorpatientController::class, "unappointDoctor"]);


    Route::post("add-doctor-feedback", [DoctorController::class, "addFeedback"]);


    Route::post("add-time-slot", [DoctorTimingController::class, "addTiming"]);


});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post("register-doctor", [DoctorController::class, "addDoctor"]);
Route::post("login-doctor", [DoctorController::class, "loginDoctor"]);
Route::get("list-doctors", [DoctorController::class, "listDoctors"]);
Route::get("single-doctor/{id}", [DoctorController::class, "singleDoctor"]);
Route::get("isDoctorLoggedIn/{id}", [DoctorController::class, "isDoctorLoggedIn"]);
Route::post("find-doctors", [DoctorController::class, "findDoctors"]);


Route::get("list-doctor-patients/{id}", [DoctorpatientController::class, "getDoctorPatients"]);


//FAQ 
Route::post("add-question", [FaqquestionController::class, "add"]);
Route::get("list-questions", [FaqquestionController::class, "index"]);
Route::get("delete-question/{id}", [FaqquestionController::class, "delete"]);
Route::post("add-answer", [FaqanswerController::class, "add"]);
Route::get("list-answers", [FaqanswerController::class, "index"]);


Route::get("get-answer/{id}", [FaqquestionController::class, "getAnswer"]);



Route::get("list-feedbacks", [DoctorController::class, "listFeedback"]);
Route::get("single-feedback/{id}", [DoctorController::class, "singleFeedback"]);



Route::get("get-time-slot/{id}", [DoctorTimingController::class, "getTimings"]);
Route::get("delete-time-slot/{id}", [DoctorTimingController::class, "delTimings"]);


Route::get("get-medicalform/{id}", [MedicalformController::class, "index"]);

