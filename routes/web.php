<?php

use App\Http\Controllers\API\ArtistController;
use App\Http\Controllers\API\PlaylistController;
use App\Http\Controllers\API\SongController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('api')->middleware('api')->group(function () {
    Route::apiResource('artists', ArtistController::class);
    Route::apiResource('songs', SongController::class);
    Route::apiResource('playlists', PlaylistController::class);
});
