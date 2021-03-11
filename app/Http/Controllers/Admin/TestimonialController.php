<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\Testimonial;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\TestimonialFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class TestimonialController extends Controller
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

    public function indexTestimonials()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.testimonial.index')->with('languages', $languages);
    }

    public function createTestimonial()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $testimonials = DataArrayHelper::defaultTestimonialsArray();
        return view('admin.testimonial.add')
                        ->with('languages', $languages)
                        ->with('testimonials', $testimonials);
    }

    public function storeTestimonial(TestimonialFormRequest $request)
    {
        $testimonial = new Testimonial();
        $testimonial->lang = $request->input('lang');
        $testimonial->testimonial_by = $request->input('testimonial_by');
        $testimonial->testimonial = $request->input('testimonial');
        $testimonial->company = $request->input('company');
        $testimonial->is_default = $request->input('is_default');
        $testimonial->testimonial_id = $request->input('testimonial_id');
        $testimonial->is_active = $request->input('is_active');
        $testimonial->save();
        /*         * ************************************ */
        $testimonial->sort_order = $testimonial->id;
        if ((int) $request->input('is_default') == 1) {
            $testimonial->testimonial_id = $testimonial->id;
        } else {
            $testimonial->testimonial_id = $request->input('testimonial_id');
        }
        $testimonial->update();
        /*         * ************************************ */
        flash('Testimonial has been added!')->success();
        return \Redirect::route('edit.testimonial', array($testimonial->id));
    }

    public function editTestimonial($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $testimonials = DataArrayHelper::defaultTestimonialsArray();

        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit')
                        ->with('testimonial', $testimonial)
                        ->with('languages', $languages)
                        ->with('testimonials', $testimonials);
    }

    public function updateTestimonial($id, TestimonialFormRequest $request)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->lang = $request->input('lang');
        $testimonial->testimonial_by = $request->input('testimonial_by');
        $testimonial->testimonial = $request->input('testimonial');
        $testimonial->company = $request->input('company');
        $testimonial->is_default = $request->input('is_default');
        $testimonial->testimonial_id = $request->input('testimonial_id');
        $testimonial->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $testimonial->testimonial_id = $testimonial->id;
        } else {
            $testimonial->testimonial_id = $request->input('testimonial_id');
        }
        /*         * ************************************ */
        $testimonial->update();
        flash('Testimonial has been updated!')->success();
        return \Redirect::route('edit.testimonial', array($testimonial->id));
    }

    public function deleteTestimonial(Request $request)
    {
        $id = $request->input('id');
        try {
            $testimonial = Testimonial::findOrFail($id);
            if ((bool) $testimonial->is_default) {
                Testimonial::where('testimonial_id', '=', $testimonial->testimonial_id)->delete();
            } else {
                $testimonial->delete();
            }
            echo 'ok';
            exit;
        } catch (ModelNotFoundException $e) {
            echo 'notok';
            exit;
        }
    }

    public function fetchTestimonialsData(Request $request)
    {
        $testimonials = Testimonial::select([
                    'testimonials.id', 'testimonials.lang', 'testimonials.testimonial_by', 'testimonials.company', 'testimonials.testimonial', 'testimonials.is_default', 'testimonials.testimonial_id', 'testimonials.is_active',
                ])->sorted();
        return Datatables::of($testimonials)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('testimonials.id', 'like', "%{$request->get('id')}%");
                            }
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('testimonials.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('testimonial_by') && !empty($request->testimonial_by)) {
                                $query->where('testimonials.testimonial_by', 'like', "%{$request->get('testimonial_by')}%");
                            }

                            if ($request->has('testimonial') && !empty($request->testimonial)) {
                                $query->where('testimonials.testimonial', 'like', "%{$request->get('testimonial')}%");
                            }
                            if ($request->has('is_default') && !empty($request->is_default)) {
                                $query->where('testimonials.is_default', 'like', "%{$request->get('is_default')}%");
                            }
                            if ($request->has('testimonial_id') && !empty($request->testimonial_id)) {
                                $query->where('testimonials.testimonial_id', 'like', "%{$request->get('testimonial_id')}%");
                            }
                            if ($request->has('is_active') && !$request->is_active == -1) {
                                $query->where('testimonials.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('testimonial', function ($testimonials) {
                            $testimonial = Str::limit($testimonials->testimonial, 100, '...');
                            $direction = MiscHelper::getLangDirection($testimonials->lang);
                            return '<span dir="' . $direction . '">' . $testimonial . '</span>';
                        })
                        ->addColumn('action', function ($testimonials) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $testimonials->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $testimonials->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $testimonials->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.testimonial', ['id' => $testimonials->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteTestimonial(' . $testimonials->id . ', ' . $testimonials->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $testimonials->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'testimonial'])
                        ->setRowId(function($testimonials) {
                            return 'testimonialDtRow' . $testimonials->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveTestimonial(Request $request)
    {
        $id = $request->input('id');
        try {
            $testimonial = Testimonial::findOrFail($id);
            $testimonial->is_active = 1;
            $testimonial->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveTestimonial(Request $request)
    {
        $id = $request->input('id');
        try {
            $testimonial = Testimonial::findOrFail($id);
            $testimonial->is_active = 0;
            $testimonial->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortTestimonials()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.testimonial.sort')->with('languages', $languages);
    }

    public function testimonialSortData(Request $request)
    {
        $lang = $request->input('lang');
        $testimonials = Testimonial::select('testimonials.id', 'testimonials.testimonial', 'testimonials.sort_order')
                ->where('testimonials.lang', 'like', $lang)
                ->orderBy('testimonials.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($testimonials != null) {
            foreach ($testimonials as $testimonial) {
                $str .= '<li id="' . $testimonial->id . '"><i class="fa fa-sort"></i>' . $testimonial->testimonial . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function testimonialSortUpdate(Request $request)
    {
        $testimonialOrder = $request->input('testimonialOrder');
        $testimonialOrderArray = explode(',', $testimonialOrder);
        $count = 1;
        foreach ($testimonialOrderArray as $testimonialId) {
            $testimonial = Testimonial::find($testimonialId);
            $testimonial->sort_order = $count;
            $testimonial->update();
            $count++;
        }
    }

}
