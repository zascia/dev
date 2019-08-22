var menu = document.getElementById( "menu-button")

menu.addEventListener( "click", function(e){
  e.preventDefault();
  $('.header-mobile-menu').toggle( "slow", function() {
    // Animation complete.
  });
  this.classList.toggle( "active" );
});

$( function() {
    var handle = $( ".radius-amount" );
    $( ".radius-slider" ).slider({
      value: 60,
      orientation: "horizontal",
      range: "min",
      animate: true,
      create: function() {
        handle.text( $( this ).slider( "value" ) + 'Km');
        $("#radius").val($( this ).slider( "value" ))
      },
      slide: function( event, ui ) {
        handle.text( ui.value + 'Km');
        $("#radius").val(ui.value)
      }
    });
    
  $('.latest-slider').owlCarousel({
    loop:true,
    margin:30,
    navText: ['<svg class="icon" viewBox="0 0 25 25"><use xlink:href="#arrow-slider" /></svg>','<svg class="icon" viewBox="0 0 25 25"><use xlink:href="#arrow-slider" /></svg>'],
    nav:true,
    dots: false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        992:{
            items:4
        }
    }
  })

  $('.offer-slider').owlCarousel({
    loop:true,
    margin: 30,
    navText: ['<svg class="icon" viewBox="0 0 25 25"><use xlink:href="#arrow-slider" /></svg>','<svg class="icon" viewBox="0 0 25 25"><use xlink:href="#arrow-slider" /></svg>'],
    nav:true,
    dots: false,
    items: 1
  })

  $('.location-slider').owlCarousel({
    loop:true,
    margin: 30,
    nav:false,
    dots: false,
    items: 3,
    responsive:{
      0:{
          items:2
      },
      992:{
          items:3
      }
  }
  })
  var tabControls = jQuery('.company-page-tabs-list-item');
  var tabTriggers = tabControls.find('a');
  var tabs        = jQuery('.tabs-content-item');
  var activeClass = 'tab-active';

  jQuery('.company-page-tabs-list-item:first, .tabs-content-item:first').addClass(activeClass);

  tabs.each(function(){
    if(!jQuery(this).hasClass(activeClass)){
      jQuery(this).hide();
    }
  });

  tabTriggers.each(function(){
    var tab		= jQuery(jQuery(this).attr('href')),
        parent	= jQuery(this).parent();
    jQuery(this).click(function(e){
      e.preventDefault();
      if(!parent.hasClass(activeClass)){
        tabControls.removeClass(activeClass);
        tabs.hide();
        parent.addClass(activeClass);
        tab.show();
      }
    });
  });
} );

$(window).scroll(function(){
  var sticky = $('.sticky'),
      scroll = $(window).scrollTop();

  if (scroll >= 100) sticky.addClass('fixed');
  else sticky.removeClass('fixed');

  if($('#menu-button').hasClass('active')){
    $('.header-mobile-menu').css('display', 'none')
    $('#menu-button').removeClass( "active" );
  }
});


$(document).ready(function() {
	$('.tabs-content-photo-content').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
		}
	});
});