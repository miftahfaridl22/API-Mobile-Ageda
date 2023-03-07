<?php

use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tampilagenda', [AgendaController::class, 'tampilagenda']);
    Route::get('/tampilagendabesok', [AgendaController::class, 'tampilagendabesok']);
    Route::post('/tambahagenda', [AgendaController::class, 'tambahagenda']);
    Route::post('/cariagenda', [AgendaController::class, 'getlistagendatanggal']);
    Route::post('/logout', [AuthController::class, 'logout']);
});