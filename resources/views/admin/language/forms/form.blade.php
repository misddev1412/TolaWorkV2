<?php
$lang = 'en';
if (isset($language))
    $lang = $language->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'lang') !!}">
        {!! Form::label('lang', 'Language', ['class' => 'bold']) !!}
        {!! Form::text('lang', null, array('class'=>'form-control', 'id'=>'lang', 'placeholder'=>'Language')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'lang') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'native') !!}">
        {!! Form::label('native', 'Native', ['class' => 'bold']) !!}
        {!! Form::text('native', null, array('class'=>'form-control', 'id'=>'native', 'placeholder'=>'Native')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'native') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'iso_code') !!}">
        {!! Form::label('iso_code', 'ISO Code', ['class' => 'bold']) !!}
        {!! Form::text('iso_code', null, array('class'=>'form-control', 'id'=>'iso_code', 'placeholder'=>'ISO Code')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'iso_code') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Is Active?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_active_1 = 'checked="checked"';
            $is_active_2 = '';
            if (old('is_active', ((isset($language)) ? $language->is_active : 1)) == 0) {
                $is_active_1 = '';
                $is_active_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="active" name="is_active" type="radio" value="1" {{$is_active_1}}>
                Active </label>
            <label class="radio-inline">
                <input id="not_active" name="is_active" type="radio" value="0" {{$is_active_2}}>
                In-Active </label>
        </div>			
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_rtl') !!}">
        {!! Form::label('is_rtl', 'Is RTL?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $radio_1 = 'checked="checked"';
            $radio_2 = '';
            if (old('is_rtl', ((isset($language)) ? $language->is_rtl : 1)) == 0) {
                $radio_1 = '';
                $radio_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="is_rtl" name="is_rtl" type="radio" value="1" {{$radio_1}}>
                Yes </label>
            <label class="radio-inline">
                <input id="is_not_rtl" name="is_rtl" type="radio" value="0" {{$radio_2}}>
                No </label>
        </div>			
        {!! APFrmErrHelp::showErrors($errors, 'is_rtl') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}">
        {!! Form::label('is_default', 'Is default?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_default_1 = 'checked="checked"';
            $is_default_2 = '';
            if (old('is_default', ((isset($language)) ? $language->is_default : 1)) == 0) {
                $is_default_1 = '';
                $is_default_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}}>
                Yes </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}}>
                No </label>
        </div>			
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!}
    </div>	
    <div class="form-actions">
        {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    function setLang(lang) {
        window.location.href = "<?php echo url(Request::url()) . $queryString; ?>" + lang;
    }
    function showHideLanguageId() {
        $('#language_id_div').hide();
        var is_default = $("input[name='is_default']:checked").val();
        if (is_default == 0) {
            $('#language_id_div').show();
        }
    }
    showHideLanguageId();
</script>
@endpush