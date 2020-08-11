<?php

namespace App\Bus\Exceptions;

use Exception;
use Throwable;

class InvalidPermissionsException extends Exception implements ExceptionInterface
{
    /**
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
