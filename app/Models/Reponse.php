<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'reponse',   // texte de la réponse
        'correct',   // true/false si c'est la bonne réponse
    ];

    // Relation vers la question
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
