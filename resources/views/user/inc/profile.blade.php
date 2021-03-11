<h5>{{__('Personal Information')}}</h5>
            {!! Form::model($user, array('method' => 'put', 'route' => array('my.profile'), 'class' => 'form', 'files'=>true)) !!}
            <h6>{{__('Profile Image')}}</h6>
            <div class="row">
              <div class="col-md-6">
                <div class="formrow"> {{ ImgUploader::print_image("user_images/$user->image", 100, 100) }} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow">
                  <div id="thumbnail"></div>
                  <label class="btn btn-default"> {{__('Select Profile Image')}}
                    <input type="file" name="image" id="image" style="display: none;">
                  </label>
                  {!! APFrmErrHelp::showErrors($errors, 'image') !!} </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'first_name') !!}"> {!! Form::text('first_name', null, array('class'=>'form-control', 'id'=>'first_name', 'placeholder'=>__('First Name'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'first_name') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'middle_name') !!}"> {!! Form::text('middle_name', null, array('class'=>'form-control', 'id'=>'middle_name', 'placeholder'=>__('Middle Name'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'middle_name') !!}</div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'last_name') !!}"> {!! Form::text('last_name', null, array('class'=>'form-control', 'id'=>'last_name', 'placeholder'=>__('Last Name'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'last_name') !!}</div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'father_name') !!}"> {!! Form::text('father_name', null, array('class'=>'form-control', 'id'=>'father_name', 'placeholder'=>__('Father Name'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'father_name') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'email') !!}"> {!! Form::text('email', null, array('class'=>'form-control', 'id'=>'email', 'placeholder'=>__('Email'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'email') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'password') !!}"> {!! Form::password('password', array('class'=>'form-control', 'id'=>'password', 'placeholder'=>__('Password'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'password') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'gender_id') !!}"> {!! Form::select('gender_id', [''=>__('Select Gender')]+$genders, null, array('class'=>'form-control', 'id'=>'gender_id')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'gender_id') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'marital_status_id') !!}"> {!! Form::select('marital_status_id', [''=>__('Select Marital Status')]+$maritalStatuses, null, array('class'=>'form-control', 'id'=>'marital_status_id')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'marital_status_id') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}">
                <?php $country_id = old('country_id', (isset($user) && (int)$user->country_id > 0)? $user->country_id:$siteSetting->default_country_id); ?>
             {!! Form::select('country_id', [''=>__('Select Country')]+$countries, $country_id, array('class'=>'form-control', 'id'=>'country_id')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'country_id') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}"> <span id="state_dd"> {!! Form::select('state_id', [''=>__('Select State')], null, array('class'=>'form-control', 'id'=>'state_id')) !!} </span> {!! APFrmErrHelp::showErrors($errors, 'state_id') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}"> <span id="city_dd"> {!! Form::select('city_id', [''=>__('Select City')], null, array('class'=>'form-control', 'id'=>'city_id')) !!} </span> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'nationality_id') !!}"> {!! Form::select('nationality_id', [''=>__('Select Nationality')]+$nationalities, null, array('class'=>'form-control', 'id'=>'nationality_id')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'nationality_id') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'date_of_birth') !!}"> {!! Form::text('date_of_birth', null, array('class'=>'form-control datepicker', 'id'=>'date_of_birth', 'placeholder'=>__('Date of Birth'), 'autocomplete'=>'off')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'date_of_birth') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'national_id_card_number') !!}"> {!! Form::text('national_id_card_number', null, array('class'=>'form-control', 'id'=>'national_id_card_number', 'placeholder'=>__('National ID Card#'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'national_id_card_number') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'phone') !!}"> {!! Form::text('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Phone'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'phone') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'mobile_num') !!}"> {!! Form::text('mobile_num', null, array('class'=>'form-control', 'id'=>'mobile_num', 'placeholder'=>__('Mobile Number'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'mobile_num') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}"> {!! Form::select('job_experience_id', [''=>__('Select Experience')]+$jobExperiences, null, array('class'=>'form-control', 'id'=>'job_experience_id')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'job_experience_id') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'career_level_id') !!}"> {!! Form::select('career_level_id', [''=>__('Select Career Level')]+$careerLevels, null, array('class'=>'form-control', 'id'=>'career_level_id')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'industry_id') !!}"> {!! Form::select('industry_id', [''=>__('Select Industry')]+$industries, null, array('class'=>'form-control', 'id'=>'industry_id')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'industry_id') !!} </div>
              </div>
              <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}"> {!! Form::select('functional_area_id', [''=>__('Select Functional Area')]+$functionalAreas, null, array('class'=>'form-control', 'id'=>'functional_area_id')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!} </div>
              </div>
              <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'current_salary') !!}"> {!! Form::text('current_salary', null, array('class'=>'form-control', 'id'=>'current_salary', 'placeholder'=>__('Current Salary'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'current_salary') !!} </div>
              </div>
              <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'expected_salary') !!}"> {!! Form::text('expected_salary', null, array('class'=>'form-control', 'id'=>'expected_salary', 'placeholder'=>__('Expected Salary'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'expected_salary') !!} </div>
              </div>
              <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_currency') !!}">
                @php
                $salary_currency = Request::get('salary_currency', (isset($user) && !empty($user->salary_currency))? $user->salary_currency:$siteSetting->default_currency_code);
                @endphp
                {!! Form::text('salary_currency', $salary_currency, array('class'=>'form-control', 'id'=>'salary_currency', 'placeholder'=>__('Salary Currency'), 'autocomplete'=>'off')) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'salary_currency') !!} </div>
              </div>
              <div class="col-md-12">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'street_address') !!}"> {!! Form::textarea('street_address', null, array('class'=>'form-control', 'id'=>'street_address', 'placeholder'=>__('Street Address'))) !!}
                  {!! APFrmErrHelp::showErrors($errors, 'street_address') !!} </div>
              </div>
              <div class="col-md-12">
                <div class="formrow"><button type="submit" class="btn">{{__('Update Profile and Save')}}  <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button></div>
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
<script type="text/javascript">
$(document).ready( function() {
	initdatepicker();
	$('#salary_currency').typeahead({
		source:  function (query, process) {
			return $.get("{{ route('typeahead.currency_codes') }}", { query: query }, function (data) {
				console.log(data);
				data = $.parseJSON(data);
				return process(data);
			});
		}
    });
	
    $('#country_id').on('change', function (e) {
    e.preventDefault();
    filterStates(0);
    });
    $(document).on('change', '#state_id', function (e) {
    e.preventDefault();
    filterCities(0);
    });
    filterStates(<?php echo old('state_id', $user->state_id);?>);
	
	/*******************************/
	var fileInput = document.getElementById("image");
        fileInput.addEventListener("change", function (e) {
            var files = this.files
            showThumbnail(files)
        }, false)

        function showThumbnail(files) {
            $('#thumbnail').html('');
            for (var i = 0; i < files.length; i++) {
                var file = files[i]
                var imageType = /image.*/

                if (!file.type.match(imageType)) {
                    console.log("Not an Image");
                    continue;
                }

                var reader = new FileReader()
                reader.onload = (function (theFile) {
                    return function (e) {
                        $('#thumbnail').append('<div class="fileattached"><img height="100px" src="' + e.target.result + '" > <div>' + theFile.name + '</div><div class="clearfix"></div></div>');
                    };
                }(file))

                var ret = reader.readAsDataURL(file);
            }
        }
});
	
    function filterStates(state_id)
    {
    var country_id = $('#country_id').val();
    if (country_id != ''){
    $.post("{{ route('filter.lang.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#state_dd').html(response);
            filterCities(<?php echo old('city_id', $user->city_id);?>);
            });
    }
    }

    function filterCities(city_id)
    {
    var state_id = $('#state_id').val();
    if (state_id != ''){
    $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#city_dd').html(response);
            });
    }
    }
function initdatepicker(){
	$(".datepicker").datepicker({
		autoclose: true,
		format:'yyyy-m-d'	
	});
}
</script> 
@endpush            