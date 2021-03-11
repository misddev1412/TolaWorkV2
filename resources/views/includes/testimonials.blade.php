<div class="section">
  <div class="container"> 
    <!-- title start -->
    <div class="titleTop">
      <div class="subtitle">{{__('Here You Can See')}}</div>
      <h3>{{__('Success')}} <span>{{__('Stories')}}</span></h3>
    </div>
    <!-- title end -->
    
    <ul class="testimonialsList">
      @if(isset($testimonials) && count($testimonials))
      @foreach($testimonials as $testimonial)
      <li class="item">        
        <div class="clientname">{{$testimonial->testimonial_by}}</div>
        <p>"{{$testimonial->testimonial}}"</p>
        <div class="clientinfo">{{$testimonial->company}}</div>
      </li>
      @endforeach
      @endif
    </ul>
  </div>
</div>