@extends('layouts.app')
@section('content') 
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Email to Friend')])
<!-- Inner Page Title end -->
<!-- Page Title End -->
<div class="listpgWraper">
    <div class="container">
        @include('flash::message')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="userccount">
                    {!! Form::open(array('method' => 'post', 'route' => ['email.to.friend', $slug])) !!}
                    <div class="formpanel"> 
                        <!-- Ad Information -->
                        <h5>Email to Friend</h5>            
                        <div class="row">
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('job_url') ? ' has-error' : '' }}">
                                    {!! Form::text('job_url', route('job.detail', $slug), array('class'=>'form-control', 'id'=>'job_url', 'placeholder'=>__('URL'), 'required'=>'required', 'readonly'=>'readonly')) !!}                
                                    @if ($errors->has('job_url')) <span class="help-block"> <strong>{{ $errors->first('job_url') }}</strong> </span> @endif </div>
                            </div>                            
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('friend_name') ? ' has-error' : '' }}">
                                    {!! Form::text('friend_name', null, array('class'=>'form-control', 'id'=>'friend_name', 'placeholder'=>__('Friends Name'), 'required'=>'required', 'autofocus'=>'autofocus')) !!}                
                                    @if ($errors->has('friend_name')) <span class="help-block"> <strong>{{ $errors->first('friend_name') }}</strong> </span> @endif </div>
                            </div>                                                                    
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('friend_email') ? ' has-error' : '' }}">
                                    {!! Form::text('friend_email', null, array('class'=>'form-control', 'id'=>'friend_email', 'placeholder'=>__('Friends Email'), 'required'=>'required')) !!}                
                                    @if ($errors->has('friend_email')) <span class="help-block"> <strong>{{ $errors->first('friend_email') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('your_name') ? ' has-error' : '' }}">
                                    <?php
                                    $your_name = (Auth::check()) ? Auth::user()->name : '';
                                    ?>
                                    {!! Form::text('your_name', $your_name, array('class'=>'form-control', 'id'=>'your_name', 'placeholder'=>__('Your Name'), 'required'=>'required')) !!}                
                                    @if ($errors->has('your_name')) <span class="help-block"> <strong>{{ $errors->first('your_name') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('your_email') ? ' has-error' : '' }}">
                                    <?php
                                    $your_email = (Auth::check()) ? Auth::user()->email : '';
                                    ?>
                                    {!! Form::text('your_email', $your_email, array('class'=>'form-control', 'id'=>'your_email', 'placeholder'=>__('Your Email'), 'required'=>'required')) !!}                
                                    @if ($errors->has('your_email')) <span class="help-block"> <strong>{{ $errors->first('your_email') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    {!! app('captcha')->display() !!}
                                    @if ($errors->has('g-recaptcha-response')) <span class="help-block"> <strong>{{ $errors->first('g-recaptcha-response') }}</strong> </span> @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <input type="submit" id="post_ad_btn" class="btn" value="{{__('Send to friend')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection