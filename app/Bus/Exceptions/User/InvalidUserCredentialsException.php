<?php

namespace App\Bus\Exceptions\User;

use Exception;
use Illuminate\Http\Response;
use Throwable;

class InvalidUserCredentialsException extends Exception implements UserExceptionInterface
{
    /**
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = '', $code = Response::HTTP_UNAUTHORIZED, Throwable $previous = null)
    {
        if ($message === '') {
            $message = 'Invalid user credentials.';
        }

        parent::__construct($message, $code, $previous);
    }
}
