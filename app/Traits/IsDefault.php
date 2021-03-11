<?php

namespace App\Traits;

trait IsDefault
{

    public function scopeIsDefault($query)
    {
        return $query->where('is_default', '=', 1);
    }

}
