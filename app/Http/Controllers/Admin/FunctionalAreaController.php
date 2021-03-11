<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\FunctionalArea;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\FunctionalAreaFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class FunctionalAreaController extends Controller
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

    public function indexFunctionalAreas()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.functional_area.index')->with('languages', $languages);
    }

    public function createFunctionalArea()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $functionalAreas = DataArrayHelper::defaultFunctionalAreasArray();
        return view('admin.functional_area.add')
                        ->with('languages', $languages)
                        ->with('functionalAreas', $functionalAreas);
    }

    public function storeFunctionalArea(FunctionalAreaFormRequest $request)
    {
        $functionalArea = new FunctionalArea();
        $functionalArea->functional_area = $request->input('functional_area');
        $functionalArea->is_active = $request->input('is_active');
        $functionalArea->lang = $request->input('lang');
        $functionalArea->is_default = $request->input('is_default');
        $functionalArea->save();
        /*         * ************************************ */
        $functionalArea->sort_order = $functionalArea->id;
        if ((int) $request->input('is_default') == 1) {
            $functionalArea->functional_area_id = $functionalArea->id;
        } else {
            $functionalArea->functional_area_id = $request->input('functional_area_id');
        }
        $functionalArea->update();
        flash('Functional Area has been added!')->success();
        return \Redirect::route('edit.functional.area', array($functionalArea->id));
    }

    public function editFunctionalArea($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $functionalAreas = DataArrayHelper::defaultFunctionalAreasArray();
        $functionalArea = FunctionalArea::findOrFail($id);
        return view('admin.functional_area.edit')
                        ->with('languages', $languages)
                        ->with('functionalArea', $functionalArea)
                        ->with('functionalAreas', $functionalAreas);
    }

    public function updateFunctionalArea($id, FunctionalAreaFormRequest $request)
    {
        $functionalArea = FunctionalArea::findOrFail($id);
        $functionalArea->functional_area = $request->input('functional_area');
        $functionalArea->is_active = $request->input('is_active');
        $functionalArea->lang = $request->input('lang');
        $functionalArea->is_default = $request->input('is_default');
        if ((int) $request->input('is_default') == 1) {
            $functionalArea->functional_area_id = $functionalArea->id;
        } else {
            $functionalArea->functional_area_id = $request->input('functional_area_id');
        }
        $functionalArea->update();
        flash('Functional Area has been updated!')->success();
        return \Redirect::route('edit.functional.area', array($functionalArea->id));
    }

    public function deleteFunctionalArea(Request $request)
    {
        $id = $request->input('id');
        try {
            $functionalArea = FunctionalArea::findOrFail($id);
            if ((bool) $functionalArea->is_default) {
                FunctionalArea::where('functional_area_id', '=', $functionalArea->functional_area_id)->delete();
            } else {
                $functionalArea->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchFunctionalAreasData(Request $request)
    {
        $functionalAreas = FunctionalArea::select(['functional_areas.id', 'functional_areas.functional_area', 'functional_areas.is_active', 'functional_areas.lang', 'functional_areas.is_default', 'functional_areas.created_at', 'functional_areas.updated_at'])->sorted();
        return Datatables::of($functionalAreas)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('functional_area') && !empty($request->functional_area)) {
                                $query->where('functional_areas.functional_area', 'like', "%{$request->get('functional_area')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('functional_areas.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('is_active') && $request->get('is_active') != -1) {
                                $query->where('functional_areas.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('functional_area', function ($functionalAreas) {
                            $functionalArea = Str::limit($functionalAreas->functional_area, 100, '...');
                            $direction = MiscHelper::getLangDirection($functionalAreas->lang);
                            return '<span dir="' . $direction . '">' . $functionalArea . '</span>';
                        })
                        ->addColumn('action', function ($functionalAreas) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $functionalAreas->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $functionalAreas->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $functionalAreas->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.functional.area', ['id' => $functionalAreas->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteFunctionalArea(' . $functionalAreas->id . ', ' . $functionalAreas->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $functionalAreas->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['functional_area', 'action'])
                        ->setRowId(function($functionalAreas) {
                            return 'functionalAreaDtRow' . $functionalAreas->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveFunctionalArea(Request $request)
    {
        $id = $request->input('id');
        try {
            $functionalArea = FunctionalArea::findOrFail($id);
            $functionalArea->is_active = 1;
            $functionalArea->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveFunctionalArea(Request $request)
    {
        $id = $request->input('id');
        try {
            $functionalArea = FunctionalArea::findOrFail($id);
            $functionalArea->is_active = 0;
            $functionalArea->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortFunctionalAreas()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.functional_area.sort')->with('languages', $languages);
    }

    public function functionalAreaSortData(Request $request)
    {
        $lang = $request->input('lang');
        $functionalAreas = FunctionalArea::select('functional_areas.id', 'functional_areas.functional_area', 'functional_areas.sort_order')
                ->where('functional_areas.lang', 'like', $lang)
                ->orderBy('functional_areas.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($functionalAreas != null) {
            foreach ($functionalAreas as $functionalArea) {
                $str .= '<li id="' . $functionalArea->id . '"><i class="fa fa-sort"></i>' . $functionalArea->functional_area . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function functionalAreaSortUpdate(Request $request)
    {
        $functionalAreaOrder = $request->input('functionalAreaOrder');
        $functionalAreaOrderArray = explode(',', $functionalAreaOrder);
        $count = 1;
        foreach ($functionalAreaOrderArray as $functionalAreaId) {
            $functionalArea = FunctionalArea::find($functionalAreaId);
            $functionalArea->sort_order = $count;
            $functionalArea->update();
            $count++;
        }
    }

}
