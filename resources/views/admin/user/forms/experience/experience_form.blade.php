<div class="modal-body">
    <div class="form-body">
        <div class="form-group" id="div_title">
            <label for="title" class="bold">Experience Title</label>
            <input class="form-control" id="title" placeholder="Experience Title" name="title" type="text" value="{{(isset($profileExperience)? $profileExperience->title:'')}}">
            <span class="help-block title-error"></span> </div>

        <div class="form-group" id="div_company">
            <label for="company" class="bold">Company</label>
            <input class="form-control" id="company" placeholder="Company" name="company" type="text" value="{{(isset($profileExperience)? $profileExperience->company:'')}}">
            <span class="help-block company-error"></span> </div>

        <div class="form-group" id="div_country_id">
            <label for="country_id" class="bold">Country</label>
            <?php
            $country_id = (isset($profileExperience) ? $profileExperience->country_id : $siteSetting->default_country_id);
            ?>
            {!! Form::select('country_id', [''=>'Select Country']+$countries, $country_id, array('class'=>'form-control', 'id'=>'experience_country_id')) !!}
            <span class="help-block country_id-error"></span> </div>

        <div class="form-group" id="div_state_id">
            <label for="state_id" class="bold">State</label>
            <span id="default_state_experience_dd">
                {!! Form::select('state_id', [''=>'Select State'], null, array('class'=>'form-control', 'id'=>'experience_state_id')) !!}
            </span>
            <span class="help-block state_id-error"></span> </div>

        <div class="form-group" id="div_city_id">
            <label for="city_id" class="bold">City</label>
            <span id="default_city_experience_dd">
                {!! Form::select('city_id', [''=>'Select City'], null, array('class'=>'form-control', 'id'=>'city_id')) !!}
            </span>
            <span class="help-block city_id-error"></span> </div>

        <div class="form-group" id="div_date_start">
            <label for="date_start" class="bold">Experience Start Date</label>
            <input class="form-control datepicker"  autocomplete="off" id="date_start" placeholder="Experience Start Date" name="date_start" type="text" value="{{(isset($profileExperience)? $profileExperience->date_start->format('Y-m-d'):'')}}">
            <span class="help-block date_start-error"></span> </div>
        <div class="form-group" id="div_date_end">
            <label for="date_end" class="bold">Experience End Date</label>
            <input class="form-control datepicker" autocomplete="off" id="date_end" placeholder="Experience End Date" name="date_end" type="text" value="{{(isset($profileExperience)? $profileExperience->date_end->format('Y-m-d'):'')}}">
            <span class="help-block date_end-error"></span> </div>
        <div class="form-group" id="div_is_currently_working">
            <label for="is_currently_working" class="bold">Currently Working?</label>
            <div class="radio-list" style="margin-left:22px;">
                <?php
                $val_1_checked = '';
                $val_2_checked = 'checked="checked"';

                if (isset($profileExperience) && $profileExperience->is_currently_working == 1) {
                    $val_1_checked = 'checked="checked"';
                    $val_2_checked = '';
                }
                ?>
                <label class="radio-inline"><input id="currently_working" name="is_currently_working" type="radio" value="1" {{$val_1_checked}}> Yes </label>
                <label class="radio-inline"><input id="not_currently_working" name="is_currently_working" type="radio" value="0" {{$val_2_checked}}> No </label>
            </div>
            <span class="help-block is_currently_working-error"></span>
        </div>
        <div class="form-group" id="div_description">
            <label for="name" class="bold">Experience Description</label>
            <textarea name="description" class="form-control" id="description" placeholder="Experience description">{{(isset($profileExperience)? $profileExperience->description:'')}}</textarea>
            <span class="help-block description-error"></span> </div>
    </div>
</div>
