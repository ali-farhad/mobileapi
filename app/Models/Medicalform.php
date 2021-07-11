<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;





class Medicalform extends Model
{
    use HasFactory;

    protected $table = "medicalforms";

    // protected $fillable = ["patient_id", "dob", "anemia", "arthritis", "disease", "clotting_disorder", "ardinal_gland_surgey", "appendectomy", "bariatric_surgery", "bladder_surgery", "cesarean_section", "cholecystectomy"];

    protected $guarded = [];

    
}
