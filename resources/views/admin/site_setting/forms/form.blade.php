{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'image') !!}">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"> <img src="{{ asset('/') }}admin_assets/no-image.png" alt="" /> </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                    <div> <span class="btn default btn-file"> <span class="fileinput-new"> Site Logo </span> <span class="fileinput-exists"> Change </span> {!! Form::file('image', null, array('id'=>'image')) !!} </span> <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a> </div>
                </div>
                {!! APFrmErrHelp::showErrors($errors, 'image') !!} </div>
        </div>
        @if(isset($siteSetting))
        <div class="col-md-6">
            {{ ImgUploader::print_image("sitesetting_images/thumb/$siteSetting->site_logo") }}        
        </div>    
        @endif  
    </div>
    
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'favicon') !!}">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"> <img src="{{ asset('/') }}admin_assets/no-image.png" alt="" /> </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 16px; max-height: 16px;"> </div>
                    <div> <span class="btn default btn-file"> <span class="fileinput-new"> Favicon </span> <span class="fileinput-exists"> Change </span> {!! Form::file('favicon', null, array('id'=>'favicon')) !!} </span> <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a> </div>
                </div>
                <span id="name-error" class="help-block help-block-error">The favicon must be a file of type/extension ".ico"</span>
            </div>
        </div>
        @if(isset($siteSetting))
        <div class="col-md-6">
            {{ ImgUploader::print_image("favicon.ico") }}        
        </div>    
        @endif  
    </div>
    
    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'site_name') !!}">
        {!! Form::label('site_name', 'Site Name', ['class' => 'bold']) !!}                    
        {!! Form::text('site_name', null, array('class'=>'form-control', 'id'=>'site_name', 'placeholder'=>'Site Name')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'site_name') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'site_slogan') !!}">
        {!! Form::label('site_slogan', 'Site Slogan', ['class' => 'bold']) !!}                    
        {!! Form::text('site_slogan', null, array('class'=>'form-control', 'id'=>'site_slogan', 'placeholder'=>'Site Slogan')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'site_slogan') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'site_phone_primary') !!}">
        {!! Form::label('site_phone_primary', 'Primary Phone#', ['class' => 'bold']) !!}                    
        {!! Form::text('site_phone_primary', null, array('class'=>'form-control', 'id'=>'site_phone_primary', 'placeholder'=>'Primary Phone#')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'site_phone_primary') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'site_phone_secondary') !!}">
        {!! Form::label('site_phone_secondary', 'Secondary Phone#', ['class' => 'bold']) !!}                    
        {!! Form::text('site_phone_secondary', null, array('class'=>'form-control', 'id'=>'site_phone_secondary', 'placeholder'=>'Secondary Phone#')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'site_phone_secondary') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_from_address') !!}">
        {!! Form::label('mail_from_address', 'From Email Address', ['class' => 'bold']) !!}                    
        {!! Form::text('mail_from_address', null, array('class'=>'form-control', 'id'=>'mail_from_address', 'placeholder'=>'From Email Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mail_from_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_from_name') !!}">
        {!! Form::label('mail_from_name', 'From Email Name', ['class' => 'bold']) !!}                    
        {!! Form::text('mail_from_name', null, array('class'=>'form-control', 'id'=>'mail_from_name', 'placeholder'=>'From Email Name')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mail_from_name') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_to_address') !!}">
        {!! Form::label('mail_to_address', 'To Email Address', ['class' => 'bold']) !!}                    
        {!! Form::text('mail_to_address', null, array('class'=>'form-control', 'id'=>'mail_to_address', 'placeholder'=>'To Email Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mail_to_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_to_name') !!}">
        {!! Form::label('mail_to_name', 'To Email Name', ['class' => 'bold']) !!}                    
        {!! Form::text('mail_to_name', null, array('class'=>'form-control', 'id'=>'mail_to_name', 'placeholder'=>'To Email Name')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mail_to_name') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'default_country_id') !!}">
        {!! Form::label('default_country_id', 'Default Country', ['class' => 'bold']) !!}                    
        {!! Form::select('default_country_id',$countries, null, array('class'=>'form-control', 'id'=>'default_country_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'default_country_id') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_specific_site') !!}">
        {!! Form::label('country_specific_site', 'Make site specific to this Country?', ['class' => 'bold']) !!}        <div class="radio-list">
            <label class="radio-inline">{!! Form::radio('country_specific_site', 1, true, ['id' => 'country_specific_site_yes']) !!} Yes </label>
            <label class="radio-inline">{!! Form::radio('country_specific_site', 0, null, ['id' => 'country_specific_site_no']) !!} No </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'country_specific_site') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'default_currency_code') !!}">
        {!! Form::label('default_currency_code', 'Default Currency Code', ['class' => 'bold']) !!}                    
        {!! Form::select('default_currency_code',$currency_codes, null, array('class'=>'form-control', 'id'=>'default_currency_code')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'default_currency_code') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'site_street_address') !!}">
        {!! Form::label('site_street_address', 'Street Address', ['class' => 'bold']) !!}                    
        {!! Form::textarea('site_street_address', null, array('class'=>'form-control', 'id'=>'site_street_address', 'placeholder'=>'Street Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'site_street_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'site_google_map') !!}">
        {!! Form::label('site_google_map', 'Site Google Map', ['class' => 'bold']) !!}                    
        {!! Form::textarea('site_google_map', null, array('class'=>'form-control', 'id'=>'site_google_map', 'placeholder'=>'Site Google Map')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'site_google_map') !!}                                       
    </div>
</div>
