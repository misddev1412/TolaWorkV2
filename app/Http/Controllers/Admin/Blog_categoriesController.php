<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Auth;
use App\Blog_category;
use Image;

class Blog_categoriesController extends Base
{

    public function index()
    {

        $user = Blog_category::get();
        return view('admin/blog_categories/blog_categories', compact('user'));
    }


    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'slug' => 'required',
        ], [
            'title.required' => ' The title field is required.',
            'slug.required' => ' The slug field is required.',
        ]);
        $blog_category = new Blog_category();
        $page_slug = $request->slug;
        $slugs = unique_slug($page_slug, 'blog_categories', $field = 'slug', $key = NULL, $value = NULL);
        $blog_category->heading = $request->title;
        $blog_category->slug = $slugs;
        $blog_category->save();
        if ($blog_category->save() == true) {
            $request->session()->flash('message.added', 'success');
            $request->session()->flash('message.content', 'Category added successfully !');
        } else {
            $request->session()->flash('message.added', 'danger');
            $request->session()->flash('message.content', 'Error!');
        }
        return redirect('/admin/blog_category');
    }
    public function get_blog_category_by_id($id = '')
    {
        if ($id != '') {
            $row = Blog_category::findOrFail($id);
            $json_data = json_encode($row);
            echo $json_data;
            return;
        }
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'title_update' => 'required',
            'slug_update' => 'required',
        ], [
            'title_update.required' => ' The title field is required.',
            'slug_update.required' => ' The slug field is required.',
        ]);
        $blog_category = Blog_category::findOrFail($request->id);
        $blog_category->heading = $request->title_update;
        $blog_category->slug = $request->slug_update;
        $blog_category->update();
        if ($blog_category->save() == true) {
            $request->session()->flash('message.updated', 'success');
            $request->session()->flash('message.content', 'Category updated successfully!');
        } else {
            $request->session()->flash('message.updated', 'danger');
            $request->session()->flash('message.content', 'Error!');
        }
        return redirect('/admin/blog_category');
    }


    public function destroy($id)
    {
        $blog_category = Blog_category::findOrFail($id);
        $blog_category->delete();

        return response()->json($blog_category);
    }
}