<?php

namespace App\Enums\Traits;

use ReflectionClass;

trait ConstantsTrait
{
    /**
     * @return array
     *
     * @throws \ReflectionException
     */
    static function getConstants(): array
    {
        $oClass = new ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }
}
