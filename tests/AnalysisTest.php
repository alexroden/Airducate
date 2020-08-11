<?php

namespace Tests;

use GrahamCampbell\Analyzer\AnalysisTrait;
use PHPUnit\Framework\TestCase;

class AnalysisTest extends TestCase
{
    use AnalysisTrait;

    protected function getPaths()
    {
        return [
            realpath(__DIR__.'/../app'),
            realpath(__DIR__.'/../bootstrap'),
            realpath(__DIR__.'/../config'),
            realpath(__DIR__.'/../database'),
            realpath(__DIR__),
        ];
    }
}
