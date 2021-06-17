<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\HospitalController;


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

Route::group(["middleware" => ["auth:sanctum"]], function () {

    Route::get("profile", [PatientController::class, "profile"]);
    Route::get("logout", [PatientController::class, "logout"]);

    Route::post("add-hospital", [HospitalController::class, "addHospital"]);
    Route::get("list-hospitals", [HospitalController::class, "listHospital"]);
    Route::get("single-hospital/{id}", [HospitalController::class, "singleHospital"]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
