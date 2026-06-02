<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'candidate_id',
        'user_id',
        'criterion_id',
        'score',
    ];

    protected $casts = [
        'period_id' => 'integer',
        'candidate_id' => 'integer',
        'user_id' => 'integer',
        'criterion_id' => 'integer',
        'score' => 'decimal:2',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(ElectionPeriod::class, 'period_id');
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
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
