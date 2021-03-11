@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Frequently asked questions')])
<!-- Inner Page Title end -->
<!-- Page Title End -->
<div class="listpgWraper">
    <div class="container"> 
        <!--Question-->
        <div class="faqs">
            <div class="panel-group" id="accordion">
                <h3>&nbsp;</h3>
                @if(isset($faqs) && count($faqs))
                @foreach($faqs as $faq)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#collapse{{ $faq->id }}">{!! $faq->faq_question !!}</a> </h4>
                    </div>
                    <div id="collapse{{ $faq->id }}" class="panel-collapse collapse">
                        <div class="panel-body">{!! $faq->faq_answer !!}</div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">{!! $siteSetting->cms_page_ad !!}</div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>
@endsection