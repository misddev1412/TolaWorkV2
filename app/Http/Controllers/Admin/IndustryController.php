<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\Industry;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\IndustryFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class IndustryController extends Controller
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

    public function indexIndustries()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.industry.index')->with('languages', $languages);
    }

    public function createIndustry()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $industries = DataArrayHelper::defaultIndustriesArray();
        return view('admin.industry.add')
                        ->with('languages', $languages)
                        ->with('industries', $industries);
    }

    public function storeIndustry(IndustryFormRequest $request)
    {
        $industry = new Industry();
        $industry->industry = $request->input('industry');
        $industry->is_active = $request->input('is_active');
        $industry->lang = $request->input('lang');
        $industry->is_default = $request->input('is_default');
        $industry->save();
        /*         * ************************************ */
        $industry->sort_order = $industry->id;
        if ((int) $request->input('is_default') == 1) {
            $industry->industry_id = $industry->id;
        } else {
            $industry->industry_id = $request->input('industry_id');
        }
        $industry->update();
        flash('Industry has been added!')->success();
        return \Redirect::route('edit.industry', array($industry->id));
    }

    public function editIndustry($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $industries = DataArrayHelper::defaultIndustriesArray();
        $industry = Industry::findOrFail($id);
        return view('admin.industry.edit')
                        ->with('languages', $languages)
                        ->with('industry', $industry)
                        ->with('industries', $industries);
    }

    public function updateIndustry($id, IndustryFormRequest $request)
    {
        $industry = Industry::findOrFail($id);
        $industry->industry = $request->input('industry');
        $industry->is_active = $request->input('is_active');
        $industry->lang = $request->input('lang');
        $industry->is_default = $request->input('is_default');
        if ((int) $request->input('is_default') == 1) {
            $industry->industry_id = $industry->id;
        } else {
            $industry->industry_id = $request->input('industry_id');
        }
        $industry->update();
        flash('Industry has been updated!')->success();
        return \Redirect::route('edit.industry', array($industry->id));
    }

    public function deleteIndustry(Request $request)
    {
        $id = $request->input('id');
        try {
            $industry = Industry::findOrFail($id);
            if ((bool) $industry->is_default) {
                Industry::where('industry_id', '=', $industry->industry_id)->delete();
            } else {
                $industry->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchIndustriesData(Request $request)
    {
        $industries = Industry::select(['industries.id', 'industries.industry', 'industries.is_active', 'industries.lang', 'industries.is_default', 'industries.created_at', 'industries.updated_at'])->sorted();
        return Datatables::of($industries)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('industry') && !empty($request->industry)) {
                                $query->where('industries.industry', 'like', "%{$request->get('industry')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('industries.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('is_active') && $request->get('is_active') != -1) {
                                $query->where('industries.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('industry', function ($industries) {
                            $industry = Str::limit($industries->industry, 100, '...');
                            $direction = MiscHelper::getLangDirection($industries->lang);
                            return '<span dir="' . $direction . '">' . $industry . '</span>';
                        })
                        ->addColumn('action', function ($industries) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $industries->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $industries->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $industries->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.industry', ['id' => $industries->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteIndustry(' . $industries->id . ', ' . $industries->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $industries->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['industry', 'action'])
                        ->setRowId(function($industries) {
                            return 'industryDtRow' . $industries->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveIndustry(Request $request)
    {
        $id = $request->input('id');
        try {
            $industry = Industry::findOrFail($id);
            $industry->is_active = 1;
            $industry->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveIndustry(Request $request)
    {
        $id = $request->input('id');
        try {
            $industry = Industry::findOrFail($id);
            $industry->is_active = 0;
            $industry->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortIndustries()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.industry.sort')->with('languages', $languages);
    }

    public function industrySortData(Request $request)
    {
        $lang = $request->input('lang');
        $industries = Industry::select('industries.id', 'industries.industry', 'industries.sort_order')
                ->where('industries.lang', 'like', $lang)
                ->orderBy('industries.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($industries != null) {
            foreach ($industries as $industry) {
                $str .= '<li id="' . $industry->id . '"><i class="fa fa-sort"></i>' . $industry->industry . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function industrySortUpdate(Request $request)
    {
        $industryOrder = $request->input('industryOrder');
        $industryOrderArray = explode(',', $industryOrder);
        $count = 1;
        foreach ($industryOrderArray as $industryId) {
            $industry = Industry::find($industryId);
            $industry->sort_order = $count;
            $industry->update();
            $count++;
        }
    }

}
