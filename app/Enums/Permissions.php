<?php

namespace App\Enums;

use App\Enums\Traits\ConstantsTrait;

final class Permissions
{
    use ConstantsTrait;

    /**
     * @var string
     */
    const INVITE_USERS = 'invite users';
}
