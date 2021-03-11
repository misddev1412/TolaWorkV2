@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title'=>__('My Messages')])
<div class="listpgWraper messageWrap">
    <div class="container">
        <div class="row"> @include('includes.user_dashboard_menu')
            <div class="col-md-9 col-sm-8">
                <div class="myads message-body">
                    <h3>{{__('Seeker Messages')}}</h3> 
                          <div class="row">
                            <div class="col-lg-4 col-md-4">
                              <div class="message-inbox">
                                <div class="message-header">
                                </div>
                                <div class="list-wrap">
                                  <ul class="message-history">
                                    @if(null !== ($companies))
                                    <?php foreach($companies as $company){?>
                                    <li class="message-grid active" id="adactive{{ $company->id}}"> 
                                      <a  href="javascript:;" data-gift="{{$company->id}}" id="company_id_{{$company->id}}"  onclick="show_messages({{ $company->id}})">
                                      <div class="image"> 
                                      {{$company->printCompanyImage()}}
                                      </div>
                                      <div class="user-name">
                                        <div class="author"> <span>{{ $company->name}}</span>                       
                                        </div> 
                                        <div class="count-messages">
                                        {{$company->countMessages(Auth::user()->id)}} 
                                        </div>                  
                                      </div>
                                      
                                      </a> 
                                    </li>
                                    <?php } ?>
                                    @endif
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-8 col-md-8 clearfix message-content">
                              <div class="message-details">
                              <h4> </h4>
                                <div id="append_messages"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                </div>
            </div>
          </div>
@endsection
@push('scripts')
<script type="text/javascript">
function show_messages(id)
{
    $.ajax({
            type: "GET",
            url: "{{route('seeker-change-message-status')}}",
            data: { 
                'sender_id': id, 
            },
            })
      $.ajax({
        type: 'get',
        url: "{{route('seeker-append-messages')}}",
        data: {
          '_token': $('input[name=_token]').val(),
          'company_id': id,
        },
        success: function(res) {
          $('#append_messages').html('');
          $('#append_messages').html(res);
          $(".messages").scrollTop(100000000000000000);
          $('.messages').off('scroll');
          $('.message-grid').removeClass('active');
          $("#adactive"+id).addClass('active');
        }
      });

  }
  
    
</script>

@endpush
