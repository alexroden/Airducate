<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Traits\Unauthorised;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthenticate
{
    use Unauthorised;

    /**
     * @var string[]
     */
    const GUEST_ROUTES = [
        'api.login',
        'api.register',
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $guestToken = $request->header('Guest-Token');
        $userToken = $request->header('User-Token');

        if ($guestToken !== null && $userToken === null) {
            if (
                $guestToken !== $request->session()->token()
                || !in_array($request->route()->getName(), self::GUEST_ROUTES)
            ) {
                return $this->handleError();
            }
        } else {
            if (!$userToken) {
                return $this->handleError();
            }

            Auth::setUser(User::findByToken($userToken));
        }

        return $next($request);
    }
}
