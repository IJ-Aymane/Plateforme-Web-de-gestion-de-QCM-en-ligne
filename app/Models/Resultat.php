<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 🔹 Import des modèles liés
use App\Models\User;
use App\Models\Qcm;

class Resultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id', // correspond à user_id dans la relation
        'qcm_id',
        'score',
        'completed_at', // correspond à date_passage dans ta migration
    ];

    // Relation avec User (étudiant)
    public function user()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    // Relation avec Qcm
    public function qcm()
    {
        return $this->belongsTo(Qcm::class, 'qcm_id');
    }
}
