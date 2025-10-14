<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InvalidCredentialsException extends Exception
{
    /**
     * The status code of the exception.
     *
     * @var int
     */
    public $status = Response::HTTP_UNAUTHORIZED;

    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->message =  __('errors.invalid_credentials');
    }
}
