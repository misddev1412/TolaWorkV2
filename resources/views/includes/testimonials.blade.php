<div class="section testimonialwrap">
    <div class="container"> 
        <!-- title start -->
        <div class="titleTop">
            <div class="subtitle">{{__('Testimonials')}}</div>
            <h3>{{__('Success')}} <span>{{__('Stories')}}</span></h3>
        </div>
        <!-- title end -->

        <ul class="testimonialsList owl-carousel">
            @if(isset($testimonials) && count($testimonials))
            @foreach($testimonials as $testimonial)
            <li class="item">        
                <div class="ratinguser">
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
				</div>
                <div class="clientname">{{$testimonial->testimonial_by}}</div>
				 <div class="clientinfo">{{$testimonial->company}}</div>
                <p>"{{$testimonial->testimonial}}"</p>
               
            </li>
            @endforeach
            @endif
        </ul>
    </div>
</div>