$(document).ready(function() {
    $('#fullpage').fullpage({
        autoScrolling:true,
        scrollHorizontally: true,
        navigation:false,
        lockAnchors: false,
        anchors: ['first-section'],
        afterLoad: function(anchorLink, index) {
            history.pushState(null, null, "index.html");
        }
    });
    $('.slider-for').slick({
        infinite: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '.slider-nav',
	});
	$('.slider-nav').slick({
		slidesToShow: 4,
        slidesToScroll: 1,
        infinite: false,
		asNavFor: '.slider-for',
		dots: false,
		centerMode: false,
		focusOnSelect: true,
		responsive: [{
			breakpoint: 1280,
			settings: {
				slidesToShow: 2
			}
		},{
			breakpoint: 768,
			settings: {
				slidesToShow: 2
			}
		}]
    });
    $('.slider-for').on('afterChange', function(){
        var stopAllYouTubeVideos = () => { 
            var iframes = document.querySelectorAll('iframe');
            Array.prototype.forEach.call(iframes, iframe => { 
              iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', 
            func: 'stopVideo' }), '*');
           });
          }
        stopAllYouTubeVideos();
    });
    
    $('.slider-project').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3
    });
});