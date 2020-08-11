<?php

namespace App\Models;

/**
 * @property int user_id
 * @property int group_id
 */
class UserGroup extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'group_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'user_id'  => 'int',
        'group_id' => 'int',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'user_id'  => 'required|int',
        'group_id' => 'required|int',
    ];
}
