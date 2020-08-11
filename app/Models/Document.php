<?php

namespace App\Models;

use App\Models\Concerns\HasToken;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    id
 * @property string token
 * @property string path
 * @property string name
 * @property string type
 * @property string mime_type
 * @property string description
 */
class Document extends Model
{
    use HasToken;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'token',
        'path',
        'type',
        'mime_type',
        'name',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'token'       => 'string',
        'path'        => 'string',
        'type'        => 'string',
        'mime_type'   => 'string',
        'name'        => 'string',
        'description' => 'string',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'token'       => 'nullable|string',
        'path'        => 'required|string',
        'type'        => 'required|string',
        'mime_type'   => 'required|string',
        'name'        => 'nullable|string',
        'description' => 'nullable|string',
    ];
}
