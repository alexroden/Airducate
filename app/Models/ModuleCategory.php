<?php

namespace App\Models;

/**
 * @property int module_id
 * @property int category_id
 */
class ModuleCategory extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'module_id',
        'category_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'module_id'   => 'int',
        'category_id' => 'int',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'module_id'   => 'required|int',
        'category_id' => 'required|int',
    ];
}
