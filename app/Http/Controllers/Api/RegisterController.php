<?php

namespace App\Http\Controllers\Api;

use AltThree\Validator\ValidationException;
use App\Bus\Commands\Users\OnboardingCommand;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController extends AbstractApiController
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            execute(new OnboardingCommand(
                $data['user'],
                $data['password'],
                $data['questions'] ?? []
            ));
        } catch (ValidationException $e) {
            throw $e;
        }

        return $this->item(['route' => route('dashboard', ['user' => Auth::user()->token])]);
    }
}
