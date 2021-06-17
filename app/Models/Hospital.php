<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Hospital extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = "hospitals";

    protected $fillable = [
        "name",
        "address",
        "hours_opened",
        "hasICU",
        "hasVentilator",
        "hasEmergency",

    ];
}
