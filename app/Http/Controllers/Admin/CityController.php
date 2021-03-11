<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use Form;
use App\Language;
use App\Country;
use App\State;
use App\City;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\CityFormRequest;
use App\Http\Controllers\Controller;
use App\Traits\CountryStateCity;

class CityController extends Controller
{

    use CountryStateCity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexCities()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $states = array(''=>'Select State');
        return view('admin.city.index')
                        ->with('languages', $languages)
                        ->with('countries', $countries)
                        ->with('states', $states);
    }

    public function createCity()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $states = array(''=>'Select State');
        return view('admin.city.add')
                        ->with('languages', $languages)
                        ->with('countries', $countries)
                        ->with('states', $states);
    }

    public function storeCity(CityFormRequest $request)
    {
        $city = new City();
        $city->id = $request->input('id');
        $city->lang = $request->input('lang');
        $city->state_id = $request->input('state_id');
        $city->city = $request->input('city');
        $city->is_default = $request->input('is_default');
        $city->city_id = $request->input('city_id');
        $city->is_active = $request->input('is_active');
        $city->save();
        /*         * ************************************ */

        $city->sort_order = $city->id;

        if ((int) $request->input('is_default') == 1) {
            $city->city_id = $city->id;
        } else {
            $city->city_id = $request->input('city_id');
        }

        $city->update();
        /*         * ************************************ */

        flash('City has been added!')->success();
        return \Redirect::route('edit.city', array($city->id));
    }

    public function editCity($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $states = array(''=>'Select State');
        $city = City::findOrFail($id);
        return view('admin.city.edit')
                        ->with('city', $city)
                        ->with('languages', $languages)
                        ->with('countries', $countries)
                        ->with('states', $states);
    }

    public function updateCity($id, CityFormRequest $request)
    {
        $city = City::findOrFail($id);
        $city->id = $request->input('id');
        $city->lang = $request->input('lang');
        $city->state_id = $request->input('state_id');
        $city->city = $request->input('city');
        $city->is_default = $request->input('is_default');
        $city->city_id = $request->input('city_id');
        $city->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $city->city_id = $city->id;
        } else {
            $city->city_id = $request->input('city_id');
        }
        /*         * ************************************ */
        $city->update();

        flash('City has been updated!')->success();
        return \Redirect::route('edit.city', array($city->id));
    }

    public function fetchCitiesData(Request $request)
    {
        $cities = City::select([
                    'cities.id', 'cities.lang', 'cities.state_id', 'cities.city', 'cities.is_default', 'cities.city_id', 'cities.is_active',
                ])->sorted();
        return Datatables::of($cities)
                        ->filter(function ($query) use ($request) {

                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('cities.id', 'like', "{$request->get('id')}%");
                            }

                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('cities.lang', 'like', "{$request->get('lang')}");
                            }

                            if ($request->has('country_id') && !empty($request->country_id)) {
                                $state_ids = State::select('states.state_id')->where('states.country_id', '=', $request->country_id)->isDefault()->active()->sorted()->pluck('states.state_id')->toArray();

                                $query->whereIn('cities.state_id', $state_ids);
                            }

                            if ($request->has('state_id') && !empty($request->state_id)) {
                                $query->where('cities.state_id', '=', "{$request->get('state_id')}");
                            }

                            if ($request->has('city') && !empty($request->city)) {
                                $query->where('cities.city', 'like', "%{$request->get('city')}%");
                            }

                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('cities.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('state_id', function ($cities) {
                            return $cities->getState('state') . ' - ' . $cities->getCountry('country');
                        })
                        ->addColumn('city', function ($cities) {
                            $city = str_limit($cities->city, 100, '...');
                            $direction = MiscHelper::getLangDirection($cities->lang);
                            return '<span dir="' . $direction . '">' . $city . '</span>';
                        })
                        ->addColumn('action', function ($cities) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $cities->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $cities->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $cities->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.city', ['id' => $cities->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteCity(' . $cities->id . ', ' . $cities->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $cities->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'state_id', 'city'])
                        ->setRowId(function($cities) {
                            return 'cityDtRow' . $cities->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveCity(Request $request)
    {
        $id = $request->input('id');
        try {
            $city = City::findOrFail($id);
            $city->is_active = 1;
            $city->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveCity(Request $request)
    {
        $id = $request->input('id');
        try {
            $city = City::findOrFail($id);
            $city->is_active = 0;
            $city->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortCities()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.city.sort')->with('languages', $languages);
    }

    public function citySortData(Request $request)
    {
        $lang = $request->input('lang');
        $cities = City::select('cities.id', 'cities.city', 'cities.sort_order')
                ->where('cities.lang', 'like', $lang)
                ->orderBy('cities.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($cities != null) {
            foreach ($cities as $city) {
                $str .= '<li id="' . $city->id . '"><i class="fa fa-sort"></i>' . $city->city . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function citySortUpdate(Request $request)
    {
        $cityOrder = $request->input('cityOrder');
        $cityOrderArray = explode(',', $cityOrder);
        $count = 1;
        foreach ($cityOrderArray as $cityId) {
            $city = City::find($cityId);
            $city->sort_order = $count;
            $city->update();
            $count++;
        }
    }

}
