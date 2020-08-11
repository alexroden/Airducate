<?php

namespace App\Bus\Handlers\Commands\Users;

use App\Bus\Commands\Users\LoginCommand;
use App\Bus\Events\Users\UserHasLoggedInEvent;
use App\Bus\Exceptions\User\InvalidUserCredentialsException;
use Illuminate\Support\Facades\Auth;

class LoginCommandHandler
{
    /**
     * @param \App\Bus\Commands\Users\LoginCommand $command
     *
     * @throws \App\Bus\Exceptions\User\InvalidUserCredentialsException
     */
    public function handle(LoginCommand $command): void
    {
        if (!Auth::attempt([
            'email'    => $command->email,
            'password' => $command->password,
        ])) {
            throw new InvalidUserCredentialsException();
        }

        event(new UserHasLoggedInEvent(Auth::user()));
    }
}
