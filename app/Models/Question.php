<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'qcm_id',
        'question',
    ];

    // Relation vers le QCM
    public function qcm()
    {
        return $this->belongsTo(Qcm::class, 'qcm_id');
    }

    // Relation vers les réponses
    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'question_id');
    }

    // Relation pour obtenir la réponse correcte
    public function reponseCorrecte()
    {
        return $this->hasOne(Reponse::class, 'question_id')->where('is_correct', true);
    }

    // Alias pour compatibilité
    public function options()
    {
        return $this->reponses();
    }
}