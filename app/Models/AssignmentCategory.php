<?php

namespace App\Models;

/**
 * @property int assignment_id
 * @property int category_id
 */
class AssignmentCategory extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'assignment_id',
        'category_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'assignment_id' => 'int',
        'category_id'   => 'int',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'assignment_id' => 'required|int',
        'category_id'   => 'required|int',
    ];
}
