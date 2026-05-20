<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AnimalApiController;

Route::get('/animals', [AnimalApiController::class, 'index']);
Route::get('/animals/{animal}', [AnimalApiController::class, 'show']);
Route::get('/schedules', [AnimalApiController::class, 'schedules']);
