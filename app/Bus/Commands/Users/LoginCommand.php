<?php

namespace App\Bus\Commands\Users;

final class LoginCommand
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        string $email,
        string $password
    ) {
        $this->email = $email;
        $this->password = $password;
    }
}
