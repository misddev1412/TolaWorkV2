@extends('layouts.app')

@section('content') 

<!-- Header start --> 

@include('includes.header') 

<!-- Header end --> 

<!-- Inner Page Title start --> 

@include('includes.inner_page_title', ['page_title'=>__('Pay with Stripe')]) 

<!-- Inner Page Title end -->

<div class="listpgWraper">

  <div class="container">

    <div class="row"> 
    @if(Auth::guard('company')->check())
    @include('includes.company_dashboard_menu')
    @else
    @include('includes.user_dashboard_menu')
    @endif
      <div class="col-md-9 col-sm-8">

        <div class="userccount">

          <div class="row">

            <div class="col-md-5">
<img src="{{asset('/')}}images/strip-logo.png" alt="" />
              <div class="strippckinfo">

                <h5>{{__('Invoice Details')}}</h5>

                <div class="pkginfo">{{__('Package')}}: <strong>{{ $package->package_title }}</strong></div>

                <div class="pkginfo">{{__('Price')}}: <strong>${{ $package->package_price }}</strong></div>

                
                @if(Auth::guard('company')->check())
                <div class="pkginfo">{{__('Can post jobs')}}: <strong>{{ $package->package_num_listings }}</strong></div>
                @else
                <div class="pkginfo">{{__('Can apply on jobs')}}: <strong>{{ $package->package_num_listings }}</strong></div>
                @endif

                <div class="pkginfo">{{__('Package Duration')}}: <strong>{{ $package->package_num_days }} {{__('Days')}}</strong></div>

              </div>
				
				
				
				
            </div>

            <div class="col-md-7">

              <div class="formpanel"> @include('flash::message')

                <h5>{{__('Strip - Credit Card Details')}}</h5>

                @php                

                $route = 'stripe.order.upgrade.package';                

                if($new_or_upgrade == 'new'){                

                $route = 'stripe.order.package';                

                }                

                @endphp                            

                {!! Form::open(array('method' => 'post', 'route' => $route, 'id' => 'stripe-form', 'class' => 'form')) !!}                

                {{ Form::hidden('package_id', $package_id) }}

                <div class="row">

                  <div class="col-md-12" id="error_div"></div>

                  <div class="col-md-12">

                    <div class="formrow">

                    <label>{{__('Name on Credit Card')}}</label>

                      <input class="form-control" id="card_name" placeholder="{{__('Name on Credit Card')}}" type="text">

                    </div>

                  </div>

                  <div class="col-md-12">

                    <div class="formrow">

                    <label>{{__('Credit card Number')}}</label>

                      <input class="form-control" id="card_no" placeholder="{{__('Credit card Number')}}" type="text">

                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class="formrow">

                    <label>{{__('Credit card Expiry Month')}}</label>                     

                    <select class="form-control" id="ccExpiryMonth">                    

                    @for ($counter = 1; $counter <= 12; $counter++)

                    @php

                    	$val = str_pad($counter, 2, '0', STR_PAD_LEFT);

                    @endphp

                    <option value="{{$val}}">{{$val}}</option>

                    @endfor

                    </select>                    

                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class="formrow">

                    <label>{{__('Credit card Expiry Year')}}</label>                    

                    <select class="form-control" id="ccExpiryYear">

                    @php

                    $ccYears = MiscHelper::getCcExpiryYears();

                    @endphp

                    @foreach($ccYears as $year)

                    <option value="{{$year}}">{{$year}}</option>

                    @endforeach

                    </select>                    

                    </div>

                  </div>                  

                  <div class="col-md-12">

                    <div class="formrow">

                    <label>{{__('CVV Number')}}</label>

                      <input class="form-control" id="cvvNumber" placeholder="{{__('CVV number')}}" type="text">

                    </div>

                  </div>

                  <div class="col-md-12">

                    <div class="formrow">

                      <button type="submit" class="btn">{{__('Pay with Stripe')}} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

                    </div>

                  </div>

                </div>

                {!! Form::close() !!}

                <hr>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

@include('includes.footer')

@endsection

@push('styles')

<style type="text/css">

.userccount p{ text-align:left !important;}

</style>

@endpush

@push('scripts') 

<script type="text/javascript" src="https://js.stripe.com/v2/"></script> 

<script type="text/javascript">

Stripe.setPublishableKey('{{Config::get('stripe.stripe_key')}}');

var $form = $('#stripe-form');

$form.submit(function(event) {

    $('#error_div').hide();

    $form.find('button').prop('disabled', true);

    Stripe.card.createToken({

        number: $('#card_no').val(),

        cvc: $('#cvvNumber').val(),

        exp_month: $('#ccExpiryMonth').val(),

        exp_year: $('#ccExpiryYear').val(),

        name: $('#card_name').val()

    }, stripeResponseHandler);

    return false;

});

function stripeResponseHandler(status, response) {

    if (response.error) {

        $('#error_div').show();

        $('#error_div').text(response.error.message);

        $form.find('button').prop('disabled', false);

    } else {

        var token = response.id;

        $form.append($('<input type="hidden" name="stripeToken" />').val(token));

        // Submit the form:

        $form.get(0).submit();

    }

}

</script> 

@endpush