@extends('layouts.app')


@section('content')

<!-- Header start -->
@include('includes.header')
<!-- Header end --> 

<!-- Search start -->
@include('includes.search')
<!-- Search End --> 

<!-- Top Employers start -->
@include('includes.top_employers')
<!-- Top Employers ends --> 

<!-- How it Works start -->
@include('includes.how_it_works')
<!-- How it Works Ends --> 

<!-- Featured Jobs start -->
@include('includes.featured_jobs')
<!-- Featured Jobs ends --> 

<!-- Popular Searches start -->
@include('includes.popular_searches')
<!-- Popular Searches ends --> 

<!-- Video start -->
@include('includes.video')
<!-- Video end --> 

<!-- Latest Jobs start -->
@include('includes.latest_jobs')
<!-- Latest Jobs ends --> 


<!-- Testimonials start -->
@include('includes.testimonials')
<!-- Testimonials End -->

@include('includes.footer')
@endsection
@push('scripts') 
<script>
    $(document).ready(function ($) {
        $("form").submit(function () {
            $(this).find(":input").filter(function () {
                return !this.value;
            }).attr("disabled", "disabled");
            return true;
        });
        $("form").find(":input").prop("disabled", false);
	});
</script>

@include('includes.country_state_city_js')

@endpush
