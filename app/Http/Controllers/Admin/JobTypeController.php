<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\JobType;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\JobTypeFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class JobTypeController extends Controller
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

    public function indexJobTypes()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.job_type.index')->with('languages', $languages);
    }

    public function createJobType()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $jobTypes = DataArrayHelper::defaultJobTypesArray();
        return view('admin.job_type.add')
                        ->with('languages', $languages)
                        ->with('jobTypes', $jobTypes);
    }

    public function storeJobType(JobTypeFormRequest $request)
    {
        $jobType = new JobType();
        $jobType->job_type = $request->input('job_type');
        $jobType->is_active = $request->input('is_active');
        $jobType->lang = $request->input('lang');
        $jobType->is_default = $request->input('is_default');
        $jobType->save();
        /*         * ************************************ */
        $jobType->sort_order = $jobType->id;
        if ((int) $request->input('is_default') == 1) {
            $jobType->job_type_id = $jobType->id;
        } else {
            $jobType->job_type_id = $request->input('job_type_id');
        }
        $jobType->update();
        flash('Job Type has been added!')->success();
        return \Redirect::route('edit.job.type', array($jobType->id));
    }

    public function editJobType($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $jobTypes = DataArrayHelper::defaultJobTypesArray();
        $jobType = JobType::findOrFail($id);
        return view('admin.job_type.edit')
                        ->with('languages', $languages)
                        ->with('jobType', $jobType)
                        ->with('jobTypes', $jobTypes);
    }

    public function updateJobType($id, JobTypeFormRequest $request)
    {
        $jobType = JobType::findOrFail($id);
        $jobType->job_type = $request->input('job_type');
        $jobType->is_active = $request->input('is_active');
        $jobType->lang = $request->input('lang');
        $jobType->is_default = $request->input('is_default');
        if ((int) $request->input('is_default') == 1) {
            $jobType->job_type_id = $jobType->id;
        } else {
            $jobType->job_type_id = $request->input('job_type_id');
        }
        $jobType->update();
        flash('Job Type has been updated!')->success();
        return \Redirect::route('edit.job.type', array($jobType->id));
    }

    public function deleteJobType(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobType = JobType::findOrFail($id);
            if ((bool) $jobType->is_default) {
                JobType::where('job_type_id', '=', $jobType->job_type_id)->delete();
            } else {
                $jobType->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchJobTypesData(Request $request)
    {
        $jobTypes = JobType::select(['job_types.id', 'job_types.job_type', 'job_types.is_active', 'job_types.lang', 'job_types.is_default', 'job_types.created_at', 'job_types.updated_at'])->sorted();
        return Datatables::of($jobTypes)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('job_type') && !empty($request->job_type)) {
                                $query->where('job_types.job_type', 'like', "%{$request->get('job_type')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('job_types.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('is_active') && $request->get('is_active') != -1) {
                                $query->where('job_types.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('job_type', function ($jobTypes) {
                            $jobType = Str::limit($jobTypes->job_type, 100, '...');
                            $direction = MiscHelper::getLangDirection($jobTypes->lang);
                            return '<span dir="' . $direction . '">' . $jobType . '</span>';
                        })
                        ->addColumn('action', function ($jobTypes) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $jobTypes->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $jobTypes->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $jobTypes->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.job.type', ['id' => $jobTypes->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteJobType(' . $jobTypes->id . ', ' . $jobTypes->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $jobTypes->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['job_type', 'action'])
                        ->setRowId(function($jobTypes) {
                            return 'jobTypeDtRow' . $jobTypes->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveJobType(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobType = JobType::findOrFail($id);
            $jobType->is_active = 1;
            $jobType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveJobType(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobType = JobType::findOrFail($id);
            $jobType->is_active = 0;
            $jobType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortJobTypes()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.job_type.sort')->with('languages', $languages);
    }

    public function jobTypeSortData(Request $request)
    {
        $lang = $request->input('lang');
        $jobTypes = JobType::select('job_types.id', 'job_types.job_type', 'job_types.sort_order')
                ->where('job_types.lang', 'like', $lang)
                ->orderBy('job_types.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($jobTypes != null) {
            foreach ($jobTypes as $jobType) {
                $str .= '<li id="' . $jobType->id . '"><i class="fa fa-sort"></i>' . $jobType->job_type . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function jobTypeSortUpdate(Request $request)
    {
        $jobTypeOrder = $request->input('jobTypeOrder');
        $jobTypeOrderArray = explode(',', $jobTypeOrder);
        $count = 1;
        foreach ($jobTypeOrderArray as $jobTypeId) {
            $jobType = JobType::find($jobTypeId);
            $jobType->sort_order = $count;
            $jobType->update();
            $count++;
        }
    }

}
