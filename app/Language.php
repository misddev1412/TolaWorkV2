<?php

namespace App;

use App\Traits\IsDefault;
use App\Traits\Active;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

    use IsDefault;
    use Active;

    protected $table = 'languages';

    public function scopeSorted($query)
    {
        return $query->orderBy('lang');
    }

    public function scopeRTL()
    {
        return $query->where('is_rtl', '=', 1);
    }

}
