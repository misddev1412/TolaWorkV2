<?php

namespace App\Http\Controllers\Admin;

use Input;
use File;
use ImgUploader;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TinyMceController extends Controller
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
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = ImgUploader::UploadImageTinyMce('tinymce_images', $image, time());
            echo json_encode(array('location' => config('app.url') . '/tinymce_images/' . $fileName));
        } else {
            echo 'No Image Available';
        }
    }

}
