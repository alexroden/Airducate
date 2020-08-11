<?php

namespace App\Http\Controllers\Api;

use AltThree\Validator\ValidationException;
use App\Bus\Commands\Users\InviteUserCommand;
use App\Http\Exceptions\Routing\UnauthorisedException;
use App\Http\Requests\InviteRequest;
use App\Models\Category;
use App\Models\Group;
use App\Models\Module;
use App\Models\Type;
use App\Models\User;
use GrahamCampbell\Binput\Facades\Binput;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends AbstractApiController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(): JsonResponse
    {
        $user = Auth::user();
        if ($user === null) {
            throw new UnauthorisedException();
        }

        if ($user->groups()->count() === 0) {
            return $this->noContent();
        }

        return $this->collection($user->groups->flatMap(function (Group $group) {
            return $group->modules;
        }));
    }

    /**
     * @param \App\Models\Module $module
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignments(Module $module): JsonResponse
    {
        return $this->collection($module->assignments);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function filters(): JsonResponse
    {
        return $this->item([
            'categories' => Category::all(),
            'types'      => Type::all(),
        ]);
    }

}
