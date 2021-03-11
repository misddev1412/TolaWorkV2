{!! APFrmErrHelp::showErrorsNotice($errors) !!}
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'seo_title') !!}">
        {!! Form::label('seo_title', 'SEO Title', ['class' => 'bold']) !!}                    
        {!! Form::text('seo_title', null, array('class'=>'form-control', 'id'=>'seo_title', 'placeholder'=>'SEO Title')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'seo_title') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'seo_description') !!}">
        {!! Form::label('seo_description', 'SEO Description', ['class' => 'bold']) !!}                    
        {!! Form::textarea('seo_description', null, array('class'=>'form-control', 'id'=>'seo_description', 'placeholder'=>'SEO Description')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'seo_description') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'seo_keywords') !!}">
        {!! Form::label('seo_keywords', 'SEO Keywords', ['class' => 'bold']) !!}                    
        {!! Form::textarea('seo_keywords', null, array('class'=>'form-control', 'id'=>'seo_keywords', 'placeholder'=>'SEO Keywords')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'seo_keywords') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'seo_other') !!}">
        {!! Form::label('seo_other', 'Other SEO Tags', ['class' => 'bold']) !!}                    
        {!! Form::textarea('seo_other', null, array('class'=>'form-control', 'id'=>'seo_other', 'placeholder'=>'Other SEO Tags')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'seo_other') !!}                                       
    </div>
</div>