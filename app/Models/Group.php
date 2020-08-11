<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int    id
 * @property string name
 * @property string description
 *
 * @property \Illuminate\Support\Collection modules
 * @property \Illuminate\Support\Collection users
 */
class Group extends AbstractModel
{
    /**
     * @var string
     */
    const GROUP_PILOTS = 'Pilot';

    /**
     * @var string
     */
    const GROUP_STEWARDS = 'Steward';

    /**
     * @var string
     */
    const GROUP_ADMIN = 'Admin';

    /**
     * @var string[]
     */
    const GROUPS = [
        self::GROUP_PILOTS   => 1,
        self::GROUP_STEWARDS => 2,
        self::GROUP_ADMIN    => 3,
    ];

    /**
     * @var string
     */
    const QUESTIONS = [
        'What department fo you work in?',
        'What position are you?',
    ];

    /**
     * @var array
     */
    const ONBOARD_QUESTION_MAPPING = [
        self::QUESTIONS[0] => [
            'Flight Crew',
            'Office',
        ],
        self::QUESTIONS[1] => [
            'Flight Crew' => [
                'Pilot'   => self::GROUPS[self::GROUP_PILOTS],
                'Steward' => self::GROUPS[self::GROUP_STEWARDS],
            ],
            'Office'      => [
                'Admin' => self::GROUPS[self::GROUP_ADMIN],
            ],
        ],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'name'        => 'string',
        'description' => 'string',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'name'        => 'required|string',
        'description' => 'nullable|string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function modules(): HasManyThrough
    {
        return $this->hasManyThrough(
            Module::class,
            GroupModule::class,
            null,
            'id',
            'id',
            'module_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            UserGroup::class,
            null,
            'id',
            'id',
            'user_id'
        );
    }
}
