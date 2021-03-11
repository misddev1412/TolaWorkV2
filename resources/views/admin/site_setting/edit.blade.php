<?php
$lang = config('default_lang');
$direction = MiscHelper::getLangDirection($lang);
?>
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
                <li> <span>Edit Site Setting</span> </li>
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
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">Site Setting Form</span> </div>
                    </div>

                    <div class="portlet-body form">          
                        <ul class="nav nav-tabs">              
                            <li class="active"> <a href="#site" data-toggle="tab" aria-expanded="false"> Site </a> </li>              
                            <li class=""> <a href="#email" data-toggle="tab" aria-expanded="false"> Email </a> </li>
                            <li class=""> <a href="#social" data-toggle="tab" aria-expanded="false"> Social Networks </a> </li>
                            <li class=""> <a href="#ads" data-toggle="tab" aria-expanded="false"> Manage Ads </a> </li>
                            <li class=""> <a href="#captcha" data-toggle="tab" aria-expanded="false"> Captcha </a> </li>
                            <!--<li class=""> <a href="#socialMediaLogin" data-toggle="tab" aria-expanded="false"> Social Media Login </a> </li>-->
                            <li class=""> <a href="#paymentGateways" data-toggle="tab" aria-expanded="false"> Payment Gateways </a> </li>              
                        </ul>

                        {!! Form::model($siteSetting, array('method' => 'put', 'route' => array('update.site.setting'), 'class' => 'form', 'files'=>true)) !!}
                        <div class="tab-content">              
                            <div class="tab-pane fade active in" id="site"> @include('admin.site_setting.forms.form') </div>
                            <div class="tab-pane fade" id="email"> @include('admin.site_setting.forms.siteEmailSetting_form') </div>
                            <div class="tab-pane fade" id="social"> @include('admin.site_setting.forms.siteSocialSetting_form') </div>
                            <div class="tab-pane fade" id="ads"> @include('admin.site_setting.forms.siteAds_form') </div>

                            <div class="tab-pane fade" id="captcha"> @include('admin.site_setting.forms.captchaSetting_form') </div>
                            <div class="tab-pane fade" id="socialMediaLogin"> @include('admin.site_setting.forms.socialMediaLoginSetting_form') </div>
                            <div class="tab-pane fade" id="paymentGateways"> @include('admin.site_setting.forms.paymentGatewaysSetting_form') </div>

                        </div>
                        <div class="form-actions">
                            {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}
                        </div>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY --> 
    </div>
    @endsection

    @push('scripts')
    @include('admin.shared.tinyMCE')
    @endpush