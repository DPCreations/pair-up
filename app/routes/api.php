<?php

use App\Http\Controllers\Api\{GroupController, MovieRatingController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('group', GroupController::class);
Route::apiResource('movierating', MovieRatingController::class);
