<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{

    protected $table = 'user_messages';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
