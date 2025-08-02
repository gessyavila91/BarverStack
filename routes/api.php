<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\BarberiaController;
use App\Http\Controllers\ServicioController;

Route::apiResource('clientes', ClienteController::class);
Route::apiResource('barberias', BarberiaController::class);
Route::apiResource('servicios', ServicioController::class);
