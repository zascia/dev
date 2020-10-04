"use strict";
jQuery(document).ready(function ($) {

//==========================================
// MOBAILE MENU
//=========================================

    $('#navbar-menu').find('a[href*="#"]:not([href="#"])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: (target.offset().top - 0)
                }, 1000);
                if ($('.navbar-toggle').css('display') != 'none') {
                    $(this).parents('.container').find(".navbar-toggle").trigger("click");
                }
                return false;
            }
        }
    });


//==========================================
//ScrollUp
//=========================================

    $(window).scroll(function () {
        if ($(this).scrollTop() > 600) {
            $('#scrollUp').fadeIn('slow');
        } else {
            $('#scrollUp').fadeOut('slow');
        }
    });

    $('#scrollUp').click(function () {
        $("html, body").animate({scrollTop: 0}, 1000);
        return false;
    });



//==========================================
// For fancybox active
//=========================================

    $('.fancybox').fancybox();
    


//==========================================
// For send email
//=========================================
// http://ccoenraets.github.io/es6-tutorial-data/promisify/
// https://www.freecodecamp.org/news/a-practical-es6-guide-on-how-to-perform-http-requests-using-the-fetch-api-594c3d91a547/
// http://youmightnotneedjquery.com/

    // send custom mail function
    function sendCustomMail(e, form) {
        e.preventDefault();
        $("#loading").fadeIn(500);

        console.log("form",form);
        let data = new FormData(form);
        data.append('action','sendMail');
        for (var value of data.values()) {
            console.log(value);
        }

		var request = new XMLHttpRequest();
		request.open('POST', './sendemail.php', true);
		request.send(data);

        request.onreadystatechange=function(){
            if (request.readyState==4 && request.status==200){
                console.log("readyState", request.readyState);
                form.reset();
                setTimeout(() => $("#loading").fadeOut(500), 3000);
            }
        }

		/*jQuery.ajax({
			'url': "./sendemail.php?action=sendMail",
			data: {
				email: jQuery('#email').val(),
				name: jQuery('#name').val(),
				msg: jQuery('#msg').val()
			},
			method: "POST",
			complete: function(r) {

				$("#loading-modalbox").modal("hide");
				if (r.responseText == 'Y') {

					jQuery('#email').val('');
					jQuery('#name').val('');
					jQuery('#msg').val('Hello, ');

					$("#result-modalbox").find("h2").text("Thank you!\n\n Our manager will contact you in a short time.");
					$("#result-modalbox").modal("show");
					return true;

				} else {

					$("#result-modalbox").find("h2").text("Email hadn't been sent due to technical reasons! Please try again.");
					$("#result-modalbox").modal("show");
					return false;

				}

			}
		});*/

    }
    // eo send custom mail function
    
    

//==========================================
// Loading
//=========================================

    $(window).load(function () {
        $("#loading").fadeOut(500);

        let sendEmailForm = document.getElementById("sendMailForm");
        sendEmailForm.addEventListener("submit", function(e){sendCustomMail(e, sendEmailForm)});
    });



});