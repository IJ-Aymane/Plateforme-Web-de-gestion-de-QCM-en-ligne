<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'qcm_id',
        'score',
        'total_questions',
    ];

    // La ligne suivante est supprimée, car 'answers' n'est plus une colonne
    // protected $casts = ['answers' => 'array',];

    public function user()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    public function qcm()
    {
        return $this->belongsTo(Qcm::class, 'qcm_id');
    }
}