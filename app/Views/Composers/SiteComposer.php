<?php

namespace App\Views\Composers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SiteComposer
{
    /**
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view): void
    {
        $user = Auth::user();

        $view->withAuth($user);
        $view->withGrades($user !== null ? $user->grades()->completed()->get() : Collection::make());
        $view->withPermissions($user !== null ? $user->getAllPermissions() : Collection::make());
        $view->withToken(request()->session()->token());
    }
}
