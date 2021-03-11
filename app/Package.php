<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    protected $table = 'packages';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
