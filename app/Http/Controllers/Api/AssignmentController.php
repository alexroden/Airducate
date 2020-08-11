<?php

namespace App\Http\Controllers\Api;

use AltThree\Validator\ValidationException;
use App\Bus\Commands\Assignments\AssignmentCommand;
use App\Bus\Commands\Users\OnboardingCommand;
use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends AbstractApiController
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\AssignmentRequest $request
     * @param \App\Models\Assignment               $assignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(AssignmentRequest $request, Assignment $assignment): JsonResponse
    {
        $data = $request->validated();

        try {
            execute(new AssignmentCommand(
                $request->user(),
                $assignment,
                Arr::get($data, 'progress'),
                Arr::get($data, 'score')
            ));
        } catch (ValidationException $e) {
            throw $e;
        }

        return $this->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assignment   $assignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGrade(Request $request, Assignment $assignment): JsonResponse
    {
        return $this->collection(
            $request->user()
                ->grades()
                ->where('assignment_id', '=', $assignment->id)
                ->get()
        );
    }
}
