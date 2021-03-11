<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\JobShift;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\JobShiftFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class JobShiftController extends Controller
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

    public function indexJobShifts()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.job_shift.index')->with('languages', $languages);
    }

    public function createJobShift()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $jobShifts = DataArrayHelper::defaultJobShiftsArray();
        return view('admin.job_shift.add')
                        ->with('languages', $languages)
                        ->with('jobShifts', $jobShifts);
    }

    public function storeJobShift(JobShiftFormRequest $request)
    {
        $jobShift = new JobShift();
        $jobShift->job_shift = $request->input('job_shift');
        $jobShift->is_active = $request->input('is_active');
        $jobShift->lang = $request->input('lang');
        $jobShift->is_default = $request->input('is_default');
        $jobShift->save();
        /*         * ************************************ */
        $jobShift->sort_order = $jobShift->id;
        if ((int) $request->input('is_default') == 1) {
            $jobShift->job_shift_id = $jobShift->id;
        } else {
            $jobShift->job_shift_id = $request->input('job_shift_id');
        }
        $jobShift->update();
        flash('Job Shift has been added!')->success();
        return \Redirect::route('edit.job.shift', array($jobShift->id));
    }

    public function editJobShift($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $jobShifts = DataArrayHelper::defaultJobShiftsArray();
        $jobShift = JobShift::findOrFail($id);
        return view('admin.job_shift.edit')
                        ->with('languages', $languages)
                        ->with('jobShift', $jobShift)
                        ->with('jobShifts', $jobShifts);
    }

    public function updateJobShift($id, JobShiftFormRequest $request)
    {
        $jobShift = JobShift::findOrFail($id);
        $jobShift->job_shift = $request->input('job_shift');
        $jobShift->is_active = $request->input('is_active');
        $jobShift->lang = $request->input('lang');
        $jobShift->is_default = $request->input('is_default');
        if ((int) $request->input('is_default') == 1) {
            $jobShift->job_shift_id = $jobShift->id;
        } else {
            $jobShift->job_shift_id = $request->input('job_shift_id');
        }
        $jobShift->update();
        flash('Job Shift has been updated!')->success();
        return \Redirect::route('edit.job.shift', array($jobShift->id));
    }

    public function deleteJobShift(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobShift = JobShift::findOrFail($id);
            if ((bool) $jobShift->is_default) {
                JobShift::where('job_shift_id', '=', $jobShift->job_shift_id)->delete();
            } else {
                $jobShift->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchJobShiftsData(Request $request)
    {
        $jobShifts = JobShift::select(['job_shifts.id', 'job_shifts.job_shift', 'job_shifts.is_active', 'job_shifts.lang', 'job_shifts.is_default', 'job_shifts.created_at', 'job_shifts.updated_at'])->sorted();
        return Datatables::of($jobShifts)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('job_shift') && !empty($request->job_shift)) {
                                $query->where('job_shifts.job_shift', 'like', "%{$request->get('job_shift')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('job_shifts.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('is_active') && $request->get('is_active') != -1) {
                                $query->where('job_shifts.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('job_shift', function ($jobShifts) {
                            $jobShift = Str::limit($jobShifts->job_shift, 100, '...');
                            $direction = MiscHelper::getLangDirection($jobShifts->lang);
                            return '<span dir="' . $direction . '">' . $jobShift . '</span>';
                        })
                        ->addColumn('action', function ($jobShifts) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $jobShifts->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $jobShifts->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $jobShifts->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.job.shift', ['id' => $jobShifts->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteJobShift(' . $jobShifts->id . ', ' . $jobShifts->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $jobShifts->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['job_shift', 'action'])
                        ->setRowId(function($jobShifts) {
                            return 'jobShiftDtRow' . $jobShifts->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveJobShift(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobShift = JobShift::findOrFail($id);
            $jobShift->is_active = 1;
            $jobShift->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveJobShift(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobShift = JobShift::findOrFail($id);
            $jobShift->is_active = 0;
            $jobShift->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortJobShifts()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.job_shift.sort')->with('languages', $languages);
    }

    public function jobShiftSortData(Request $request)
    {
        $lang = $request->input('lang');
        $jobShifts = JobShift::select('job_shifts.id', 'job_shifts.job_shift', 'job_shifts.sort_order')
                ->where('job_shifts.lang', 'like', $lang)
                ->orderBy('job_shifts.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($jobShifts != null) {
            foreach ($jobShifts as $jobShift) {
                $str .= '<li id="' . $jobShift->id . '"><i class="fa fa-sort"></i>' . $jobShift->job_shift . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function jobShiftSortUpdate(Request $request)
    {
        $jobShiftOrder = $request->input('jobShiftOrder');
        $jobShiftOrderArray = explode(',', $jobShiftOrder);
        $count = 1;
        foreach ($jobShiftOrderArray as $jobShiftId) {
            $jobShift = JobShift::find($jobShiftId);
            $jobShift->sort_order = $count;
            $jobShift->update();
            $count++;
        }
    }

}
