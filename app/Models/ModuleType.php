<?php

namespace App\Models;

/**
 * @property int module_id
 * @property int type_id
 */
class ModuleType extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'module_id',
        'type_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'module_id' => 'int',
        'type_id'   => 'int',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'module_id' => 'required|int',
        'type_id'   => 'required|int',
    ];
}
