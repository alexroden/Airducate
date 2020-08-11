<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\View;

class ModuleController extends Controller
{
    /**
     * @param \App\Models\Module $module
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function get(Module $module)
    {
        return View::make('module')
            ->withModule($module);
    }

    /**
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function user(User $user)
    {
        return View::make('modules')
            ->withUser($user);
    }

}
