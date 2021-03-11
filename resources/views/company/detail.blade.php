@extends('layouts.app')



@section('content') 

<!-- Header start --> 

@include('includes.header') 

<!-- Header end --> 



<!-- Inner Page Title start --> 

@include('includes.inner_page_title', ['page_title'=>__('Company Detail')]) 

<!-- Inner Page Title end -->



<div class="listpgWraper">

  <div class="container"> 

    @include('flash::message') 

    <!-- Job Header start -->

    <div class="job-header">

      <div class="jobinfo">

        <div class="row">

          <div class="col-md-8 col-sm-8"> 

            <!-- Candidate Info -->

            <div class="candidateinfo">

              <div class="userPic"><a href="{{route('company.detail',$company->slug)}}">{{$company->printCompanyImage()}}</a></div>

              <div class="title">{{$company->name}}</div>

              <div class="desi">{{$company->getIndustry('industry')}}</div>

              <div class="loctext"><i class="fa fa-history" aria-hidden="true"></i> {{__('Member Since')}}, {{$company->created_at->format('M d, Y')}}</div>

              <div class="loctext"><i class="fa fa-map-marker" aria-hidden="true"></i> {{$company->location}}</div>

              <div class="clearfix"></div>

            </div>

          </div>

          <div class="col-md-4 col-sm-4"> 

            <!-- Candidate Contact -->

            <div class="candidateinfo">

            @if(!empty($company->phone))

              <div class="loctext"><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:{{$company->phone}}">{{$company->phone}}</a></div>

            @endif

            @if(!empty($company->email))

              <div class="loctext"><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:{{$company->email}}">{{$company->email}}</a></div>

            @endif

            @if(!empty($company->website))

              <div class="loctext"><i class="fa fa-globe" aria-hidden="true"></i> <a href="{{$company->website}}" target="_blank">{{$company->website}}</a></div>

            @endif  

              <div class="cadsocial"> {!!$company->getSocialNetworkHtml()!!} </div>

            </div>

          </div>

        </div>

      </div>

      

      <!-- Buttons -->

      <div class="jobButtons"> @if(Auth::check() && Auth::user()->isFavouriteCompany($company->slug)) <a href="{{route('remove.from.favourite.company', $company->slug)}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Favourite Company')}} </a> @else <a href="{{route('add.to.favourite.company', $company->slug)}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Add to Favourite')}}</a> @endif <a href="{{route('report.abuse.company', $company->slug)}}" class="btn report"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{__('Report Abuse')}}</a> <a href="#contact_company" class="btn"><i class="fa fa-envelope" aria-hidden="true"></i> {{__('Send Message')}}</a> </div>

    </div>

    

    <!-- Job Detail start -->

    <div class="row">

      <div class="col-md-8"> 

        <!-- About Employee start -->

        <div class="job-header">

          <div class="contentbox">

            <h3>{{__('About Company')}}</h3>

            <p>{!! $company->description !!}</p>

          </div>

        </div>

        

        <!-- Opening Jobs start -->

        <div class="relatedJobs">

          <h3>{{__('Job Openings')}}</h3>

          <ul class="searchList">

            @if(isset($company->jobs) && count($company->jobs))

            @foreach($company->jobs as $companyJob) 

            <!--Job start-->

            <li>

              <div class="row">

                <div class="col-md-8 col-sm-8">

                  <div class="jobimg"><a href="{{route('job.detail', [$companyJob->slug])}}" title="{{$companyJob->title}}"> {{$company->printCompanyImage()}} </a></div>

                  <div class="jobinfo">

                    <h3><a href="{{route('job.detail', [$companyJob->slug])}}" title="{{$companyJob->title}}">{{$companyJob->title}}</a></h3>

                    <div class="companyName"><a href="{{route('company.detail', $company->slug)}}" title="{{$company->name}}">{{$company->name}}</a></div>

                    <div class="location">

                      <label class="fulltime" title="{{$companyJob->getJobType('job_type')}}">{{$companyJob->getJobType('job_type')}}</label>

                      <label class="partTime" title="{{$companyJob->getJobShift('job_shift')}}">{{$companyJob->getJobShift('job_shift')}}</label>

                      - <span>{{$companyJob->getCity('city')}}</span></div>

                  </div>

                  <div class="clearfix"></div>

                </div>

                <div class="col-md-4 col-sm-4">

                  <div class="listbtn"><a href="{{route('job.detail', [$companyJob->slug])}}">{{__('View Detail')}}</a></div>

                </div>

              </div>

              <p>{{str_limit(strip_tags($companyJob->description), 150, '...')}}</p>

            </li>

            <!--Job end--> 

            @endforeach

            @endif 

            

            <!-- Job end -->

          </ul>

        </div>

      </div>

      <div class="col-md-4"> 

        <!-- Company Detail start -->

        <div class="job-header">

          <div class="jobdetail">

            <h3>{{__('Company Detail')}}</h3>

            <ul class="jbdetail">

            	<li class="row">

                <div class="col-md-6 col-xs-6">{{__('Is Email Verified')}}</div>

                <div class="col-md-6 col-xs-6"><span>{{((bool)$company->verified)? 'Yes':'No'}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-6 col-xs-6">{{__('Total Employees')}}</div>

                <div class="col-md-6 col-xs-6"><span>{{$company->no_of_employees}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-6 col-xs-6">{{__('Established In')}}</div>

                <div class="col-md-6 col-xs-6"><span>{{$company->established_in}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-6 col-xs-6">{{__('Current jobs')}}</div>

                <div class="col-md-6 col-xs-6"><span>{{$company->countNumJobs('company_id',$company->id)}}</span></div>

              </li>

            </ul>

          </div>

        </div>

        

        <!-- Google Map start -->

        <div class="job-header">

          <div class="jobdetail">{!!$company->map!!}</div>

        </div>

        

        <!-- Contact Company start -->

        <div class="job-header">

          <div class="jobdetail">

            <h3 id="contact_company">{{__('Contact Company')}}</h3>

            <div id="alert_messages"></div>

            <?php

                        $from_name = $from_email = $from_phone = $subject = $message = $from_id = '';

                        if (Auth::check()) {

                            $from_name = Auth::user()->name;

                            $from_email = Auth::user()->email;

                            $from_phone = Auth::user()->phone;

                            $from_id = Auth::user()->id;

                        }

                        $from_name = old('name', $from_name);

                        $from_email = old('email', $from_email);

                        $from_phone = old('phone', $from_phone);

                        $subject = old('subject');

                        $message = old('message');

                        ?>

            <form method="post" id="send-company-message-form">

              {{ csrf_field() }}

              <input type="hidden" name="to_id" value="{{ $company->id }}">

              <input type="hidden" name="from_id" value="{{ $from_id }}">

              <input type="hidden" name="company_id" value="{{ $company->id }}">

              <input type="hidden" name="company_name" value="{{ $company->name }}">

              <div class="formpanel">

                <div class="formrow">

                  <input type="text" name="from_name" value="{{ $from_name }}" class="form-control" placeholder="{{__('Your Name')}}">

                </div>

                <div class="formrow">

                  <input type="text" name="from_email" value="{{ $from_email }}" class="form-control" placeholder="{{__('Your Email')}}">

                </div>

                <div class="formrow">

                  <input type="text" name="from_phone" value="{{ $from_phone }}" class="form-control" placeholder="{{__('Phone')}}">

                </div>

                <div class="formrow">

                  <input type="text" name="subject" value="{{ $subject }}" class="form-control" placeholder="{{__('Subject')}}">

                </div>

                <div class="formrow">

                  <textarea name="message" class="form-control" placeholder="Message">{{ $message }}</textarea>

                </div>

                <div class="formrow">{!! app('captcha')->display() !!}</div>

                <div class="formrow">

                <input type="button" class="btn" value="{{__('Submit')}}" id="send_company_message">

                </div>

              </div>

            </form>

          </div>

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