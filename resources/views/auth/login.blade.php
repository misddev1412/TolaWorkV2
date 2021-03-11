@extends('layouts.app')

@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 

<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Login')])
<!-- Inner Page Title end -->
<div class="listpgWraper">
  <div class="container">
  @include('flash::message')
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="userccount">
          <div class="userbtns">
            <ul class="nav nav-tabs">
            <?php
            $c_or_e = old('candidate_or_employer', 'candidate');
			?>
              <li class="{{($c_or_e == 'candidate')? 'active':''}}"><a data-toggle="tab" href="#candidate" aria-expanded="true">{{__('Candidate')}}</a></li>
              <li class="{{($c_or_e == 'employer')? 'active':''}}"><a data-toggle="tab" href="#employer" aria-expanded="false">{{__('Employer')}}</a></li>
            </ul>
          </div>
          <div class="tab-content">
            <div id="candidate" class="formpanel tab-pane fade {{($c_or_e == 'candidate')? 'active in':''}}">
            <!--<div class="socialLogin">
                        <h5>{{__('Login Or Register with Social')}}</h5>
                        <a href="{{ url('login/jobseeker/facebook')}}" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a> <a href="{{ url('login/jobseeker/google')}}" class="gp"><i class="fa fa-google-plus" aria-hidden="true"></i></a> <a href="{{ url('login/jobseeker/twitter')}}" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a> </div>-->
              <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="candidate_or_employer" value="candidate" />
          <div class="formpanel">
            <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="{{__('Email Address')}}">
              @if ($errors->has('email'))
              <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
            <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" value="" required placeholder="{{__('Password')}}">
              @if ($errors->has('password'))
              <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>            
            <input type="submit" class="btn" value="{{__('Login')}}">
          </div>
          <!-- login form  end--> 
          </form>
            </div>
            <div id="employer" class="formpanel tab-pane fade {{($c_or_e == 'employer')? 'active in':''}}">
            <!--<div class="socialLogin">
                        <h5>{{__('Login Or Register with Social')}}</h5>
                        <a href="{{ url('login/employer/facebook')}}" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a> <a href="{{ url('login/employer/google')}}" class="gp"><i class="fa fa-google-plus" aria-hidden="true"></i></a> <a href="{{ url('login/employer/twitter')}}" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a> </div>-->
              <form class="form-horizontal" method="POST" action="{{ route('company.login') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="candidate_or_employer" value="employer" />
          <div class="formpanel">
            <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="{{__('Email Address')}}">
              @if ($errors->has('email'))
              <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
            <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" value="" required placeholder="{{__('Password')}}">
              @if ($errors->has('password'))
              <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>            
            <input type="submit" class="btn" value="{{__('Login')}}">
          </div>
          <!-- login form  end--> 
          </form>
            </div>
          </div>
          <!-- login form -->
          
          <!-- sign up form -->
          <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> {{__('New User')}}? <a href="{{route('register')}}">{{__('Register Here')}}</a></div>
          <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> {{__('Forgot Your Password')}}? <a href="{{ route('password.request') }}">{{__('Click here')}}</a></div>
          <!-- sign up form end--> 
          
        </div>
      </div>
    </div>
  </div>
</div>
@include('includes.footer')
@endsection
