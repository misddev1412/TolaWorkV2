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
    <div class="row"> @include('includes.company_dashboard_menu')
      <div class="col-md-9 col-sm-8"> @include('includes.company_dashboard_stats')
        
        
        @php
        $packages = App\Package::where('package_for', 'like', 'employer')->get();
        $package = Auth::guard('company')->user()->getPackage();
        if(null !== $package){
        $packages = App\Package::where('package_for', 'like', 'employer')->where('id', '<>', $package->id)->where('package_price', '>=', $package->package_price)->get();
        }
        @endphp
        
        @if(null !== $package)
        @include('includes.company_package_msg')
        @include('includes.company_packages_upgrade')
        @else
        
        @if(null !== $packages)
        @include('includes.company_packages_new')
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