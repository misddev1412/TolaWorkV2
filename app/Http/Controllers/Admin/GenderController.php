<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use File;
use Carbon\Carbon;
use ImgUploader;
use Redirect;
use App\Gender;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\GenderFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class GenderController extends Controller
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

    public function indexGenders()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.gender.index')->with('languages', $languages);
    }

    public function createGender()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $genders = DataArrayHelper::defaultGendersArray();
        return view('admin.gender.add')
                        ->with('languages', $languages)
                        ->with('genders', $genders);
    }

    public function storeGender(GenderFormRequest $request)
    {
        $gender = new Gender();
        $gender->gender = $request->input('gender');
        $gender->is_active = $request->input('is_active');
        $gender->lang = $request->input('lang');
        $gender->is_default = $request->input('is_default');
        $gender->save();
        /*         * ************************************ */
        $gender->sort_order = $gender->id;
        if ((int) $request->input('is_default') == 1) {
            $gender->gender_id = $gender->id;
        } else {
            $gender->gender_id = $request->input('gender_id');
        }
        $gender->update();
        flash('Gender has been added!')->success();
        return \Redirect::route('edit.gender', array($gender->id));
    }

    public function editGender($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $genders = DataArrayHelper::defaultGendersArray();
        $gender = Gender::findOrFail($id);
        return view('admin.gender.edit')
                        ->with('languages', $languages)
                        ->with('gender', $gender)
                        ->with('genders', $genders);
    }

    public function updateGender($id, GenderFormRequest $request)
    {
        $gender = Gender::findOrFail($id);
        $gender->gender = $request->input('gender');
        $gender->is_active = $request->input('is_active');
        $gender->lang = $request->input('lang');
        $gender->is_default = $request->input('is_default');
        if ((int) $request->input('is_default') == 1) {
            $gender->gender_id = $gender->id;
        } else {
            $gender->gender_id = $request->input('gender_id');
        }
        $gender->update();
        flash('Gender has been updated!')->success();
        return \Redirect::route('edit.gender', array($gender->id));
    }

    public function deleteGender(Request $request)
    {
        $id = $request->input('id');
        try {
            $gender = Gender::findOrFail($id);
            if ((bool) $gender->is_default) {
                Gender::where('gender_id', '=', $gender->gender_id)->delete();
            } else {
                $gender->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchGendersData(Request $request)
    {
        $genders = Gender::select(['genders.id', 'genders.gender', 'genders.is_active', 'genders.lang', 'genders.is_default', 'genders.created_at', 'genders.updated_at'])->sorted();
        return Datatables::of($genders)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('gender') && !empty($request->gender)) {
                                $query->where('genders.gender', 'like', "%{$request->get('gender')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('genders.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('is_active') && $request->get('is_active') != -1) {
                                $query->where('genders.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('gender', function ($genders) {
                            $gender = Str::limit($genders->gender, 100, '...');
                            $direction = MiscHelper::getLangDirection($genders->lang);
                            return '<span dir="' . $direction . '">' . $gender . '</span>';
                        })
                        ->addColumn('action', function ($genders) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $genders->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $genders->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $genders->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.gender', ['id' => $genders->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteGender(' . $genders->id . ', ' . $genders->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $genders->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['gender', 'action'])
                        ->setRowId(function($genders) {
                            return 'genderDtRow' . $genders->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveGender(Request $request)
    {
        $id = $request->input('id');
        try {
            $gender = Gender::findOrFail($id);
            $gender->is_active = 1;
            $gender->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveGender(Request $request)
    {
        $id = $request->input('id');
        try {
            $gender = Gender::findOrFail($id);
            $gender->is_active = 0;
            $gender->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortGenders()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.gender.sort')->with('languages', $languages);
    }

    public function genderSortData(Request $request)
    {
        $lang = $request->input('lang');
        $genders = Gender::select('genders.id', 'genders.gender', 'genders.sort_order')
                ->where('genders.lang', 'like', $lang)
                ->orderBy('genders.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($genders != null) {
            foreach ($genders as $gender) {
                $str .= '<li id="' . $gender->id . '"><i class="fa fa-sort"></i>' . $gender->gender . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function genderSortUpdate(Request $request)
    {
        $genderOrder = $request->input('genderOrder');
        $genderOrderArray = explode(',', $genderOrder);
        $count = 1;
        foreach ($genderOrderArray as $genderId) {
            $gender = Gender::find($genderId);
            $gender->sort_order = $count;
            $gender->update();
            $count++;
        }
    }

}
