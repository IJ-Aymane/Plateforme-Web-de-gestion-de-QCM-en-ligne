<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qcm extends Model
{
    use HasFactory;

    protected $table = 'qcm';

    protected $fillable = [
        'titre',
        'description',
        'enseignant_id',
    ];

    // Relation vers les questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'qcm_id');
    }

    // Relation vers l'enseignant (User)
    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }
}
