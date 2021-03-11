@extends('admin.layouts.admin_layout')

@push('css')
<link rel="stylesheet" href="{{ asset('modules/blog_categories/css/blog_categories.css') }}">
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
                                        Manage Categories

                                    </h1>
                                </div>
                                <div class="col-md-2 col-md-offset-1">


                                    <button class="add-modal" class="btn btn-primary"
                                        onclick="load_blog_category_add_form ()">Add
                                        new Category</button>




                                </div>
                            </div>


                            <ul class="breadcrumb">
                                <ul class="breadcrumb">
                                    <li><a href="{{ URL::asset('/admin/blog')}}"><i class="fa fa-dashboard"></i> Manage
                                            Blogs</a>
                                    </li>
                                    <li class="active"><a href="{{ URL::asset('/admin/blog_category')}}"><i
                                                class="fa fa-file-text-o"></i> Manage Categories</a></li>

                                </ul>

                            </ul>

                        </div>


                    </section>


                    <section class="content">

                        <div class="panel-body">
                            <table class="table" id="blog_categoryTable">
                                <thead>
                                    <tr>

                                        <th>Title</th>
                                        <th>Last updated</th>
                                        <th>Actions</th>
                                    </tr>
                                    {{ csrf_field() }}
                                </thead>
                                <tbody>
                                    @foreach($user as $blog_category)
                                    <tr class="item{{$blog_category->id}}">

                                        <td>{{$blog_category->heading}}</td>

                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog_category->updated_at)->diffForHumans() }}
                                        </td>
                                        <td>
                                            <button id="popup" class="edit-modal btn btn-success"
                                                onClick="load_content_edit_form({{$blog_category->id}});"><span
                                                    class="fa fa-pencil"></span> Edit</button>
                                            <button id="popup" class="delete-modal btn btn-danger"
                                                onClick="delete_blog_category({{$blog_category->id}});"><span
                                                    class="fa fa-trash"></span> Delete</button>
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
                        <form method="POST" files="true" action="{{ asset('admin/blog_category/create')}}"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Category</h4>
                            </div>
                            <div class="modal-body">

                                {{csrf_field()}}
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <label class="control-label col-sm-3" for="title">Title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title" autofocus
                                            value="{{ old('title_add') }}">
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
                        <form method="POST" files="true" action="{{ asset('/admin/blog_category')}}"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Update Category</h4>

                            </div>
                            <div class="modal-body">
                                {{csrf_field()}}
                                <input type="hidden" name="id" id="id">
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
            @endsection



            @push('scripts')
            <script type="text/javascript" src="{{ asset('public/toastr/toastr.min.js') }}"></script>
            <script src="{{ asset('modules/blog_categories/js/blog_categories.js') }}"></script>


            <script>
            < ? php
            if ($errors - > has('title') || $errors - > has('slug')) {
                ? >
                $('#addModal').modal('show');

                <
                ? php
            } ? >
            <
            ? php
            if ($errors - > has('title_update') || $errors - > has('slug_update')) {
                ? >
                $('#editModal').modal('show');

                <
                ? php
            } ? >

            $('#blog_categoryTable').dataTable();
            </script>
            @endpush