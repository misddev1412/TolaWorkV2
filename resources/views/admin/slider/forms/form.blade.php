<?php
$lang = config('default_lang');
if (isset($slider))
    $lang = $slider->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'lang') !!}" id="lang_div">
        {!! Form::select('lang', ['' => 'Select Language']+$languages, $lang, ['class'=>'form-control', 'id'=>'lang', 'onchange'=>'setLang(this.value);']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'lang') !!}                                       
    </div>    
    
    @if(isset($slider))
    <div class="form-group">
        {{ ImgUploader::print_image("slider_images/thumb/$slider->slider_image") }}        
    </div>    
    @endif    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'slider_image') !!}">
        {!! Form::label('slider_image', 'Slider Image', ['class' => 'bold']) !!}
        {!! Form::File('slider_image', array('class'=>'form-control', 'id'=>'slider_image')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'slider_image') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'slider_heading') !!}">
        {!! Form::label('slider_heading', 'Slider heading', ['class' => 'bold']) !!}
        {!! Form::text('slider_heading', null, array('class'=>'form-control', 'id'=>'slider_heading', 'placeholder'=>'Slider heading', 'dir'=>$direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'slider_heading') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'slider_description') !!}">
        {!! Form::label('slider_description', 'Slider description', ['class' => 'bold']) !!}
        {!! Form::textarea('slider_description', null, array('class'=>'form-control', 'id'=>'slider_description', 'placeholder'=>'Slider description', 'dir'=>$direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'slider_description') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'slider_link') !!}">
        {!! Form::label('slider_link', 'Slider link', ['class' => 'bold']) !!}
        {!! Form::text('slider_link', null, array('class'=>'form-control', 'id'=>'slider_link', 'placeholder'=>'Slider link', 'dir'=>$direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'slider_link') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'slider_link_text') !!}">
        {!! Form::label('slider_link_text', 'Slider link text', ['class' => 'bold']) !!}
        {!! Form::text('slider_link_text', null, array('class'=>'form-control', 'id'=>'slider_link_text', 'placeholder'=>'Slider link text', 'dir'=>$direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'slider_link_text') !!}
    </div>        
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}">
        {!! Form::label('is_default', 'Is default?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_default_1 = 'checked="checked"';
            $is_default_2 = '';
            if (old('is_default', ((isset($slider)) ? $slider->is_default : 1)) == 0) {
                $is_default_1 = '';
                $is_default_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}} onchange="showHideSliderId();">
                Yes </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}} onchange="showHideSliderId();">
                No </label>
        </div>			
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'slider_id') !!}" id="slider_id_div">
        {!! Form::label('slider_id', 'Default Slider', ['class' => 'bold']) !!}                    
        {!! Form::select('slider_id', ['' => 'Select Default Slider']+$sliders, null, array('class'=>'form-control', 'id'=>'slider_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'slider_id') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Is Active?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_active_1 = 'checked="checked"';
            $is_active_2 = '';
            if (old('is_active', ((isset($slider)) ? $slider->is_active : 1)) == 0) {
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
    <div class="form-actions">
        {!! Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}
    </div>
</div>
@push('scripts')
@include('admin.shared.tinyMCE')
<script type="text/javascript">
    function setLang(lang) {
        window.location.href = "<?php echo url(Request::url()) . $queryString; ?>" + lang;
    }
    function showHideSliderId() {
        $('#slider_id_div').hide();
        var is_default = $("input[name='is_default']:checked").val();
        if (is_default == 0) {
            $('#slider_id_div').show();
        }
    }
    showHideSliderId();
</script>
@endpush