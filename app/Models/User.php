<?php

namespace App\Models;

use AltThree\Validator\ValidatingTrait;
use App\Models\Concerns\DateTimeFormatter;
use App\Models\Concerns\HasToken;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int    id
 * @property string token
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string password
 * @property string full_name
 * @property string api_token
 *
 * @property \Illuminate\Support\Collection grades
 * @property \Illuminate\Support\Collection groups
 */
class User extends Authenticatable
{
    use DateTimeFormatter;
    use HasRoles;
    use HasToken;
    use Notifiable;
    use ValidatingTrait;

    /**
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * The accessors to append to the model's array form.
     *
     * @var string[]
     */
    protected $appends = [
        'full_name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'token',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'token'      => 'string',
        'first_name' => 'string',
        'last_name'  => 'string',
        'email'      => 'string',
        'password'   => 'string',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'token'      => 'nullable|string',
        'first_name' => 'required|string',
        'last_name'  => 'required|string',
        'email'      => 'required|string|email',
        'password'   => 'nullable|string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function groups(): HasManyThrough
    {
        return $this->hasManyThrough(
            Group::class,
            UserGroup::class,
            null,
            'id',
            'id',
            'group_id'
        );
    }

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @param string $password
     *
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * @return string
     */
    public function routeNotificationForMail(): string
    {
        return $this->email;
    }
}
