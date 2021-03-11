<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyMessage extends Model
{

    protected $table = 'company_messages';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];
}
