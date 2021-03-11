<h5>{{__('Job Details')}}</h5>
@if(isset($job))
{!! Form::model($job, array('method' => 'put', 'route' => array('update.front.job', $job->id), 'class' => 'form')) !!}
{!! Form::hidden('id', $job->id) !!}
@else
{!! Form::open(array('method' => 'post', 'route' => array('store.front.job'), 'class' => 'form')) !!}
@endif
<div class="row">  
  <div class="col-md-12">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'title') !!}"> {!! Form::text('title', null, array('class'=>'form-control', 'id'=>'title', 'placeholder'=>__('Job title'))) !!}
      {!! APFrmErrHelp::showErrors($errors, 'title') !!} </div>
  </div>
  <div class="col-md-12">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'description') !!}"> {!! Form::textarea('description', null, array('class'=>'form-control', 'id'=>'description', 'placeholder'=>__('Job description'))) !!}
      {!! APFrmErrHelp::showErrors($errors, 'description') !!} </div>
  </div>
  <div class="col-md-12">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'skills') !!}">
      <?php
        $skills = old('skills', $jobSkillIds);
		?>
      {!! Form::select('skills[]', $jobSkills, $skills, array('class'=>'form-control select2-multiple', 'id'=>'skills', 'multiple'=>'multiple')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'skills') !!} </div>
  </div>
  <div class="col-md-4">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}" id="country_id_div"> {!! Form::select('country_id', ['' => __('Select Country')]+$countries, old('country_id', (isset($job))? $job->country_id:$siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'country_id') !!} </div>
  </div>
  <div class="col-md-4">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}" id="state_id_div"> <span id="default_state_dd"> {!! Form::select('state_id', ['' => __('Select State')], null, array('class'=>'form-control', 'id'=>'state_id')) !!} </span> {!! APFrmErrHelp::showErrors($errors, 'state_id') !!} </div>
  </div>
  <div class="col-md-4">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}" id="city_id_div"> <span id="default_city_dd"> {!! Form::select('city_id', ['' => __('Select City')], null, array('class'=>'form-control', 'id'=>'city_id')) !!} </span> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_from') !!}" id="salary_from_div"> {!! Form::number('salary_from', null, array('class'=>'form-control', 'id'=>'salary_from', 'placeholder'=>__('Salary from'))) !!}
      {!! APFrmErrHelp::showErrors($errors, 'salary_from') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_to') !!}" id="salary_to_div">
      {!! Form::number('salary_to', null, array('class'=>'form-control', 'id'=>'salary_to', 'placeholder'=>__('Salary to'))) !!}
      {!! APFrmErrHelp::showErrors($errors, 'salary_to') !!} </div>
  </div>
  <div class="col-md-4">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_currency') !!}" id="salary_currency_div">
    @php
    $salary_currency = Request::get('salary_currency', (isset($job))? $job->salary_currency:$siteSetting->default_currency_code);
    @endphp
    
    {!! Form::select('salary_currency', ['' => __('Select Salary Currency')]+$currencies, $salary_currency, array('class'=>'form-control', 'id'=>'salary_currency')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'salary_currency') !!} </div>
  </div>
  <div class="col-md-4">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_period_id') !!}" id="salary_period_id_div"> {!! Form::select('salary_period_id', ['' => __('Select Salary Period')]+$salaryPeriods, null, array('class'=>'form-control', 'id'=>'salary_period_id')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'salary_period_id') !!} </div>
  </div>
  <div class="col-md-4">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'hide_salary') !!}"> {!! Form::label('hide_salary', __('Hide Salary?'), ['class' => 'bold']) !!}
      <div class="radio-list">
        <?php
            $hide_salary_1 = '';
            $hide_salary_2 = 'checked="checked"';
            if (old('hide_salary', ((isset($job)) ? $job->hide_salary : 0)) == 1) {
                $hide_salary_1 = 'checked="checked"';
                $hide_salary_2 = '';
            }
            ?>
        <label class="radio-inline">
          <input id="hide_salary_yes" name="hide_salary" type="radio" value="1" {{$hide_salary_1}}>
          {{__('Yes')}} </label>
        <label class="radio-inline">
          <input id="hide_salary_no" name="hide_salary" type="radio" value="0" {{$hide_salary_2}}>
          {{__('No')}} </label>
      </div>
      {!! APFrmErrHelp::showErrors($errors, 'hide_salary') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'career_level_id') !!}" id="career_level_id_div"> {!! Form::select('career_level_id', ['' => __('Select Career level')]+$careerLevels, null, array('class'=>'form-control', 'id'=>'career_level_id')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!} </div>
  </div>
  
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}" id="functional_area_id_div"> {!! Form::select('functional_area_id', ['' => __('Select Functional Area')]+$functionalAreas, null, array('class'=>'form-control', 'id'=>'functional_area_id')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_type_id') !!}" id="job_type_id_div"> {!! Form::select('job_type_id', ['' => __('Select Job Type')]+$jobTypes, null, array('class'=>'form-control', 'id'=>'job_type_id')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'job_type_id') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_shift_id') !!}" id="job_shift_id_div"> {!! Form::select('job_shift_id', ['' => __('Select Job Shift')]+$jobShifts, null, array('class'=>'form-control', 'id'=>'job_shift_id')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'job_shift_id') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'num_of_positions') !!}" id="num_of_positions_div"> {!! Form::select('num_of_positions', ['' => __('Select number of Positions')]+MiscHelper::getNumPositions(), null, array('class'=>'form-control', 'id'=>'num_of_positions')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'num_of_positions') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'gender_id') !!}" id="gender_id_div"> {!! Form::select('gender_id', ['' => __('No preference')]+$genders, null, array('class'=>'form-control', 'id'=>'gender_id')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'gender_id') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'expiry_date') !!}"> {!! Form::text('expiry_date', null, array('class'=>'form-control datepicker', 'id'=>'expiry_date', 'placeholder'=>__('Job expiry date'), 'autocomplete'=>'off')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'expiry_date') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'degree_level_id') !!}" id="degree_level_id_div"> {!! Form::select('degree_level_id', ['' =>__('Select Required Degree Level')]+$degreeLevels, null, array('class'=>'form-control', 'id'=>'degree_level_id')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'degree_level_id') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}" id="job_experience_id_div"> {!! Form::select('job_experience_id', ['' => __('Select Required job experience')]+$jobExperiences, null, array('class'=>'form-control', 'id'=>'job_experience_id')) !!}
      {!! APFrmErrHelp::showErrors($errors, 'job_experience_id') !!} </div>
  </div>
  <div class="col-md-6">
    <div class="formrow {!! APFrmErrHelp::hasError($errors, 'is_freelance') !!}"> {!! Form::label('is_freelance', __('Is Freelance?'), ['class' => 'bold']) !!}
      <div class="radio-list">
        <?php
            $is_freelance_1 = '';
            $is_freelance_2 = 'checked="checked"';
            if (old('is_freelance', ((isset($job)) ? $job->is_freelance : 0)) == 1) {
                $is_freelance_1 = 'checked="checked"';
                $is_freelance_2 = '';
            }
            ?>
        <label class="radio-inline">
          <input id="is_freelance_yes" name="is_freelance" type="radio" value="1" {{$is_freelance_1}}>
          {{__('Yes')}} </label>
        <label class="radio-inline">
          <input id="is_freelance_no" name="is_freelance" type="radio" value="0" {{$is_freelance_2}}>
          {{__('No')}} </label>
      </div>
      {!! APFrmErrHelp::showErrors($errors, 'is_freelance') !!} </div>
  </div>
  <div class="col-md-12">
    <div class="formrow">
      <button type="submit" class="btn">{{__('Update Job')}} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
    </div>
  </div>
</div>
{!! Form::close() !!}
<hr>
@push('styles')
<style type="text/css">
.datepicker>div {
    display: block;
}
</style>
@endpush
@push('scripts')
@include('admin.shared.tinyMCEFront')
<script type="text/javascript">
$(document).ready(function() {
    $('.select2-multiple').select2({
    	placeholder: "{{__('Select Required Skills')}}",
    	allowClear: true
	});
	$(".datepicker").datepicker({
		autoclose: true,
		format:'yyyy-m-d'	
	});
    $('#country_id').on('change', function (e) {
    e.preventDefault();
    filterLangStates(0);
    });
    $(document).on('change', '#state_id', function (e) {
    e.preventDefault();
    filterLangCities(0);
    });
    filterLangStates(<?php echo old('state_id', (isset($job))? $job->state_id:0); ?>);
    });
    function filterLangStates(state_id)
    {
    var country_id = $('#country_id').val();
    if (country_id != ''){
    $.post("{{ route('filter.lang.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#default_state_dd').html(response);
            filterLangCities(<?php echo old('city_id', (isset($job))? $job->city_id:0); ?>);
            });
    }
    }

    function filterLangCities(city_id)
    {
    var state_id = $('#state_id').val();
    if (state_id != ''){
    $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#default_city_dd').html(response);
            });
    }
    }
</script> 
@endpush