<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\FaqAnswer;


class FaqQuestion extends Model
{
    use HasFactory;

    protected $table = 'faq_questions';
    protected $fillable = ['question'];

    protected $hidden = ['created_at', 'updated_at'];

    public function answer()
    {
        return $this->hasOne(FaqAnswer::class, "question_id");
        // note: we can also inlcude Mobile model like: 'App\Mobile'
    }
}
