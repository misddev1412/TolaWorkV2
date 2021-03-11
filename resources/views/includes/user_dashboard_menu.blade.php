<div class="col-md-3 col-sm-4">

	<div class="switchbox">

		<div class="txtlbl">{{__('Immediate Available')}} <i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="{{__('Are you immediate available')}}?" data-original-title="{{__('Are you immediate available')}}?" title="{{__('Are you immediate available')}}?"></i>
		</div>

		<div class="pull-right">

			<label class="switch switch-green"> @php

        $checked = ((bool)Auth::user()->is_immediate_available)? 'checked="checked"':'';

        @endphp

        <input type="checkbox" name="is_immediate_available" id="is_immediate_available" class="switch-input" {{$checked}} onchange="changeImmediateAvailableStatus({{Auth::user()->id}}, {{Auth::user()->is_immediate_available}});">

        <span class="switch-label" data-on="On" data-off="Off"></span> <span class="switch-handle"></span> </label>

		</div>

		<div class="clearfix"></div>

	</div>

	<ul class="usernavdash">

		<li class="active"><a href="{{route('home')}}"><i class="fa fa-tachometer" aria-hidden="true"></i> {{__('Dashboard')}}</a>
		</li>

		<li><a href="{{ route('my.profile') }}"><i class="fa fa-user" aria-hidden="true"></i> {{__('My Profile')}}</a>
		</li>

		<li><a href="{{ route('view.public.profile', Auth::user()->id) }}"><i class="fa fa-eye" aria-hidden="true"></i> {{__('View Public Profile')}}</a>
		</li>

		<li><a href="{{ route('my.job.applications') }}"><i class="fa fa-desktop" aria-hidden="true"></i> {{__('My Job Applications')}}</a>
		</li>



		<li><a href="{{ route('my.favourite.jobs') }}"><i class="fa fa-heart" aria-hidden="true"></i> {{__('My Favourite Jobs')}}</a>
		</li>



		<li><a href="{{url('my-profile#cvs')}}"><i class="fa fa-file-text" aria-hidden="true"></i> {{__('Manage Resume')}}</a>
		</li>

		<li><a href="{{route('my.messages')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{__('My Messages')}}</a>
		</li>

		<li><a href="{{route('my.followings')}}"><i class="fa fa-user-o" aria-hidden="true"></i> {{__('My Followings')}}</a>
		</li>

		<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> {{__('Logout')}}</a>

			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

				{{ csrf_field() }}

			</form>

		</li>

	</ul>

	<div class="row">

		<div class="col-md-12">{!! $siteSetting->dashboard_page_ad !!}</div>

	</div>

</div>