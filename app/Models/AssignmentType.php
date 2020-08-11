<?php

namespace App\Models;

/**
 * @property int assignment_id
 * @property int type_id
 */
class AssignmentType extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'assignment_id',
        'type_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'assignment_id' => 'int',
        'type_id'       => 'int',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'assignment_id' => 'required|int',
        'type_id'       => 'required|int',
    ];
}
