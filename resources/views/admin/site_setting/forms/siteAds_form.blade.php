{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'index_page_below_top_employes_ad') !!}">
        {!! Form::label('index_page_below_top_employes_ad', 'Index Page Below Top Employes', ['class' => 'bold']) !!}                    
        {!! Form::textarea('index_page_below_top_employes_ad', null, array('class'=>'form-control', 'id'=>'index_page_below_top_employes_ad', 'placeholder'=>'Index Page Below Top Employes')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'index_page_below_top_employes_ad') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'above_footer_ad') !!}">
        {!! Form::label('above_footer_ad', 'Index Page Below Cities', ['class' => 'bold']) !!}                    
        {!! Form::textarea('above_footer_ad', null, array('class'=>'form-control', 'id'=>'above_footer_ad', 'placeholder'=>'Index Page Below Cities')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'above_footer_ad') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'dashboard_page_ad') !!}">
        {!! Form::label('dashboard_page_ad', 'Dashboard Below Menu Verticle Ad', ['class' => 'bold']) !!}                    
        {!! Form::textarea('dashboard_page_ad', null, array('class'=>'form-control', 'id'=>'dashboard_page_ad', 'placeholder'=>'Dashboard Below Menu Verticle Ad')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'dashboard_page_ad') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'cms_page_ad') !!}">
        {!! Form::label('cms_page_ad', 'CMS Page Below Content Ad', ['class' => 'bold']) !!}                    
        {!! Form::textarea('cms_page_ad', null, array('class'=>'form-control', 'id'=>'cms_page_ad', 'placeholder'=>'CMS Page Below Content Ad')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'cms_page_ad') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'listing_page_vertical_ad') !!}">
        {!! Form::label('listing_page_vertical_ad', 'Listing Page Sidebar Verticle Ad', ['class' => 'bold']) !!}                    
        {!! Form::textarea('listing_page_vertical_ad', null, array('class'=>'form-control', 'id'=>'listing_page_vertical_ad', 'placeholder'=>'Listing Page Sidebar Verticle Ad')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'listing_page_vertical_ad') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'listing_page_horizontal_ad') !!}">
        {!! Form::label('listing_page_horizontal_ad', 'Listing Page Below Listings Horizantal Ad', ['class' => 'bold']) !!}                    
        {!! Form::textarea('listing_page_horizontal_ad', null, array('class'=>'form-control', 'id'=>'listing_page_horizontal_ad', 'placeholder'=>'Listing Page Below Listings Horizantal Ad')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'listing_page_horizontal_ad') !!}                                       
    </div>
</div>
