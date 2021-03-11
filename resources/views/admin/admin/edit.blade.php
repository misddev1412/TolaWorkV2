@extends('admin.layouts.admin_layout')
@section('content')
<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Edit Admin User</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"> Edit Admin User <small>Admin Users</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        @include('flash::message')
        <div class="row">
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">Edit Admin User Form</span> </div>
                    </div>
                    <div class="portlet-body form">
                        {!! Form::model($user, array('method' => 'put', 'route' => array('update.admin.user', $user->id), 'class' => 'form', 'novalidate' => 'novalidate')) !!}
                        {!! Form::hidden('id', $user->id) !!}
                        @include('admin.admin.add_edit_form')
                        <div class="form-actions">
                            {!! Form::submit('Update Admin User!', array('class'=>'btn blue')) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY --> 
</div>
@endsection