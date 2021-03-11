<?php

namespace App\Traits;

use DB;
use App\Country;
use App\State;
use App\City;
use App\Http\Requests;
use Illuminate\Http\Request;

trait CountryStateCity
{

    public function deleteCountry(Request $request)
    {
        $id = $request->input('id');
        try {
            $this->delCountry($id);
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    private function delCountry($id)
    {
        $country = Country::findOrFail($id);
        $states = State::select('states.id')->where('states.country_id', '=', $country->country_id)->pluck('states.id')->toArray();
        foreach ($states as $state_id) {
            $this->delState($state_id);
        }
        if ((bool) $country->is_default) {
            Country::where('country_id', '=', $country->country_id)->delete();
        } else {
            $country->delete();
        }
    }

    public function deleteState(Request $request)
    {
        $id = $request->input('id');
        try {
            $this->delState($id);
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    private function delState($id)
    {
        $state = State::findOrFail($id);
        $cities = City::select('cities.id')->where('cities.state_id', '=', $state->state_id)->pluck('cities.id')->toArray();
        foreach ($cities as $city_id) {
            $this->delCity($city_id);
        }
        if ((bool) $state->is_default) {
            State::where('state_id', '=', $state->state_id)->delete();
        } else {
            $state->delete();
        }
    }

    public function deleteCity(Request $request)
    {
        $id = $request->input('id');
        try {
            $this->delCity($id);
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    private function delCity($id)
    {
        $city = City::findOrFail($id);
        if ((bool) $city->is_default) {
            City::where('city_id', '=', $city->city_id)->delete();
        } else {
            $city->delete();
        }
    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id', 'country_id');
    }

    public function getCountry($field = '')
    {
        $country = $this->country()->lang()->first();
        if (null === $country) {
            $country = $this->country()->first();
        }
        if (null !== $country) {
            if (!empty($field)) {
                return $country->$field;
            } else {
                return $country;
            }
        }
    }

    public function state()
    {
        return $this->belongsTo('App\State', 'state_id', 'state_id');
    }

    public function getState($field = '')
    {
        $state = $this->state()->lang()->first();
        if (null === $state) {
            $state = $this->state()->first();
        }
        if (null !== $state) {
            if (!empty($field)) {
                return $state->$field;
            } else {
                return $state;
            }
        }
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id', 'city_id');
    }

    public function getCity($field = '')
    {
        $city = $this->city()->lang()->first();
        if (null === $city) {
            $city = $this->city()->first();
        }
        if (null !== $city) {
            if (!empty($field)) {
                return $city->$field;
            } else {
                return $city;
            }
        }
    }

    public function getLocation()
    {
        $country = $this->getCountry('country');
        $state = $this->getState('state');
        $city = $this->getCity('city');

        $str = '';
        if (!empty($city))
            $str .= $city;
        if (!empty($state))
            $str .= ', ' . $state;
        if (!empty($country))
            $str .= ', ' . $country;

        return $str;
    }

}
