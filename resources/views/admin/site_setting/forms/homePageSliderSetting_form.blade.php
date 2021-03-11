{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <fieldset>
        <legend>Home Page Slider:</legend>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_slider_active') !!}">
            {!! Form::label('is_slider_active', 'Is Home Page Slider active?', ['class' => 'bold']) !!}
            <div class="radio-list">
                <label class="radio-inline">{!! Form::radio('is_slider_active', 1, null, ['id' => 'is_slider_active_yes']) !!} Yes </label>
                <label class="radio-inline">{!! Form::radio('is_slider_active', 0, true, ['id' => 'is_slider_active_no']) !!} No </label>
            </div>
            {!! APFrmErrHelp::showErrors($errors, 'is_slider_active') !!}
        </div>        
    </fieldset>

</div>
