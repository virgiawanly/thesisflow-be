<?php

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Lecturer\TopicOfferController as LecturerTopicOfferController;
use App\Http\Controllers\V1\Misc\FieldTaxonomyController as MiscFieldTaxonomyController;
use App\Http\Controllers\V1\SystemAdmin\FieldTaxonomyController as SystemAdminFieldTaxonomyController;
use App\Http\Controllers\V1\Coordinator\ThesisPeriodController as CoordinatorThesisPeriodController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
  Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
  Route::get('me', [AuthController::class, 'me']);
});

Route::middleware('auth:sanctum')->prefix('misc')->group(function () {
  Route::get('field-taxonomies', [MiscFieldTaxonomyController::class, 'nestedList']);
});

Route::middleware('auth:sanctum')->prefix('system-admin')->group(function () {
  Route::apiResource('field-taxonomies', SystemAdminFieldTaxonomyController::class);
});

Route::middleware('auth:sanctum')->prefix('coordinator')->group(function () {
  Route::apiResource('thesis-periods', CoordinatorThesisPeriodController::class);
});

Route::middleware('auth:sanctum', 'user-type:lecturer')->prefix('lecturer')->group(function () {
  Route::apiResource('topic-offers', LecturerTopicOfferController::class);
});

Route::middleware('auth:sanctum', 'user-type:student')->prefix('student')->group(function () {
  // 
});
