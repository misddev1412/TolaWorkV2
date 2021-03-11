@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title'=>__('Apply on Job')]) 
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container"> @include('flash::message')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="userccount">
                    <div class="formpanel"> {!! Form::open(array('method' => 'post', 'route' => ['post.apply.job', $job_slug])) !!} 
                        <!-- Job Information -->
                        <h5>{{$job->title}}</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('cv_id') ? ' has-error' : '' }}"> {!! Form::select('cv_id', [''=>__('Select CV')]+$myCvs, null, array('class'=>'form-control', 'id'=>'cv_id')) !!}
                                    @if ($errors->has('cv_id')) <span class="help-block"> <strong>{{ $errors->first('cv_id') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formrow{{ $errors->has('current_salary') ? ' has-error' : '' }}"> {!! Form::number('current_salary', null, array('class'=>'form-control', 'id'=>'current_salary', 'placeholder'=>__('Current salary').' ('.$job->getSalaryPeriod('salary_period').')' )) !!}
                                    @if ($errors->has('current_salary')) <span class="help-block"> <strong>{{ $errors->first('current_salary') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formrow{{ $errors->has('expected_salary') ? ' has-error' : '' }}"> {!! Form::number('expected_salary', null, array('class'=>'form-control', 'id'=>'expected_salary', 'placeholder'=>__('Expected salary').' ('.$job->getSalaryPeriod('salary_period').')')) !!}
                                    @if ($errors->has('expected_salary')) <span class="help-block"> <strong>{{ $errors->first('expected_salary') }}</strong> </span> @endif </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow{{ $errors->has('salary_currency') ? ' has-error' : '' }}"> {!! Form::text('salary_currency', Request::get('salary_currency', $siteSetting->default_currency_code), array('class'=>'form-control', 'id'=>'salary_currency', 'placeholder'=>__('Salary Currency'), 'autocomplete'=>'off')) !!}
                                    @if ($errors->has('salary_currency')) <span class="help-block"> <strong>{{ $errors->first('salary_currency') }}</strong> </span> @endif </div>
                            </div>
                        </div>
                        <br>
                        <input type="submit" class="btn" value="{{__('Apply on Job')}}">
                        {!! Form::close() !!} </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
@push('scripts') 
<script>
    $(document).ready(function () {
        $('#salary_currency').typeahead({
            source: function (query, process) {
                return $.get("{{ route('typeahead.currency_codes') }}", {query: query}, function (data) {
                    console.log(data);
                    data = $.parseJSON(data);
                    return process(data);
                });
            }
        });

    });
</script> 
@endpush