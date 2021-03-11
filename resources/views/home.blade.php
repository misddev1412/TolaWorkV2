@extends('layouts.app')

@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 

<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title'=>__('Dashboard')]) 
<!-- Inner Page Title end -->

<div class="listpgWraper">
  <div class="container">@include('flash::message')
    <div class="row"> @include('includes.user_dashboard_menu')
      <div class="col-md-9 col-sm-8"> @include('includes.user_dashboard_stats')
        @if((bool)config('jobseeker.is_jobseeker_package_active'))
        @php        
        $packages = App\Package::where('package_for', 'like', 'job_seeker')->get();
        $package = Auth::user()->getPackage();
        if(null !== $package){
        $packages = App\Package::where('package_for', 'like', 'job_seeker')->where('id', '<>', $package->id)->where('package_price', '>=', $package->package_price)->get();
        }
        @endphp
        
        @if(null !== $package)
        @include('includes.user_package_msg')
        @include('includes.user_packages_upgrade')
        @else
        
        @if(null !== $packages)
        @include('includes.user_packages_new')
        @endif
        @endif
        @endif </div>
    </div>
  </div>
</div>
@include('includes.footer')
@endsection
@push('scripts')
@include('includes.immediate_available_btn')
@endpush