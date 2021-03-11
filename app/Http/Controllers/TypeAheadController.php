<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Input;
use App\CountryDetail;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Helpers\DataArrayHelper;

class TypeAheadController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function typeAheadCurrencyCodes(Request $request)
    {
        $searchKey = $request->input('query');
        if (!empty($searchKey)) {
            $codes = CountryDetail::select('code AS name')->where('countries_details.code', 'like', '%' . $searchKey . '%')->orderBy('countries_details.code')->pluck('name')->toArray();
            echo json_encode(array_unique($codes));
        }
    }

}
