@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title'=>__('All Companies')]) 
<!-- Inner Page Title end -->

<div class="pageSearch">
<div class="container">
<section id="joblisting-header" role="search" class="searchform">
            <form id="top-search" method="GET" action="{{route('company.listing')}}">
                <div class="row">                    
                    <div class="col-lg-9">
						<input type="text" name="search" value="{{Request::get('search', '')}}" class="form-control search" placeholder="{{__('keywords e.g. "Google"')}}" />
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" id="submit-form-top" class="btn"><i class="fa fa-search" aria-hidden="true"></i> {{__('Search Company')}}</button>
                    </div>
                </div>
            </form>
        </section>
</div></div>






<div class="listpgWraper">
<div class="container">
    <ul class="row compnaieslist">
        @if($companies)
        @foreach($companies as $company)
        <li class="col-md-3 col-sm-6">
            <div class="compint">
            <div class="imgwrap"><a href="{{route('company.detail',$company->slug)}}">{{$company->printCompanyImage()}}</a></div>
            <h3><a href="{{route('company.detail',$company->slug)}}">{{$company->name}}</a></h3>
            <div class="loctext"><i class="fa fa-map-marker" aria-hidden="true"></i> {{$company->location}}</div>
            <div class="curentopen"><i class="fa fa-black-tie" aria-hidden="true"></i> {{__('Current jobs')}} : {{$company->countNumJobs('company_id',$company->id)}}</div>
            </div>
        </li>
        @endforeach
        @endif

    </ul>
	 <div class="pagiWrap">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="showreslt">
                                    {{__('Showing Pages')}} : {{ $companies->firstItem() }} - {{ $companies->lastItem() }} {{__('Total')}} {{ $companies->total() }}
                                </div>
                            </div>
                            <div class="col-md-7 text-right">
                                @if(isset($companies) && count($companies))
                                {{ $companies->appends(request()->query())->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
  
</div>
</div>

@include('includes.footer')
@endsection
@push('styles')
<style type="text/css">
    .formrow iframe {
        height: 78px;
    }
</style>
@endpush
@push('scripts') 
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#send_company_message', function () {
            var postData = $('#send-company-message-form').serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('contact.company.message.send') }}",
                data: postData,
                //dataType: 'json',
                success: function (data)
                {
                    response = JSON.parse(data);
                    var res = response.success;
                    if (res == 'success')
                    {
                        var errorString = '<div role="alert" class="alert alert-success">' + response.message + '</div>';
                        $('#alert_messages').html(errorString);
                        $('#send-company-message-form').hide('slow');
                        $(document).scrollTo('.alert', 2000);
                    } else
                    {
                        var errorString = '<div class="alert alert-danger" role="alert"><ul>';
                        response = JSON.parse(data);
                        $.each(response, function (index, value)
                        {
                            errorString += '<li>' + value + '</li>';
                        });
                        errorString += '</ul></div>';
                        $('#alert_messages').html(errorString);
                        $(document).scrollTo('.alert', 2000);
                    }
                },
            });
        });
    });
</script> 
@endpush