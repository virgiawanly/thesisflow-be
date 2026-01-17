<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class BadRequestException extends Exception
{
    /**
     * The status code of the exception.
     *
     * @var int
     */
    public $status = Response::HTTP_BAD_REQUEST;

    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct($message = null)
    {
        $this->message = $message ?? __('errors.bad_request');
    }
}
