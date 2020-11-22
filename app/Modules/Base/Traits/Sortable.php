<?php

namespace App\Modules\Base\Traits;

trait Sortable
{
    // Repository

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'ASC');
    }
}
