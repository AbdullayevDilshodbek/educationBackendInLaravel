<?php

namespace App\Http\Routes;

use App\Http\Controllers\api\v1\UserController;
use Illuminate\Support\Facades\Route;

class UserRouter
{
    public static function routes()
    {
        Route::put('user/change_active/{user}', [UserController::class, 'changeActive']);
        Route::get('auth_user', [UserController::class, 'authUser']);
        Route::post('user/upload_image', [UserController::class, 'uploadImage']);
        Route::apiResource('users', UserController::class);
    }
}
