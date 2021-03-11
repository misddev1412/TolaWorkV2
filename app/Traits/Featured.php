<?php

namespace App\Traits;

trait Featured
{

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', '=', 1);
    }

}
