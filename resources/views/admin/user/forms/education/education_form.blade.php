<div class="modal-body">
    <div class="form-body">
        <div class="form-group" id="div_degree_level_id">
            <label for="degree_level_id" class="bold">Degree Level</label>
            <?php
            $degree_level_id = (isset($profileEducation) ? $profileEducation->degree_level_id : null);
            ?>
            {!! Form::select('degree_level_id', [''=>'Select Degree Level']+$degreeLevels, $degree_level_id, array('class'=>'form-control', 'id'=>'degree_level_id')) !!}
            <span class="help-block degree_level_id-error"></span> </div>


        <div class="form-group" id="div_degree_type_id">
            <label for="degree_type_id" class="bold">Degree Type</label>
            <?php
            $degree_type_id = (isset($profileEducation) ? $profileEducation->degree_type_id : null);
            ?>
            <span id="degree_types_dd">
                {!! Form::select('degree_type_id', [''=>'Select Degree Type'], $degree_type_id, array('class'=>'form-control', 'id'=>'degree_type_id')) !!}
            </span>
            <span class="help-block degree_type_id-error"></span> </div>

        <div class="form-group" id="div_degree_title">
            <label for="degree_title" class="bold">Degree Title</label>
            <input class="form-control" id="degree_title" placeholder="Degree Title" name="degree_title" type="text" value="{{(isset($profileEducation)? $profileEducation->degree_title:'')}}">
            <span class="help-block degree_title-error"></span> </div>

        <div class="form-group" id="div_major_subjects">
            <label for="degree_major_subjects" class="bold">Major Subjects</label>
            <?php
            $profileEducationMajorSubjectIds = old('major_subjects', $profileEducationMajorSubjectIds);
            ?>
            {!! Form::select('major_subjects[]', $majorSubjects, $profileEducationMajorSubjectIds, array('class'=>'form-control select2-multiple', 'id'=>'major_subjects', 'multiple'=>'multiple')) !!}
            <span class="help-block major_subjects-error"></span> </div>

        <div class="form-group" id="div_country_id">
            <label for="country_id" class="bold">Country</label>
            <?php
            $country_id = (isset($profileEducation) ? $profileEducation->country_id : $siteSetting->default_country_id);
            ?>
            {!! Form::select('country_id', [''=>'Select Country']+$countries, $country_id, array('class'=>'form-control', 'id'=>'education_country_id')) !!}
            <span class="help-block country_id-error"></span> </div>

        <div class="form-group" id="div_state_id">
            <label for="state_id" class="bold">State</label>
            <span id="default_state_education_dd">
                {!! Form::select('state_id', [''=>'Select State'], null, array('class'=>'form-control', 'id'=>'education_state_id')) !!}
            </span>
            <span class="help-block state_id-error"></span> </div>

        <div class="form-group" id="div_city_id">
            <label for="city_id" class="bold">City</label>
            <span id="default_city_education_dd">
                {!! Form::select('city_id', [''=>'Select City'], null, array('class'=>'form-control', 'id'=>'city_id')) !!}
            </span>
            <span class="help-block city_id-error"></span> </div>

        <div class="form-group" id="div_institution">
            <label for="institution" class="bold">Institution</label>
            <input class="form-control" id="institution" placeholder="Institution" name="institution" type="text" value="{{(isset($profileEducation)? $profileEducation->institution:'')}}">
            <span class="help-block institution-error"></span> </div>


        <div class="form-group" id="div_date_completion">
            <label for="date_completion" class="bold">Completion Year</label>
            <?php
            $date_completion = (isset($profileEducation) ? $profileEducation->date_completion : null);
            ?>
            {!! Form::select('date_completion', [''=>'Select Year']+MiscHelper::getEstablishedIn(), $date_completion, array('class'=>'form-control', 'id'=>'date_completion')) !!}
            <span class="help-block date_completion-error"></span> </div>


        <div class="form-group" id="div_degree_result">
            <label for="degree_result" class="bold">Degree Result</label>
            <input class="form-control" id="degree_result" placeholder="Degree Result" name="degree_result" type="text" value="{{(isset($profileEducation)? $profileEducation->degree_result:'')}}">
            <span class="help-block degree_result-error"></span> </div>



        <div class="form-group" id="div_result_type_id">
            <label for="result_type_id" class="bold">Result Type</label>
            <?php
            $result_type_id = (isset($profileEducation) ? $profileEducation->result_type_id : null);
            ?>
            {!! Form::select('result_type_id', [''=>'Select Result Type']+$resultTypes, $result_type_id, array('class'=>'form-control', 'id'=>'result_type_id')) !!}
            <span class="help-block result_type_id-error"></span> </div>

    </div>
</div>