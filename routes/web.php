<?php

use App\Enums\Roles;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AuthController@login')
    ->name('login')
    ->middleware('auth.redirect');

Route::get('register/{token}', 'RegisterController')
    ->name('register');

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', 'AuthController@logout')
        ->name('logout');

    Route::get('invite', 'InviteController')
        ->name('invite')
        ->middleware('role:'.Roles::ADMINISTRATOR);

    Route::get('{user}', 'DashboardController')
        ->name('dashboard');

    Route::get('{user}/modules', 'ModuleController@user')
        ->name('user.modules');

    Route::get('modules/{module}', 'ModuleController@get')
        ->name('module')
        ->middleware('assigned');

    Route::get('modules/{module}/assignments/{assignment}', 'AssignmentController')
        ->name('assignment');

    Route::get('documents/{document}', 'DocumentController')
        ->name('document');
});
