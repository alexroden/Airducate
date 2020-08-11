<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property string name
 *
 * @property \Illuminate\Support\Collection assignments
 * @property \Illuminate\Support\Collection modules
 */
class Type extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'name' => 'required|string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function assignments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Assignment::class,
            AssignmentType::class,
            null,
            'id',
            'id',
            'assignment_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function modules(): HasManyThrough
    {
        return $this->hasManyThrough(
            Module::class,
            ModuleType::class,
            null,
            'id',
            'id',
            'module_id'
        );
    }
}
