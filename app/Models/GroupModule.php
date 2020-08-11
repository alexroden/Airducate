<?php

namespace App\Models;

/**
 * @property int group_id
 * @property int module_id
 */
class GroupModule extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'group_id',
        'module_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'group_id'  => 'int',
        'module_id' => 'int',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'group_id'  => 'required|int',
        'module_id' => 'required|int',
    ];
}
