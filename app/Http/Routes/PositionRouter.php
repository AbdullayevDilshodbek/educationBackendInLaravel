<?php

namespace App\Http\Routes;

use App\Http\Controllers\api\v1\PositionController;
use Illuminate\Support\Facades\Route;

class PositionRouter
{
    public static function routes()
    {
        Route::put('position/change_active/{id}', [PositionController::class, 'changeActive']);
        Route::get('position/for_auto_complete', [PositionController::class, 'getAllForAutoComplete']);
        Route::apiResource('positions', PositionController::class);
    }
}
