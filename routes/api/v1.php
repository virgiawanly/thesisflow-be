<?php

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\SystemAdmin\FieldTaxonomyController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
  Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->prefix('system-admin')->group(function () {
  Route::apiResource('field-taxonomies', FieldTaxonomyController::class);
});

Route::middleware('auth:sanctum')->prefix('coordinator')->group(function () {
  // 
});

Route::middleware('auth:sanctum')->prefix('lecturer')->group(function () {
  // 
});

Route::middleware('auth:sanctum')->prefix('student')->group(function () {
  // 
});
