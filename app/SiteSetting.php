<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{

    protected $table = 'site_settings';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
