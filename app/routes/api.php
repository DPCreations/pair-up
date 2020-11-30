<?php

use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\MovieRatingController;
use Illuminate\Support\Facades\Route;

Route::apiResource('group', GroupController::class);
Route::apiResource('movierating', MovieRatingController::class);
