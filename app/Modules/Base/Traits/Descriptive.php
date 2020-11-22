<?php

namespace App\Modules\Base\Traits;

trait Descriptive
{
    public function getReadableAttribute(): string
    {
        return $this->description ? $this->description : 'Sin descripción';
    }
}
