<?php



namespace App\Http\Controllers;



use App;

use App\Seo;

use App\Job;

use App\Company;

use App\FunctionalArea;

use App\Country;

use App\Video;

use App\Industry;

use App\Testimonial;

use App\Slider;

use App\Blog;

use App\Blog_category;

use Illuminate\Http\Request;

use App\Total_jobs;

use Redirect;

use App\Traits\CompanyTrait;

use App\Traits\FunctionalAreaTrait;

use App\Traits\CityTrait;

use App\Traits\JobTrait;

use App\Traits\Active;

use App\Helpers\DataArrayHelper;

use App\Traits\Lang;

use DB;

use Cache;

use Session;



class BlogController extends Controller

{



    //use CompanyTrait;

    //use FunctionalAreaTrait;

    // use CityTrait;

    //use JobTrait;

     use Lang;



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

    public function index()

    {

        $data['blogs'] = Blog::orderBy('id', 'DESC')->where('lang', 'like', \App::getLocale())->paginate(10);

        $data['categories'] = Blog_category::get();

        return view('blog')->with($data);

    }



    public function details($slug)

    {

        $data['blog'] = Blog::where('slug','like','%'. $slug.'%')->where('lang', 'like', \App::getLocale())->first();

        $data['blog_categories'] = Blog_category::get();

		$data['categories'] = Blog_category::get();

         $data['seo'] = (object) array(

                    'seo_title' => $data['blog']->meta_title,

                    'seo_description' => $data['blog']->meta_keywords,

                    'seo_keywords' => $data['blog']->meta_descriptions,

                    'seo_other' => ''

        );

        return view('blog_detail')->with($data);

    }

    public function categories($slug)

    {

        $category = Blog_category::where('slug', $slug)->first();

        $data['category'] = $category;

        $data['blogs_categories'] = Blog_category::get();

        $data['blogs'] = Blog::whereRaw("FIND_IN_SET('$category->id',cate_id)")->where('lang', 'like', \App::getLocale())->orderBy('id', 'DESC')->paginate(10);

        return view('blog_categories_details')->with($data);

    }

    public function search(Request $request)

    { 

        $data['serach_result'] = $request->get('search');

        $data['blogs'] =Blog::where('heading', 'like', $request->get('search'))

                ->orWhere('content', 'like','%' . $request->get('search') . '%')->where('lang', 'like', \App::getLocale())

                ->paginate(1);

        $data['categories'] = Blog_category::get();

        return view('blog_search')->with($data);

    }

}