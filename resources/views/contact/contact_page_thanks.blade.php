@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Contact Us')])
<!-- Inner Page Title end -->
<div class="inner-page">
    <div class="container">
        <div class="contact-wrap">
            <div class="title"> <span>&nbsp;</span>
                <h2>{{__('Thanks for being awesome')}}</h2>
                <p>{{__('We have received your message and would like to thank you for writing to us. If your inquiry is urgent, please use the telephone number to talk to one of our staff members. Otherwise, we will reply by email as soon as possible')}}<br /><br />
                    {{__('Talk to you soon')}}<br />
                    {{ $siteSetting->site_name }}</p>
            </div>      
        </div>
    </div>
</div>
@include('includes.footer')
@endsection