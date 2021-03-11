<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\MajorSubject;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\MajorSubjectFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class MajorSubjectController extends Controller
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

    public function indexMajorSubjects()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.major_subject.index')->with('languages', $languages);
    }

    public function createMajorSubject()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $majorSubjects = DataArrayHelper::defaultMajorSubjectsArray();
        return view('admin.major_subject.add')
                        ->with('languages', $languages)
                        ->with('majorSubjects', $majorSubjects);
    }

    public function storeMajorSubject(MajorSubjectFormRequest $request)
    {
        $majorSubject = new MajorSubject();
        $majorSubject->lang = $request->input('lang');
        $majorSubject->major_subject = $request->input('major_subject');
        $majorSubject->is_default = $request->input('is_default');
        $majorSubject->major_subject_id = $request->input('major_subject_id');
        $majorSubject->is_active = $request->input('is_active');
        $majorSubject->save();
        /*         * ************************************ */
        $majorSubject->sort_order = $majorSubject->id;
        if ((int) $request->input('is_default') == 1) {
            $majorSubject->major_subject_id = $majorSubject->id;
        } else {
            $majorSubject->major_subject_id = $request->input('major_subject_id');
        }
        $majorSubject->update();
        /*         * ************************************ */
        flash('Major Subject has been added!')->success();
        return \Redirect::route('edit.major.subject', array($majorSubject->id));
    }

    public function editMajorSubject($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $majorSubjects = DataArrayHelper::defaultMajorSubjectsArray();
        $majorSubject = MajorSubject::findOrFail($id);
        return view('admin.major_subject.edit')
                        ->with('languages', $languages)
                        ->with('majorSubjects', $majorSubjects)
                        ->with('majorSubject', $majorSubject);
    }

    public function updateMajorSubject($id, MajorSubjectFormRequest $request)
    {
        $majorSubject = MajorSubject::findOrFail($id);
        $majorSubject->lang = $request->input('lang');
        $majorSubject->major_subject = $request->input('major_subject');
        $majorSubject->is_default = $request->input('is_default');
        $majorSubject->major_subject_id = $request->input('major_subject_id');
        $majorSubject->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $majorSubject->major_subject_id = $majorSubject->id;
        } else {
            $majorSubject->major_subject_id = $request->input('major_subject_id');
        }
        /*         * ************************************ */
        $majorSubject->update();
        flash('Major Subject has been updated!')->success();
        return \Redirect::route('edit.major.subject', array($majorSubject->id));
    }

    public function deleteMajorSubject(Request $request)
    {
        $id = $request->input('id');
        try {
            $majorSubject = MajorSubject::findOrFail($id);
            if ((bool) $majorSubject->is_default) {
                MajorSubject::where('major_subject_id', '=', $majorSubject->major_subject_id)->delete();
            } else {
                $majorSubject->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchMajorSubjectsData(Request $request)
    {
        $majorSubjects = MajorSubject::select([
                    'major_subjects.id', 'major_subjects.lang', 'major_subjects.major_subject', 'major_subjects.is_default', 'major_subjects.major_subject_id', 'major_subjects.is_active',
                ])->sorted();
        return Datatables::of($majorSubjects)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('major_subjects.id', 'like', "%{$request->get('id')}%");
                            }
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('major_subjects.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('major_subject') && !empty($request->major_subject)) {
                                $query->where('major_subjects.major_subject', 'like', "%{$request->get('major_subject')}%");
                            }
                            if ($request->has('is_default') && !empty($request->is_default)) {
                                $query->where('major_subjects.is_default', 'like', "%{$request->get('is_default')}%");
                            }
                            if ($request->has('major_subject_id') && !empty($request->major_subject_id)) {
                                $query->where('major_subjects.major_subject_id', 'like', "%{$request->get('major_subject_id')}%");
                            }
                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('major_subjects.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('major_subject', function ($majorSubjects) {
                            $majorSubject = Str::limit($majorSubjects->major_subject, 100, '...');
                            $direction = MiscHelper::getLangDirection($majorSubjects->lang);
                            return '<span dir="' . $direction . '">' . $majorSubject . '</span>';
                        })
                        ->addColumn('action', function ($majorSubjects) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $majorSubjects->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $majorSubjects->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $majorSubjects->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.major.subject', ['id' => $majorSubjects->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteMajorSubject(' . $majorSubjects->id . ', ' . $majorSubjects->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $majorSubjects->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'major_subject'])
                        ->setRowId(function($majorSubjects) {
                            return 'majorSubjectDtRow' . $majorSubjects->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveMajorSubject(Request $request)
    {
        $id = $request->input('id');
        try {
            $majorSubject = MajorSubject::findOrFail($id);
            $majorSubject->is_active = 1;
            $majorSubject->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveMajorSubject(Request $request)
    {
        $id = $request->input('id');
        try {
            $majorSubject = MajorSubject::findOrFail($id);
            $majorSubject->is_active = 0;
            $majorSubject->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortMajorSubjects()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.major_subject.sort')->with('languages', $languages);
    }

    public function majorSubjectSortData(Request $request)
    {
        $lang = $request->input('lang');
        $majorSubjects = MajorSubject::select('major_subjects.id', 'major_subjects.major_subject', 'major_subjects.sort_order')
                ->where('major_subjects.lang', 'like', $lang)
                ->orderBy('major_subjects.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($majorSubjects != null) {
            foreach ($majorSubjects as $majorSubject) {
                $str .= '<li id="' . $majorSubject->id . '"><i class="fa fa-sort"></i>' . $majorSubject->major_subject . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function majorSubjectSortUpdate(Request $request)
    {
        $majorSubjectOrder = $request->input('majorSubjectOrder');
        $majorSubjectOrderArray = explode(',', $majorSubjectOrder);
        $count = 1;
        foreach ($majorSubjectOrderArray as $majorSubjectId) {
            $majorSubject = MajorSubject::find($majorSubjectId);
            $majorSubject->sort_order = $count;
            $majorSubject->update();
            $count++;
        }
    }

}
