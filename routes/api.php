<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\OrganizationController;

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

Route::middleware('auth:api')->group(function(){
    Route::apiResource('organizations', OrganizationController::class);
    Route::put('organization', [OrganizationController::class, 'changeActive']);
});
