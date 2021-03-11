@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end -->
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('My Job Alerts')])
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">
        <div class="row"> @include('includes.user_dashboard_menu')
            <div class="col-lg-9 col-sm-8">
                <div class="userdashbox">
                    <h3>{{__('My Job Alerts')}}</h3>
                   
						<table class="table">
						  <tbody>
							<tr>
							  <th scope="col">Alert Title</th>	
								@if(isset($id) && $id!='')
							  <th scope="col">Location</th>
								@endif
								<th scope="col">Created On</th>
							  <th scope="col">Action</th>
							</tr>							
							 <!-- job start -->
                        @if(isset($alerts) && count($alerts))
                        @foreach($alerts as $alert)
                        <tr id="delete_{{$alert->id}}">
                            @php
                            if(null!==($alert->search_title)){
                            $title = $alert->search_title;
                            }

                            @endphp
                            @php
                            if(null!==($alert->country_id)){
                            $id = $alert->country_id;
                            }

                            if(isset($title) && $title!='' && isset($id) && $id!=''){
                            $cols = 'col-lg-4';
                            }else{
                            $cols = 'col-lg-8';
                            }
                            @endphp
							
							@if(isset($title) && $title!='')
							<td>{{$title}}</td>
							@endif
                                @if(isset($id) && $id!='')
							  <td> {{$id}}</td>
							@endif
							  <td> {{$alert->created_at->format('M d,Y')}}</td>
							  <td> <a href="javascript:;" onclick="delete_alert({{$alert->id}})" class="delete_alert">Delete</a></td>							
                        </tr>
                        <!-- job end -->
                        @endforeach
                        @endif 
							  
							  
						  </tbody>
						</table>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
    @endsection
    @push('scripts')
    <script>
        function delete_alert(id) {

            $.ajax({
                type: 'GET',
                url: "{{url('/')}}/delete-alert/" + id,
                success: function(response) {
                    if (response["status"] == true) {
                        $('#delete_' + id).hide();
                        swal({
                            title: "Success",
                            text: response["msg"],
                            icon: "success",
                            button: "OK",
                        });

                    } else {
                        swal({
                            title: "Already exist",
                            text: response["msg"],
                            icon: "error",
                            button: "OK",
                        });
                    }

                }
            });
        }
    </script>
    @include('includes.immediate_available_btn')
    @endpush