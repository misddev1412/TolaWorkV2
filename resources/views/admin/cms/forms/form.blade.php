{!! APFrmErrHelp::showErrorsNotice($errors) !!}
<div class="form-body">	
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'page_slug') !!}">
        {!! Form::label('page_slug', 'Page Slug', ['class' => 'bold']) !!}                    
        {!! Form::text('page_slug', null, array('class'=>'form-control', 'id'=>'page_slug', 'placeholder'=>'Page Slug')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'page_slug') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'show_in_top_menu') !!}">
        {!! Form::label('show_in_top_menu', 'Show in top Menu', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $radio_1 = 'checked="checked"';
            $radio_2 = '';
            if (old('show_in_top_menu', ((isset($cms)) ? $cms->show_in_top_menu : 1)) == 0) {
                $radio_1 = '';
                $radio_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="show_in_top_menu" name="show_in_top_menu" type="radio" value="1" {{$radio_1}}>
                Yes </label>
            <label class="radio-inline">
                <input id="not_show_in_top_menu" name="show_in_top_menu" type="radio" value="0" {{$radio_2}}>
                No </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'show_in_top_menu') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'show_in_footer_menu') !!}">
        {!! Form::label('show_in_footer_menu', 'Show in footer Menu', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $radio_1 = 'checked="checked"';
            $radio_2 = '';
            if (old('show_in_footer_menu', ((isset($cms)) ? $cms->show_in_footer_menu : 1)) == 0) {
                $radio_1 = '';
                $radio_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="show_in_footer_menu" name="show_in_footer_menu" type="radio" value="1" {{$radio_1}}>
                Yes </label>
            <label class="radio-inline">
                <input id="not_show_in_footer_menu" name="show_in_footer_menu" type="radio" value="0" {{$radio_2}}>
                No </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'show_in_footer_menu') !!}
    </div>
</div>