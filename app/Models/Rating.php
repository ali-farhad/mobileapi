<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;



class Rating extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = "ratings";

    protected $fillable = [
        "comment",
        "doctor_id",
        "user_id",
        "label",
        "neg",
        "pos",
        "neutral"
    ];

}
