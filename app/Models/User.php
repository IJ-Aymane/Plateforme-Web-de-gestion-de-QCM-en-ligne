<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 🔹 Import des modèles utilisés dans les relations
use App\Models\Qcm;
use App\Models\Resultat;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

   

   
    public function qcms()
    {
        return $this->hasMany(Qcm::class, 'enseignant_id');
    }

    
    public function resultats()
    {
        return $this->hasMany(Resultat::class, 'etudiant_id');
    }
}
