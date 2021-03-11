@extends('layouts.app')

@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 

<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title'=>__($page_title)]) 
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
              <div class="userPic">{{$user->printUserImage()}}</div>
              <div class="title">
              {{$user->getName()}}
              @if((bool)$user->is_immediate_available)
              <sup style="font-size:12px; color:#090;">{{__('Immediate Available For Work')}}</sup>
            @endif
              </div>
              <div class="desi">{{$user->getLocation()}}</div>
              <div class="loctext"><i class="fa fa-history" aria-hidden="true"></i> {{__('Member Since')}}, {{$user->created_at->format('M d, Y')}}</div>
              <div class="loctext"><i class="fa fa-map-marker" aria-hidden="true"></i> {{$user->street_address}}</div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="col-md-4 col-sm-4"> 
            <!-- Candidate Contact -->
            <div class="candidateinfo">            
            @if(!empty($user->phone))
              <div class="loctext"><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:{{$user->phone}}">{{$user->phone}}</a></div>
            @endif
            @if(!empty($user->mobile_num))
              <div class="loctext"><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:{{$user->mobile_num}}">{{$user->mobile_num}}</a></div>
            @endif
            @if(!empty($user->email))
              <div class="loctext"><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:{{$user->email}}">{{$user->email}}</a></div>
            @endif
            </div>            
          </div>
        </div>
      </div>
      
      <!-- Buttons -->
      <div class="jobButtons">
      @if(isset($job) && isset($company))
      @if(Auth::guard('company')->check() && Auth::guard('company')->user()->isFavouriteApplicant($user->id, $job->id, $company->id))
      <a href="{{route('remove.from.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id])}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Short Listed Applicant')}} </a>
      @else
      <a href="{{route('add.to.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id])}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Short List This Applicant')}}</a>
      @endif
      @endif
      
      @if(null !== $profileCv)<a href="{{asset('cvs/'.$profileCv->cv_file)}}" class="btn"><i class="fa fa-download" aria-hidden="true"></i> {{__('Download CV')}}</a>@endif
      <a href="#contact_applicant" class="btn"><i class="fa fa-envelope" aria-hidden="true"></i> {{__('Send Message')}}</a>
      
      </div>
    </div>
    
    <!-- Job Detail start -->
    <div class="row">
      <div class="col-md-8"> 
        <!-- About Employee start -->
        <div class="job-header">
          <div class="contentbox">
            <h3>{{__('About me')}}</h3>
            <p>{{$user->getProfileSummary('summary')}}</p>
          </div>
        </div>
        
        <!-- Education start -->
        <div class="job-header">
          <div class="contentbox">
            <h3>{{__('Education')}}</h3>
            <div class="" id="education_div"></div>            
          </div>
        </div>
        
        <!-- Experience start -->
        <div class="job-header">
          <div class="contentbox">
            <h3>{{__('Experience')}}</h3>
            <div class="" id="experience_div"></div>            
          </div>
        </div>
        
        <!-- Portfolio start -->
        <div class="job-header">
          <div class="contentbox">
            <h3>{{__('Portfolio')}}</h3>
            <div class="" id="projects_div"></div>            
          </div>
        </div>
      </div>
      <div class="col-md-4"> 
        <!-- Candidate Detail start -->
        <div class="job-header">
          <div class="jobdetail">
            <h3>{{__('Candidate Detail')}}</h3>
            <ul class="jbdetail">
              
              <li class="row">
                <div class="col-md-6 col-xs-6">{{__('Is Email Verified')}}</div>
                <div class="col-md-6 col-xs-6"><span>{{((bool)$user->verified)? 'Yes':'No'}}</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">{{__('Immediate Available')}}</div>
                <div class="col-md-6 col-xs-6"><span>{{((bool)$user->is_immediate_available)? 'Yes':'No'}}</span></div>
              </li>
              
              <li class="row">
                <div class="col-md-6 col-xs-6">{{__('Age')}}</div>
                <div class="col-md-6 col-xs-6"><span>{{$user->getAge()}} Years</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">{{__('Gender')}}</div>
                <div class="col-md-6 col-xs-6"><span>{{$user->getGender('gender')}}</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">{{__('Marital Status')}}</div>
                <div class="col-md-6 col-xs-6"><span>{{$user->getMaritalStatus('marital_status')}}</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">{{__('Experience')}}</div>
                <div class="col-md-6 col-xs-6"><span>{{$user->getJobExperience('job_experience')}}</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">{{__('Career Level')}}</div>
                <div class="col-md-6 col-xs-6"><span>{{$user->getCareerLevel('career_level')}}</span></div>
              </li>             
              <li class="row">
                <div class="col-md-6 col-xs-6">{{__('Current Salary')}}</div>
                <div class="col-md-6 col-xs-6"><span class="permanent">{{$user->current_salary}} {{$user->salary_currency}}</span></div>
              </li>
              <li class="row">
                <div class="col-md-6 col-xs-6">{{__('Expected Salary')}}</div>
                <div class="col-md-6 col-xs-6"><span class="freelance">{{$user->expected_salary}} {{$user->salary_currency}}</span></div>
              </li>              
            </ul>
          </div>
        </div>
        
        <!-- Google Map start -->
        <div class="job-header">
          <div class="jobdetail">
            <h3>{{__('Skills')}}</h3>
            <div id="skill_div"></div>            
          </div>
        </div>
        
        <div class="job-header">
          <div class="jobdetail">
            <h3>{{__('Languages')}}</h3>
            <div id="language_div"></div>            
          </div>
        </div>
        <!-- Contact Company start -->
        <div class="job-header">
          <div class="jobdetail">
            <h3 id="contact_applicant">{{__($form_title)}}</h3>
            <div id="alert_messages"></div>
            <?php
                        $from_name = $from_email = $from_phone = $subject = $message = $from_id = '';
                        if(isset($company)){
							$from_name = $company->name;
							$from_email = $company->email;
							$from_phone = $company->phone;
							$from_id = $company->id;
						}
                        $from_name = old('name', $from_name);
                        $from_email = old('email', $from_email);
                        $from_phone = old('phone', $from_phone);
                        $subject = old('subject');
                        $message = old('message');
                        ?>
            <form method="post" id="send-applicant-message-form">
              {{ csrf_field() }}
              <input type="hidden" name="to_id" value="{{ $user->id }}">
              <input type="hidden" name="from_id" value="{{ $from_id }}">
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <input type="hidden" name="user_name" value="{{ $user->getName() }}">
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
                <div class="formrow">
                <input type="button" class="btn" value="{{__('Submit')}}" id="send_applicant_message">
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
        $(document).on('click', '#send_applicant_message', function () {
            var postData = $('#send-applicant-message-form').serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('contact.applicant.message.send') }}",
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
                        $('#send-applicant-message-form').hide('slow');
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
		
		showEducation();
		showProjects();
		showExperience();
		showSkills();
		showLanguages();
		
    });
	
function showProjects()
{
	$.post("{{ route('show.applicant.profile.projects', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
	.done(function (response) {
	$('#projects_div').html(response);
	});		
}

function showExperience()
{
	$.post("{{ route('show.applicant.profile.experience', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
	.done(function (response) {
	$('#experience_div').html(response);
	});		
}

function showEducation()
{
	$.post("{{ route('show.applicant.profile.education', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
	.done(function (response) {
	$('#education_div').html(response);
	});		
}
function showLanguages()
{
	$.post("{{ route('show.applicant.profile.languages', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
	.done(function (response) {
	$('#language_div').html(response);
	});		
}
function showSkills()
{
	$.post("{{ route('show.applicant.profile.skills', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
	.done(function (response) {
	$('#skill_div').html(response);
	});		
}
</script> 
@endpush