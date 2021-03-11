<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Faq;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Language;
use App\Http\Requests\FaqFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class FaqController extends Controller
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
    public function indexFaqs()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.faq.index')->with('languages', $languages);
    }

    public function createFaq()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.faq.add')->with('languages', $languages);
    }

    public function storeFaq(FaqFormRequest $request)
    {
        $faq = new Faq();
        $faq->faq_question = $request->input('faq_question');
        $faq->faq_answer = $request->input('faq_answer');
        $faq->lang = $request->input('lang');
        $faq->save();
        /*         * ************************************ */
        $faq->sort_order = $faq->id;
        $faq->update();
        flash('FAQ has been added!')->success();
        return \Redirect::route('edit.faq', array($faq->id));
    }

    public function editFaq($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $faq = Faq::findOrFail($id);
        return view('admin.faq.edit')
                        ->with('languages', $languages)
                        ->with('faq', $faq);
    }

    public function updateFaq($id, FaqFormRequest $request)
    {
        $faq = Faq::findOrFail($id);
        $faq->faq_question = $request->input('faq_question');
        $faq->faq_answer = $request->input('faq_answer');
        $faq->lang = $request->input('lang');
        $faq->update();
        flash('FAQ has been updated!')->success();
        return \Redirect::route('edit.faq', array($faq->id));
    }

    public function deleteFaq(Request $request)
    {
        $id = $request->input('id');
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function fetchFaqsData(Request $request)
    {
        $faqs = Faq::select(
                        [
                            'faqs.id',
                            'faqs.faq_question',
                            'faqs.faq_answer',
                            'faqs.sort_order',
                            'faqs.lang',
                            'faqs.created_at',
                            'faqs.updated_at'
                        ]
        );
        return Datatables::of($faqs)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('faq_question') && !empty($request->faq_question)) {
                                $query->where('faqs.faq_question', 'like', "%{$request->get('faq_question')}%");
                            }
                            if ($request->has('lang') && !empty($request->get('lang'))) {
                                $query->where('faqs.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('faq_answer') && !empty($request->faq_answer)) {
                                $query->where('faqs.faq_question', 'like', "%{$request->get('faq_answer')}%");
                            }
                        })
                        ->addColumn('faq_answer', function ($faqs) {
                            $faq_answer = Str::limit($faqs->faq_answer, 100, '...');
                            $direction = MiscHelper::getLangDirection($faqs->lang);
                            return '<span dir="' . $direction . '">' . $faq_answer . '</span>';
                        })
                        ->addColumn('faq_question', function ($faqs) {
                            $faq_question = Str::limit($faqs->faq_question, 100, '...');
                            $direction = MiscHelper::getLangDirection($faqs->lang);
                            return '<span dir="' . $direction . '">' . $faq_question . '</span>';
                        })
                        ->addColumn('action', function ($faqs) {
                            /*                             * ************************* */
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.faq', ['id' => $faqs->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="delete_faq(' . $faqs->id . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>																																							
					</ul>
				</div>';
                        })
                        ->rawColumns(['faq_answer', 'faq_question', 'action'])
                        ->setRowId(function($faqs) {
                            return 'faq_dt_row_' . $faqs->id;
                        })
                        ->make(true);
    }

    public function sortFaqs()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.faq.sort')->with('languages', $languages);
    }

    public function faqSortData(Request $request)
    {
        $lang = $request->input('lang');
        $faqs = Faq::select('faqs.id', 'faqs.faq_question', 'faqs.sort_order')
                        ->where('faqs.lang', 'like', $lang)
                        ->orderBy('faqs.sort_order')->get();
        $str = '<ul id="sortable">';
        if ($faqs != null) {
            foreach ($faqs as $faq) {
                $str .= '<li id="' . $faq->id . '"><i class="fa fa-sort"></i>' . $faq->faq_question . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function faqSortUpdate(Request $request)
    {
        $faqOrder = $request->input('faqOrder');
        $faqOrderArray = explode(',', $faqOrder);
        $count = 1;
        foreach ($faqOrderArray as $faq_id) {
            $faq = Faq::find($faq_id);
            $faq->sort_order = $count;
            $faq->update();
            $count++;
        }
    }

}
