@extends('layouts.app')



@section('content') 

<!-- Header start --> 

@include('includes.header') 

<!-- Header end --> 



<!-- Inner Page Title start --> 

@include('includes.inner_page_title', ['page_title'=>__('Job Detail')]) 

<!-- Inner Page Title end -->



@php

$company = $job->getCompany();

@endphp



<div class="listpgWraper">

  <div class="container"> 

    @include('flash::message')

    <!-- Job Header start -->

    <div class="job-header">

      <div class="jobinfo">

        <div class="row">

          <div class="col-md-8">

            <h2>{{$job->title}} - {{$company->name}}</h2>

            <div class="ptext">{{__('Date Posted')}}: {{$job->created_at->format('M d, Y')}}</div>

            @if(!(bool)$job->hide_salary)

            <div class="salary">{{__('Monthly Salary')}}: <strong>{{$job->salary_from.' '.$job->salary_currency}} - {{$job->salary_to.' '.$job->salary_currency}}</strong></div>

            @endif

          </div>

          <div class="col-md-4">

            <div class="companyinfo">

              <div class="companylogo"><a href="{{route('company.detail',$company->slug)}}">{{$company->printCompanyImage()}}</a></div>

              <div class="title"><a href="{{route('company.detail',$company->slug)}}">{{$company->name}}</a></div>

              <div class="ptext">{{$company->getLocation()}}</div>

              <div class="opening">

              <a href="{{route('company.detail',$company->slug)}}">

              {{App\Company::countNumJobs('company_id', $company->id)}} {{__('Current Jobs Openings')}}

              </a>

              </div>

              <div class="clearfix"></div>

            </div>

          </div>

        </div>

      </div>

      <div class="jobButtons">

      

      @if(Auth::check() && Auth::user()->isAppliedOnJob($job->id))

		<a href="javascript:;" class="btn apply"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{__('Already Applied')}}</a>

      @else

      	<a href="{{route('apply.job', $job->slug)}}" class="btn apply"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{__('Apply Now')}}</a>

      @endif

      

      

      <a href="{{route('email.to.friend', $job->slug)}}" class="btn"><i class="fa fa-envelope" aria-hidden="true"></i> {{__('Email to Friend')}}</a>

      @if(Auth::check() && Auth::user()->isFavouriteJob($job->slug)) <a href="{{route('remove.from.favourite', $job->slug)}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Favourite Job')}} </a> @else <a href="{{route('add.to.favourite', $job->slug)}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Add to Favourite')}}</a> @endif

      <a href="{{route('report.abuse', $job->slug)}}" class="btn report"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{__('Report Abuse')}}</a>

      </div>

    </div>

    

    <!-- Job Detail start -->

    <div class="row">

      <div class="col-md-8"> 

        <!-- Job Description start -->

        <div class="job-header">

          <div class="contentbox">

            <h3>{{__('Job Description')}}</h3>

            <p>{!! $job->description !!}</p>
			  
			  <hr>

            <h3>{{__('Skills Required')}}</h3>

            <ul class="skillslist">

              {!!$job->getJobSkillsList()!!}

            </ul>

          </div>

        </div>

        <!-- Job Description end --> 

        

        <!-- related jobs start -->

        <div class="relatedJobs">

          <h3>{{__('Related Jobs')}}</h3>

          <ul class="searchList">

            @if(isset($relatedJobs) && count($relatedJobs))

              @foreach($relatedJobs as $relatedJob)

              <?php $relatedJobCompany = $relatedJob->getCompany();?>

              @if(null !== $relatedJobCompany)

              <!--Job start-->

              <li>

            <div class="row">

              <div class="col-md-8 col-sm-8">

                <div class="jobimg"><a href="{{route('job.detail', [$relatedJob->slug])}}" title="{{$relatedJob->title}}">

                    {{$relatedJobCompany->printCompanyImage()}}

                    </a></div>

                <div class="jobinfo">

                  <h3><a href="{{route('job.detail', [$relatedJob->slug])}}" title="{{$relatedJob->title}}">{{$relatedJob->title}}</a></h3>

                  <div class="companyName"><a href="{{route('company.detail', $relatedJobCompany->slug)}}" title="{{$relatedJobCompany->name}}">{{$relatedJobCompany->name}}</a></div>

                  <div class="location">

                  <label class="fulltime">{{$relatedJob->getJobType('job_type')}}</label>

                  <label class="partTime">{{$relatedJob->getJobShift('job_shift')}}</label>   - <span>{{$relatedJob->getCity('city')}}</span></div>

                </div>

                <div class="clearfix"></div>

              </div>

              <div class="col-md-4 col-sm-4">

                <div class="listbtn"><a href="{{route('job.detail', [$relatedJob->slug])}}">{{__('View Detail')}}</a></div>

              </div>

            </div>

            <p>{{str_limit(strip_tags($relatedJob->description), 150, '...')}}</p>

          </li>

          <!--Job end--> 

              @endif

              @endforeach

              @endif

            

            <!-- Job end -->

          </ul>

        </div>

      </div>

      <!-- related jobs end -->

      

      <div class="col-md-4"> 

        <!-- Job Detail start -->

        <div class="job-header">

          <div class="jobdetail">

            <h3>{{__('Job Detail')}}</h3>

            <ul class="jbdetail">

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Location')}}</div>

                <div class="col-md-8 col-xs-7">

                @if((bool)$job->is_freelance)

                <span>Freelance</span>

                @else

                <span>{{$job->getLocation()}}</span>

                @endif

                </div>

              </li>

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Company')}}</div>

                <div class="col-md-8 col-xs-7"><a href="{{route('company.detail', $company->id)}}">{{$company->name}}</a></div>

              </li>

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Type')}}</div>

                <div class="col-md-8 col-xs-7"><span class="permanent">{{$job->getJobType('job_type')}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Shift')}}</div>

                <div class="col-md-8 col-xs-7"><span class="freelance">{{$job->getJobShift('job_shift')}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Career Level')}}</div>

                <div class="col-md-8 col-xs-7"><span>{{$job->getCareerLevel('career_level')}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Positions')}}</div>

                <div class="col-md-8 col-xs-7"><span>{{$job->num_of_positions}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Experience')}}</div>

                <div class="col-md-8 col-xs-7"><span>{{$job->getJobExperience('job_experience')}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Gender')}}</div>

                <div class="col-md-8 col-xs-7"><span>{{$job->getGender('gender')}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Degree')}}</div>

                <div class="col-md-8 col-xs-7"><span>{{$job->getDegreeLevel('degree_level')}}</span></div>

              </li>

              <li class="row">

                <div class="col-md-4 col-xs-5">{{__('Apply Before')}}</div>

                <div class="col-md-8 col-xs-7"><span>{{$job->expiry_date->format('M d, Y')}}</span></div>

              </li>

            </ul>

          </div>

        </div>

        <!-- Google Map start -->

        <div class="job-header">

          <div class="jobdetail">

            <h3>{{__('Google Map')}}</h3>

            <div class="gmap">

            {!!$company->map!!}

            </div>

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

.view_more{display:none !important;}

</style>

@endpush

@push('scripts') 

<script>

    $(document).ready(function ($) {

        $("form").submit(function () {

            $(this).find(":input").filter(function () {

                return !this.value;

            }).attr("disabled", "disabled");

            return true;

        });

        $("form").find(":input").prop("disabled", false);

				

		$( ".view_more_ul" ).each(function() {

		  	if($( this ).height() > 100)

			{

				$( this ).css('height',100);

				$( this ).css('overflow','hidden');

				//alert($( this ).next());

				$( this ).next().removeClass('view_more');

			}

		});

    

		

	

	});

</script> 

@endpush