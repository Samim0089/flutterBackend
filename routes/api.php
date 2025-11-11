<?php

use App\Http\Controllers\MytableController;
use Illuminate\Support\Facades\Route;

Route::get('/mytable', [MytableController::class, 'index']);
Route::get('/mytable/{id}', [MytableController::class, 'show']);
Route::post('/mytable', [MytableController::class, 'store']);
Route::put('/mytable/{id}', [MytableController::class, 'update']);
Route::delete('/mytable/{id}', [MytableController::class, 'destroy']);


