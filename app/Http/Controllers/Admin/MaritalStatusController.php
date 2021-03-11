<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\MaritalStatus;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\MaritalStatusFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class MaritalStatusController extends Controller
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

    public function indexMaritalStatuses()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.marital_status.index')->with('languages', $languages);
    }

    public function createMaritalStatus()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $maritalStatuses = DataArrayHelper::defaultMaritalStatusesArray();
        return view('admin.marital_status.add')
                        ->with('languages', $languages)
                        ->with('maritalStatuses', $maritalStatuses);
    }

    public function storeMaritalStatus(MaritalStatusFormRequest $request)
    {
        $maritalStatus = new MaritalStatus();
        $maritalStatus->lang = $request->input('lang');
        $maritalStatus->marital_status = $request->input('marital_status');
        $maritalStatus->is_default = $request->input('is_default');
        $maritalStatus->marital_status_id = $request->input('marital_status_id');
        $maritalStatus->is_active = $request->input('is_active');
        $maritalStatus->save();
        /*         * ************************************ */
        $maritalStatus->sort_order = $maritalStatus->id;
        if ((int) $request->input('is_default') == 1) {
            $maritalStatus->marital_status_id = $maritalStatus->id;
        } else {
            $maritalStatus->marital_status_id = $request->input('marital_status_id');
        }
        $maritalStatus->update();
        /*         * ************************************ */
        flash('Marital Status has been added!')->success();
        return \Redirect::route('edit.marital.status', array($maritalStatus->id));
    }

    public function editMaritalStatus($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $maritalStatuses = DataArrayHelper::defaultMaritalStatusesArray();
        $maritalStatus = MaritalStatus::findOrFail($id);
        return view('admin.marital_status.edit')
                        ->with('languages', $languages)
                        ->with('maritalStatuses', $maritalStatuses)
                        ->with('maritalStatus', $maritalStatus);
    }

    public function updateMaritalStatus($id, MaritalStatusFormRequest $request)
    {
        $maritalStatus = MaritalStatus::findOrFail($id);
        $maritalStatus->lang = $request->input('lang');
        $maritalStatus->marital_status = $request->input('marital_status');
        $maritalStatus->is_default = $request->input('is_default');
        $maritalStatus->marital_status_id = $request->input('marital_status_id');
        $maritalStatus->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $maritalStatus->marital_status_id = $maritalStatus->id;
        } else {
            $maritalStatus->marital_status_id = $request->input('marital_status_id');
        }
        /*         * ************************************ */
        $maritalStatus->update();
        flash('Marital Status has been updated!')->success();
        return \Redirect::route('edit.marital.status', array($maritalStatus->id));
    }

    public function deleteMaritalStatus(Request $request)
    {
        $id = $request->input('id');
        try {
            $maritalStatus = MaritalStatus::findOrFail($id);
            if ((bool) $maritalStatus->is_default) {
                MaritalStatus::where('marital_status_id', '=', $maritalStatus->marital_status_id)->delete();
            } else {
                $maritalStatus->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchMaritalStatusesData(Request $request)
    {
        $maritalStatuses = MaritalStatus::select([
                    'marital_statuses.id', 'marital_statuses.lang', 'marital_statuses.marital_status', 'marital_statuses.is_default', 'marital_statuses.marital_status_id', 'marital_statuses.is_active',
                ])->sorted();
        return Datatables::of($maritalStatuses)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('marital_statuses.lang', 'like', "{$request->get('lang')}");
                            }
                            if ($request->has('marital_status') && !empty($request->marital_status)) {
                                $query->where('marital_statuses.marital_status', 'like', "%{$request->get('marital_status')}%");
                            }
                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('marital_statuses.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('marital_status', function ($maritalStatuses) {
                            $maritalStatus = Str::limit($maritalStatuses->marital_status, 100, '...');
                            $direction = MiscHelper::getLangDirection($maritalStatuses->lang);
                            return '<span dir="' . $direction . '">' . $maritalStatus . '</span>';
                        })
                        ->addColumn('action', function ($maritalStatuses) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $maritalStatuses->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $maritalStatuses->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $maritalStatuses->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.marital.status', ['id' => $maritalStatuses->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteMaritalStatus(' . $maritalStatuses->id . ', ' . $maritalStatuses->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $maritalStatuses->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'marital_status'])
                        ->setRowId(function($maritalStatuses) {
                            return 'maritalStatusDtRow' . $maritalStatuses->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveMaritalStatus(Request $request)
    {
        $id = $request->input('id');
        try {
            $maritalStatus = MaritalStatus::findOrFail($id);
            $maritalStatus->is_active = 1;
            $maritalStatus->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveMaritalStatus(Request $request)
    {
        $id = $request->input('id');
        try {
            $maritalStatus = MaritalStatus::findOrFail($id);
            $maritalStatus->is_active = 0;
            $maritalStatus->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortMaritalStatuses()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.marital_status.sort')->with('languages', $languages);
    }

    public function maritalStatusSortData(Request $request)
    {
        $lang = $request->input('lang');
        $maritalStatuses = MaritalStatus::select('marital_statuses.id', 'marital_statuses.marital_status', 'marital_statuses.sort_order')
                ->where('marital_statuses.lang', 'like', $lang)
                ->orderBy('marital_statuses.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($maritalStatuses != null) {
            foreach ($maritalStatuses as $maritalStatus) {
                $str .= '<li id="' . $maritalStatus->id . '"><i class="fa fa-sort"></i>' . $maritalStatus->marital_status . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function maritalStatusSortUpdate(Request $request)
    {
        $maritalStatusOrder = $request->input('maritalStatusOrder');
        $maritalStatusOrderArray = explode(',', $maritalStatusOrder);
        $count = 1;
        foreach ($maritalStatusOrderArray as $maritalStatusId) {
            $maritalStatus = MaritalStatus::find($maritalStatusId);
            $maritalStatus->sort_order = $count;
            $maritalStatus->update();
            $count++;
        }
    }

}
