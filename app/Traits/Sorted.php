<?php

namespace App\Traits;

trait Sorted
{

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

}
