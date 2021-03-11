<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\DegreeLevel;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\DegreeLevelFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class DegreeLevelController extends Controller
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

    public function indexDegreeLevels()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.degree_level.index')->with('languages', $languages);
    }

    public function createDegreeLevel()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();
        return view('admin.degree_level.add')
                        ->with('languages', $languages)
                        ->with('degreeLevels', $degreeLevels);
    }

    public function storeDegreeLevel(DegreeLevelFormRequest $request)
    {
        $degreeLevel = new DegreeLevel();
        $degreeLevel->lang = $request->input('lang');
        $degreeLevel->degree_level = $request->input('degree_level');
        $degreeLevel->is_default = $request->input('is_default');
        $degreeLevel->degree_level_id = $request->input('degree_level_id');
        $degreeLevel->is_active = $request->input('is_active');
        $degreeLevel->save();
        /*         * ************************************ */
        $degreeLevel->sort_order = $degreeLevel->id;
        if ((int) $request->input('is_default') == 1) {
            $degreeLevel->degree_level_id = $degreeLevel->id;
        } else {
            $degreeLevel->degree_level_id = $request->input('degree_level_id');
        }
        $degreeLevel->update();
        /*         * ************************************ */
        flash('Degree Level has been added!')->success();
        return \Redirect::route('edit.degree.level', array($degreeLevel->id));
    }

    public function editDegreeLevel($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();

        $degreeLevel = DegreeLevel::findOrFail($id);
        return view('admin.degree_level.edit')
                        ->with('degreeLevel', $degreeLevel)
                        ->with('languages', $languages)
                        ->with('degreeLevels', $degreeLevels);
    }

    public function updateDegreeLevel($id, DegreeLevelFormRequest $request)
    {
        $degreeLevel = DegreeLevel::findOrFail($id);
        $degreeLevel->lang = $request->input('lang');
        $degreeLevel->degree_level = $request->input('degree_level');
        $degreeLevel->is_default = $request->input('is_default');
        $degreeLevel->degree_level_id = $request->input('degree_level_id');
        $degreeLevel->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $degreeLevel->degree_level_id = $degreeLevel->id;
        } else {
            $degreeLevel->degree_level_id = $request->input('degree_level_id');
        }
        /*         * ************************************ */
        $degreeLevel->update();
        flash('Degree Level has been updated!')->success();
        return \Redirect::route('edit.degree.level', array($degreeLevel->id));
    }

    public function deleteDegreeLevel(Request $request)
    {
        $id = $request->input('id');
        try {
            $degreeLevel = DegreeLevel::findOrFail($id);
            if ((bool) $degreeLevel->is_default) {
                DegreeLevel::where('degree_level_id', '=', $degreeLevel->degree_level_id)->delete();
            } else {
                $degreeLevel->delete();
            }
            echo 'ok';
            exit;
        } catch (ModelNotFoundException $e) {
            echo 'notok';
            exit;
        }
    }

    public function fetchDegreeLevelsData(Request $request)
    {
        $degreeLevels = DegreeLevel::select([
                    'degree_levels.id', 'degree_levels.lang', 'degree_levels.degree_level', 'degree_levels.is_default', 'degree_levels.degree_level_id', 'degree_levels.is_active',
                ])->sorted();
        return Datatables::of($degreeLevels)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('degree_levels.id', 'like', "%{$request->get('id')}%");
                            }
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('degree_levels.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('degree_level') && !empty($request->degree_level)) {
                                $query->where('degree_levels.degree_level', 'like', "%{$request->get('degree_level')}%");
                            }
                            if ($request->has('is_default') && !empty($request->is_default)) {
                                $query->where('degree_levels.is_default', 'like', "%{$request->get('is_default')}%");
                            }
                            if ($request->has('degree_level_id') && !empty($request->degree_level_id)) {
                                $query->where('degree_levels.degree_level_id', 'like', "%{$request->get('degree_level_id')}%");
                            }
                            if ($request->has('is_active') && !$request->is_active == -1) {
                                $query->where('degree_levels.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('degree_level', function ($degreeLevels) {
                            $degreeLevel = Str::limit($degreeLevels->degree_level, 100, '...');
                            $direction = MiscHelper::getLangDirection($degreeLevels->lang);
                            return '<span dir="' . $direction . '">' . $degreeLevel . '</span>';
                        })
                        ->addColumn('action', function ($degreeLevels) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $degreeLevels->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $degreeLevels->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $degreeLevels->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.degree.level', ['id' => $degreeLevels->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteDegreeLevel(' . $degreeLevels->id . ', ' . $degreeLevels->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $degreeLevels->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'degree_level'])
                        ->setRowId(function($degreeLevels) {
                            return 'degreeLevelDtRow' . $degreeLevels->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveDegreeLevel(Request $request)
    {
        $id = $request->input('id');
        try {
            $degreeLevel = DegreeLevel::findOrFail($id);
            $degreeLevel->is_active = 1;
            $degreeLevel->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveDegreeLevel(Request $request)
    {
        $id = $request->input('id');
        try {
            $degreeLevel = DegreeLevel::findOrFail($id);
            $degreeLevel->is_active = 0;
            $degreeLevel->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortDegreeLevels()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.degree_level.sort')->with('languages', $languages);
    }

    public function degreeLevelSortData(Request $request)
    {
        $lang = $request->input('lang');
        $degreeLevels = DegreeLevel::select('degree_levels.id', 'degree_levels.degree_level', 'degree_levels.sort_order')
                ->where('degree_levels.lang', 'like', $lang)
                ->orderBy('degree_levels.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($degreeLevels != null) {
            foreach ($degreeLevels as $degreeLevel) {
                $str .= '<li id="' . $degreeLevel->id . '"><i class="fa fa-sort"></i>' . $degreeLevel->degree_level . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function degreeLevelSortUpdate(Request $request)
    {
        $degreeLevelOrder = $request->input('degreeLevelOrder');
        $degreeLevelOrderArray = explode(',', $degreeLevelOrder);
        $count = 1;
        foreach ($degreeLevelOrderArray as $degreeLevelId) {
            $degreeLevel = DegreeLevel::find($degreeLevelId);
            $degreeLevel->sort_order = $count;
            $degreeLevel->update();
            $count++;
        }
    }

}
