<?php

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Lecturer\TopicOfferController as LecturerTopicOfferController;
use App\Http\Controllers\V1\SystemAdmin\FieldTaxonomyController as SystemAdminFieldTaxonomyController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
  Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->prefix('system-admin')->group(function () {
  Route::apiResource('field-taxonomies', SystemAdminFieldTaxonomyController::class);
});

Route::middleware('auth:sanctum')->prefix('coordinator')->group(function () {
  // 
});

Route::middleware('auth:sanctum')->prefix('lecturer')->group(function () {
  Route::apiResource('topic-offers', LecturerTopicOfferController::class);
});

Route::middleware('auth:sanctum')->prefix('student')->group(function () {
  // 
});
