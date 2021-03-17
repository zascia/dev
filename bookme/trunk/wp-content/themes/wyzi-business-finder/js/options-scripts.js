jQuery(document).ready(function() {
	if ( 'on' == options_scripts_vars.page_loader ) {
		
		var loading_screen = pleaseWait({
			logo: options_scripts_vars.page_loader_logo,
			backgroundColor: options_scripts_vars.page_loader_bg,
			loadingHtml: '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>'
		});

		jQuery(window).load(function() {
			if(jQuery('#page-loader-init').length)
				jQuery('#page-loader-init').hide();
			loading_screen.finish();
		});
	}

	var adminBarHeight = 0;

	if ( 'on' == options_scripts_vars.sticky_menu_option ) {

		jQuery('.header-bottom').sticky({
			zIndex: 10
		});

		if (options_scripts_vars.admin_bar_showing) {
			jQuery('.header-bottom').sticky({
				topSpacing: 32,
			});
		}

		if ( options_scripts_vars.admin_bar_showing ) {
			refreshStickyMenu();
			var resizeId;
			jQuery(window).resize(function() {
				clearTimeout(resizeId);
				resizeId = setTimeout(refreshStickyMenu, 500);
			});

			function refreshStickyMenu(){
				var wWidth = jQuery(document).width() + 17;
				if(wWidth<=600){
					jQuery('.header-bottom').sticky({
						zIndex: 10,
						topSpacing: 0,
					});
				} else if(wWidth<=782){
					jQuery('.header-bottom').sticky({
						zIndex: 10,
						topSpacing: 46,
					});
				} else {
					jQuery('.header-bottom').sticky({
						zIndex: 10,
						topSpacing: 32,
					});
				}
				jQuery('.header-bottom').sticky('update');
			}

		}
	} 
	 
	
	if ( options_scripts_vars.template_type == 2 ){ 
		jQuery('#main-menu > li:has(ul.sub-menu)>a, #login-menu > li:has(ul.sub-menu)>a').append("<i class=\"fa fa-caret-down\"></i>").addClass('parent');
	}

	if ( options_scripts_vars.template_type == 1 ){ 
		jQuery('#mobile-main-menu li:has(ul.sub-menu)>a').each(function(){
			jQuery(this).html(jQuery(this).text()+' <i class=\"fa fa-caret-down\"></i>');
		});
		jQuery('#main-menu > li:has(ul.sub-menu), #login-menu > li:has(ul.sub-menu)').append("<i class=\"fa fa-caret-down\"></i>").addClass('parent');
		if( ! options_scripts_vars.is_mobile ) { 
			setTimeout(function(){
			if(jQuery('.header-acgbtb .acgbtb .header-logo').length) {
				var lH = jQuery('.header-acgbtb .acgbtb .header-logo').height();
				var lCH = jQuery('.header-acgbtb').height();
				if(lH < lCH ){
					var lHa = jQuery('.header-acgbtb .acgbtb .header-logo a').height();
					var padd = (lCH - lHa)/2;
					jQuery( "<style>@media screen and (min-width:768px) { .header-acgbtb .acgbtb .header-logo { padding-top :"+padd+"px;padding-bottom:"+padd+"px;}}</style>" ).appendTo( "head" );
				}
			}},500);
		}
	}
	
	jQuery('#main-menu ul.sub-menu > li:has(ul.sub-menu) > a, #login-menu ul.sub-menu > li:has(ul.sub-menu) > a').append("<i class=\"fa fa-caret-right\"></i>").addClass('parent');

	if ( 'off' != options_scripts_vars.resp ) { 
		jQuery('.mobile-menu').css({ "display": "block"});
		if ( 1 == options_scripts_vars.template_type ) { 
			jQuery('.mobile-menu nav').meanmenu({
				meanScreenWidth: "767",
				meanMenuContainer: ".mobile-menu",
			});
	
		} else if ( 2 == options_scripts_vars.template_type ) { 
			jQuery('.mobile-menu nav').meanmenu({
				meanScreenWidth: '767',
				meanMenuContainer: '.mobile-menu',
				meanMenuClose: '<i class="fa fa-close"></i>',
				meanMenuOpen: '<i class="fa fa-bars"></i>',
				meanRevealPosition: 'right',
				meanMenuCloseSize: '30px',
			});
		 }
	}
	if ( 'menu-1' == options_scripts_vars.mobile_menu_layout ) {
		jQuery('.mean-bar nav.mean-nav').css({"max-height":(jQuery(window).height()*0.8)+'px', "overflow":"auto"});
	}

	setTimeout(function(){
	var cont = jQuery('.vc_row[data-vc-full-width-init="true"] .location-search.filter-location-search').closest('.vc_row[data-vc-full-width-init="true"]');
	cont.css({"position":"absolute","top":0,"overflow":"visible"}).parent().css({"margin-top":cont.height()});
	},2000);

	// Scroll to top.
	var offset = 250;
	var duration = 300;
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > offset) {
			jQuery('.back-to-top').fadeIn(duration);
		} else {
			jQuery('.back-to-top').fadeOut(duration);
		}
	});

	jQuery('.back-to-top').on('click',function(event) {
		event.preventDefault();
		jQuery('html, body').animate({scrollTop: 0}, duration);
		return false;
	});

	jQuery('footer').on('footer_fit_trigger', function(){
		var docHeight = jQuery(window).height();
		var footerHeight = jQuery(this).height();
		if(footerHeight){
			var footerTop = jQuery(this).position().top + footerHeight;

			if (footerTop < docHeight){
				jQuery(this).addClass('fit-footer-bottom');
			}
		}
	});


	if ( 'on' == options_scripts_vars.nice_scroll ) {
		
			jQuery("body").niceScroll({
				scrollspeed: 100,
				mousescrollstep: 100,
				cursorborder: "none",
				cursorwidth: options_scripts_vars.nice_width,
				cursorcolor: options_scripts_vars.nice_scroll_color
				});
	
	}


	if ( options_scripts_vars.isrtl ) {
			setTimeout(function(){
				if( jQuery('html').attr('dir') == 'rtl' ) {
					jQuery('[data-vc-full-width="true"]').each(function(i, v){
						jQuery(this).css( 'right', jQuery(this).css('left') ).css('left', 'auto');
					});
				}
			}, 500)
	}
});