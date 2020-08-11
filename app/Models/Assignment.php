<?php

namespace App\Models;

use App\Models\Concerns\HasToken;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int    id
 * @property string token
 * @property int    type
 * @property string name
 * @property string description
 * @property string source
 * @property string content
 * @property string cover_image
 * @property float  length
 *
 * @property \Illuminate\Support\Collection categories
 * @property \Illuminate\Support\Collection modules
 * @property \Illuminate\Support\Collection types
 */
class Assignment extends AbstractModel
{
    use HasToken;

    /**
     * @var int
     */
    const TYPE_LINK = 0;

    /**
     * @var int
     */
    const TYPE_VIDEO = 1;

    /**
     * @var int
     */
    const TYPE_AUDIO = 2;

    /**
     * @var int
     */
    const TYPE_MARKDOWN = 3;

    /**
     * @var int
     */
    const TYPE_DOCUMENT = 4;

    /**
     * @var string[]
     */
    const TYPES = [
        self::TYPE_LINK     => 'link',
        self::TYPE_VIDEO    => 'video',
        self::TYPE_AUDIO    => 'audio',
        self::TYPE_MARKDOWN => 'markdown',
        self::TYPE_DOCUMENT => 'document',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var string[]
     */
    protected $appends = [
        'modal',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'token',
        'type',
        'name',
        'description',
        'source',
        'content',
        'cover_image',
        'length',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'token'       => 'string',
        'type'        => 'int',
        'name'        => 'string',
        'description' => 'string',
        'source'      => 'string',
        'content'     => 'string',
        'cover_image' => 'string',
        'length'      => 'float',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'token'       => 'nullable|string',
        'type'        => 'required|int',
        'name'        => 'required|string',
        'description' => 'nullable|string',
        'source'      => 'nullable|string',
        'content'     => 'nullable|string',
        'cover_image' => 'nullable|string',
        'length'      => 'nullable|numeric',
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
    public function categories(): HasManyThrough
    {
        return $this->hasManyThrough(
            Category::class,
            AssignmentCategory::class,
            null,
            'id',
            'id',
            'category_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function modules(): HasManyThrough
    {
        return $this->hasManyThrough(
            Module::class,
            ModuleAssignment::class,
            null,
            'id',
            'id',
            'module_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function types(): HasManyThrough
    {
        return $this->hasManyThrough(
            Type::class,
            AssignmentType::class,
            null,
            'id',
            'id',
            'type_id'
        );
    }

    /**
     * @return string
     */
    public function getModalAttribute(): string
    {
        return self::TYPES[$this->type] . '-modal';
    }
}
