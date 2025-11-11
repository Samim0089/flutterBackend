<?php

use App\Http\Controllers\MytableController;
use Illuminate\Support\Facades\Route;



Route::get('/mytable', [MytableController::class, 'index']);        // List all
Route::get('/mytable/{id}', [MytableController::class, 'show']);    // Single row
Route::post('/mytable', [MytableController::class, 'store']);       // Add
Route::put('/mytable/{id}', [MytableController::class, 'update']);  // Update
Route::delete('/mytable/{id}', [MytableController::class, 'destroy']); // Delete

