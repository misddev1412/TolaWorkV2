{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}">
        {!! Form::label('country_id', 'Country', ['class' => 'bold']) !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'sort_name') !!}">
        {!! Form::label('sort_name', 'Sort Name', ['class' => 'bold']) !!}
        {!! Form::text('sort_name', null, array('class'=>'form-control', 'id'=>'sort_name', 'placeholder'=>'Sort Name')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'sort_name') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'phone_code') !!}">
        {!! Form::label('phone_code', 'Phone Code', ['class' => 'bold']) !!}
        {!! Form::text('phone_code', null, array('class'=>'form-control', 'id'=>'phone_code', 'placeholder'=>'Phone Code')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'phone_code') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'currency') !!}">
        {!! Form::label('currency', 'Currency', ['class' => 'bold']) !!}
        {!! Form::text('currency', null, array('class'=>'form-control', 'id'=>'currency', 'placeholder'=>'Currency')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'currency') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'code') !!}">
        {!! Form::label('code', 'Code', ['class' => 'bold']) !!}
        {!! Form::text('code', null, array('class'=>'form-control', 'id'=>'code', 'placeholder'=>'Code')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'code') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'symbol') !!}">
        {!! Form::label('symbol', 'Symbol', ['class' => 'bold']) !!}
        {!! Form::text('symbol', null, array('class'=>'form-control', 'id'=>'symbol', 'placeholder'=>'Symbol')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'symbol') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'thousand_separator') !!}">
        {!! Form::label('thousand_separator', 'Thousand Separator', ['class' => 'bold']) !!}
        {!! Form::text('thousand_separator', null, array('class'=>'form-control', 'id'=>'thousand_separator', 'placeholder'=>'Thousand Separator')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'thousand_separator') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'decimal_separator') !!}">
        {!! Form::label('decimal_separator', 'Decimal Separator', ['class' => 'bold']) !!}
        {!! Form::text('decimal_separator', null, array('class'=>'form-control', 'id'=>'decimal_separator', 'placeholder'=>'Decimal Separator')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'decimal_separator') !!}
    </div>	
    <div class="form-actions">
        {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}
    </div>
</div>
