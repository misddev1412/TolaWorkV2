@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title'=>__('Company Messages')])
<div class="listpgWraper messageWrap">
    <div class="container">
        <div class="row"> @include('includes.company_dashboard_menu')
            <div class="col-md-9 col-sm-8">
                <div class="myads message-body">
                    <h3>{{__('Company Messages')}}</h3> 
                          <div class="row">
                            <div class="col-lg-4 col-md-4">
                              <div class="message-inbox">
                                <div class="message-header">
                                </div>
                                <div class="list-wrap">
                                  <ul class="message-history">
                                    @if(null !== ($seekers))
                                    <?php foreach($seekers as $seeker){?>
                                    <li class="message-grid" id="adactive{{ $seeker->id}}"> 
                                      <a  href="javascript:;" data-gift="{{$seeker->id}}" id="company_id_{{$seeker->id}}"  onclick="show_messages({{ $seeker->id}})">
                                      <div class="image"> 
                                     {{$seeker->printUserImage(100, 100)}}
                                      </div>
                                      <div class="user-name">
                                        <div class="author"> <span>{{ $seeker->name}}</span>                       
                                        </div> 
                                        <div class="count-messages">
                                        {{$seeker->countMessages(Auth::guard('company')->user()->id)}} 
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
            url: "{{route('company-change-message-status')}}",
            data: { 
                'sender_id': id, 
            },
            });
      $.ajax({
        type: 'get',
        url: "{{route('append-message')}}",
        data: {
          '_token': $('input[name=_token]').val(),
          'seeker_id': id,
        },
        success: function(res) {
          $('#append_messages').html('');
          $('#append_messages').html(res);
          $(".messages").scrollTop(1000000000000);
          $('.messages').off('scroll');
          $('.message-grid').removeClass('active');
          $("#adactive"+id).addClass('active');
        }
      });

  }
  
    
</script>

@endpush
