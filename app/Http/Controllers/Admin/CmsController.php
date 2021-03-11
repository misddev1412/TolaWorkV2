<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Cms;
use App\CmsContent;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Language;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\CmsFormRequest;
use App\Http\Controllers\Controller;

class CmsController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCms()
    {
        return view('admin.cms.index');
    }

    public function createCms()
    {
        return view('admin.cms.add');
    }

    public function storeCms(CmsFormRequest $request)
    {
        $cms = new Cms();
        $cms->page_slug = $request->input('page_slug');
        $cms->seo_title = $request->input('seo_title');
        $cms->seo_description = $request->input('seo_description');
        $cms->seo_keywords = $request->input('seo_keywords');
        $cms->seo_other = $request->input('seo_other');
        $cms->show_in_top_menu = $request->input('show_in_top_menu');
        $cms->show_in_footer_menu = $request->input('show_in_footer_menu');
        $cms->save();
        flash('C.M.S page has been added!')->success();
        return \Redirect::route('edit.cms', array($cms->id));
    }

    public function editCms($id)
    {
        $cms = Cms::findOrFail($id);
        return view('admin.cms.edit', compact('cms'));
    }

    public function updateCms($id, CmsFormRequest $request)
    {
        $cms = Cms::findOrFail($id);
        $cms->page_slug = $request->input('page_slug');
        $cms->seo_title = $request->input('seo_title');
        $cms->seo_description = $request->input('seo_description');
        $cms->seo_keywords = $request->input('seo_keywords');
        $cms->seo_other = $request->input('seo_other');
        $cms->show_in_top_menu = $request->input('show_in_top_menu');
        $cms->show_in_footer_menu = $request->input('show_in_footer_menu');
        $cms->update();
        flash('C.M.S page has been updated!')->success();
        return \Redirect::route('edit.cms', array($cms->id));
    }

    public function deleteCms(Request $request)
    {
        $id = $request->input('id');
        try {
            $deletedCms = Cms::where('id', $id)->delete();
            $deletedCmsContent = CmsContent::where('page_id', $id)->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function fetchCmsData(Request $request)
    {
        $cms = Cms::select(
                        [
                            'cms.id',
                            'cms.page_slug',
                            'cms.seo_title',
                            'cms.seo_description',
                            'cms.seo_keywords',
                            'cms.seo_other',
                            'cms.created_at',
                            'cms.updated_at'
                        ]
        );
        return Datatables::of($cms)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('cms.id', 'like', "{$request->get('id')}");
                            }
                            if ($request->has('page_slug') && !empty($request->page_slug)) {
                                $query->where('cms.page_slug', 'like', "%{$request->get('page_slug')}%");
                            }
                        })
                        ->addColumn('action', function ($cms) {
                            /*                             * ************************* */
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.cms', ['id' => $cms->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="delete_cms(' . $cms->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>																																							
					</ul>
				</div>';
                        })
                        ->rawColumns(['action'])
                        ->setRowId(function($cms) {
                            return 'cms_dt_row_' . $cms->id;
                        })
                        ->make(true);
    }

}
