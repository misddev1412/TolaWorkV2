"use strict";
/* ==== Jquery Functions ==== */
(function($) {
	
	/* ==== Tool Tip ==== */	
    $('[data-toggle="tooltip"]').tooltip();	
		
	
	/* ==== Testimonials Slider ==== */	
  	$(".testimonialsList").owlCarousel({      
	   loop:true,
		margin:30,
		nav:false,
		responsiveClass:true,
		responsive:{
			0:{
				items:1,
				nav:false
			},
			768:{
				items:1,
				nav:false
			},
			1170:{
				items:1,
				nav:false,
				loop:true
			}
		}
  	});
	
	
	/* ==== Revolution Slider ==== */
	if($('.tp-banner').length > 0){
		$('.tp-banner').show().revolution({
			delay:6000,
	        startheight:550,
	        startwidth: 1140,
	        hideThumbs: 1000,
	        navigationType: 'none',
	        touchenabled: 'on',
	        onHoverStop: 'on',
	        navOffsetHorizontal: 0,
	        navOffsetVertical: 0,
	        dottedOverlay: 'none',
	        fullWidth: 'on'
		});
	}
	
})(jQuery);