<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\Country;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\CountryFormRequest;
use App\Http\Controllers\Controller;
use App\Traits\CountryStateCity;
use Illuminate\Support\Str;

class CountryController extends Controller
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

    public function indexCountries()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.country.index')->with('languages', $languages);
    }

    public function createCountry()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        return view('admin.country.add')
                        ->with('languages', $languages)
                        ->with('countries', $countries);
    }

    public function storeCountry(CountryFormRequest $request)
    {
        $country = new Country();
        $country->country = $request->input('country');
        $country->nationality = $request->input('nationality');
        $country->is_active = $request->input('is_active');
        $country->lang = $request->input('lang');
        $country->is_default = $request->input('is_default');
        $country->save();
        /*         * ************************************ */
        $country->sort_order = $country->id;
        if ((int) $request->input('is_default') == 1) {
            $country->country_id = $country->id;
        } else {
            $country->country_id = $request->input('country_id');
        }
        $country->update();
        flash('Country has been added!')->success();
        return \Redirect::route('edit.country', array($country->id));
    }

    public function editCountry($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $countries = DataArrayHelper::defaultCountriesArray();
        $country = Country::findOrFail($id);
        return view('admin.country.edit')
                        ->with('languages', $languages)
                        ->with('country', $country)
                        ->with('countries', $countries);
    }

    public function updateCountry($id, CountryFormRequest $request)
    {
        $country = Country::findOrFail($id);
        $country->country = $request->input('country');
        $country->nationality = $request->input('nationality');
        $country->is_active = $request->input('is_active');
        $country->lang = $request->input('lang');
        $country->is_default = $request->input('is_default');
        if ((int) $request->input('is_default') == 1) {
            $country->country_id = $country->id;
        } else {
            $country->country_id = $request->input('country_id');
        }
        $country->update();
        flash('Country has been updated!')->success();
        return \Redirect::route('edit.country', array($country->id));
    }

    public function fetchCountriesData(Request $request)
    {
        $countries = Country::select(['countries.id', 'countries.country', 'countries.nationality', 'countries.is_active', 'countries.lang', 'countries.is_default', 'countries.created_at', 'countries.updated_at'])->sorted();
        return Datatables::of($countries)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('country') && !empty($request->country)) {
                                $query->where('countries.country', 'like', "%{$request->get('country')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('countries.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('is_active') && $request->get('is_active') != -1) {
                                $query->where('countries.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('country', function ($countries) {
                            $country = Str::limit($countries->country, 100, '...');
                            $direction = MiscHelper::getLangDirection($countries->lang);
                            return '<span dir="' . $direction . '">' . $country . '</span>';
                        })
                        ->addColumn('action', function ($countries) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $countries->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $countries->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $countries->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.country', ['id' => $countries->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteCountry(' . $countries->id . ', ' . $countries->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $countries->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['country', 'action'])
                        ->setRowId(function($countries) {
                            return 'countryDtRow' . $countries->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveCountry(Request $request)
    {
        $id = $request->input('id');
        try {
            $country = Country::findOrFail($id);
            $country->is_active = 1;
            $country->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveCountry(Request $request)
    {
        $id = $request->input('id');
        try {
            $country = Country::findOrFail($id);
            $country->is_active = 0;
            $country->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortCountries()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.country.sort')->with('languages', $languages);
    }

    public function countrySortData(Request $request)
    {
        $lang = $request->input('lang');
        $countries = Country::select('countries.id', 'countries.country', 'countries.sort_order')
                ->where('countries.lang', 'like', $lang)
                ->orderBy('countries.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($countries != null) {
            foreach ($countries as $country) {
                $str .= '<li id="' . $country->id . '"><i class="fa fa-sort"></i>' . $country->country . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function countrySortUpdate(Request $request)
    {
        $countryOrder = $request->input('countryOrder');
        $countryOrderArray = explode(',', $countryOrder);
        $count = 1;
        foreach ($countryOrderArray as $countryId) {
            $country = Country::find($countryId);
            $country->sort_order = $count;
            $country->update();
            $count++;
        }
    }

}
