<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'registration_number',
        'full_name',
        'student_number',
        'email',
        'phone',
        'faculty',
        'study_program',
        'semester',
        'vision',
        'mission',
        'photo_file',
        'cv_file',
        'status',
        'validated_by',
        'validated_at',
        'rejection_reason',
    ];

    protected $casts = [
        'period_id' => 'integer',
        'semester' => 'integer',
        'validated_by' => 'integer',
        'validated_at' => 'datetime',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(ElectionPeriod::class, 'period_id');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function interview(): HasOne
    {
        return $this->hasOne(Interview::class, 'candidate_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class, 'candidate_id');
    }

    public function arasResult(): HasOne
    {
        return $this->hasOne(ArasResult::class, 'candidate_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeValid($query)
    {
        return $query->where('status', 'valid');
    }

    public function scopeInvalid($query)
    {
        return $query->where('status', 'invalid');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_file
            ? asset('storage/' . $this->photo_file)
            : null;
    }

    public function getCvUrlAttribute(): ?string
    {
        return $this->cv_file
            ? asset('storage/' . $this->cv_file)
            : null;
    }
}
