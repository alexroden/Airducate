<?php

namespace App\Models\Concerns;

use DateTimeInterface;

trait DateTimeFormatter
{
    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
