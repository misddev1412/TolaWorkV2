<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;

class CountryDetail extends Model
{

    protected $table = 'countries_details';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function country()
    {
        return $this->hasMany('App\Country', 'country_id', 'id');
    }

    public function getCountry($field = '')
    {
        if (null !== $country = $this->country()->isDefault()->first()) {
            if (!empty($field)) {
                return $country->$field;
            } else {
                return $country;
            }
        }
    }

}
