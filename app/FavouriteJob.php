<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;

class FavouriteJob extends Model
{

    protected $table = 'favourites_job';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

}
