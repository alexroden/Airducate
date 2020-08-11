<?php

namespace App\Http\Exceptions\Routing;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UnauthorisedException extends UnauthorizedHttpException
{
    public function __construct(string $type)
    {
        parent::__construct($type, 'Unauthorised');
    }
}
