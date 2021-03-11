<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Seo;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\SeoFormRequest;
use App\Http\Controllers\Controller;

class SeoController extends Controller
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
    public function indexSeo()
    {
        return view('admin.seo.index');
    }

    public function editSeo($id)
    {
        $seo = Seo::findOrFail($id);
        return view('admin.seo.edit')->with('seo', $seo);
    }

    public function updateSeo($id, SeoFormRequest $request)
    {
        $seo = Seo::findOrFail($id);
        $seo->seo_title = $request->input('seo_title');
        $seo->seo_description = $request->input('seo_description');
        $seo->seo_keywords = $request->input('seo_keywords');
        $seo->seo_other = $request->input('seo_other');
        $seo->update();
        flash('S.E.O has been updated!')->success();
        return \Redirect::route('edit.seo', array($seo->id));
    }

    public function fetchSeoData(Request $request)
    {
        $seo = Seo::select(
                        [
                            'seo.id',
                            'seo.page_title',
                            'seo.seo_title',
                            'seo.seo_description',
                            'seo.seo_keywords',
                            'seo.seo_other',
                            'seo.created_at',
                            'seo.updated_at'
                        ]
        );
        return Datatables::of($seo)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('seo.id', 'like', "{$request->get('id')}");
                            }
                            if ($request->has('page_title') && !empty($request->page_title)) {
                                $query->where('seo.page_title', 'like', "%{$request->get('page_title')}%");
                            }
                        })
                        ->addColumn('action', function ($seo) {
                            /*                             * ************************* */
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.seo', ['id' => $seo->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>																																													
					</ul>
				</div>';
                        })
                        ->rawColumns(['action'])
                        ->setRowId(function($seo) {
                            return 'seo_dt_row_' . $seo->id;
                        })
                        ->make(true);
    }

}
