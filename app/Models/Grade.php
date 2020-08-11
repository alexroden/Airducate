<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int   user_id
 * @property int   assignment_id
 * @property float progress
 * @property float score
 *
 * @property \App\Models\User       user
 * @property \App\Models\Assignment assignment
 */
class Grade extends AbstractModel
{
    /**
     * @var float
     */
    const THRESHOLD = 0.95;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'assignment_id',
        'progress',
        'score',
        'completed_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'user_id'       => 'int',
        'assignment_id' => 'int',
        'progress'      => 'float',
        'score'         => 'float',
        'completed_at'  => 'datetime',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'user_id'       => 'required|int',
        'assignment_id' => 'required|int',
        'progress'      => 'nullable|numeric',
        'score'         => 'nullable|numeric',
        'completed_at'  => 'nullable|date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereNotNull('completed_at');
    }
}
