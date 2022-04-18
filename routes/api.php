<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, "login"]);
    Route::post('logout', [AuthController::class, "logout"]);
    Route::post('refresh', [AuthController::class, "refresh"]);
    Route::get('me', [AuthController::class, "me"]);
});

Route::group([
    "middleware" => "auth:api",
    "prefix" => "meta"
], function(){
    Route::get("permission", [\App\Http\Controllers\MetaController::class, "permissionIndex"]);
    Route::get("role", [\App\Http\Controllers\MetaController::class, "roleIndex"]);
});

Route::group([
    "middleware" => "auth:api",
    "prefix" => "user"
], function(){
    Route::get("", [UserController::class, "index"])->middleware(["can:view users"]);
    Route::get("{user}", [UserController::class, "show"])->middleware(["can:view users"]);
    Route::post("", [UserController::class, "store"])->middleware(["can:create users"]);
    Route::put("{user}", [UserController::class, "update"])->middleware(["can:create users"]);
    Route::delete("{user}", [UserController::class, "destroy"])->middleware(["can:create users"]);
});
