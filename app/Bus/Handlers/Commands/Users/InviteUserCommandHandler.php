<?php

namespace App\Bus\Handlers\Commands\Users;

use App\Bus\Commands\Users\InviteUserCommand;
use App\Bus\Events\Users\UserHasBeenInvitedEvent;
use App\Bus\Exceptions\InvalidPermissionsException;
use App\Enums\Permissions;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;

class InviteUserCommandHandler
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param \App\Bus\Commands\Users\InviteUserCommand $command
     *
     * @throws \App\Bus\Exceptions\InvalidPermissionsException
     */
    public function handle(InviteUserCommand $command): void
    {
        /** @var \App\Models\User $authUser */
        $authUser = $this->auth->user();
        if (!$authUser->hasPermissionTo(Permissions::INVITE_USERS)) {
            throw new InvalidPermissionsException(Permissions::INVITE_USERS);
        }

        $user = User::create($this->filter($command));

        $token = Token::create([
            'type'    => Token::TYPE_ACCESS,
            'token'   => Token::generateToken([$user->token]),
            'expires' => Carbon::now()->addDay(),
        ]);

        event(new UserHasBeenInvitedEvent($user, $token->token));
    }

    /**
     * @param \App\Bus\Commands\Users\InviteUserCommand $command
     *
     * @return array
     */
    protected function filter(InviteUserCommand $command): array
    {
        $params = [
            'first_name' => $command->firstName,
            'last_name'  => $command->lastName,
            'email'      => $command->email,
        ];

        return array_filter($params, function ($val) {
            return $val !== null && $val !== '';
        });
    }
}
