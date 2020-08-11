<?php

namespace App\Http\Controllers\Api;

use AltThree\Validator\ValidationException;
use App\Bus\Commands\Users\LoginCommand;
use App\Bus\Commands\Users\OnboardingCommand;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends AbstractApiController
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            execute(new LoginCommand(
                $data['email'],
                $data['password']
            ));
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->item(['route' => route('dashboard', ['user' => Auth::user()->token])]);
    }
}
