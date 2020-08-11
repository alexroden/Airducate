<?php

namespace Tests\Routes\Concerns;

trait Session
{
    /**
     * @param string $token
     */
    public function setToken(string $token = 'foo')
    {
        $this->session(['_token' => $token]);
    }
}
