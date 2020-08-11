<?php

namespace App\Bus\Commands\Users;

final class InviteUserCommand
{
    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $email;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $email
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }
}
