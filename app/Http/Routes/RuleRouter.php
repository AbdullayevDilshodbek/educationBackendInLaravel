<?php

namespace App\Http\Routes;

use App\Http\Controllers\api\v1\RuleController;
use App\Http\Controllers\api\v1\RuleModelController;
use Illuminate\Support\Facades\Route;

class RuleRouter
{
    public static function routes()
    {
        Route::apiResource('rule_models', RuleModelController::class);
        Route::apiResource('rules/', RuleController::class);
    }
}
