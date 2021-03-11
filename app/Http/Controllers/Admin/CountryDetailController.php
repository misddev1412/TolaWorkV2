<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\CountryDetail;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\CountryDetailFormRequest;
use App\Http\Controllers\Controller;

class CountryDetailController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexCountryDetails()
    {
        return view('admin.country_detail.index');
    }

    public function createCountryDetail()
    {
        return view('admin.country_detail.add');
    }

    public function storeCountryDetail(CountryDetailFormRequest $request)
    {
        $countryDetail = new CountryDetail();
        $countryDetail->country_id = $request->input('country_id');
        $countryDetail->sort_name = $request->input('sort_name');
        $countryDetail->phone_code = $request->input('phone_code');
        $countryDetail->currency = $request->input('currency');
        $countryDetail->code = $request->input('code');
        $countryDetail->symbol = $request->input('symbol');
        $countryDetail->thousand_separator = $request->input('thousand_separator');
        $countryDetail->decimal_separator = $request->input('decimal_separator');
        $countryDetail->created_at = $request->input('created_at');
        $countryDetail->updated_at = $request->input('updated_at');
        $countryDetail->save();
        /*         * ************************************ */
        flash('Country Detail has been added!')->success();
        return \Redirect::route('edit.country.detail', array($countryDetail->id));
    }

    public function editCountryDetail($id)
    {
        $countryDetail = CountryDetail::findOrFail($id);
        return view('admin.country_detail.edit')
                        ->with('countryDetail', $countryDetail);
    }

    public function updateCountryDetail($id, CountryDetailFormRequest $request)
    {
        $countryDetail = CountryDetail::findOrFail($id);
        $countryDetail->country_id = $request->input('country_id');
        $countryDetail->sort_name = $request->input('sort_name');
        $countryDetail->phone_code = $request->input('phone_code');
        $countryDetail->currency = $request->input('currency');
        $countryDetail->code = $request->input('code');
        $countryDetail->symbol = $request->input('symbol');
        $countryDetail->thousand_separator = $request->input('thousand_separator');
        $countryDetail->decimal_separator = $request->input('decimal_separator');
        $countryDetail->created_at = $request->input('created_at');
        $countryDetail->updated_at = $request->input('updated_at');
        $countryDetail->update();
        flash('Country Detail has been updated!')->success();
        return \Redirect::route('edit.country.detail', array($countryDetail->id));
    }

    public function deleteCountryDetail(Request $request)
    {
        $id = $request->input('id');
        try {
            $countryDetail = CountryDetail::findOrFail($id);
            $countryDetail->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchCountryDetailsData(Request $request)
    {
        $countryDetails = CountryDetail::select([
                    'countries_details.id', 'countries_details.country_id', 'countries_details.sort_name', 'countries_details.phone_code', 'countries_details.currency', 'countries_details.code', 'countries_details.symbol', 'countries_details.thousand_separator', 'countries_details.decimal_separator', 'countries_details.created_at', 'countries_details.updated_at'
        ]);
        return Datatables::of($countryDetails)
                        ->addColumn('country_id', function ($countryDetails) {
                            return $countryDetails->getCountry('country');
                        })
                        ->addColumn('action', function ($countryDetails) {
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.country.detail', ['id' => $countryDetails->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteCountryDetail(' . $countryDetails->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						
					</ul>
				</div>';
                        })
                        ->rawColumns(['action'])
                        ->setRowId(function($countryDetails) {
                            return 'countryDetailDtRow' . $countryDetails->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveCountryDetail(Request $request)
    {
        $id = $request->input('id');
        try {
            $countryDetail = CountryDetail::findOrFail($id);
            $countryDetail->is_active = 1;
            $countryDetail->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveCountryDetail(Request $request)
    {
        $id = $request->input('id');
        try {
            $countryDetail = CountryDetail::findOrFail($id);
            $countryDetail->is_active = 0;
            $countryDetail->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortCountryDetails()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.country_detail.sort')->with('languages', $languages);
    }

    public function countryDetailSortData(Request $request)
    {
        $lang = $request->input('lang');
        $countryDetails = CountryDetail::select('countries_details.id', 'countries_details.country_detail', 'countries_details.sort_order')
                ->where('countries_details.lang', 'like', $lang)
                ->orderBy('countries_details.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($countryDetails != null) {
            foreach ($countryDetails as $countryDetail) {
                $str .= '<li id="' . $countryDetail->id . '"><i class="fa fa-sort"></i>' . $countryDetail->country_detail . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function countryDetailSortUpdate(Request $request)
    {
        $countryDetailOrder = $request->input('countryDetailOrder');
        $countryDetailOrderArray = explode(',', $countryDetailOrder);
        $count = 1;
        foreach ($countryDetailOrderArray as $countryDetailId) {
            $countryDetail = CountryDetail::find($countryDetailId);
            $countryDetail->sort_order = $count;
            $countryDetail->update();
            $count++;
        }
    }

}
