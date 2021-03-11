<?php
$lang = config('default_lang');
if (isset($careerLevel))
    $lang = $careerLevel->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'lang') !!}"> {!! Form::label('lang', 'Language', ['class' => 'bold']) !!}                    
        {!! Form::select('lang', ['' => 'Select Language']+$languages, $lang, array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'setLang(this.value)')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'lang') !!} </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'career_level') !!}"> {!! Form::label('career_level', 'Career Level', ['class' => 'bold']) !!}                    
        {!! Form::text('career_level', null, array('class'=>'form-control', 'id'=>'career_level', 'placeholder'=>'Career Level', 'dir'=>$direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'career_level') !!} </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}"> {!! Form::label('is_default', 'Is Default?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_default_1 = 'checked="checked"';
            $is_default_2 = '';
            if (old('is_default', ((isset($careerLevel)) ? $careerLevel->is_default : 1)) == 0) {
                $is_default_1 = '';
                $is_default_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}} onchange="showHideCareerLevelId();">
                Yes </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}} onchange="showHideCareerLevelId();">
                No </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!} </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'career_level_id') !!}" id="career_level_id_div"> {!! Form::label('career_level_id', 'Default Career Level', ['class' => 'bold']) !!}                    
        {!! Form::select('career_level_id', ['' => 'Select Default Career Level']+$careerLevels, null, array('id'=>'career_level_id', 'class'=>'form-control')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!} </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}"> {!! Form::label('is_active', 'Active', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_active_1 = 'checked="checked"';
            $is_active_2 = '';
            if (old('is_active', ((isset($careerLevel)) ? $careerLevel->is_active : 1)) == 0) {
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
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!} </div>
    <div class="form-actions"> {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!} </div>
</div>
@push('scripts') 
<script type="text/javascript">
    function setLang(lang) {
        window.location.href = "<?php echo url(Request::url()) . $queryString; ?>" + lang;
    }
    function showHideCareerLevelId() {
        $('#career_level_id_div').hide();
        var is_default = $("input[name='is_default']:checked").val();
        if (is_default == 0) {
            $('#career_level_id_div').show();
        }
    }
    showHideCareerLevelId();
</script> 
@endpush