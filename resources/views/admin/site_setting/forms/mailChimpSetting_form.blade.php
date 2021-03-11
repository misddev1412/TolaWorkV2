{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mailchimp_api_key') !!}">
        {!! Form::label('mailchimp_api_key', 'MailChimp API Key', ['class' => 'bold']) !!}                    
        {!! Form::textarea('mailchimp_api_key', null, array('class'=>'form-control', 'id'=>'mailchimp_api_key', 'placeholder'=>'MailChimp API Key')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mailchimp_api_key') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mailchimp_list_name') !!}">
        {!! Form::label('mailchimp_list_name', 'MailChimp List Name', ['class' => 'bold']) !!}                    
        {!! Form::textarea('mailchimp_list_name', null, array('class'=>'form-control', 'id'=>'mailchimp_list_name', 'placeholder'=>'MailChimp List Name')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mailchimp_list_name') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mailchimp_list_id') !!}">
        {!! Form::label('mailchimp_list_id', 'MailChimp List ID', ['class' => 'bold']) !!}                    
        {!! Form::textarea('mailchimp_list_id', null, array('class'=>'form-control', 'id'=>'mailchimp_list_id', 'placeholder'=>'MailChimp List ID')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mailchimp_list_id') !!}                                       
    </div>    
</div>
