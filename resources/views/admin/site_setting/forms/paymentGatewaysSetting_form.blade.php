{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <fieldset>
        <legend>PayPal:</legend>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'paypal_account') !!}">
            {!! Form::label('paypal_account', 'Paypal account', ['class' => 'bold']) !!}                    
            {!! Form::text('paypal_account', null, array('class'=>'form-control', 'id'=>'paypal_account', 'placeholder'=>'paypal account')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'paypal_account') !!}                                       
        </div>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'paypal_client_id') !!}">
            {!! Form::label('paypal_client_id', 'Paypal client_id', ['class' => 'bold']) !!}                    
            {!! Form::text('paypal_client_id', null, array('class'=>'form-control', 'id'=>'paypal_client_id', 'placeholder'=>'paypal client_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'paypal_client_id') !!}                                       
        </div>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'paypal_secret') !!}">
            {!! Form::label('paypal_secret', 'Paypal secret', ['class' => 'bold']) !!}                    
            {!! Form::text('paypal_secret', null, array('class'=>'form-control', 'id'=>'paypal_secret', 'placeholder'=>'paypal secret')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'paypal_secret') !!}                                       
        </div>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'paypal_live_sandbox') !!}">
            {!! Form::label('paypal_live_sandbox', 'Is Sandbox?', ['class' => 'bold']) !!}
            <div class="radio-list">
                <?php
                $radio_1 = 'checked="checked"';
                $radio_2 = '';
                if (old('paypal_live_sandbox', ((isset($settings)) ? $settings->paypal_live_sandbox : 'sandbox')) == 'live') {
                    $radio_1 = '';
                    $radio_2 = 'checked="checked"';
                }
                ?>
                <label class="radio-inline">
                    <input id="paypal_sandbox" name="paypal_live_sandbox" type="radio" value="sandbox" {{$radio_1}}>
                    Sandbox </label>
                <label class="radio-inline">
                    <input id="paypal_live" name="paypal_live_sandbox" type="radio" value="live" {{$radio_2}}>
                    Live </label>
            </div>
            {!! APFrmErrHelp::showErrors($errors, 'paypal_live_sandbox') !!}
        </div>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_paypal_active') !!}">
            {!! Form::label('is_paypal_active', 'Is Paypal active?', ['class' => 'bold']) !!}
            <div class="radio-list">
                <label class="radio-inline">{!! Form::radio('is_paypal_active', 1, true, ['id' => 'is_paypal_active_yes']) !!} Yes </label>
                <label class="radio-inline">{!! Form::radio('is_paypal_active', 0, null, ['id' => 'is_paypal_active_no']) !!} No </label>
            </div>
            {!! APFrmErrHelp::showErrors($errors, 'is_paypal_active') !!}
        </div>
        </fieldset>
        <fieldset>
        <legend>Stripe:</legend>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'stripe_key') !!}">
            {!! Form::label('stripe_key', 'Stripe Publishable Key', ['class' => 'bold']) !!}                    
            {!! Form::text('stripe_key', null, array('class'=>'form-control', 'id'=>'stripe_key', 'placeholder'=>'Stripe Publishable Key')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'stripe_key') !!}                                       
        </div>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'stripe_secret') !!}">
            {!! Form::label('stripe_secret', 'Stripe Secret', ['class' => 'bold']) !!}                    
            {!! Form::text('stripe_secret', null, array('class'=>'form-control', 'id'=>'stripe_secret', 'placeholder'=>'Stripe Secret')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'stripe_secret') !!}                                       
        </div>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_stripe_active') !!}">
            {!! Form::label('is_stripe_active', 'Is Stripe active?', ['class' => 'bold']) !!}
            <div class="radio-list">
                <label class="radio-inline">{!! Form::radio('is_stripe_active', 1, true, ['id' => 'is_stripe_active_yes']) !!} Yes </label>
                <label class="radio-inline">{!! Form::radio('is_stripe_active', 0, null, ['id' => 'is_stripe_active_no']) !!} No </label>
            </div>
            {!! APFrmErrHelp::showErrors($errors, 'is_stripe_active') !!}
        </div>
    </fieldset>
    <fieldset>
    <legend>Job Seeker Packages:</legend>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_jobseeker_package_active') !!}">
            {!! Form::label('is_jobseeker_package_active', 'Is Package active for job seaker?', ['class' => 'bold']) !!}
            <div class="radio-list">
                <label class="radio-inline">{!! Form::radio('is_jobseeker_package_active', 1, null, ['id' => 'is_jobseeker_package_active_yes']) !!} Yes </label>
                <label class="radio-inline">{!! Form::radio('is_jobseeker_package_active', 0, true, ['id' => 'is_jobseeker_package_active_no']) !!} No </label>
            </div>
            {!! APFrmErrHelp::showErrors($errors, 'is_jobseeker_package_active') !!}
        </div>        
    </fieldset>
    
</div>

