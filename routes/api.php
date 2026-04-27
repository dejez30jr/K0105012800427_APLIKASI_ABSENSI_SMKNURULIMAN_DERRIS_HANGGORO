<?php

use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/users', [SiswaController::class, 'apiSiswa']);
Route::post('/users', [SiswaController::class, 'apiStore']);
Route::delete('/kelas/{id}', [SiswaController::class, 'kelasDestroy']);