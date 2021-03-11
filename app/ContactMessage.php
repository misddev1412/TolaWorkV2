<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{

    protected $table = 'contact_messages';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
