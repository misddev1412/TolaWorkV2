@extends('admin.layouts.admin_layout')

@push('css')
<link rel="stylesheet" href="{{ asset('public/modules/blogs/css/blogs.css') }}">
<link href="{{ asset('css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')

<div class="content-wrapper">

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            @if(session()->has('message.added'))

            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                {!! session('message.content') !!}
            </div>
            @endif
            @if(session()->has('message.updated'))
            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                {!! session('message.content') !!}
            </div>
            @endif
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="content-header">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-9">

                                    <h1>
                                        Manage Blogs

                                    </h1>
                                </div>
                            </div>


                            <ul class="breadcrumb">
                                <li class="active"><a href="{{ URL::asset('/admin/blog')}}"><i
                                            class="fa fa-dashboard"></i> Manage
                                        Blogs</a></li>
                                <li><a href="{{ URL::asset('/admin/blog_category')}}"><i class="fa fa-file-text-o"></i>
                                        Manage
                                        Categories</a></li>

                            </ul>

                        </div>


                    </section>


                    <section class="content">

                        <div class="panel-body">
                            <table class="table" id="blogTable">
                                <thead>
                                    <tr>

                                        <th>Title</th>
                                        <th>Content</th>

                                        <th>Last updated</th>
                                        <th>Actions</th>
                                    </tr>
                                    {{ csrf_field() }}
                                </thead>
                                <tbody>
                                    @foreach($user as $blog)
                                    <tr class="item{{$blog->id}}">

                                        <td>{{$blog->heading}}</td>
                                        <td>
                                            {!!
                                            \Illuminate\Support\Str::words($blog->content, 5,'..') !!}
                                        </td>

                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->updated_at)->diffForHumans() }}
                                        </td>
                                        <td>
                                            <a id="popup" class="edit-modal btn btn-success"
                                                href="{{route('edit-blog',$blog->id)}}"><span
                                                    class="fa fa-pencil"></span>
                                                Edit</a>
                                            <button id="popup" class="delete-modal btn btn-danger"
                                                onClick="delete_blog({{$blog->id}});"><span class="fa fa-trash"></span>
                                                Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- /.panel-body -->
                    </section>
                </div>
            </div><!-- /.panel panel-default -->
            <!-- /.col-md-8 -->
            <div id="addModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" files="true" action="{{ asset('admin/blog/create')}}"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Blog</h4>
                            </div>
                            <div class="modal-body">

                                {{csrf_field()}}
                                @if($categories!='')
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="title">Select Category</label>
                                    <div class="col-sm-12">
                                        <select id="cate_id" name="cate_id[]" class="form-control" multiple="multiple">
                                            @foreach($categories as $cate)
                                            <option value="<?php echo $cate->id; ?>">{!!$cate->heading!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <label class="control-label col-sm-3" for="title">Title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title" autofocus
                                            value="{{ old('title') }}">
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                    <label class="control-label col-sm-3" for="Slug">Slug</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="slug" id="slug" autofocus
                                            value="{{ old('slug') }}">
                                        <span class="text-danger">{{ $errors->first('slug') }}</span>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                    <label class="control-label col-sm-3" for="content">Content</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="content" id="content" cols="40" rows="5"
                                            autofocus>{{ old('content') }}</textarea>
                                        <span class="text-danger">{{ $errors->first('content') }}</span>
                                    </div>
                                </div>
                                <br /><br /><br /> <br />
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="Upload Image">Featured Image</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" name="image" id="image" autofocus>

                                    </div>
                                </div>
                                <br /> <br />
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="Manage Seo">
                                        <input type="checkbox" id="show_seo_fields" />
                                        Manage Seo
                                    </label>
                                </div>
                                <div style="clear:both"></div>
                                <div id="div_show_seo_fields" style="display: none">

                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Meta Title</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="meta_title" id="meta_title"
                                                autofocus value="{{ old('meta_title') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Meta Keywords</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="meta_keywords"
                                                id="meta_keywords" autofocus value="{{ old('meta_keywords') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Meta Description</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="meta_descriptions"
                                                id="meta_descriptions" cols="40" rows="5"
                                                autofocus>{{ old('meta_description') }}</textarea>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div style="clear:both"></div>
                            <br>
                            <div class="modal-footer">
                                <input type="submit" value="Add" class="btn btn-primary">
                                <input type="submit" value="Close" class="btn btn-warning" data-dismiss="modal">
                            </div>


                        </form>
                    </div>

                </div>

            </div>

            <!-- Modal form to add a form close -->

            <!-- Modal form to edit a form -->
            <div id="editModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" files="true" action="{{ asset('/admin/blog')}}"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Update Blog</h4>

                            </div>
                            <div class="modal-body">

                                {{csrf_field()}}
                                <input type="hidden" name="id" id="id">
                                @if($categories!='')
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="title">Select Category</label>
                                    <div class="col-sm-12">
                                        <select id="cate_id_update" name="cate_id_update[]" class="form-control"
                                            multiple="multiple">
                                            @foreach($categories as $cate)
                                            <option value="<?php echo $cate->id; ?>">{!!$cate->heading!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group {{ $errors->has('title_update') ? 'has-error' : '' }}">
                                    <label class="control-label col-sm-3" for="title">Title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title_update" id="title_update"
                                            value="{{ old('title_update') }}">
                                        <span class="text-danger">{{ $errors->first('title_update') }}</span>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('slug_update') ? 'has-error' : '' }}">
                                    <label class="control-label col-sm-3" for="Slug">Slug</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" value="{{ old('slug_update') }}"
                                            name="slug_update" id="slug_update">
                                        <span class="text-danger">{{ $errors->first('slug_update') }}</span>
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('content_update') ? 'has-error' : '' }}">
                                    <label class="control-label col-sm-3" for="content">Content</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="content_update" id="content_update"
                                            cols="40" rows="5">{{ old('content_update') }}</textarea>
                                        <span class="text-danger">{{ $errors->first('content_update') }}</span>
                                    </div>
                                </div>
                                <br /><br /><br /> <br />
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="Upload Image">Featured Image</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" name="imageupdate" id="imageupdate">
                                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                                        <div class="image_append" id="image_append">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="Manage Seo">
                                        <input type="checkbox" id="show_seo_fields_for_update" />
                                        Manage Seo
                                    </label>
                                </div>
                                <div style="clear:both"></div>
                                <div id="div_show_seo_fields_for_update" style="display: none">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Meta Title</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="meta_title_update"
                                                id="meta_title_update" autofocus value="{{ old('meta_title_update') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Meta Keywords</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="meta_keywords_update"
                                                id="meta_keywords_update" autofocus
                                                value="{{ old('meta_keywords_update') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Meta Description</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="meta_descriptions_update"
                                                id="meta_descriptions_update" cols="40"
                                                rows="5">{{ old('meta_description_update') }}</textarea>
                                        </div>
                                    </div>
                                </div>




                            </div>
                            <div style="clear:both"></div>
                            <br>
                            <div class="modal-footer">
                                <input type="submit" value="Update" class="btn btn-primary">
                                <input type="submit" value="Close" class="btn btn-warning" data-dismiss="modal">
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Modal form to add a form -->
            <div id="viewModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Content</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">

                                <div class="col-sm-12">
                                    <textarea class="form-control" name="contentview" id="contentview" disabled=""
                                        cols="40" rows="5"></textarea>
                                    <p class="errorContent text-center alert alert-danger hidden"></p>
                                </div>
                            </div>
                        </div>

                        <div style="clear:both"></div>
                        <br>
                        <div class="modal-footer">

                            <input type="submit" value="Close" class="btn btn-warning" data-dismiss="modal">
                        </div>



                    </div>

                </div>

            </div>

            @endsection



            @push('scripts')
            <script type="text/javascript" src="{{ asset('public/toastr/toastr.min.js') }}"></script>
            <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
            <script src="{{ asset('modules/blogs/js/blogs.js') }}"></script>




            <script>
            < ? php
            if ($errors - > has('title') || $errors - > has('slug') || $errors - > has('content')) {
                ?
                >
                $('#addModal').modal('show'); <
                ?
                php
            } ? >
            <
            ?
            php
            if ($errors - > has('title_update') || $errors - > has('slug_update') || $errors - > has(
                    'content_update')) {
                ?
                >
                $('#editModal').modal('show'); <
                ?
                php
            } ? >

            $('#blogTable').dataTable();
            </script>

            @endpush