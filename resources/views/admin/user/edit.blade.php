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
                <li> <a href="{{ route('list.users') }}">Users</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Edit User</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <!--<h3 class="page-title">Edit User <small>Users</small> </h3>-->
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <br />
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">User Form</span> </div>            
                    </div>
                    <div class="portlet-body form">          
                        <ul class="nav nav-tabs">              
                            <li class="active"> <a href="#Details" data-toggle="tab" aria-expanded="false"> Details </a> </li>
                            <li><a href="#Summary" data-toggle="tab" aria-expanded="false">Summary</a></li>
                            <li><a href="#CV" data-toggle="tab" aria-expanded="false">C.V</a></li>
                            <li><a href="#Projects" data-toggle="tab" aria-expanded="false">Projects</a></li>
                            <li><a href="#Experience" data-toggle="tab" aria-expanded="false">Experience</a></li>
                            <li><a href="#Education" data-toggle="tab" aria-expanded="false">Education</a></li>
                            <li><a href="#Skills" data-toggle="tab" aria-expanded="false">Skills</a></li>
                            <li><a href="#Languages" data-toggle="tab" aria-expanded="false">Languages</a></li>
                        </ul>

                        <div class="tab-content">              
                            <div class="tab-pane fade active in" id="Details"> @include('admin.user.forms.form') </div>
                            <div class="tab-pane fade" id="Summary"> @include('admin.user.forms.summary') </div>
                            <div class="tab-pane fade" id="CV"> @include('admin.user.forms.cv.cvs') </div>
                            <div class="tab-pane fade" id="Projects"> @include('admin.user.forms.project.projects') </div>
                            <div class="tab-pane fade" id="Experience"> @include('admin.user.forms.experience.experience') </div>
                            <div class="tab-pane fade" id="Education"> @include('admin.user.forms.education.education') </div>
                            <div class="tab-pane fade" id="Skills"> @include('admin.user.forms.skill.skills') </div>
                            <div class="tab-pane fade" id="Languages"> @include('admin.user.forms.language.languages') </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY --> 
    </div>
    @endsection