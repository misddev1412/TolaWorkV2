<div class="modal-body">
    <div class="form-body">
        <div class="formrow" id="div_degree_level_id">
            <?php
            $degree_level_id = (isset($profileEducation) ? $profileEducation->degree_level_id : null);
            ?>
            {!! Form::select('degree_level_id', [''=>__('Select Degree Level')]+$degreeLevels, $degree_level_id, array('class'=>'form-control', 'id'=>'degree_level_id')) !!}
            <span class="help-block degree_level_id-error"></span> </div>


        <div class="formrow" id="div_degree_type_id">
            <?php
            $degree_type_id = (isset($profileEducation) ? $profileEducation->degree_type_id : null);
            ?>
            <span id="degree_types_dd">
                {!! Form::select('degree_type_id', [''=>__('Select Degree Type')], $degree_type_id, array('class'=>'form-control', 'id'=>'degree_type_id')) !!}
            </span>
            <span class="help-block degree_type_id-error"></span> </div>

        <div class="formrow" id="div_degree_title">
            <input class="form-control" id="degree_title" placeholder="{{__('Degree Title')}}" name="degree_title" type="text" value="{{(isset($profileEducation)? $profileEducation->degree_title:'')}}">
            <span class="help-block degree_title-error"></span> </div>

        <div class="formrow" id="div_major_subjects">
            <?php
            $profileEducationMajorSubjectIds = old('major_subjects', $profileEducationMajorSubjectIds);
            ?>
            {!! Form::select('major_subjects[]', $majorSubjects, $profileEducationMajorSubjectIds, array('class'=>'form-control select2-multiple', 'id'=>'major_subjects', 'multiple'=>'multiple')) !!}
            <span class="help-block major_subjects-error"></span> </div>

        <div class="formrow" id="div_country_id">
            <?php
            $country_id = (isset($profileEducation) ? $profileEducation->country_id : $siteSetting->default_country_id);
            ?>
            {!! Form::select('country_id', [''=>__('Select Country')]+$countries, $country_id, array('class'=>'form-control', 'id'=>'education_country_id')) !!}
            <span class="help-block country_id-error"></span> </div>

        <div class="formrow" id="div_state_id">
            <span id="default_state_education_dd">
                {!! Form::select('state_id', [''=>__('Select State')], null, array('class'=>'form-control', 'id'=>'education_state_id')) !!}
            </span>
            <span class="help-block state_id-error"></span> </div>

        <div class="formrow" id="div_city_id">
            <span id="default_city_education_dd">
                {!! Form::select('city_id', [''=>__('Select City')], null, array('class'=>'form-control', 'id'=>'city_id')) !!}
            </span>
            <span class="help-block city_id-error"></span> </div>

        <div class="formrow" id="div_institution">
            <input class="form-control" id="institution" placeholder="{{__('Institution')}}" name="institution" type="text" value="{{(isset($profileEducation)? $profileEducation->institution:'')}}">
            <span class="help-block institution-error"></span> </div>


        <div class="formrow" id="div_date_completion">
            <?php
            $date_completion = (isset($profileEducation) ? $profileEducation->date_completion : null);
            ?>
            {!! Form::select('date_completion', [''=>__('Select Year')]+MiscHelper::getEstablishedIn(), $date_completion, array('class'=>'form-control', 'id'=>'date_completion')) !!}
            <span class="help-block date_completion-error"></span> </div>


        <div class="formrow" id="div_degree_result">
            <input class="form-control" id="degree_result" placeholder="{{__('Degree Result')}}" name="degree_result" type="text" value="{{(isset($profileEducation)? $profileEducation->degree_result:'')}}">
            <span class="help-block degree_result-error"></span> </div>



        <div class="formrow" id="div_result_type_id">
            <?php
            $result_type_id = (isset($profileEducation) ? $profileEducation->result_type_id : null);
            ?>
            {!! Form::select('result_type_id', [''=>__('Select Result Type')]+$resultTypes, $result_type_id, array('class'=>'form-control', 'id'=>'result_type_id')) !!}
            <span class="help-block result_type_id-error"></span> </div>

    </div>
</div>