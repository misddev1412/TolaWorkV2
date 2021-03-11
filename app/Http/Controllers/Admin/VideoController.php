<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Redirect;
use App\Language;
use App\Video;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\VideoFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class VideoController extends Controller
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

    public function indexVideos()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.video.index')->with('languages', $languages);
    }

    public function createVideo()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $videos = DataArrayHelper::defaultVideosArray();
        return view('admin.video.add')
                        ->with('languages', $languages)
                        ->with('videos', $videos);
    }

    public function storeVideo(VideoFormRequest $request)
    {
        $video = new Video();
        $video->lang = $request->input('lang');
        $video->video_title = $request->input('video_title');
        $video->video_text = $request->input('video_text');
        $video->video_link = $request->input('video_link');
        $video->is_default = $request->input('is_default');
        $video->video_id = $request->input('video_id');
        $video->is_active = $request->input('is_active');
        $video->save();
        /*         * ************************************ */
        $video->sort_order = $video->id;
        if ((int) $request->input('is_default') == 1) {
            $video->video_id = $video->id;
        } else {
            $video->video_id = $request->input('video_id');
        }
        $video->update();
        /*         * ************************************ */
        flash('Video has been added!')->success();
        return \Redirect::route('edit.video', array($video->id));
    }

    public function editVideo($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $videos = DataArrayHelper::defaultVideosArray();

        $video = Video::findOrFail($id);
        return view('admin.video.edit')
                        ->with('video', $video)
                        ->with('languages', $languages)
                        ->with('videos', $videos);
    }

    public function updateVideo($id, VideoFormRequest $request)
    {
        $video = Video::findOrFail($id);
        $video->lang = $request->input('lang');
        $video->video_title = $request->input('video_title');
        $video->video_text = $request->input('video_text');
        $video->video_link = $request->input('video_link');
        $video->is_default = $request->input('is_default');
        $video->video_id = $request->input('video_id');
        $video->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $video->video_id = $video->id;
        } else {
            $video->video_id = $request->input('video_id');
        }
        /*         * ************************************ */
        $video->update();
        flash('Video has been updated!')->success();
        return \Redirect::route('edit.video', array($video->id));
    }

    public function deleteVideo(Request $request)
    {
        $id = $request->input('id');
        try {
            $video = Video::findOrFail($id);
            if ((bool) $video->is_default) {
                Video::where('video_id', '=', $video->video_id)->delete();
            } else {
                $video->delete();
            }
            echo 'ok';
            exit;
        } catch (ModelNotFoundException $e) {
            echo 'notok';
            exit;
        }
    }

    public function fetchVideosData(Request $request)
    {
        $videos = Video::select([
                    'videos.id', 'videos.lang', 'videos.video_title', 'videos.video_text', 'videos.video_link', 'videos.is_default', 'videos.video_id', 'videos.is_active',
                ])->sorted();
        return Datatables::of($videos)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('videos.id', 'like', "%{$request->get('id')}%");
                            }
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('videos.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('video_title') && !empty($request->video_title)) {
                                $query->where('videos.video_title', 'like', "%{$request->get('video_title')}%");
                            }
                            if ($request->has('is_default') && !empty($request->is_default)) {
                                $query->where('videos.is_default', 'like', "%{$request->get('is_default')}%");
                            }
                            if ($request->has('video_id') && !empty($request->video_id)) {
                                $query->where('videos.video_id', 'like', "%{$request->get('video_id')}%");
                            }
                            if ($request->has('is_active') && !$request->is_active == -1) {
                                $query->where('videos.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('video_title', function ($videos) {
                            $video = Str::limit($videos->video_title, 100, '...');
                            $direction = MiscHelper::getLangDirection($videos->lang);
                            return '<span dir="' . $direction . '">' . $video . '</span>';
                        })
                        ->addColumn('action', function ($videos) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $videos->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $videos->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $videos->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.video', ['id' => $videos->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteVideo(' . $videos->id . ', ' . $videos->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $videos->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })
                        ->rawColumns(['action', 'video_title'])
                        ->setRowId(function($videos) {
                            return 'videoDtRow' . $videos->id;
                        })
                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveVideo(Request $request)
    {
        $id = $request->input('id');
        try {
            $video = Video::findOrFail($id);
            $video->is_active = 1;
            $video->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveVideo(Request $request)
    {
        $id = $request->input('id');
        try {
            $video = Video::findOrFail($id);
            $video->is_active = 0;
            $video->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortVideos()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        return view('admin.video.sort')->with('languages', $languages);
    }

    public function videoSortData(Request $request)
    {
        $lang = $request->input('lang');
        $videos = Video::select('videos.id', 'videos.video_title', 'videos.sort_order')
                ->where('videos.lang', 'like', $lang)
                ->orderBy('videos.sort_order')
                ->get();
        $str = '<ul id="sortable">';
        if ($videos != null) {
            foreach ($videos as $video) {
                $str .= '<li id="' . $video->id . '"><i class="fa fa-sort"></i>' . $video->video_title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function videoSortUpdate(Request $request)
    {
        $videoOrder = $request->input('videoOrder');
        $videoOrderArray = explode(',', $videoOrder);
        $count = 1;
        foreach ($videoOrderArray as $videoId) {
            $video = Video::find($videoId);
            $video->sort_order = $count;
            $video->update();
            $count++;
        }
    }

}
