<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantMessage extends Model
{

    protected $table = 'applicant_messages';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
