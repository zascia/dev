(function($) {
	"use strict";
	
	$(function(){ 
		
		/*START SCREENSHOTS SLIDE JS*/
			$('#screenshots').slick({
				  autoplay: true,
				  autoplaySpeed: 5000,
				  centerMode: true,
				  centerPadding: '50px',
				  arrows: false,
				  infinite: true,
				  speed: 550,
				  slidesToShow: 3,
				  slidesToScroll: 1,
				  responsive: [
				    {
				      breakpoint: 1024,
				      settings: {
				        slidesToShow: 3,
				        slidesToScroll: 1,
				        infinite: true,
				      }
				    },
				    {
				      breakpoint: 600,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 1
				      }
				    },
				    {
				      breakpoint: 480,
				      settings: {
				        slidesToShow: 1,
				        slidesToScroll: 1
				      }
				    }
				  ]
				});
		/*END SCREENSHOTS SLIDE JS*/

		/*END popup SLIDE JS*/
		$(".group2").colorbox({rel:'group2', transition:"fade"});
		/*END popup JS*/

		/*START CIRCLES JS*/
		var vel = '';
		if ($(window).width() <= '320') {
	    	vel = 32;
	    }
	    else if ($(window).width() <= '410') {
	    	vel = 34;
	    }
	    else if ($(window).width() <= '640') {
	    	vel = 42;
	    }  
	    else if ($(window).width() <= '991') {
	    	vel = 58;
	    }
	    else { 
	    	vel = 42; 
	    }
		
		Circles.create({
		  id:           'circles-1', 
		  radius:       vel,
		  value:        4,
		  maxValue:     5,
		  width:        1,
		  text:         'B+',
		  colors:       ['#E8ECF1', '#A3BF43'],
		  duration:     400,
		  wrpClass:     'circles-wrp',
		  textClass:    'circles-text',
		  styleWrapper: true,
		  styleText:    true,
		})

		Circles.create({
		  id:           'circles-2', 
		  radius:       vel,
		  value:        5.0,
		  maxValue:     5,
		  width:        1,
		  text:         function(value){return value +'.0';},
		  colors:       ['#E8ECF1', '#A3BF43'],
		  duration:     400,
		  wrpClass:     'circles-wrp',
		  textClass:    'circles-text',
		  styleWrapper: true,
		  styleText:    true
		})

		Circles.create({
		  id:           'circles-3', 
		  radius:       vel,
		  value:        3.9,
		  maxValue:     5,
		  width:        1,
		  text:         function(value){return value;},
		  colors:       ['#E8ECF1', '#A3BF43'],
		  duration:     400,
		  wrpClass:     'circles-wrp',
		  textClass:    'circles-text',
		  styleWrapper: true,
		  styleText:    true
		})

		Circles.create({
		  id:           'circles-4', 
		  radius:       vel,
		  value:        4.7,
		  maxValue:     5,
		  width:        1,
		  text:         function(value){return value;},
		  colors:       ['#E8ECF1', '#A3BF43'],
		  duration:     400,
		  wrpClass:     'circles-wrp',
		  textClass:    'circles-text',
		  styleWrapper: true,
		  styleText:    true
		})
		/*END CIRCLES JS*/

		/*START TABS JS*/
		$('#myTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		})
		/*END TABS JS*/
	
	});	
		
})(jQuery);

