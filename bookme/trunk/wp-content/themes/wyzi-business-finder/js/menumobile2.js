jQuery(document).ready(function(){

			"use strict";
			// Toggle the blurred class
			var trigger = jQuery('#wyz-mobile-menu-trigger, #wyz-mobile-menu-close'),
			menu = jQuery('.wyz-menu-sidebar');

			trigger.on('click',function(e){
				e.preventDefault();
				jQuery(this).toggleClass('active');
				menu.toggleClass('closed');
				if(!jQuery('#mobile-main-menu').is(':visible')){
					jQuery('.meanmenu-reveal').trigger('click');
				}
				jQuery('#blurrMe').toggleClass('blurred'); // just here
			});

			var menuResizeId;
			jQuery(window).resize(function() {
				clearTimeout(menuResizeId);
				menuResizeId = setTimeout(refreshMobileMenu, 200);
			});


			function refreshMobileMenu() {
				var wWidth = jQuery(document).width();
				if(wWidth<=767){
					if(!(jQuery('#mobile-main-menu').is(':visible'))){
						jQuery('.meanmenu-reveal').trigger('click');

					}
				}
			}

		});