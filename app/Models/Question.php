<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 🔹 Import des modèles utilisés
use App\Models\Qcm;
use App\Models\Reponse;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'qcm_id',
        'question', // correspond au nom de la colonne dans ta migration
    ];

    // Relation avec QCM
    public function qcm()
    {
        return $this->belongsTo(Qcm::class, 'qcm_id');
    }

    // Relation avec les réponses
    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'question_id');
    }
}
