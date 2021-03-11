@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Error')])
<!-- Inner Page Title end -->
<div class="about-wraper"> 
    <!-- About -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{__('Error')}}</h2>
                <p>{{__('Whoops, looks like something went wrong.')}}</p>
            </div>      
        </div>
    </div>  
</div>
@include('includes.footer')
@endsection