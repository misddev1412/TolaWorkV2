{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'facebook_app_id') !!}">
        {!! Form::label('facebook_app_id', 'Facebook App ID', ['class' => 'bold']) !!}                    
        {!! Form::text('facebook_app_id', null, array('class'=>'form-control', 'id'=>'facebook_app_id', 'placeholder'=>'Facebook App ID')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'facebook_app_id') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'facebeek_app_secret') !!}">
        {!! Form::label('facebeek_app_secret', 'Facebeek App Secret', ['class' => 'bold']) !!}                    
        {!! Form::text('facebeek_app_secret', null, array('class'=>'form-control', 'id'=>'facebeek_app_secret', 'placeholder'=>'Facebeek App Secret')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'facebeek_app_secret') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'twitter_app_id') !!}">
        {!! Form::label('twitter_app_id', 'Twitter App ID', ['class' => 'bold']) !!}                    
        {!! Form::text('twitter_app_id', null, array('class'=>'form-control', 'id'=>'twitter_app_id', 'placeholder'=>'Twitter App ID')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'twitter_app_id') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'twitter_app_secret') !!}">
        {!! Form::label('twitter_app_secret', 'Twitter App Secret', ['class' => 'bold']) !!}                    
        {!! Form::text('twitter_app_secret', null, array('class'=>'form-control', 'id'=>'twitter_app_secret', 'placeholder'=>'Twitter App Secret')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'twitter_app_secret') !!}                                       
    </div>
</div>
