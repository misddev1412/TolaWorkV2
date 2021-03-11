{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_driver') !!}">
        {!! Form::label('mail_driver', 'Mail Driver', ['class' => 'bold']) !!}                    
        {!! Form::select('mail_driver',$mail_drivers, null, array('class'=>'form-control', 'id'=>'mail_driver')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mail_driver') !!}                                       
    </div>
    <br>
    <fieldset>
        <legend>SMTP Settings:</legend>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_host') !!}">
            {!! Form::label('mail_host', 'Mail Host', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_host', null, array('class'=>'form-control', 'id'=>'mail_host', 'placeholder'=>'Mail Host')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_host') !!}                                       
        </div>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_port') !!}">
            {!! Form::label('mail_port', 'Mail Port', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_port', null, array('class'=>'form-control', 'id'=>'mail_port', 'placeholder'=>'Mail Port')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_port') !!}                                       
        </div>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_encryption') !!}">
            {!! Form::label('mail_encryption', 'Mail Encryption', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_encryption', null, array('class'=>'form-control', 'id'=>'mail_encryption', 'placeholder'=>'Mail Encryption')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_encryption') !!}                                       
        </div>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_username') !!}">
            {!! Form::label('mail_username', 'Mail Username', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_username', null, array('class'=>'form-control', 'id'=>'mail_username', 'placeholder'=>'Mail Username')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_username') !!}                                       
        </div>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_password') !!}">
            {!! Form::label('mail_password', 'Mail Password', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_password', null, array('class'=>'form-control', 'id'=>'mail_password', 'placeholder'=>'Mail Password')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_password') !!}                                       
        </div>
    </fieldset>
    <br> 
    <fieldset>
        <legend>SendMail - Pretend Settings:</legend>     
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_sendmail') !!}">
            {!! Form::label('mail_sendmail', 'Mail Sendmail', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_sendmail', null, array('class'=>'form-control', 'id'=>'mail_sendmail', 'placeholder'=>'Mail Sendmail')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_sendmail') !!}                                       
        </div>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_pretend') !!}">
            {!! Form::label('mail_pretend', 'Mail Pretend', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_pretend', null, array('class'=>'form-control', 'id'=>'mail_pretend', 'placeholder'=>'Mail Pretend')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_pretend') !!}                                       
        </div>
    </fieldset>    
    <br>
    <fieldset>
        <legend>MailGun Settings:</legend>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mailgun_domain') !!}">
            {!! Form::label('mailgun_domain', 'Mailgun Domain', ['class' => 'bold']) !!}                    
            {!! Form::text('mailgun_domain', null, array('class'=>'form-control', 'id'=>'mailgun_domain', 'placeholder'=>'Mailgun Domain')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mailgun_domain') !!}                                       
        </div>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mailgun_secret') !!}">
            {!! Form::label('mailgun_secret', 'Mailgun Secret', ['class' => 'bold']) !!}                    
            {!! Form::text('mailgun_secret', null, array('class'=>'form-control', 'id'=>'mailgun_secret', 'placeholder'=>'Mailgun Secret')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mailgun_secret') !!}                                       
        </div>
    </fieldset>
    <br>
    <fieldset>
        <legend>Mandrill Settings:</legend>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mandrill_secret') !!}">
            {!! Form::label('mandrill_secret', 'Mandrill Secret', ['class' => 'bold']) !!}                    
            {!! Form::text('mandrill_secret', null, array('class'=>'form-control', 'id'=>'mandrill_secret', 'placeholder'=>'Mandrill Secret')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mandrill_secret') !!}                                       
        </div>
    </fieldset>
    <br>
    <fieldset>
        <legend>Sparkpost Settings:</legend>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'sparkpost_secret') !!}">
            {!! Form::label('sparkpost_secret', 'Sparkpost Secret', ['class' => 'bold']) !!}                    
            {!! Form::text('sparkpost_secret', null, array('class'=>'form-control', 'id'=>'sparkpost_secret', 'placeholder'=>'Sparkpost Secret')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'sparkpost_secret') !!}                                       
        </div>
    </fieldset>
    <br>
    <fieldset>
        <legend>AMAZON SES Settings:</legend>        
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'ses_key') !!}">
            {!! Form::label('ses_key', 'SES Key', ['class' => 'bold']) !!}                    
            {!! Form::text('ses_key', null, array('class'=>'form-control', 'id'=>'ses_key', 'placeholder'=>'SES Key')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'ses_key') !!}                                       
        </div>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'ses_secret') !!}">
            {!! Form::label('ses_secret', 'SES Secret', ['class' => 'bold']) !!}                    
            {!! Form::text('ses_secret', null, array('class'=>'form-control', 'id'=>'ses_secret', 'placeholder'=>'SES Secret')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'ses_secret') !!}                                       
        </div>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'ses_region') !!}">
            {!! Form::label('ses_region', 'SES Region', ['class' => 'bold']) !!}                    
            {!! Form::text('ses_region', null, array('class'=>'form-control', 'id'=>'ses_region', 'placeholder'=>'SES Region')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'ses_region') !!}                                       
        </div>
    </fieldset>   
</div>
