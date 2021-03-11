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
use App\Http\Requests\CmsContentFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CmsContentController extends Controller
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
    public function indexCmsContent()
    {
        return view('admin.cms_content.index');
    }

    public function createCmsContent()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $cmsPages = cms::select('cms.id', 'cms.page_slug')->orderBy('cms.page_slug')->pluck('cms.page_slug', 'cms.id')->toArray();
        return view('admin.cms_content.add')
                        ->with('languages', $languages)
                        ->with('cmsPages', $cmsPages);
    }

    public function storeCmsContent(CmsContentFormRequest $request)
    {
        $cmsContent = new CmsContent();
        $cmsContent->page_id = $request->input('page_id');
        $cmsContent->page_title = $request->input('page_title');
        $cmsContent->page_content = $request->input('page_content');
        $cmsContent->lang = $request->input('lang');
        $cmsContent->save();
        flash('C.M.S page has been added!')->success();
        return \Redirect::route('edit.cmsContent', array($cmsContent->id));
    }

    public function editCmsContent($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $cmsPages = cms::select('cms.id', 'cms.page_slug')->orderBy('cms.page_slug')->pluck('cms.page_slug', 'cms.id')->toArray();
        $cmsContent = CmsContent::findOrFail($id);
        return view('admin.cms_content.edit', compact('languages', 'cmsPages', 'cmsContent'));
    }

    public function updateCmsContent($id, CmsContentFormRequest $request)
    {
        $cmsContent = CmsContent::findOrFail($id);
        $cmsContent->page_id = $request->input('page_id');
        $cmsContent->page_title = $request->input('page_title');
        $cmsContent->page_content = $request->input('page_content');
        $cmsContent->lang = $request->input('lang');
        $cmsContent->update();
        flash('C.M.S page has been updated!')->success();
        return \Redirect::route('edit.cmsContent', array($cmsContent->id));
    }

    public function deleteCmsContent(Request $request)
    {
        $id = $request->input('id');
        try {
            $cmsContent = CmsContent::findOrFail($id);
            $cmsContent->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function fetchCmsContentData(Request $request)
    {
        $cmsContent = CmsContent::select(
                        [
                            'cms_content.id',
                            'cms_content.page_title',
                            'cms_content.page_id',
                            'cms_content.page_content',
                            'cms_content.lang',
                            'cms_content.created_at',
                            'cms_content.updated_at'
                        ]
        );
        return Datatables::of($cmsContent)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('cms_content.id', 'like', "{$request->get('id')}");
                            }
                            if ($request->has('page_title') && !empty($request->page_title)) {
                                $query->where('cms_content.page_title', 'like', "%{$request->get('page_title')}%");
                            }
                        })
                        ->addColumn('page_title', function ($cmsContent) {
                            $page_title = Str::limit($cmsContent->page_title, 100, '...');
                            $direction = MiscHelper::getLangDirection($cmsContent->lang);
                            return '<span dir="' . $direction . '">' . $page_title . '</span>';
                        })
                        ->addColumn('page_content', function ($cmsContent) {
                            $page_content = Str::limit($cmsContent->page_content, 100, '...');
                            $direction = MiscHelper::getLangDirection($cmsContent->lang);
                            return '<span dir="' . $direction . '">' . $page_content . '</span>';
                        })
                        ->addColumn('action', function ($cmsContent) {
                            /*                             * ************************* */
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.cmsContent', ['id' => $cmsContent->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="delete_cmsContent(' . $cmsContent->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>																																							
					</ul>
				</div>';
                        })
                        ->rawColumns(['page_title', 'page_content', 'action'])
                        ->setRowId(function($cmsContent) {
                            return 'cmsContent_dt_row_' . $cmsContent->id;
                        })
                        ->make(true);
    }

}
