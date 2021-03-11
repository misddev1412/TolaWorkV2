<?php

namespace App\Http\Controllers;

use App\Seo;
use App\Cms;
use App\CmsContent;
use Illuminate\Http\Request;

class CmsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPage($slug)
    {
        $cms = Cms::where('page_slug', 'like', $slug)->first();
        if (null === $cmsContent = CmsContent::getContentByPageId($cms->id)) {
            echo 'No Content';
            exit;
        }

        $seo = (object) array(
                    'seo_title' => $cms->seo_title,
                    'seo_description' => $cms->seo_description,
                    'seo_keywords' => $cms->seo_keywords,
                    'seo_other' => $cms->seo_other
        );

        return view('cms.cms_page')
                        ->with('cmsContent', $cmsContent)
                        ->with('seo', $seo);
    }

}
