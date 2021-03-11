<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\LanguageLevel;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\LanguageLevelFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class LanguageLevelController extends Controller
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

    public function indexLanguageLevels()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.language_level.index')->with('languages', $languages);
    }

    public function createLanguageLevel()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $languageLevels = DataArrayHelper::defaultLanguageLevelsArray();
        return view('admin.language_level.add')
                        ->with('languages', $languages)
                        ->with('languageLevels', $languageLevels);
    }

    public function storeLanguageLevel(LanguageLevelFormRequest $request)
    {
        $languageLevel = new LanguageLevel();
        $languageLevel->lang = $request->input('lang');
        $languageLevel->language_level = $request->input('language_level');
        $languageLevel->is_default = $request->input('is_default');
        $languageLevel->language_level_id = $request->input('language_level_id');
        $languageLevel->is_active = $request->input('is_active');
        $languageLevel->save();
        /*         * ************************************ */
        $languageLevel->sort_order = $languageLevel->id;
        if ((int) $request->input('is_default') == 1) {
            $languageLevel->language_level_id = $languageLevel->id;
        } else {
            $languageLevel->language_level_id = $request->input('language_level_id');
        }
        $languageLevel->update();
        /*         * ************************************ */
        flash('Language Level has been added!')->success();
        return \Redirect::route('edit.language.level', array($languageLevel->id));
    }

    public function editLanguageLevel($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $languageLevels = DataArrayHelper::defaultLanguageLevelsArray();
        $languageLevel = LanguageLevel::findOrFail($id);
        return view('admin.language_level.edit')
                        ->with('languages', $languages)
                        ->with('languageLevels', $languageLevels)
                        ->with('languageLevel', $languageLevel);
    }

    public function updateLanguageLevel($id, LanguageLevelFormRequest $request)
    {
        $languageLevel = LanguageLevel::findOrFail($id);
        $languageLevel->lang = $request->input('lang');
        $languageLevel->language_level = $request->input('language_level');
        $languageLevel->is_default = $request->input('is_default');
        $languageLevel->language_level_id = $request->input('language_level_id');
        $languageLevel->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $languageLevel->language_level_id = $languageLevel->id;
        } else {
            $languageLevel->language_level_id = $request->input('language_level_id');
        }
        /*         * ************************************ */
        $languageLevel->update();
        flash('Language Level has been updated!')->success();
        return \Redirect::route('edit.language.level', array($languageLevel->id));
    }

    public function deleteLanguageLevel(Request $request)
    {
        $id = $request->input('id');
        try {
            $languageLevel = LanguageLevel::findOrFail($id);
            if ((bool) $languageLevel->is_default) {
                LanguageLevel::where('language_level_id', '=', $languageLevel->language_level_id)->delete();
            } else {
                $languageLevel->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchLanguageLevelsData(Request $request)
    {
        $languageLevels = LanguageLevel::select([
                    'language_levels.id', 'language_levels.lang', 'language_levels.language_level', 'language_levels.is_default', 'language_levels.language_level_id', 'language_levels.is_active',
                ])->sorted();
        return Datatables::of($languageLevels)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('language_levels.lang', 'like', "{$request->get('lang')}");
                            }
                            if ($request->has('language_level') && !empty($request->language_level)) {
                                $query->where('language_levels.language_level', 'like', "%{$request->get('language_level')}%");
                            }
                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('language_levels.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('language_level', function ($languageLevels) {
                            $languageLevel = Str::limit($languageLevels->language_level, 100, '...');
                            $direction = MiscHelper::getLangDirection($languageLevels->lang);
                            return '<span dir="' . $direction . '">' . $languageLevel . '</span>';
                        })
                        ->addColumn('action', function ($languageLevels) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $languageLevels->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $languageLevels->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $languageLevels->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.language.level', ['id' => $languageLevels->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteLanguageLevel(' . $languageLevels->id . ', ' . $languageLevels->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $languageLevels->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'language_level'])
                        ->setRowId(function($languageLevels) {
                            return 'languageLevelDtRow' . $languageLevels->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveLanguageLevel(Request $request)
    {
        $id = $request->input('id');
        try {
            $languageLevel = LanguageLevel::findOrFail($id);
            $languageLevel->is_active = 1;
            $languageLevel->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveLanguageLevel(Request $request)
    {
        $id = $request->input('id');
        try {
            $languageLevel = LanguageLevel::findOrFail($id);
            $languageLevel->is_active = 0;
            $languageLevel->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortLanguageLevels()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.language_level.sort')->with('languages', $languages);
    }

    public function languageLevelSortData(Request $request)
    {
        $lang = $request->input('lang');
        $languageLevels = LanguageLevel::select('language_levels.id', 'language_levels.language_level', 'language_levels.sort_order')
                ->where('language_levels.lang', 'like', $lang)
                ->orderBy('language_levels.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($languageLevels != null) {
            foreach ($languageLevels as $languageLevel) {
                $str .= '<li id="' . $languageLevel->id . '"><i class="fa fa-sort"></i>' . $languageLevel->language_level . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function languageLevelSortUpdate(Request $request)
    {
        $languageLevelOrder = $request->input('languageLevelOrder');
        $languageLevelOrderArray = explode(',', $languageLevelOrder);
        $count = 1;
        foreach ($languageLevelOrderArray as $languageLevelId) {
            $languageLevel = LanguageLevel::find($languageLevelId);
            $languageLevel->sort_order = $count;
            $languageLevel->update();
            $count++;
        }
    }

}
