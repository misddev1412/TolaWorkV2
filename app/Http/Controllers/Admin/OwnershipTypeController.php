<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\OwnershipType;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\OwnershipTypeFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class OwnershipTypeController extends Controller
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

    public function indexOwnershipTypes()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.ownership_type.index')->with('languages', $languages);
    }

    public function createOwnershipType()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();

        return view('admin.ownership_type.add')
                        ->with('languages', $languages)
                        ->with('ownershipTypes', $ownershipTypes);
    }

    public function storeOwnershipType(OwnershipTypeFormRequest $request)
    {
        $ownershipType = new OwnershipType();
        $ownershipType->lang = $request->input('lang');
        $ownershipType->ownership_type = $request->input('ownership_type');
        $ownershipType->is_default = $request->input('is_default');
        $ownershipType->ownership_type_id = $request->input('ownership_type_id');
        $ownershipType->is_active = $request->input('is_active');
        $ownershipType->save();
        /*         * ************************************ */
        $ownershipType->sort_order = $ownershipType->id;
        if ((int) $request->input('is_default') == 1) {
            $ownershipType->ownership_type_id = $ownershipType->id;
        } else {
            $ownershipType->ownership_type_id = $request->input('ownership_type_id');
        }
        $ownershipType->update();
        /*         * ************************************ */
        flash('Ownership Type has been added!')->success();
        return \Redirect::route('edit.ownership.type', array($ownershipType->id));
    }

    public function editOwnershipType($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();

        $ownershipType = OwnershipType::findOrFail($id);
        return view('admin.ownership_type.edit')
                        ->with('languages', $languages)
                        ->with('ownershipTypes', $ownershipTypes)
                        ->with('ownershipType', $ownershipType);
    }

    public function updateOwnershipType($id, OwnershipTypeFormRequest $request)
    {
        $ownershipType = OwnershipType::findOrFail($id);
        $ownershipType->lang = $request->input('lang');
        $ownershipType->ownership_type = $request->input('ownership_type');
        $ownershipType->is_default = $request->input('is_default');
        $ownershipType->ownership_type_id = $request->input('ownership_type_id');
        $ownershipType->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $ownershipType->ownership_type_id = $ownershipType->id;
        } else {
            $ownershipType->ownership_type_id = $request->input('ownership_type_id');
        }
        /*         * ************************************ */
        $ownershipType->update();
        flash('Ownership Type has been updated!')->success();
        return \Redirect::route('edit.ownership.type', array($ownershipType->id));
    }

    public function deleteOwnershipType(Request $request)
    {
        $id = $request->input('id');
        try {
            $ownershipType = OwnershipType::findOrFail($id);
            if ((bool) $ownershipType->is_default) {
                OwnershipType::where('ownership_type_id', '=', $ownershipType->ownership_type_id)->delete();
            } else {
                $ownershipType->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchOwnershipTypesData(Request $request)
    {
        $ownershipTypes = OwnershipType::select([
                    'ownership_types.id', 'ownership_types.lang', 'ownership_types.ownership_type', 'ownership_types.is_default', 'ownership_types.ownership_type_id', 'ownership_types.is_active',
                ])->sorted();
        return Datatables::of($ownershipTypes)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('ownership_types.lang', 'like', "{$request->get('lang')}");
                            }
                            if ($request->has('ownership_type') && !empty($request->ownership_type)) {
                                $query->where('ownership_types.ownership_type', 'like', "%{$request->get('ownership_type')}%");
                            }
                            if ($request->has('is_active') && $request->is_active != -1) {
                                $query->where('ownership_types.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('ownership_type', function ($ownershipTypes) {
                            $ownershipType = Str::limit($ownershipTypes->ownership_type, 100, '...');
                            $direction = MiscHelper::getLangDirection($ownershipTypes->lang);
                            return '<span dir="' . $direction . '">' . $ownershipType . '</span>';
                        })
                        ->addColumn('action', function ($ownershipTypes) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $ownershipTypes->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $ownershipTypes->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $ownershipTypes->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.ownership.type', ['id' => $ownershipTypes->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteOwnershipType(' . $ownershipTypes->id . ', ' . $ownershipTypes->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $ownershipTypes->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'ownership_type'])
                        ->setRowId(function($ownershipTypes) {
                            return 'ownershipTypeDtRow' . $ownershipTypes->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveOwnershipType(Request $request)
    {
        $id = $request->input('id');
        try {
            $ownershipType = OwnershipType::findOrFail($id);
            $ownershipType->is_active = 1;
            $ownershipType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveOwnershipType(Request $request)
    {
        $id = $request->input('id');
        try {
            $ownershipType = OwnershipType::findOrFail($id);
            $ownershipType->is_active = 0;
            $ownershipType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortOwnershipTypes()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.ownership_type.sort')->with('languages', $languages);
    }

    public function ownershipTypeSortData(Request $request)
    {
        $lang = $request->input('lang');
        $ownershipTypes = OwnershipType::select('ownership_types.id', 'ownership_types.ownership_type', 'ownership_types.sort_order')
                ->where('ownership_types.lang', 'like', $lang)
                ->orderBy('ownership_types.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($ownershipTypes != null) {
            foreach ($ownershipTypes as $ownershipType) {
                $str .= '<li id="' . $ownershipType->id . '"><i class="fa fa-sort"></i>' . $ownershipType->ownership_type . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function ownershipTypeSortUpdate(Request $request)
    {
        $ownershipTypeOrder = $request->input('ownershipTypeOrder');
        $ownershipTypeOrderArray = explode(',', $ownershipTypeOrder);
        $count = 1;
        foreach ($ownershipTypeOrderArray as $ownershipTypeId) {
            $ownershipType = OwnershipType::find($ownershipTypeId);
            $ownershipType->sort_order = $count;
            $ownershipType->update();
            $count++;
        }
    }

}
