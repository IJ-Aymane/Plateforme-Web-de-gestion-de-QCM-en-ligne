<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',           // ✅ Changé de 'name' à 'nom'
        'prenom',        // ✅ Ajouté
        'email',         // ✅ Gardé
        'password',      // ✅ Gardé
        'role',          // ✅ Ajouté
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relations
     */
    public function qcms()
    {
        return $this->hasMany(Qcm::class, 'enseignant_id');
    }

    public function resultats()
    {
        return $this->hasMany(Resultat::class, 'etudiant_id');
    }

    /**
     * Scopes
     */
    public function scopeEnseignants($query)
    {
        return $query->where('role', 'enseignant');
    }

    public function scopeEtudiants($query)
    {
        return $query->where('role', 'etudiant');
    }

    /**
     * Accessors
     */
    public function getFullNameAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }
}