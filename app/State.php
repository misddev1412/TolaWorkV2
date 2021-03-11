<?php

namespace App;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use App\Traits\CountryStateCity;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;
    use CountryStateCity;

    protected $table = 'states';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function cities()
    {
        return $this->hasMany('App\City', 'state_id', 'id');
    }

}
