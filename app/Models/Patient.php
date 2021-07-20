<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Doctor;



class Patient extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = "patients";

    protected $fillable = [
        "fullname",
        "email",
        "password",
    ];

    protected $hidden = [
        "password",
        "isAdmin",
        "pivot",
        "is_logged_in"
    ];

    public function doctors() {
        return $this->belongsToMany(Doctor::class)->withTimestamps();;
    }

}
