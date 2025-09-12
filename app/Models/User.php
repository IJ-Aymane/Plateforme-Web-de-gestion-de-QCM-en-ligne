<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $email
 * @property string $password
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 *
 * Relations:
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Qcm> $qcm
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Resultat> $resultats
 *
 * Accessors:
 * @property-read string $full_name
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relations
     */
    public function qcm(): HasMany
    {
        return $this->hasMany(Qcm::class, 'enseignant_id');
    }

    public function resultats(): HasMany
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
    public function getFullNameAttribute(): string
    {
        return $this->nom . ' ' . $this->prenom;
    }
}
