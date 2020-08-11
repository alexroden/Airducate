<?php

namespace App\Bus\Commands\Users;

final class OnboardingCommand
{
    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $password;

    /**
     * @var array
     */
    public $questions;

    /**
     * @param string $user
     * @param string $password
     * @param array  $questions
     */
    public function __construct(
        string $user,
        string $password,
        array $questions = []
    ) {
        $this->user = $user;
        $this->password = $password;
        $this->questions = $questions;
    }
}
