<?php

namespace App\Http\Routes;

use App\Http\Controllers\api\v1\SubjectController;
use Illuminate\Support\Facades\Route;

class SubjectRouter
{
    public static function routes()
    {
        Route::apiResource('subjects', SubjectController::class);
        Route::put('subject/change_active/{subject}', [SubjectController::class, 'changeActive']);
    }
}
