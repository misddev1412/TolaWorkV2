<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportAbuseCompanyMessage extends Model
{

    protected $table = 'report_abuse_company_messages';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
