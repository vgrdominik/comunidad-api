<?php

namespace App\Modules\Base\Traits;

trait Availability
{
    public function isAvailable(): bool
    {
        return $this->is_available;
    }

    // Repository

    public function scopeAvailable($query)
    {
        return $query->where('is_available', 1);
    }
}
