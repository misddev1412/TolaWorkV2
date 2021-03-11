<?php

namespace App\Traits;

use DB;

trait Lang
{

    public function scopeLang($query)
    {
        return $query->where('lang', 'like', \App::getLocale());
    }

    public function language()
    {
        return $this->hasOne('App\Language', 'iso_code', 'lang');
    }

    public function isLangRTL()
    {
        return $this->language()->first()->is_rtl;
    }

}
