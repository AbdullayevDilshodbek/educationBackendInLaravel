<?php

namespace App\Http\Routes;

use App\Http\Controllers\api\v1\OrganizationController;
use Illuminate\Support\Facades\Route;

class OrganizationRouter
{
    public static function routes()
    {
        Route::apiResource('organizations', OrganizationController::class);
        Route::put('organization/change_active/{id}', [OrganizationController::class, 'changeActive']);
        Route::get('organization/for_auto_complete', [OrganizationController::class, 'getAllForAutoComplete']);
    }
}
