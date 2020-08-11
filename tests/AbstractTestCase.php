<?php

namespace Tests;

use GrahamCampbell\TestBenchCore\MockeryTrait;
use Illuminate\Foundation\Testing\TestCase;

abstract class AbstractTestCase extends TestCase
{
    use CreatesApplication;
    use MockeryTrait;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';
}
