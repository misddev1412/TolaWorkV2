<div class="searchwrap">

  <div class="container">

    <h3>{{__('One million success stories')}}. <span>{{__('Start yours today')}}.</span></h3>

    

    @if(Auth::guard('company')->check())

    <form action="{{route('job.seeker.list')}}" method="get">

    <div class="searchbar row">

      <div class="col-md-{{((bool)$siteSetting->country_specific_site)? 12:8}}">

        <input type="text"  name="search" value="{{Request::get('search', '')}}" class="form-control" placeholder="{{__('Enter Skills or Job Seeker Details')}}" />

      </div>

      <div class="col-md-4">

        {!! Form::select('functional_area_id[]', ['' => __('Select Functional Area')]+$functionalAreas, Request::get('functional_area_id', null), array('class'=>'form-control', 'id'=>'functional_area_id')) !!}

      </div>

      

      @if((bool)$siteSetting->country_specific_site)

      {!! Form::hidden('country_id[]', Request::get('country_id[]', $siteSetting->default_country_id), array('id'=>'country_id')) !!}

      @else

      <div class="col-md-4">

      {!! Form::select('country_id[]', ['' => __('Select Country')]+$countries, Request::get('country_id', $siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}

      </div>

      @endif

      

      <div class="col-md-3">

      <span id="state_dd">

      {!! Form::select('state_id[]', ['' => __('Select State')], Request::get('state_id', null), array('class'=>'form-control', 'id'=>'state_id')) !!}

      </span>

      </div>

      <div class="col-md-3">

      <span id="city_dd">

      {!! Form::select('city_id[]', ['' => __('Select City')], Request::get('city_id', null), array('class'=>'form-control', 'id'=>'city_id')) !!}

      </span>

      </div>

      <div class="col-md-2">

        <input type="submit" class="btn" value="{{__('Search Job Seeker')}}">

      </div>

    </div>

    </form>

    @else

    <form action="{{route('job.list')}}" method="get">

    <div class="searchbar row">

      <div class="col-md-{{((bool)$siteSetting->country_specific_site)? 12:8}}">

        <input type="text"  name="search" value="{{Request::get('search', '')}}" class="form-control" placeholder="{{__('Enter Skills or job title')}}" />

      </div>

      <div class="col-md-4">

        {!! Form::select('functional_area_id[]', ['' => __('Select Functional Area')]+$functionalAreas, Request::get('functional_area_id', null), array('class'=>'form-control', 'id'=>'functional_area_id')) !!}

      </div>

      

      @if((bool)$siteSetting->country_specific_site)

      {!! Form::hidden('country_id[]', Request::get('country_id[]', $siteSetting->default_country_id), array('id'=>'country_id')) !!}

      @else

      <div class="col-md-4">

      {!! Form::select('country_id[]', ['' => __('Select Country')]+$countries, Request::get('country_id', $siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}

      </div>

      @endif

      

      <div class="col-md-3">

      <span id="state_dd">

      {!! Form::select('state_id[]', ['' => __('Select State')], Request::get('state_id', null), array('class'=>'form-control', 'id'=>'state_id')) !!}

      </span>

      </div>

      <div class="col-md-3">

      <span id="city_dd">

      {!! Form::select('city_id[]', ['' => __('Select City')], Request::get('city_id', null), array('class'=>'form-control', 'id'=>'city_id')) !!}

      </span>

      </div>

      <div class="col-md-2">

        <input type="submit" class="btn" value="{{__('Search Job')}}">

      </div>

    </div>

    </form>

    @endif

    

    <!-- button start 

    <div class="getstarted"><a href="{{url('/')}}"><i class="fa fa-user" aria-hidden="true"></i> {{__('Get Started Now')}}</a></div>

    button end --> 

    

  </div>

</div>