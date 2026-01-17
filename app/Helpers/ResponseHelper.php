<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class ResponseHelper
{
  /**
   * Return success response.
   *
   * @param  string|null $message
   * @param  mixed|null $data
   * @param  int $status
   * @return \Illuminate\Http\JsonResponse
   */
  public static function success(string|null $message = null, mixed $data = null, int $status = 200): JsonResponse
  {
    $response = [
      'error' => false,
      'status' => $status,
    ];

    if ($data) {
      $response['data'] = $data;
    }

    if ($message) {
      $response['message'] = $message;
    }

    return response()->json($response);
  }

  /**
   * Return error response for thrown exception.
   *
   * @param  Throwable $exception
   * @return \Illuminate\Http\JsonResponse
   */
  public static function exceptionError(Throwable $exception): JsonResponse
  {
    $response = [
      'error' => true,
      'status' => $exception->status ?? 500,
      'message' => $exception->getMessage(),
    ];

    if ($exception && config('app.debug') && ($exception->status ?? 500) >= 500) {
      $response['exception'] = [
        'message' => $exception->getMessage(),
        'code' => $exception->getCode(),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'trace' => $exception->getTrace(),
      ];
    }

    return response()->json($response, $exception->status ?? 500);
  }

  /**
   * Return data response.
   *
   * @param  mixed $data
   * @param  string|null $message
   * @param  int $status
   * @return \Illuminate\Http\JsonResponse
   */
  public static function data(mixed $data, string|null $message = null, int $status = 200): JsonResponse
  {
    $response = [
      'error' => false,
      'status' => $status,
      'data' => $data,
    ];

    if ($message) {
      $response['message'] = $message;
    }

    return response()->json($response, $status);
  }

  /**
   * Return 404 not found response.
   *
   * @param  string|null $message
   * @return \Illuminate\Http\JsonResponse
   */
  public static function notFound(string|null $message = null): JsonResponse
  {
    return response()->json([
      'error' => true,
      'status' => 404,
      'message' => $message ? $message : __('messages.resource_not_found'),
    ], 404);
  }

  /**
   * Return 401 unauthorized response.
   *
   * @param  string|null $message
   * @return \Illuminate\Http\JsonResponse
   */
  public static function unauthorized(string|null $message = null): JsonResponse
  {
    return response()->json([
      'error' => true,
      'status' => 401,
      'message' => $message ? $message : __('messages.sorry_not_authorized'),
    ], 401);
  }

  /**
   * Return 403 forbidden response.
   *
   * @param  string|null $message
   * @return \Illuminate\Http\JsonResponse
   */
  public static function forbidden(string|null $message = null): JsonResponse
  {
    return response()->json([
      'error' => true,
      'status' => 403,
      'message' => $message ? $message : __('messages.sorry_forbidden'),
    ], 403);
  }

  /**
   * Return 400 bad request response.
   *
   * @param  string|null $message
   * @return \Illuminate\Http\JsonResponse
   */
  public static function badRequest(string|null $message = null): JsonResponse
  {
    return response()->json([
      'error' => true,
      'status' => 400,
      'message' => $message ? $message : __('messages.sorry_bad_request'),
    ], 400);
  }

  /**
   * Return 500 internal server error response.
   *
   * @param  string|null $message
   * @return \Illuminate\Http\JsonResponse
   */
  public static function internalServerError(string|null $message = null, Exception|null $exception = null, bool $sendLog = true): JsonResponse
  {
    if ($exception && $sendLog) {
      // Log exception here (e.g. sentry)
    }

    $errorMessage = $message;

    if (!config('app.debug')) {
      $errorMessage = __('messages.sorry_something_went_wrong');
    }

    $response = [
      'error' => true,
      'status' => 500,
      'message' => $errorMessage,
    ];

    if ($exception && config('app.debug')) {
      $response['exception'] = [
        'message' => $exception->getMessage(),
        'code' => $exception->getCode(),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'trace' => $exception->getTrace(),
      ];
    }

    return response()->json($response, 500);
  }

  /**
   * Return 422 validation error response.
   *
   * @param  string|null $message
   * @param  mixed|null $errors
   */
  public static function validationError(string|null $message = null, mixed $errors = null): JsonResponse
  {
    $response = [
      'error' => true,
      'status' => 422,
      'message' => $message ? $message : __('messages.validation_failed'),
    ];

    if ($errors) {
      $response['errors'] = $errors;
    } else {
      // Set default errors, laravel validation
      $response['errors'] = [
        'error' => [$message ? $message : __('messages.validation_failed')],
      ];
    }

    return response()->json($response, 422);
  }
}
