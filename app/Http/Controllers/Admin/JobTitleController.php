<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\JobTitle;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\JobTitleFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class JobTitleController extends Controller
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

    public function indexJobTitles()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.job_title.index')->with('languages', $languages);
    }

    public function createJobTitle()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $jobTitles = DataArrayHelper::defaultJobTitlesArray();
        return view('admin.job_title.add')
                        ->with('languages', $languages)
                        ->with('jobTitles', $jobTitles);
    }

    public function storeJobTitle(JobTitleFormRequest $request)
    {
        $jobTitle = new JobTitle();
        $jobTitle->job_title = $request->input('job_title');
        $jobTitle->is_active = $request->input('is_active');
        $jobTitle->lang = $request->input('lang');
        $jobTitle->is_default = $request->input('is_default');
        $jobTitle->save();
        /*         * ************************************ */
        $jobTitle->sort_order = $jobTitle->id;
        if ((int) $request->input('is_default') == 1) {
            $jobTitle->job_title_id = $jobTitle->id;
        } else {
            $jobTitle->job_title_id = $request->input('job_title_id');
        }
        $jobTitle->update();
        flash('Job Title has been added!')->success();
        return \Redirect::route('edit.job.title', array($jobTitle->id));
    }

    public function editJobTitle($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $jobTitles = DataArrayHelper::defaultJobTitlesArray();
        $jobTitle = JobTitle::findOrFail($id);
        return view('admin.job_title.edit')
                        ->with('languages', $languages)
                        ->with('jobTitle', $jobTitle)
                        ->with('jobTitles', $jobTitles);
    }

    public function updateJobTitle($id, JobTitleFormRequest $request)
    {
        $jobTitle = JobTitle::findOrFail($id);
        $jobTitle->job_title = $request->input('job_title');
        $jobTitle->is_active = $request->input('is_active');
        $jobTitle->lang = $request->input('lang');
        $jobTitle->is_default = $request->input('is_default');
        if ((int) $request->input('is_default') == 1) {
            $jobTitle->job_title_id = $jobTitle->id;
        } else {
            $jobTitle->job_title_id = $request->input('job_title_id');
        }
        $jobTitle->update();
        flash('Job Title has been updated!')->success();
        return \Redirect::route('edit.job.title', array($jobTitle->id));
    }

    public function deleteJobTitle(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobTitle = JobTitle::findOrFail($id);
            if ((bool) $jobTitle->is_default) {
                JobTitle::where('job_title_id', '=', $jobTitle->job_title_id)->delete();
            } else {
                $jobTitle->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchJobTitlesData(Request $request)
    {
        $jobTitles = JobTitle::select(['job_titles.id', 'job_titles.job_title', 'job_titles.is_active', 'job_titles.lang', 'job_titles.is_default', 'job_titles.created_at', 'job_titles.updated_at'])->sorted();
        return Datatables::of($jobTitles)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('job_title') && !empty($request->job_title)) {
                                $query->where('job_titles.job_title', 'like', "%{$request->get('job_title')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('job_titles.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('is_active') && $request->get('is_active') != -1) {
                                $query->where('job_titles.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('job_title', function ($jobTitles) {
                            $jobTitle = Str::limit($jobTitles->job_title, 100, '...');
                            $direction = MiscHelper::getLangDirection($jobTitles->lang);
                            return '<span dir="' . $direction . '">' . $jobTitle . '</span>';
                        })
                        ->addColumn('action', function ($jobTitles) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $jobTitles->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $jobTitles->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $jobTitles->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.job.title', ['id' => $jobTitles->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteJobTitle(' . $jobTitles->id . ', ' . $jobTitles->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $jobTitles->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['job_title', 'action'])
                        ->setRowId(function($jobTitles) {
                            return 'jobTitleDtRow' . $jobTitles->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveJobTitle(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobTitle = JobTitle::findOrFail($id);
            $jobTitle->is_active = 1;
            $jobTitle->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveJobTitle(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobTitle = JobTitle::findOrFail($id);
            $jobTitle->is_active = 0;
            $jobTitle->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortJobTitles()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.job_title.sort')->with('languages', $languages);
    }

    public function jobTitleSortData(Request $request)
    {
        $lang = $request->input('lang');
        $jobTitles = JobTitle::select('job_titles.id', 'job_titles.job_title', 'job_titles.sort_order')
                ->where('job_titles.lang', 'like', $lang)
                ->orderBy('job_titles.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($jobTitles != null) {
            foreach ($jobTitles as $jobTitle) {
                $str .= '<li id="' . $jobTitle->id . '"><i class="fa fa-sort"></i>' . $jobTitle->job_title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function jobTitleSortUpdate(Request $request)
    {
        $jobTitleOrder = $request->input('jobTitleOrder');
        $jobTitleOrderArray = explode(',', $jobTitleOrder);
        $count = 1;
        foreach ($jobTitleOrderArray as $jobTitleId) {
            $jobTitle = JobTitle::find($jobTitleId);
            $jobTitle->sort_order = $count;
            $jobTitle->update();
            $count++;
        }
    }

}
