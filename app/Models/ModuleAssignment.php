<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int module_id
 * @property int assignment_id
 */
class ModuleAssignment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'module_id',
        'assignment_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'module_id'   => 'int',
        'assignment_id' => 'int',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'module_id'   => 'required|int',
        'assignment_id' => 'required|int',
    ];
}
