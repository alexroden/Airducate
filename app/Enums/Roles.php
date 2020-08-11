<?php

namespace App\Enums;

use App\Enums\Traits\ConstantsTrait;

final class Roles
{
    use ConstantsTrait;

    /**
     * @var string
     */
    const ADMINISTRATOR = 'administrator';

    /**
     * @var string
     */
    const USER = 'user';
}
