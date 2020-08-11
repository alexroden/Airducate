<?php

namespace App\Models;

use App\Models\Concerns\HasToken;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property string name
 * @property string description
 *
 * @property \Illuminate\Support\Collection assignments
 * @property \Illuminate\Support\Collection categories
 * @property \Illuminate\Support\Collection groups
 * @property \Illuminate\Support\Collection types
 */
class Module extends AbstractModel
{
    use HasToken;

    /**
     * The accessors to append to the model's array form.
     *
     * @var string[]
     */
    protected $appends = [
        'route',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'token',
        'name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'token' => 'string',
        'name'  => 'string',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'token' => 'nullable|string',
        'name'  => 'required|string',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var string[]
     */
    protected $with = [
        'categories',
        'types',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function assignments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Assignment::class,
            ModuleAssignment::class,
            null,
            'id',
            'id',
            'assignment_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function categories(): HasManyThrough
    {
        return $this->hasManyThrough(
            Category::class,
            ModuleCategory::class,
            null,
            'id',
            'id',
            'category_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function groups(): HasManyThrough
    {
        return $this->hasManyThrough(
            Group::class,
            GroupModule::class,
            null,
            'id',
            'id',
            'group_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function types(): HasManyThrough
    {
        return $this->hasManyThrough(
            Type::class,
            ModuleType::class,
            null,
            'id',
            'id',
            'type_id'
        );
    }

    /**
     * @return string
     */
    public function getRouteAttribute(): string
    {
        return route('module', ['module' => $this]);
    }

}
