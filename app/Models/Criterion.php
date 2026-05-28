<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criterion extends Model
{
    protected $table = 'criteria';

    protected $fillable = [
        'period_id',
        'code',
        'name',
        'weight',
        'type',
        'min_score',
        'max_score',
        'is_active',
    ];

    protected $casts = [
        'weight' => 'decimal:4',
        'min_score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(ElectionPeriod::class, 'period_id');
    }

    public function juryCriteria(): HasMany
    {
        return $this->hasMany(JuryCriterion::class, 'criterion_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class, 'criterion_id');
    }
}