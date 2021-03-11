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
use App\Country;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'job_alerts';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function get_country($id)
    {
        return $country = Country::where('id', $id)->first();
    }
}
