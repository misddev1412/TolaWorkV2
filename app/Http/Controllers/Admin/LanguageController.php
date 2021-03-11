<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\LanguageFormRequest;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
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

    public function indexLanguages()
    {
        return view('admin.language.index');
    }

    public function createLanguage()
    {
        return view('admin.language.add');
    }

    public function storeLanguage(LanguageFormRequest $request)
    {
        $language = new Language();
        $language->lang = $request->input('lang');
        $language->native = $request->input('native');
        $language->iso_code = $request->input('iso_code');
        $language->is_active = $request->input('is_active');
        $language->is_rtl = $request->input('is_rtl');
        $language->is_default = $request->input('is_default');
        $language->save();
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $this->updateDefaultLang($language->id);
        }
        /*         * ************************************ */
        flash('Language has been added!')->success();
        return \Redirect::route('edit.language', array($language->id));
    }

    public function editLanguage($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.language.edit')
                        ->with('language', $language);
    }

    public function updateLanguage($id, LanguageFormRequest $request)
    {
        $language = Language::findOrFail($id);
        $language->lang = $request->input('lang');
        $language->native = $request->input('native');
        $language->iso_code = $request->input('iso_code');
        $language->is_active = $request->input('is_active');
        $language->is_rtl = $request->input('is_rtl');
        $language->is_default = $request->input('is_default');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $this->updateDefaultLang($language->id);
        }
        /*         * ************************************ */
        $language->update();
        flash('Language has been updated!')->success();
        return \Redirect::route('edit.language', array($language->id));
    }

    public function deleteLanguage(Request $request)
    {
        $id = $request->input('id');
        try {
            $language = Language::findOrFail($id);
            $language->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchLanguagesData(Request $request)
    {
        $languages = Language::select([
                    'languages.id', 'languages.lang', 'languages.native', 'languages.iso_code', 'languages.is_active', 'languages.is_rtl', 'languages.is_default',
                ])->sorted();
        return Datatables::of($languages)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('native') && !empty($request->native)) {
                                $query->where('languages.native', 'like', "%{$request->get('native')}%");
                            }
                            if ($request->has('iso_code') && !empty($request->iso_code)) {
                                $query->where('languages.iso_code', 'like', "%{$request->get('iso_code')}%");
                            }
                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('languages.is_active', '=', "{$request->get('is_active')}");
                            }
                            if ($request->has('is_rtl') && $request->is_rtl != -1) {
                                $query->where('languages.is_rtl', '=', "{$request->get('is_rtl')}");
                            }
                            if ($request->has('is_default') && $request->is_default != -1) {
                                $query->where('languages.is_default', '=', "{$request->get('is_default')}");
                            }
                        })
                        ->addColumn('is_default', function($languages) {
                            return ((int) $languages->is_default === 1) ? 'Yes' : 'No';
                        })
                        ->addColumn('is_rtl', function($languages) {
                            return ((int) $languages->is_rtl === 1) ? 'Yes' : 'No';
                        })
                        ->addColumn('action', function ($languages) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $languages->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $languages->is_active === 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $languages->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.language', ['id' => $languages->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteLanguage(' . $languages->id . ', ' . $languages->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="makeDefaultLanguage(' . $languages->id . ');" class=""><i class="fa fa-pencil" aria-hidden="true"></i>Make Default</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $languages->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'is_default', 'is_rtl'])
                        ->setRowId(function($languages) {
                            return 'languageDtRow' . $languages->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveLanguage(Request $request)
    {
        $id = $request->input('id');
        try {
            $language = Language::findOrFail($id);
            $language->is_active = 1;
            $language->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveLanguage(Request $request)
    {
        $id = $request->input('id');
        try {
            $language = Language::findOrFail($id);
            $language->is_active = 0;
            $language->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeDefaultLanguage(Request $request)
    {
        $id = $request->input('id');
        try {
            $language = Language::findOrFail($id);
            $language->is_default = 1;
            $language->update();
            $this->updateDefaultLang($id);
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    private function updateDefaultLang($language_id)
    {
        Language::where('is_default', '=', 1)->where('id', '<>', $language_id)->update(['is_default' => 0]);
    }

}
