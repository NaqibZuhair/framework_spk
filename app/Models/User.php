<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function validatedCandidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'validated_by');
    }

    public function createdInterviews(): HasMany
    {
        return $this->hasMany(Interview::class, 'created_by');
    }

    public function juryCriteria(): HasMany
    {
        return $this->hasMany(JuryCriterion::class, 'user_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class, 'user_id');
    }

    public function calculatedArasResults(): HasMany
    {
        return $this->hasMany(ArasResult::class, 'calculated_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isJuri(): bool
    {
        return $this->role === 'juri';
    }
}
