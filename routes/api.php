<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ArticlesControllers;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/articles', [ArticlesControllers::class, 'getArticlesWithFilter']);
Route::post('/preference/get/all', [PreferenceController::class, 'getAllPreferences']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/articles/my', [ArticlesControllers::class, 'getMyArticles']);
    Route::post('/preference/get', [PreferenceController::class, 'getUserPreference']);
    Route::post('/preference/save', [PreferenceController::class, 'saveUserPreference']);
});
