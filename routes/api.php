<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DatabaseController;
use App\Http\Controllers\Api\WebspaceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/plans', [PlanController::class, 'index']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/databases', [DatabaseController::class, 'index']);
    Route::get('/webspaces', [WebspaceController::class, 'index']);

});