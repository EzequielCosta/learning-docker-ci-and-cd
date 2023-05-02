<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix("paciente")->group(function() {

    Route::delete(
        '/{pacienteId}',
        [\App\Http\Controllers\PacienteController::class, 'delete']
    );

    Route::get(
        '/',
        [\App\Http\Controllers\PacienteController::class, 'showAll']
    );

    Route::get(
        '/{pacienteId}',
        [\App\Http\Controllers\PacienteController::class, 'show']
    );

    Route::post(
        '/store',
        [\App\Http\Controllers\PacienteController::class, 'store']
    );

    Route::put(
        '/{pacienteId}',
        [\App\Http\Controllers\PacienteController::class, 'update']
    );



});

Route::fallback(function ($e) {
    return response()->json(
        [
            "status" => false,
            "message" => "Rota inexistente"
        ], 404
    );
});
