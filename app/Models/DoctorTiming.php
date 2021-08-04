<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorTiming extends Model
{
    use HasFactory;

    protected $table = 'doctor_timings';
    protected $fillable = ['doctor_id', 'slot_time', 'is_booked'];
    protected $hidden = ['created_at', 'updated_at', 'is_booked'];



}
