<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqAnswer extends Model
{
    use HasFactory;

    protected $table = 'faq_answers';
    protected $fillable = ['answer', 'question_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function question() {
        return $this->belongsTo(FaqQuestion::class);
    }
}
