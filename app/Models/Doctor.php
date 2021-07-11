<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Doctor extends Model
{
    use HasFactory, HasApiTokens;
    
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
