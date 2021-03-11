<ul class="messages message{{$company->id}}">
    @if(null !== ($messages))
    <?php foreach ($messages as $msg) { ?>
    <li
        class="<?php if ($msg->type == 'reply') { ?>friend-message<?php } else { ?>my-message<?php } ?> clearfix tab{{$company->id}}">
        <figure class="profile-picture"><?php if ($msg->type == 'reply') { ?> {{$company->printCompanyImage()}}
            <?php } else { ?>{{$seeker->printUserImage(100, 100)}} <?php } ?></figure>
        <div class="message"> {{$msg->message}}
            <div class="time"><i
                    class="fa fa-clock-o"></i>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $msg->updated_at)->diffForHumans() }}
            </div>
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
                <input type="hidden" name="company_id" value="{{$company->id}}">
                <textarea class="form-control" name="message" placeholder="Type Your Message here.."></textarea>
                <div class="input-group-prepend"> <button type="submit" class="input-group-text"
                        id="inputGroupPrepend3"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button> </div>
            </div>
        </div>

    </form>
    <script>
    $(document).ready(function() {
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
                        url: "{{route('seeker.submit-message')}}",
                        type: "POST",
                        data: $('.form-inline').serialize(),
                        success: function(res) {
                            $(".form-inline").trigger("reset");
                            $('.messages').html('');
                            $('.messages').html(res);
                            $(".messages").scrollTop(1000000000000);
                            $('.messages').off('scroll');
                        }
                    });
                }
            })
        }
    })

    clearInterval(chat_interval);
    var chat_interval = setInterval(function() {
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: "{{route('seeker-append-only-message')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'company_id': "{{$company->id}}",
            },
            success: function(res) {
                $('.message' + res.company_id).html(res.html_data);
            }
        });
    }, 5000);
    </script>
</div>