<?php

use App\Http\Controllers\api\v1\CowController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("/v1/auth")->group(function () {
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [AuthController::class, "register"]);
});

Route::middleware('auth:sanctum')->prefix("/v1/cows")->group(function () {
    Route::get("/", [CowController::class, 'index']);
    Route::post("/add", [CowController::class, "store"]);
});
