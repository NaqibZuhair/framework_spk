<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JuryCriterion extends Model
{
    protected $table = 'jury_criteria';

    protected $fillable = [
        'period_id',
        'user_id',
        'criterion_id',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(ElectionPeriod::class, 'period_id');
    }

    public function jury(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class, 'criterion_id');
    }
}