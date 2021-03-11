<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\SalaryPeriod;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\SalaryPeriodFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class SalaryPeriodController extends Controller
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

    public function indexSalaryPeriods()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.salary_period.index')->with('languages', $languages);
    }

    public function createSalaryPeriod()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $salaryPeriods = DataArrayHelper::defaultSalaryPeriodsArray();
        return view('admin.salary_period.add')
                        ->with('languages', $languages)
                        ->with('salaryPeriods', $salaryPeriods);
    }

    public function storeSalaryPeriod(SalaryPeriodFormRequest $request)
    {
        $salaryPeriod = new SalaryPeriod();
        $salaryPeriod->salary_period = $request->input('salary_period');
        $salaryPeriod->is_active = $request->input('is_active');
        $salaryPeriod->lang = $request->input('lang');
        $salaryPeriod->is_default = $request->input('is_default');
        $salaryPeriod->save();
        /*         * ************************************ */
        $salaryPeriod->sort_order = $salaryPeriod->id;
        if ((int) $request->input('is_default') == 1) {
            $salaryPeriod->salary_period_id = $salaryPeriod->id;
        } else {
            $salaryPeriod->salary_period_id = $request->input('salary_period_id');
        }
        $salaryPeriod->update();
        flash('Salary Period has been added!')->success();
        return \Redirect::route('edit.salary.period', array($salaryPeriod->id));
    }

    public function editSalaryPeriod($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $salaryPeriods = DataArrayHelper::defaultSalaryPeriodsArray();
        $salaryPeriod = SalaryPeriod::findOrFail($id);
        return view('admin.salary_period.edit')
                        ->with('languages', $languages)
                        ->with('salaryPeriod', $salaryPeriod)
                        ->with('salaryPeriods', $salaryPeriods);
    }

    public function updateSalaryPeriod($id, SalaryPeriodFormRequest $request)
    {
        $salaryPeriod = SalaryPeriod::findOrFail($id);
        $salaryPeriod->salary_period = $request->input('salary_period');
        $salaryPeriod->is_active = $request->input('is_active');
        $salaryPeriod->lang = $request->input('lang');
        $salaryPeriod->is_default = $request->input('is_default');
        if ((int) $request->input('is_default') == 1) {
            $salaryPeriod->salary_period_id = $salaryPeriod->id;
        } else {
            $salaryPeriod->salary_period_id = $request->input('salary_period_id');
        }
        $salaryPeriod->update();
        flash('Salary Period has been updated!')->success();
        return \Redirect::route('edit.salary.period', array($salaryPeriod->id));
    }

    public function deleteSalaryPeriod(Request $request)
    {
        $id = $request->input('id');
        try {
            $salaryPeriod = SalaryPeriod::findOrFail($id);
            if ((bool) $salaryPeriod->is_default) {
                SalaryPeriod::where('salary_period_id', '=', $salaryPeriod->salary_period_id)->delete();
            } else {
                $salaryPeriod->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchSalaryPeriodsData(Request $request)
    {
        $salaryPeriods = SalaryPeriod::select(['salary_periods.id', 'salary_periods.salary_period', 'salary_periods.is_active', 'salary_periods.lang', 'salary_periods.is_default', 'salary_periods.created_at', 'salary_periods.updated_at'])->sorted();
        return Datatables::of($salaryPeriods)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('salary_period') && !empty($request->salary_period)) {
                                $query->where('salary_periods.salary_period', 'like', "%{$request->get('salary_period')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('salary_periods.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('is_active') && $request->get('is_active') != -1) {
                                $query->where('salary_periods.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('salary_period', function ($salaryPeriods) {
                            $salaryPeriod = Str::limit($salaryPeriods->salary_period, 100, '...');
                            $direction = MiscHelper::getLangDirection($salaryPeriods->lang);
                            return '<span dir="' . $direction . '">' . $salaryPeriod . '</span>';
                        })
                        ->addColumn('action', function ($salaryPeriods) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $salaryPeriods->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $salaryPeriods->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $salaryPeriods->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.salary.period', ['id' => $salaryPeriods->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteSalaryPeriod(' . $salaryPeriods->id . ', ' . $salaryPeriods->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $salaryPeriods->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['salary_period', 'action'])
                        ->setRowId(function($salaryPeriods) {
                            return 'salaryPeriodDtRow' . $salaryPeriods->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveSalaryPeriod(Request $request)
    {
        $id = $request->input('id');
        try {
            $salaryPeriod = SalaryPeriod::findOrFail($id);
            $salaryPeriod->is_active = 1;
            $salaryPeriod->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveSalaryPeriod(Request $request)
    {
        $id = $request->input('id');
        try {
            $salaryPeriod = SalaryPeriod::findOrFail($id);
            $salaryPeriod->is_active = 0;
            $salaryPeriod->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortSalaryPeriods()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.salary_period.sort')->with('languages', $languages);
    }

    public function salaryPeriodSortData(Request $request)
    {
        $lang = $request->input('lang');
        $salaryPeriods = SalaryPeriod::select('salary_periods.id', 'salary_periods.salary_period', 'salary_periods.sort_order')
                ->where('salary_periods.lang', 'like', $lang)
                ->orderBy('salary_periods.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($salaryPeriods != null) {
            foreach ($salaryPeriods as $salaryPeriod) {
                $str .= '<li id="' . $salaryPeriod->id . '"><i class="fa fa-sort"></i>' . $salaryPeriod->salary_period . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function salaryPeriodSortUpdate(Request $request)
    {
        $salaryPeriodOrder = $request->input('salaryPeriodOrder');
        $salaryPeriodOrderArray = explode(',', $salaryPeriodOrder);
        $count = 1;
        foreach ($salaryPeriodOrderArray as $salaryPeriodId) {
            $salaryPeriod = SalaryPeriod::find($salaryPeriodId);
            $salaryPeriod->sort_order = $count;
            $salaryPeriod->update();
            $count++;
        }
    }

}
