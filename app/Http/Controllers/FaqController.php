<?php

namespace App\Http\Controllers;

use DB;
use App\Faq;
use App\Seo;
use App\Http\Controllers\Controller;

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
    public function index()
    {
        $faqs = Faq::select(
                        [
                            'faqs.id',
                            'faqs.faq_question',
                            'faqs.faq_answer',
                            'faqs.sort_order',
                            'faqs.created_at',
                            'faqs.updated_at'
                        ]
                )
                ->lang()
                ->orderBy('faqs.sort_order', 'ASC')
                ->orderBy('faqs.id', 'ASC')
                ->get();
        $seo = SEO::where('seo.page_title', 'like', 'faq')->first();
        //print_r($seo);exit;
        return view('faq.list_faq')->with('faqs', $faqs)->with('seo', $seo);
    }

}
