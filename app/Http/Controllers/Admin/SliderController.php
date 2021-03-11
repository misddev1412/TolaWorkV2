<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\Slider;
use ImgUploader;
use File;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\SliderFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class SliderController extends Controller
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

    public function indexSliders()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.slider.index')->with('languages', $languages);
    }

    public function createSlider()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $sliders = DataArrayHelper::defaultSlidersArray();
        return view('admin.slider.add')
                        ->with('languages', $languages)
                        ->with('sliders', $sliders);
    }

    public function storeSlider(SliderFormRequest $request)
    {
        $slider = new Slider();
		if ($request->hasFile('slider_image')) {
            $image_name = $request->input('slider_heading');
			$fileName = ImgUploader::UploadImage('slider_images', $request->file('slider_image'), $image_name, 1920, 730);
            $slider->slider_image = $fileName;
        }
        $slider->lang = $request->input('lang');        
		$slider->slider_heading = $request->input('slider_heading');
		$slider->slider_description = $request->input('slider_description');
		$slider->slider_link = $request->input('slider_link');
		$slider->slider_link_text = $request->input('slider_link_text');		
        $slider->is_default = $request->input('is_default');
        $slider->slider_id = $request->input('slider_id');
        $slider->is_active = $request->input('is_active');
        $slider->save();
        /*         * ************************************ */
        $slider->sort_order = $slider->id;
        if ((int) $request->input('is_default') == 1) {
            $slider->slider_id = $slider->id;
        } else {
            $slider->slider_id = $request->input('slider_id');
        }
        $slider->update();
        /*         * ************************************ */
        flash('Slider has been added!')->success();
        return \Redirect::route('edit.slider', array($slider->id));
    }

    public function editSlider($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $sliders = DataArrayHelper::defaultSlidersArray();

        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit')
                        ->with('slider', $slider)
                        ->with('languages', $languages)
                        ->with('sliders', $sliders);
    }

    public function updateSlider($id, SliderFormRequest $request)
    {
        $slider = Slider::findOrFail($id);
		if ($request->hasFile('slider_image')) {
            $this->deleteSliderImage($id);
            $image_name = $request->input('slider_heading');
            $fileName = ImgUploader::UploadImage('slider_images', $request->file('slider_image'), $image_name, 1920, 730);
            $slider->slider_image = $fileName;
        }
        $slider->lang = $request->input('lang');
        $slider->slider_heading = $request->input('slider_heading');
		$slider->slider_description = $request->input('slider_description');
		$slider->slider_link = $request->input('slider_link');
		$slider->slider_link_text = $request->input('slider_link_text');
        $slider->is_default = $request->input('is_default');
        $slider->slider_id = $request->input('slider_id');
        $slider->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $slider->slider_id = $slider->id;
        } else {
            $slider->slider_id = $request->input('slider_id');
        }
        /*         * ************************************ */
        $slider->update();
        flash('Slider has been updated!')->success();
        return \Redirect::route('edit.slider', array($slider->id));
    }
	
	public function deleteSlider(Request $request)
    {
        $id = $request->input('id');
        try {
            $slider = Slider::findOrFail($id);
            if ((bool) $slider->is_default) {
				$sliders = Slider::where('slider_id', '=', $slider->slider_id)->get();				
				foreach($sliders as $sld)
				{
					$this->deleteSingleSlider($sld->id);
				}
            } else {
                $this->deleteSingleSlider($id);
            }
            echo 'ok';
            exit;
        } catch (ModelNotFoundException $e) {
            echo 'notok';
            exit;
        }
    }
	
	private function deleteSingleSlider($id)
    {        
		$this->deleteSliderImage($id);
		$slider = Slider::findOrFail($id);            
		$slider->delete();                    
    }
	
	private function deleteSliderImage($id)
    {
		$slider = Slider::findOrFail($id);
		$image = $slider->slider_image;
		if (!empty($image)) {
			File::delete(ImgUploader::real_public_path() . 'slider_images/' . $image);
			File::delete(ImgUploader::real_public_path() . 'slider_images/mid/' . $image);
			File::delete(ImgUploader::real_public_path() . 'slider_images/thumb/' . $image);
		}
    }

    public function fetchSlidersData(Request $request)
    {
        $sliders = Slider::select([
                    'sliders.id', 'sliders.lang', 'sliders.slider_heading', 'sliders.is_default', 'sliders.slider_id', 'sliders.is_active',
                ])->sorted();
        return Datatables::of($sliders)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('sliders.id', 'like', "%{$request->get('id')}%");
                            }
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('sliders.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('slider_heading') && !empty($request->slider_heading)) {
                                $query->where('sliders.slider_heading', 'like', "%{$request->get('slider_heading')}%");
                            }
                            if ($request->has('is_default') && !empty($request->is_default)) {
                                $query->where('sliders.is_default', 'like', "%{$request->get('is_default')}%");
                            }
                            if ($request->has('slider_id') && !empty($request->slider_id)) {
                                $query->where('sliders.slider_id', 'like', "%{$request->get('slider_id')}%");
                            }
                            if ($request->has('is_active') && !$request->is_active == -1) {
                                $query->where('sliders.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('slider_heading', function ($sliders) {
                            $slider_heading = Str::limit($sliders->slider_heading, 100, '...');
                            $direction = MiscHelper::getLangDirection($sliders->lang);
                            return '<span dir="' . $direction . '">' . $slider_heading . '</span>';
                        })
                        ->addColumn('action', function ($sliders) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $sliders->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $sliders->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $sliders->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.slider', ['id' => $sliders->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteSlider(' . $sliders->id . ', ' . $sliders->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $sliders->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'slider_heading'])
                        ->setRowId(function($sliders) {
                            return 'sliderDtRow' . $sliders->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveSlider(Request $request)
    {
        $id = $request->input('id');
        try {
            $slider = Slider::findOrFail($id);
            $slider->is_active = 1;
            $slider->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveSlider(Request $request)
    {
        $id = $request->input('id');
        try {
            $slider = Slider::findOrFail($id);
            $slider->is_active = 0;
            $slider->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortSliders()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.slider.sort')->with('languages', $languages);
    }

    public function sliderSortData(Request $request)
    {
        $lang = $request->input('lang');
        $sliders = Slider::select('sliders.id', 'sliders.slider_heading', 'sliders.sort_order')
                ->where('sliders.lang', 'like', $lang)
                ->orderBy('sliders.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($sliders != null) {
            foreach ($sliders as $slider) {
                $str .= '<li id="' . $slider->id . '"><i class="fa fa-sort"></i>' . $slider->slider_heading . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function sliderSortUpdate(Request $request)
    {
        $sliderOrder = $request->input('sliderOrder');
        $sliderOrderArray = explode(',', $sliderOrder);
        $count = 1;
        foreach ($sliderOrderArray as $sliderId) {
            $slider = Slider::find($sliderId);
            $slider->sort_order = $count;
            $slider->update();
            $count++;
        }
    }

}
