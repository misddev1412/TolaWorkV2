<!--Footer-->
<div class="btad">{!! $siteSetting->above_footer_ad !!}</div>


<div class="footerWrap"> 

  <div class="container">

    <div class="row"> 

      

      <!--Quick Links-->

      <div class="col-md-3 col-sm-6">

        <h5>{{_('Quick Links')}}</h5>

        <!--Quick Links menu Start-->

        <ul class="quicklinks">

          <li><a href="{{ route('index') }}">{{__('Home')}}</a></li>

          <li><a href="{{ route('contact.us') }}">{{__('Contact Us')}}</a></li>

          <li class="postad"><a href="{{ route('post.job') }}">{{__('Post a Job')}}</a></li>

          <li><a href="{{ route('faq') }}">{{__('FAQs')}}</a></li>

          @foreach($show_in_footer_menu as $footer_menu)

          @php

          $cmsContent = App\CmsContent::getContentBySlug($footer_menu->page_slug);

          @endphp

          

          <li class="{{ Request::url() == route('cms', $footer_menu->page_slug) ? 'active' : '' }}"><a href="{{ route('cms', $footer_menu->page_slug) }}">{{ $cmsContent->page_title }}</a></li>

          @endforeach

        </ul>

      </div>

      <!--Quick Links menu end-->

      

      <div class="col-md-3 col-sm-6">

        <h5>{{_('Jobs By Functional Area')}}</h5>

        <!--Quick Links menu Start-->

        <ul class="quicklinks">

          @php

          $functionalAreas = App\FunctionalArea::getUsingFunctionalAreas(10);

          @endphp

          @foreach($functionalAreas as $functionalArea)

          <li><a href="{{ route('job.list', ['functional_area_id[]'=>$functionalArea->functional_area_id]) }}">{{$functionalArea->functional_area}}</a></li>

          @endforeach

        </ul>

      </div>

      

      <!--Jobs By Industry-->

      <div class="col-md-3 col-sm-6">

        <h5>{{_('Jobs By Industry')}}</h5>

        <!--Industry menu Start-->

        <ul class="quicklinks">

          @php

          $industries = App\Industry::getUsingIndustries(10);

          @endphp

          @foreach($industries as $industry)

          <li><a href="{{ route('job.list', ['industry_id[]'=>$industry->industry_id]) }}">{{$industry->industry}}</a></li>

          @endforeach

        </ul>

        <!--Industry menu End-->

        <div class="clear"></div>

      </div>

      

      <!--About Us-->

      <div class="col-md-3 col-sm-12">

        <h5>{{__('Contact Us')}}</h5>

        <div class="address">{{ $siteSetting->site_street_address }}</div>

        <div class="email"> <a href="mailto:{{ $siteSetting->mail_to_address }}">{{ $siteSetting->mail_to_address }}</a> </div>

        <div class="phone"> <a href="tel:{{ $siteSetting->site_phone_primary }}">{{ $siteSetting->site_phone_primary }}</a></div>

        <!-- Social Icons -->

        <div class="social">@include('includes.footer_social')</div>

        <!-- Social Icons end --> 
		
      </div>

      <!--About us End--> 

      

      

    </div>

  </div>

</div>

<!--Footer end--> 



<!--Copyright-->

<div class="copyright">

  <div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="bttxt">{{__('Copyright')}} &copy; {{date('Y')}} {{ $siteSetting->site_name }}. {{__('All Rights Reserved')}}. {{__('Design by')}}: <a href="{{url('/')}}http://graphicriver.net/user/ecreativesol" target="_blank">eCreativeSolutions</a></div>
		</div>
		<div class="col-md-4">
			<div class="paylogos"><img src="{{asset('/')}}images/payment-icons.png" alt="" /></div>	
		</div>
	</div>
    

  </div>

</div>

