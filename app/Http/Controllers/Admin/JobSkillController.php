<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\JobSkill;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\JobSkillFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class JobSkillController extends Controller
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

    public function indexJobSkills()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.job_skill.index')->with('languages', $languages);
    }

    public function createJobSkill()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $jobSkills = DataArrayHelper::defaultJobSkillsArray();
        return view('admin.job_skill.add')
                        ->with('languages', $languages)
                        ->with('jobSkills', $jobSkills);
    }

    public function storeJobSkill(JobSkillFormRequest $request)
    {
        $jobSkill = new JobSkill();
        $jobSkill->job_skill = $request->input('job_skill');
        $jobSkill->is_active = $request->input('is_active');
        $jobSkill->lang = $request->input('lang');
        $jobSkill->is_default = $request->input('is_default');
        $jobSkill->save();
        /*         * ************************************ */
        $jobSkill->sort_order = $jobSkill->id;
        if ((int) $request->input('is_default') == 1) {
            $jobSkill->job_skill_id = $jobSkill->id;
        } else {
            $jobSkill->job_skill_id = $request->input('job_skill_id');
        }
        $jobSkill->update();
        flash('Job Skill has been added!')->success();
        return \Redirect::route('edit.job.skill', array($jobSkill->id));
    }

    public function editJobSkill($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $jobSkills = DataArrayHelper::defaultJobSkillsArray();
        $jobSkill = JobSkill::findOrFail($id);
        return view('admin.job_skill.edit')
                        ->with('languages', $languages)
                        ->with('jobSkill', $jobSkill)
                        ->with('jobSkills', $jobSkills);
    }

    public function updateJobSkill($id, JobSkillFormRequest $request)
    {
        $jobSkill = JobSkill::findOrFail($id);
        $jobSkill->job_skill = $request->input('job_skill');
        $jobSkill->is_active = $request->input('is_active');
        $jobSkill->lang = $request->input('lang');
        $jobSkill->is_default = $request->input('is_default');
        if ((int) $request->input('is_default') == 1) {
            $jobSkill->job_skill_id = $jobSkill->id;
        } else {
            $jobSkill->job_skill_id = $request->input('job_skill_id');
        }
        $jobSkill->update();
        flash('Job Skill has been updated!')->success();
        return \Redirect::route('edit.job.skill', array($jobSkill->id));
    }

    public function deleteJobSkill(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobSkill = JobSkill::findOrFail($id);
            if ((bool) $jobSkill->is_default) {
                JobSkill::where('job_skill_id', '=', $jobSkill->job_skill_id)->delete();
            } else {
                $jobSkill->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchJobSkillsData(Request $request)
    {
        $jobSkills = JobSkill::select(['job_skills.id', 'job_skills.job_skill', 'job_skills.is_active', 'job_skills.lang', 'job_skills.is_default', 'job_skills.created_at', 'job_skills.updated_at'])->sorted();
        return Datatables::of($jobSkills)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('job_skill') && !empty($request->job_skill)) {
                                $query->where('job_skills.job_skill', 'like', "%{$request->get('job_skill')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('job_skills.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('is_active') && $request->get('is_active') != -1) {
                                $query->where('job_skills.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('job_skill', function ($jobSkills) {
                            $jobSkill = Str::limit($jobSkills->job_skill, 100, '...');
                            $direction = MiscHelper::getLangDirection($jobSkills->lang);
                            return '<span dir="' . $direction . '">' . $jobSkill . '</span>';
                        })
                        ->addColumn('action', function ($jobSkills) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $jobSkills->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $jobSkills->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $jobSkills->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.job.skill', ['id' => $jobSkills->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteJobSkill(' . $jobSkills->id . ', ' . $jobSkills->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $jobSkills->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['job_skill', 'action'])
                        ->setRowId(function($jobSkills) {
                            return 'jobSkillDtRow' . $jobSkills->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveJobSkill(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobSkill = JobSkill::findOrFail($id);
            $jobSkill->is_active = 1;
            $jobSkill->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveJobSkill(Request $request)
    {
        $id = $request->input('id');
        try {
            $jobSkill = JobSkill::findOrFail($id);
            $jobSkill->is_active = 0;
            $jobSkill->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortJobSkills()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.job_skill.sort')->with('languages', $languages);
    }

    public function jobSkillSortData(Request $request)
    {
        $lang = $request->input('lang');
        $jobSkills = JobSkill::select('job_skills.id', 'job_skills.job_skill', 'job_skills.sort_order')
                ->where('job_skills.lang', 'like', $lang)
                ->orderBy('job_skills.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($jobSkills != null) {
            foreach ($jobSkills as $jobSkill) {
                $str .= '<li id="' . $jobSkill->id . '"><i class="fa fa-sort"></i>' . $jobSkill->job_skill . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function jobSkillSortUpdate(Request $request)
    {
        $jobSkillOrder = $request->input('jobSkillOrder');
        $jobSkillOrderArray = explode(',', $jobSkillOrder);
        $count = 1;
        foreach ($jobSkillOrderArray as $jobSkillId) {
            $jobSkill = JobSkill::find($jobSkillId);
            $jobSkill->sort_order = $count;
            $jobSkill->update();
            $count++;
        }
    }

}
