<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    
    protected $table = "doctors";


    protected $fillable = [
        "fullname",
        "email",
        "phone",
        "password",
        "speacility",
        "years_of_experience"

    ];

    protected $hidden = ['password'];


}
