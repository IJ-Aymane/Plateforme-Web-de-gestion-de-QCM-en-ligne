<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qcm extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'user_id',
    ];

    // Relation avec User (créateur du QCM)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec Question
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relation avec Resultat
    public function resultats()
    {
        return $this->hasMany(Resultat::class);
    }
}
