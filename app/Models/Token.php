<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property string         type
 * @property string         token
 * @property \Carbon\Carbon expires_at
 */
class Token extends AbstractModel
{
    /**
     * @var string
     */
    const TYPE_ACCESS = 'access';

    /**
     * @var string
     */
    const TYPE_ONE_TIME = 'one-time';

    /**
     * @var string
     */
    protected static $salt = '1f6c171e-c132-40ff-9046-5b39f9d865a9';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'token',
        'expires_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'type'       => 'string',
        'token'      => 'string',
        'expires_at' => 'datetime',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'type'       => 'required|string',
        'token'      => 'required|string',
        'expires_at' => 'nullable|datetime',
    ];

    /**
     * @param array $data
     *
     * @return string
     */
    public static function generateToken(array $data): string
    {
        $data = implode('.', $data);

        return base64_encode(Carbon::now()->toDateTimeString(). '_' . self::$salt.$data);
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public static function validateToken(string $token): array
    {
        $data = base64_decode($token);
        $data = str_replace(self::$salt, '', $data);

        return explode('.', substr($data, strpos($data, "_") + 1, strlen($data)));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccess(Builder $query): Builder
    {
        return $query->where('type', '=', self::TYPE_ACCESS);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $token
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForToken(Builder $query, string $token): Builder
    {
        return $query->where('token', '=', $token);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOneTime(Builder $query): Builder
    {
        return $query->where('type', '=', self::TYPE_ACCESS);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValid(Builder $query): Builder
    {
        return $query->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'token';
    }
}
