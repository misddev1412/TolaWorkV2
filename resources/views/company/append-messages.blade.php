<ul class="messages message{{$seeker->id}}">
@if(null !== ($messages))
<?php foreach($messages as $msg){?>
<li class="<?php if($msg->type=='message'){?>friend-message<?php }else{?>my-message<?php }?> clearfix tab{{$seeker->id}}">
<figure class="profile-picture"><?php if($msg->type=='message'){?> {{$seeker->printUserImage(100, 100)}} <?php }else{?>{{$company->printCompanyImage()}} <?php }?></figure>
  <div class="message"> {{$msg->message}}
    <div class="time"><i class="fa fa-clock-o"></i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $msg->updated_at)->diffForHumans() }}</div>
  </div>
</li>
<?php } ?>
@endif
</ul>
<div class="chat-form" type="post">
<form class="form-inline">
  @csrf
  <div class="form-group">
    <div class="input-wrap">
    <input type="hidden" name="seeker_id" value="{{$seeker->id}}">
      <textarea class="form-control" name="message" placeholder="Type Your Message here.."></textarea>
      <div class="input-group-prepend"> <button type="submit" class="input-group-text" id="inputGroupPrepend3"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button> </div>
    </div>
  </div>
  
</form>
</div>
<script>
  $(document).ready(function(){
if ($(".form-inline").length > 0) {
        $(".form-inline").validate({
            validateHiddenInputs: true,
            ignore: "",

            rules: {
                message: {
                    required: true,
                    maxlength: 5000
                },
            },
            messages: {

                message: {
                    required: "Message is required",
                }

            },
            submitHandler: function(form) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('company.submit-message')}}",
                    type: "POST",
                    data: $('.form-inline').serialize(),
                    success: function(res) {
                        $(".form-inline").trigger("reset");
                         $('.messages').html('');
                          $('.messages').html(res);
                          $(".messages").scrollTop(100000000000000);
                          $('.messages').off('scroll');
                    }
                });
            }
        })
    }
  })



clearInterval(chat_interval);
var chat_interval=setInterval(function()
{
  $.ajax({
        type: 'get',
        dataType: 'json',
        url: "{{route('append-only-message')}}",
        data: {
        '_token': $('input[name=_token]').val(),
        'seeker_id': "{{$seeker->id}}",
      },
      success: function(res) {
        $('.message'+res.seeker_id).html(res.html_data);
      }
    });
}, 5000);

</script>
