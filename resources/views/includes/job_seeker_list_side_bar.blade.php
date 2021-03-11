<div class="col-md-3 col-sm-6"> 
	
	
	
    <!-- Side Bar start -->
    <div class="sidebar">
        <input type="hidden" name="search" value="{{Request::get('search', '')}}"/>

        <!-- Jobs By Country -->
        <div class="widget">
            <h4 class="widget-title">{{__('By Country')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($countryIdsArray) && count($countryIdsArray))
                @foreach($countryIdsArray as $key=>$country_id)
                @php
                $country = App\Country::where('country_id','=',$country_id)->lang()->active()->first();			  
                @endphp
                @if(null !== $country)
                @php
                $checked = (in_array($country->country_id, Request::get('country_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="country_id[]" id="country_{{$country->country_id}}" value="{{$country->country_id}}" {{$checked}}>
                    <label for="country_{{$country->country_id}}"></label>
                    {{$country->country}} <span>{{App\User::countNumJobSeekers('country_id', $country->country_id)}}</span> </li>
                @endif
                @endforeach
                @endif
            </ul>
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> </div>
        <!-- Jobs By Country end--> 


        <!-- Jobs By State -->
        <div class="widget">
            <h4 class="widget-title">{{__('By State')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($stateIdsArray) && count($stateIdsArray))
                @foreach($stateIdsArray as $key=>$state_id)
                @php
                $state = App\State::where('state_id','=',$state_id)->lang()->active()->first();			  
                @endphp
                @if(null !== $state)
                @php
                $checked = (in_array($state->state_id, Request::get('state_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="state_id[]" id="state_{{$state->state_id}}" value="{{$state->state_id}}" {{$checked}}>
                    <label for="state_{{$state->state_id}}"></label>
                    {{$state->state}} <span>{{App\User::countNumJobSeekers('state_id', $state->state_id)}}</span> </li>
                @endif
                @endforeach
                @endif
            </ul>
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> </div>
        <!-- Jobs By State end--> 


        <!-- Jobs By City -->
        <div class="widget">
            <h4 class="widget-title">{{__('By City')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($cityIdsArray) && count($cityIdsArray))
                @foreach($cityIdsArray as $key=>$city_id)
                @php
                $city = App\City::where('city_id','=',$city_id)->lang()->active()->first();			  
                @endphp
                @if(null !== $city)
                @php
                $checked = (in_array($city->city_id, Request::get('city_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="city_id[]" id="city_{{$city->city_id}}" value="{{$city->city_id}}" {{$checked}}>
                    <label for="city_{{$city->city_id}}"></label>
                    {{$city->city}} <span>{{App\User::countNumJobSeekers('city_id', $city->city_id)}}</span> </li>
                @endif
                @endforeach
                @endif
            </ul>
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> </div>
        <!-- Jobs By City end--> 

        <!-- Jobs By Experience -->
        <div class="widget">
            <h4 class="widget-title">{{__('By Experience')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($jobExperienceIdsArray) && count($jobExperienceIdsArray))
                @foreach($jobExperienceIdsArray as $key=>$job_experience_id)
                @php
                $jobExperience = App\JobExperience::where('job_experience_id','=',$job_experience_id)->lang()->active()->first();			  
                @endphp
                @if(null !== $jobExperience)
                @php
                $checked = (in_array($jobExperience->job_experience_id, Request::get('job_experience_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="job_experience_id[]" id="job_experience_{{$jobExperience->job_experience_id}}" value="{{$jobExperience->job_experience_id}}" {{$checked}}>
                    <label for="job_experience_{{$jobExperience->job_experience_id}}"></label>
                    {{$jobExperience->job_experience}} <span>{{App\User::countNumJobSeekers('job_experience_id', $jobExperience->job_experience_id)}}</span> </li>
                @endif
                @endforeach
                @endif
            </ul>
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> </div>
        <!-- Jobs By Experience end --> 


        <!-- Jobs By Career Level -->
        <div class="widget">
            <h4 class="widget-title">{{__('By Career Level')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($careerLevelIdsArray) && count($careerLevelIdsArray))
                @foreach($careerLevelIdsArray as $key=>$career_level_id)
                @php
                $careerLevel = App\CareerLevel::where('career_level_id','=',$career_level_id)->lang()->active()->first();
                @endphp
                @if(null !== $careerLevel)
                @php
                $checked = (in_array($careerLevel->career_level_id, Request::get('career_level_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="career_level_id[]" id="career_level_{{$careerLevel->career_level_id}}" value="{{$careerLevel->career_level_id}}" {{$checked}}>
                    <label for="career_level_{{$careerLevel->career_level_id}}"></label>
                    {{$careerLevel->career_level}} <span>{{App\User::countNumJobSeekers('career_level_id', $careerLevel->career_level_id)}}</span> </li>
                @endif
                @endforeach
                @endif
            </ul>
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> </div>
        <!-- Jobs By Career Level end --> 

        <!-- Jobs By Gender -->
        <div class="widget">
            <h4 class="widget-title">{{__('By Gender')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($genderIdsArray) && count($genderIdsArray))
                @foreach($genderIdsArray as $key=>$gender_id)
                @php
                $gender = App\Gender::where('gender_id','=',$gender_id)->lang()->active()->first();
                @endphp
                @if(null !== $gender)
                @php
                $checked = (in_array($gender->gender_id, Request::get('gender_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="gender_id[]" id="gender_{{$gender->gender_id}}" value="{{$gender->gender_id}}" {{$checked}}>
                    <label for="gender_{{$gender->gender_id}}"></label>
                    {{$gender->gender}} <span>{{App\User::countNumJobSeekers('gender_id', $gender->gender_id)}}</span> </li>
                @endif
                @endforeach
                @endif
            </ul>
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> </div>
        <!-- Jobs By Gender end --> 



        <!-- Jobs By Industry -->
        <div class="widget">
            <h4 class="widget-title">{{__('By Industry')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($industryIdsArray) && count($industryIdsArray))
                @foreach($industryIdsArray as $key=>$industry_id)
                @php
                $industry = App\Industry::where('id','=',$industry_id)->lang()->active()->first();
                @endphp
                @if(null !== $industry)
                @php
                $checked = (in_array($industry->id, Request::get('industry_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="industry_id[]" id="industry_{{$industry->id}}" value="{{$industry->id}}" {{$checked}}>
                    <label for="industry_{{$industry->id}}"></label>
                    {{$industry->industry}} <span>{{App\User::countNumJobSeekers('industry_id', $industry->id)}}</span> </li>
                @endif
                @endforeach
                @endif
            </ul>
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> </div>
        <!-- Jobs By Industry end --> 

        <!-- Jobs By Skill -->
        <div class="widget">
            <h4 class="widget-title">{{__('By Skill')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($skillIdsArray) && count($skillIdsArray))
                @foreach($skillIdsArray as $key=>$job_skill_id)
                @php
                $jobSkill = App\JobSkill::where('job_skill_id','=',$job_skill_id)->lang()->active()->first();
                @endphp
                @if(null !== $jobSkill)

                @php
                $checked = (in_array($jobSkill->job_skill_id, Request::get('job_skill_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="job_skill_id[]" id="job_skill_{{$jobSkill->job_skill_id}}" value="{{$jobSkill->job_skill_id}}" {{$checked}}>
                    <label for="job_skill_{{$jobSkill->job_skill_id}}"></label>
                    {{$jobSkill->job_skill}} <span>{{App\User::countNumJobSeekers('job_skill_id', $jobSkill->job_skill_id)}}</span> </li>
                @endif
                @endforeach
                @endif
            </ul>
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> </div>
        <!-- Jobs By Industry end --> 


        <div class="widget">
            <h4 class="widget-title">{{__('By Functional Areas')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($functionalAreaIdsArray) && count($functionalAreaIdsArray))
                @foreach($functionalAreaIdsArray as $key=>$functional_area_id)
                @php
                $functionalArea = App\FunctionalArea::where('functional_area_id','=',$functional_area_id)->lang()->active()->first();
                @endphp
                @if(null !== $functionalArea)
                @php
                $checked = (in_array($functionalArea->functional_area_id, Request::get('functional_area_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="functional_area_id[]" id="functional_area_id_{{$functionalArea->functional_area_id}}" value="{{$functionalArea->functional_area_id}}" {{$checked}}>
                    <label for="functional_area_id_{{$functionalArea->functional_area_id}}"></label>
                    {{$functionalArea->functional_area}} <span>{{App\User::countNumJobSeekers('functional_area_id', $functionalArea->functional_area_id)}}</span>
                </li>                
                @endif
                @endforeach
                @endif

            </ul>
            <!-- title end --> 
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> </div>


        <!-- Salary -->
        <div class="widget">
            <h4 class="widget-title">{{__('Salary Range')}}</h4>
            <div class="form-group">
                {!! Form::number('current_salary', Request::get('current_salary', null), array('class'=>'form-control', 'id'=>'current_salary', 'placeholder'=>__('Current Salary'))) !!}
            </div>
            <div class="form-group">
                {!! Form::number('expected_salary', Request::get('expected_salary', null), array('class'=>'form-control', 'id'=>'expected_salary', 'placeholder'=>__('Expected Salary'))) !!}
            </div>
            <div class="form-group">
                {!! Form::select('salary_currency', ['' =>__('Select Salary Currency')]+$currencies, Request::get('salary_currency', $siteSetting->default_currency_code), array('class'=>'form-control', 'id'=>'salary_currency')) !!}
            </div>
            <!-- Salary end --> 

            <!-- button -->
            <div class="searchnt">
                <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i> {{__('Search')}}</button>
            </div>
            <!-- button end--> 
        </div>
        <!-- Side Bar end --> 
    </div>
</div>