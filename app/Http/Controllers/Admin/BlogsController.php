<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Blog;
use App\Blog_category;
use App\Helpers\DataArrayHelper;
use Image;

class BlogsController extends Base
{
    public function index()
    {
        $user = Blog::get();
        $data['user'] = $user;
        $categories = Blog_category::get();
        $data['categories'] = $categories;
        return view('admin/blogs/blogs')->with($data);
    }
    public function show_form()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $categories = Blog_category::get();
        $data['categories'] = $categories;
        return view('admin/blogs/post_form')->with('categories',$categories)->with('languages',$languages);
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'title.required' => ' The title field is required.',
            'slug.required' => ' The slug field is required.',
            'content.required' => ' The content field is required.',
        ]);

        $image = $request->file('image');
        if ($image != '') {
            $nameonly = preg_replace('/\..+$/', '', $request->image->getClientOriginalName());
            $input['imagename'] = $nameonly . '_' . rand(1, 999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/blogs/thumbnail');
            $img = Image::make($image->getRealPath());
            $img->resize(222, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['imagename']);

            $destinationPath = public_path('/uploads/blogs/');
            $image->move($destinationPath, $input['imagename']);
        }
        $page_slug = $request->slug;
        $slugs = unique_slug($page_slug, 'blogs', $field = 'slug', $key = NULL, $value = NULL);
        if ($request->cate_id != '') {
            $category_Ids = implode(",", $request->cate_id);
        } else {
            $category_Ids = '';
        }

        $blog = new Blog();
        $blog->heading = $request->title;
        $blog->slug = $slugs;
        $blog->cate_id = $category_Ids;
        $blog->content = $request->content;
        $blog->meta_title = $request->meta_title;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->lang = $request->lang;
        $blog->meta_descriptions = $request->meta_descriptions;
        if ($image != '') {
            $blog->image = $input['imagename'];
        } else {
            $blog->image = '';
        }
        $blog->save();
        if ($blog->save() == true) {
            $request->session()->flash('message.added', 'success');
            $request->session()->flash('message.content', 'Blog was successfully added!');
        } else {
            $request->session()->flash('message.added', 'danger');
            $request->session()->flash('message.content', 'Error!');
        }
        return redirect('/admin/blog');
    }

    public function get_blog_by_id($id = '')
    {
        if ($id != '') {
            $row = Blog::findOrFail($id);
            $json_data = json_encode($row);
            echo $json_data;
            return;
        }
    }
    public function get_blog($id = '')
    {
        if ($id != '') {
            $data['languages'] = DataArrayHelper::languagesNativeCodeArray();
            $row = Blog::findOrFail($id);
            $data['blog'] = $row;
            $categories = Blog_category::get();
            $data['categories'] = $categories;
            return view('admin/blogs/update_form')->with($data);
        }
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'title_update' => 'required',
            'slug_update' => 'required',
            'content_update' => 'required',
            'imageupdate' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'title_update.required' => ' The title field is required.',
            'slug_update.required' => ' The slug field is required.',
            'content_update.required' => ' The content field is required.',
        ]);

        if ($request->cate_id_update != '') {
            $category_Ids = implode(",", $request->cate_id_update);
        } else {
            $category_Ids = '';
        }

        $blog = Blog::findOrFail($request->id);
        $blog->heading = $request->title_update;
        $blog->slug = $request->slug_update;;
        $blog->cate_id = $category_Ids;
        $blog->content = $request->content_update;
        $blog->lang = $request->lang;
        $blog->meta_title = $request->meta_title_update;
        $blog->meta_keywords = $request->meta_keywords_update;
        $blog->meta_descriptions = $request->meta_descriptions_update;
        $blog->update();
        $this->validate($request, [
            'imageupdate' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = $request->file('imageupdate');
        if ($image) {
            $nameonly = preg_replace('/\..+$/', '', $request->imageupdate->getClientOriginalName());
            $input['imagename'] = $nameonly . '_' . rand(1, 999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/blogs/thumbnail');
            $img = Image::make($image->getRealPath());
            $img->resize(222, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['imagename']);
            $destinationPath = public_path('/uploads/blogs/');
            $image->move($destinationPath, $input['imagename']);
        }
        if ($image) {
            $blog->image = $input['imagename'];
        }
        $blog->update();
        if ($blog->save() == true) {
            $request->session()->flash('message.updated', 'success');
            $request->session()->flash('message.content', 'Blog was successfully updated!');
        } else {
            $request->session()->flash('message.updated', 'danger');
            $request->session()->flash('message.content', 'Error!');
        }
        return redirect('/admin/blog');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json($blog);
    }

    public function remove_blog_feature_image($id)
    {
        $image = Blog::findOrFail($id);
        $file = $image->image;
        $sts = 'done';
        $imagename = '';
        $filenamethumb = public_path() . '/uploads/blogs/thumbnail/' . $file;
        $filename = public_path() . '/uploads/blogs/' . $file;
        \File::delete([
            $filename,
            $filenamethumb
        ]);
        $image->image = $imagename;
        $image->update();
        return response()->json($sts);
    }
}