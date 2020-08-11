<?php

use Illuminate\Contracts\Bus\Dispatcher;

if (!function_exists('execute')) {
    /**
     * Send the given command to the dispatcher for execution.
     *
     * @param object $command
     *
     * @return mixed
     */
    function execute($command)
    {
        return app(Dispatcher::class)->dispatch($command);
    }
}
