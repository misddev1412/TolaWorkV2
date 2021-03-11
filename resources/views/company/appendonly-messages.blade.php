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