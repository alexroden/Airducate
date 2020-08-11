<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'LoginController')->name('api.login');
Route::post('invite', 'InviteController')->name('api.invite');
Route::post('register', 'RegisterController')->name('api.register');
Route::get('modules', 'ModuleController@get')->name('api.modules.get');
Route::get('modules/{module}/assignments', 'ModuleController@assignments')->name('api.modules.assignments');
Route::post('assignments/{assignment}', 'AssignmentController@get')->name('api.assignment');
Route::get('assignments/{assignment}', 'AssignmentController@getGrade')->name('api.assignment');
Route::get('filters', 'ModuleController@filters')->name('api.filters');
