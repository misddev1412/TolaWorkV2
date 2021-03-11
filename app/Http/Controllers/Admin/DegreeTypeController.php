<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\DegreeLevel;
use App\DegreeType;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\DegreeTypeFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class DegreeTypeController extends Controller
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

    public function indexDegreeTypes()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();

        return view('admin.degree_type.index')
                        ->with('languages', $languages)
                        ->with('degreeLevels', $degreeLevels);
    }

    public function createDegreeType()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();
        $degreeTypes = array('' => 'Select Degree Type');
        return view('admin.degree_type.add')
                        ->with('languages', $languages)
                        ->with('degreeLevels', $degreeLevels)
                        ->with('degreeTypes', $degreeTypes);
    }

    public function storeDegreeType(DegreeTypeFormRequest $request)
    {
        $degreeType = new DegreeType();
        $degreeType->lang = $request->input('lang');
        $degreeType->degree_level_id = $request->input('degree_level_id');
        $degreeType->degree_type = $request->input('degree_type');
        $degreeType->is_default = $request->input('is_default');
        $degreeType->degree_type_id = $request->input('degree_type_id');
        $degreeType->is_active = $request->input('is_active');
        $degreeType->save();
        /*         * ************************************ */
        $degreeType->sort_order = $degreeType->id;
        if ((int) $request->input('is_default') == 1) {
            $degreeType->degree_type_id = $degreeType->id;
        } else {
            $degreeType->degree_type_id = $request->input('degree_type_id');
        }
        $degreeType->update();
        /*         * ************************************ */
        flash('Degree Type has been added!')->success();
        return \Redirect::route('edit.degree.type', array($degreeType->id));
    }

    public function editDegreeType($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();
        $degreeTypes = array('' => 'Select Degree Type');
        $degreeType = DegreeType::findOrFail($id);
        return view('admin.degree_type.edit')
                        ->with('languages', $languages)
                        ->with('degreeLevels', $degreeLevels)
                        ->with('degreeTypes', $degreeTypes)
                        ->with('degreeType', $degreeType);
    }

    public function updateDegreeType($id, DegreeTypeFormRequest $request)
    {
        $degreeType = DegreeType::findOrFail($id);
        $degreeType->lang = $request->input('lang');
        $degreeType->degree_level_id = $request->input('degree_level_id');
        $degreeType->degree_type = $request->input('degree_type');
        $degreeType->is_default = $request->input('is_default');
        $degreeType->degree_type_id = $request->input('degree_type_id');
        $degreeType->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $degreeType->degree_type_id = $degreeType->id;
        } else {
            $degreeType->degree_type_id = $request->input('degree_type_id');
        }
        /*         * ************************************ */
        $degreeType->update();
        flash('Degree Type has been updated!')->success();
        return \Redirect::route('edit.degree.type', array($degreeType->id));
    }

    public function deleteDegreeType(Request $request)
    {
        $id = $request->input('id');
        try {
            $degreeType = DegreeType::findOrFail($id);
            if ((bool) $degreeType->is_default) {
                DegreeType::where('degree_type_id', '=', $degreeType->degree_type_id)->delete();
            } else {
                $degreeType->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchDegreeTypesData(Request $request)
    {
        $degreeTypes = DegreeType::select([
                    'degree_types.id', 'degree_types.lang', 'degree_types.degree_level_id', 'degree_types.degree_type', 'degree_types.is_default', 'degree_types.degree_type_id', 'degree_types.is_active',
                ])->sorted();
        return Datatables::of($degreeTypes)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('degree_types.id', 'like', "%{$request->get('id')}%");
                            }
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('degree_types.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('degree_level_id') && !empty($request->degree_level_id)) {
                                $query->where('degree_types.degree_level_id', 'like', "%{$request->get('degree_level_id')}%");
                            }
                            if ($request->has('degree_type') && !empty($request->degree_type)) {
                                $query->where('degree_types.degree_type', 'like', "%{$request->get('degree_type')}%");
                            }
                            if ($request->has('is_default') && !empty($request->is_default)) {
                                $query->where('degree_types.is_default', 'like', "%{$request->get('is_default')}%");
                            }
                            if ($request->has('degree_type_id') && !empty($request->degree_type_id)) {
                                $query->where('degree_types.degree_type_id', 'like', "%{$request->get('degree_type_id')}%");
                            }
                            if ($request->has('is_active') && !$request->is_active == -1) {
                                $query->where('degree_types.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('degree_type', function ($degreeTypes) {
                            $degreeType = Str::limit($degreeTypes->degree_type, 100, '...');
                            $direction = MiscHelper::getLangDirection($degreeTypes->lang);
                            return '<span dir="' . $direction . '">' . $degreeType . '</span>';
                        })
                        ->addColumn('degree_level_id', function ($degreeTypes) {
                            return $degreeTypes->getDegreeLevel('degree_level');
                        })
                        ->addColumn('action', function ($degreeTypes) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $degreeTypes->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $degreeTypes->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $degreeTypes->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.degree.type', ['id' => $degreeTypes->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteDegreeType(' . $degreeTypes->id . ', ' . $degreeTypes->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $degreeTypes->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'degree_level_id', 'degree_type'])
                        ->setRowId(function($degreeTypes) {
                            return 'degreeTypeDtRow' . $degreeTypes->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveDegreeType(Request $request)
    {
        $id = $request->input('id');
        try {
            $degreeType = DegreeType::findOrFail($id);
            $degreeType->is_active = 1;
            $degreeType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveDegreeType(Request $request)
    {
        $id = $request->input('id');
        try {
            $degreeType = DegreeType::findOrFail($id);
            $degreeType->is_active = 0;
            $degreeType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortDegreeTypes()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();
        return view('admin.degree_type.sort')
                        ->with('languages', $languages)
                        ->with('degreeLevels', $degreeLevels);
    }

    public function degreeTypeSortData(Request $request)
    {
        $lang = $request->input('lang');
        $degree_level_id = $request->input('degree_level_id');
        $degreeTypes = DegreeType::select('degree_types.id', 'degree_types.degree_type', 'degree_types.sort_order')
                ->where('degree_types.lang', 'like', $lang)
                ->where('degree_types.degree_level_id', '=', $degree_level_id)
                ->orderBy('degree_types.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($degreeTypes != null) {
            foreach ($degreeTypes as $degreeType) {
                $str .= '<li id="' . $degreeType->id . '"><i class="fa fa-sort"></i>' . $degreeType->degree_type . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function degreeTypeSortUpdate(Request $request)
    {
        $degreeTypeOrder = $request->input('degreeTypeOrder');
        $degreeTypeOrderArray = explode(',', $degreeTypeOrder);
        $count = 1;
        foreach ($degreeTypeOrderArray as $degreeTypeId) {
            $degreeType = DegreeType::find($degreeTypeId);
            $degreeType->sort_order = $count;
            $degreeType->update();
            $count++;
        }
    }

}
