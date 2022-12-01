<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Routes\OrganizationRouter;
use App\Http\Routes\PositionRouter;
use App\Http\Routes\SubjectRouter;
use App\Http\Routes\UserRouter;

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

Route::post('get_token', [UserController::class, 'login']);
Route::group(['middleware' => 'auth:api'], function () {
    OrganizationRouter::routes();
    PositionRouter::routes();
    UserRouter::routes();
    SubjectRouter::routes();
});
