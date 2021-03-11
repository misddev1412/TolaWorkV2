<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\ResultType;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\ResultTypeFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ResultTypeController extends Controller
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

    public function indexResultTypes()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.result_type.index')->with('languages', $languages);
    }

    public function createResultType()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $resultTypes = DataArrayHelper::defaultResultTypesArray();
        return view('admin.result_type.add')
                        ->with('languages', $languages)
                        ->with('resultTypes', $resultTypes);
    }

    public function storeResultType(ResultTypeFormRequest $request)
    {
        $resultType = new ResultType();
        $resultType->lang = $request->input('lang');
        $resultType->result_type = $request->input('result_type');
        $resultType->is_default = $request->input('is_default');
        $resultType->result_type_id = $request->input('result_type_id');
        $resultType->is_active = $request->input('is_active');
        $resultType->save();
        /*         * ************************************ */
        $resultType->sort_order = $resultType->id;
        if ((int) $request->input('is_default') == 1) {
            $resultType->result_type_id = $resultType->id;
        } else {
            $resultType->result_type_id = $request->input('result_type_id');
        }
        $resultType->update();
        /*         * ************************************ */
        flash('Result Type has been added!')->success();
        return \Redirect::route('edit.result.type', array($resultType->id));
    }

    public function editResultType($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $resultTypes = DataArrayHelper::defaultResultTypesArray();
        $resultType = ResultType::findOrFail($id);
        return view('admin.result_type.edit')
                        ->with('languages', $languages)
                        ->with('resultTypes', $resultTypes)
                        ->with('resultType', $resultType);
    }

    public function updateResultType($id, ResultTypeFormRequest $request)
    {
        $resultType = ResultType::findOrFail($id);
        $resultType->lang = $request->input('lang');
        $resultType->result_type = $request->input('result_type');
        $resultType->is_default = $request->input('is_default');
        $resultType->result_type_id = $request->input('result_type_id');
        $resultType->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $resultType->result_type_id = $resultType->id;
        } else {
            $resultType->result_type_id = $request->input('result_type_id');
        }
        /*         * ************************************ */
        $resultType->update();
        flash('Result Type has been updated!')->success();
        return \Redirect::route('edit.result.type', array($resultType->id));
    }

    public function deleteResultType(Request $request)
    {
        $id = $request->input('id');
        try {
            $resultType = ResultType::findOrFail($id);
            if ((bool) $resultType->is_default) {
                ResultType::where('result_type_id', '=', $resultType->result_type_id)->delete();
            } else {
                $resultType->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchResultTypesData(Request $request)
    {
        $resultTypes = ResultType::select([
                    'result_types.id', 'result_types.lang', 'result_types.result_type', 'result_types.is_default', 'result_types.result_type_id', 'result_types.is_active',
                ])->sorted();
        return Datatables::of($resultTypes)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('result_types.lang', 'like', "{$request->get('lang')}");
                            }
                            if ($request->has('result_type') && !empty($request->result_type)) {
                                $query->where('result_types.result_type', 'like', "%{$request->get('result_type')}%");
                            }
                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('result_types.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('result_type', function ($resultTypes) {
                            $resultType = Str::limit($resultTypes->result_type, 100, '...');
                            $direction = MiscHelper::getLangDirection($resultTypes->lang);
                            return '<span dir="' . $direction . '">' . $resultType . '</span>';
                        })
                        ->addColumn('action', function ($resultTypes) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $resultTypes->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $resultTypes->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $resultTypes->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.result.type', ['id' => $resultTypes->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteResultType(' . $resultTypes->id . ', ' . $resultTypes->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $resultTypes->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'result_type'])
                        ->setRowId(function($resultTypes) {
                            return 'resultTypeDtRow' . $resultTypes->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveResultType(Request $request)
    {
        $id = $request->input('id');
        try {
            $resultType = ResultType::findOrFail($id);
            $resultType->is_active = 1;
            $resultType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveResultType(Request $request)
    {
        $id = $request->input('id');
        try {
            $resultType = ResultType::findOrFail($id);
            $resultType->is_active = 0;
            $resultType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortResultTypes()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.result_type.sort')->with('languages', $languages);
    }

    public function resultTypeSortData(Request $request)
    {
        $lang = $request->input('lang');
        $resultTypes = ResultType::select('result_types.id', 'result_types.result_type', 'result_types.sort_order')
                ->where('result_types.lang', 'like', $lang)
                ->orderBy('result_types.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($resultTypes != null) {
            foreach ($resultTypes as $resultType) {
                $str .= '<li id="' . $resultType->id . '"><i class="fa fa-sort"></i>' . $resultType->result_type . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function resultTypeSortUpdate(Request $request)
    {
        $resultTypeOrder = $request->input('resultTypeOrder');
        $resultTypeOrderArray = explode(',', $resultTypeOrder);
        $count = 1;
        foreach ($resultTypeOrderArray as $resultTypeId) {
            $resultType = ResultType::find($resultTypeId);
            $resultType->sort_order = $count;
            $resultType->update();
            $count++;
        }
    }

}
