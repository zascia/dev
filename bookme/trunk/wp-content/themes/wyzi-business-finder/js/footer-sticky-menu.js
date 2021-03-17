"use strict";
	var liCount=0;
	var footerMenuOpen = false;
	if(jQuery("#menu-foot").length){
		liCount = jQuery('#menu-foot>li').length;
		if(liCount > 5) {
			var i = 1;
			jQuery('#menu-foot>li').slice(4, liCount).wrapAll('<ul class="footer-menu-more"></ul>');
			jQuery('#menu-foot .footer-menu-more').after('<li id="footer-menu-trigger-cont"><a href="#" id="footer-menu-trigger"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a></li>');
		}

		if ( jQuery('#footer-search-trigger').length){
			jQuery('#menu-foot').before('<div class="header-search">'+ footer_seach_form.search + '</div>');
		}
		jQuery('#footer-search-trigger').on('click',function(e){
			e.preventDefault();
			jQuery('.footer-bottom .header-search').toggleClass('footer-menu-trigger-class');
		});
		
	}
	if(liCount>5){
		var menuTriggerButton = jQuery('#footer-menu-trigger');
		var footerMenuMore = jQuery('.footer-menu-more');

		menuTriggerButton.on('click',function(e){
			e.preventDefault();
			footerMenuOpen = !footerMenuOpen;
			footerMenuMore.toggleClass('footer-menu-trigger-class');
		});

		var container = jQuery(".footer-menu-more");
		jQuery(document).mouseup(function(e) {
			if(menuTriggerButton.is(e.target))
				return;
			if (!container.is(e.target) && container.has(e.target).length === 0 && footerMenuOpen) {
				menuTriggerButton.trigger('click');
			}
		});
	}