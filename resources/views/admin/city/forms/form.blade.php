<?php
$lang = config('default_lang');
if (isset($city))
    $lang = $city->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'lang') !!}" id="lang_div">
        {!! Form::label('lang', 'Language', ['class' => 'bold']) !!}                    
        {!! Form::select('lang', ['' => 'Select Language']+$languages, $lang, array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'setLang(this.value);')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'lang') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}" id="country_id_div">
        {!! Form::label('country_id', 'Country', ['class' => 'bold']) !!}
        {!! Form::select('country_id', ['' => 'Select Country']+$countries, old('country_id', (isset($city))? $city->getState()->getCountry('country_id'):$siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'state_id') !!}" id="state_id_div">
        {!! Form::label('state_id', 'State', ['class' => 'bold']) !!}                    
        <span id="default_state_dd">
            {!! Form::select('state_id', ['' => 'Select State'], null, array('class'=>'form-control', 'id'=>'state_id')) !!}
        </span>
        {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'city') !!}">
        {!! Form::label('city', 'City', ['class' => 'bold']) !!}
        {!! Form::text('city', null, array('class'=>'form-control', 'id'=>'city', 'placeholder'=>'City', 'dir'=>$direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'city') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}">
        {!! Form::label('is_default', 'Is Default?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_default_1 = 'checked="checked"';
            $is_default_2 = '';
            if (old('is_default', ((isset($city)) ? $city->is_default : 1)) == 0) {
                $is_default_1 = '';
                $is_default_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}} onchange="showHideCityId();">
                Yes </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}} onchange="showHideCityId();">
                No </label>
        </div>			
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'city_id') !!}" id="city_id_div">
        {!! Form::label('city_id', 'Default City', ['class' => 'bold']) !!}                    
        <span id="default_cities_dd">
            {!! Form::select('city_id', ['' => 'Select Default City'], null, array('class'=>'form-control', 'id'=>'city_id')) !!}
        </span>
        {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Is Active?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_active_1 = 'checked="checked"';
            $is_active_2 = '';
            if (old('is_active', ((isset($city)) ? $city->is_active : 1)) == 0) {
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
<script type="text/javascript">
    $(document).ready(function(){
    $('#country_id').on('change', function (e) {
    e.preventDefault();
    filterDefaultStates(0);
    });
    $(document).on('change', '#state_id', function (e) {
    e.preventDefault();
    filterDefaultCities(0);
    });
    filterDefaultStates(<?php echo old('state_id', (isset($city))? $city->getState('id'):0); ?>);
    filterDefaultCities(<?php echo old('city_id', (isset($city))? $city->city_id:0) ; ?>);
    });
    function setLang(lang) {
    window.location.href = "<?php echo url(Request::url()) . $queryString; ?>" + lang;
    }
    function showHideCityId(){
    $('#city_id_div').hide();
    var is_default = $("input[name='is_default']:checked").val();
    if (is_default == 0){
    $('#city_id_div').show();
    }
    }
    showHideCityId();
    function filterDefaultStates(state_id)
    {
    var country_id = $('#country_id').val();
    if (country_id != ''){
    $.post("{{ route('filter.default.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#default_state_dd').html(response);
            });
    }
    }

    function filterDefaultCities(city_id)
    {
    var state_id = $('#state_id').val();
    if (state_id != ''){
    $.post("{{ route('filter.default.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            $('#default_cities_dd').html(response);
            });
    }
    }

</script>
@endpush