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

    // Relation vers les réponses (alias options)
    public function options()
    {
        return $this->hasMany(Reponse::class, 'question_id');
    }
}
