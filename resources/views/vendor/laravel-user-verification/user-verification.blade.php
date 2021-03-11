@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('User Verification')])
<!-- Inner Page Title end -->
<!-- Page Title start -->
<!-- Page Title End -->
<div class="about-wraper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <h5>{!! trans('laravel-user-verification::user-verification.verification_error_header') !!}</h5>
                    <div class="formpanel">
                        <div class="formrow"> <span class="help-block"> <strong>{!! trans('laravel-user-verification::user-verification.verification_error_message') !!}</strong> </span> </div>
                        <div class="formrow"> <a href="{{url('/')}}" class="btn btn-primary"> {!! trans('laravel-user-verification::user-verification.verification_error_back_button') !!} </a> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection