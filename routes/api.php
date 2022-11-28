<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\OrganizationController;
use App\Http\Controllers\api\v1\PositionController;
use App\Http\Controllers\api\v1\UserController;

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
Route::middleware('auth:api')->group(function(){
    Route::apiResource('organizations', OrganizationController::class);
    Route::put('organization/change_active/{id}', [OrganizationController::class, 'changeActive']);
    Route::get('organization/for_auto_complete', [OrganizationController::class, 'getAllForAutoComplete']);

    Route::apiResource('positions', PositionController::class);
    Route::put('position/change_active/{id}', [PositionController::class, 'changeActive']);
    Route::get('position/for_auto_complete', [PositionController::class, 'getAllForAutoComplete']);

    Route::apiResource('users', UserController::class);
    Route::put('user/change_active/{user}', [UserController::class, 'changeActive']);
    Route::get('auth_user', [UserController::class, 'authUser']);
});
