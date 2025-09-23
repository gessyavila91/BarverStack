<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BarbershopController;
use App\Http\Controllers\ServiceController;

Route::apiResource('clients', ClientController::class);
Route::apiResource('barbershops', BarbershopController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('appointments', AppointmentController::class);
