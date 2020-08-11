<?php

namespace App\Http\Controllers\Api;

use AltThree\Validator\ValidationException;
use App\Bus\Commands\Users\InviteUserCommand;
use App\Http\Requests\InviteRequest;
use GrahamCampbell\Binput\Facades\Binput;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InviteController extends AbstractApiController
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\InviteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(InviteRequest $request): JsonResponse
    {
        try {
            execute(new InviteUserCommand(
                Binput::get('first_name'),
                Binput::get('last_name'),
                Binput::get('email')
            ));
        } catch (ValidationException $e) {
            throw $e;
        }

        return $this->noContent();
    }
}
