<div class="subscribe">
  <div class="container">
   
    <div class="row">
		
		<div class="col-lg-4">
		
		 <h6>{{__('Newsletter')}}</h6> 
    <p>{{__('Subscribe to our newsletter and stay updated.')}}</p>	
		
		</div>
		
      <div class="col-lg-8">
      <div id="alert_messages"></div>       
       <form method="post" action="{{ route('subscribe.newsletter')}}" name="subscribe_newsletter_form" id="subscribe_newsletter_form">
      {{ csrf_field() }}
		  
		   
		   
		  <div class="input-group">
		  <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" id="name" required="required">
			<input type="text" class="form-control" placeholder="{{__('Email')}}" name="email" id="email" required="required">
		  <div class="input-group-append">
			<button class="btn btn-default" type="button" id="send_subscription_form">{{__('Subscribe')}}</button>			  
		  </div>
		</div> 
      
    
</form>         
      </div>
    </div>
  </div>
</div>

<!--<div class="section greybg">
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 align-center">{!! $siteSetting->index_page_below_subscribe_ad !!}</div>
    <div class="col-md-1"></div>
  </div>
</div>-->


@push('scripts') 
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#send_subscription_form', function () {
            var postData = $('#subscribe_newsletter_form').serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('subscribe.newsletter') }}",
                data: postData,
                //dataType: 'json',
                success: function (data)
                {
                    response = JSON.parse(data);
                    var res = response.success;
                    if (res == 'success')
                    {
                        var errorString = '<div role="alert" class="alert alert-success">' + response.message + '</div>';
                        $('#alert_messages').html(errorString);
                        $('#subscribe_newsletter_form').hide('slow');
                        $(document).scrollTo('.alert', 2000);
                    } else
                    {
                        var errorString = '<div class="alert alert-danger" role="alert"><ul>';
                        response = JSON.parse(data);
                        $.each(response, function (index, value)
                        {
                            errorString += '<li>' + value + '</li>';
                        });
                        errorString += '</ul></div>';
                        $('#alert_messages').html(errorString);
                        $(document).scrollTo('.alert', 2000);
                    }
                },
            });
        });
    });
</script> 
@endpush