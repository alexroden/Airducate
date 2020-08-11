<?php

namespace App\Http\Middleware;

use App\Models\Grade;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class Assigned
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $userAssignments = $user->grades->map(function (Grade $grade) {
            return $grade->assignment;
        });

        $module = Arr::get($request->route()->parameters, 'module');
        if ($module->assignments()->whereIn('assignments.id', $userAssignments->pluck('id'))->count() === 0) {
            return Redirect::route('dashboard', [$user]);
        }

        return $next($request);
    }
}
