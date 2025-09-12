<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\User;
use App\Models\Qcm;

class Resultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id', 
        'qcm_id',
        'score',
        'completed_at',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

   
    public function qcm()
    {
        return $this->belongsTo(Qcm::class, 'qcm_id');
    }
}
