$(".content-ad").on("click",function(t){$(t.target).hasClass("content-ad")&&$("html, body").stop().animate({scrollTop:$(this).offset().top+250},500)});
function fontSize(t){var i,n,e,s,o=$.extend({holder:"",buttons:"",step:2,size:18,size_intro:24,size_h2:24,min:14,max:22,min_intro:20,max_intro:28,min_h2:20,max_h2:28},t);window.__is_mobile_page&&(o=$.extend({holder:"",buttons:"",step:2,size:16,size_intro:18,size_h2:24,min:12,max:20,min_intro:14,max_intro:22,min_h2:20,max_h2:28},t)),this.change=function(t){var e=parseInt(i.filter(":first").css("font-size")),a=parseInt(n.css("font-size")),r=parseInt(s.css("font-size")),h="-"===t?-1:1,c=e+h*o.step,f=a+h*o.step,x=r+h*o.step;i.css({fontSize:Math.min(Math.max(o.min,c),o.max)+"px"}),n.css({fontSize:Math.min(Math.max(o.min_intro,f),o.max_intro)+"px"}),s.css({fontSize:Math.min(Math.max(o.min_h2,x),o.max_h2)+"px"})},this.reset=function(){i.css({fontSize:o.size+"px"}),n.css({fontSize:o.size_intro+"px"}),s.css({fontSize:o.size_h2+"px"})},this.bind=function(){var t=this;e.find("[data-font-size]").on("click",function(i){var n=$(this).data("fontSize");"reset"===n?t.reset():t.change(n)})},this.init=function(){if(!o.text||!o.buttons)throw new Error("Article FontSize: bad config");i=$(o.text).find(".article-content .text > p"),n=$(o.text).find(".article-top .intro"),s=$(o.text).find(".article-content .text > h2"),e=$(o.buttons)},this.init(),this.bind()}
var ReportError=function(e){var o={},n={},t={holder:".error-reporting",text_element:".article h1, .article .intro, .article .text",top_element:".text",news_id:0},r=!1,i=function(){return window.getSelection?window.getSelection().toString():document.getSelection?document.getSelection():document.selection?document.selection.createRange().text:void 0},c=function(e){d();var o=$(n.holder).find(".form-holder").clone();$.colorbox({inline:!0,href:o,onComplete:function(){o.find(".mistake-error").val(e),o.find(".mistake-comment").val(""),o.on("click",".mistake-send",function(){a(o).done(function(){s(),u()})})}})},l=function(){if($("body").addClass("report-error-on"),!$(".report-error-text").length){var e=$("html").hasClass("lang-en")?"MARK ERRORS IN THE TEXT WITH YOUR MOUSE BY PRESSING THE LEFT MOUSE BUTTON":"PAŽYMĖKITE KLAIDĄ TEKSTE PELE, PASPAUDĘ KAIRĮJĮ PELĖS KLAVIŠĄ";$(".article").find(".text").append('<div class="report-error-text">'+e+"</div>")}$(document).on("keyup",function(e){27==e.keyCode&&d()});var o=function(){$(n.text_element).one("mouseup",function(e){setTimeout(function(){var t=i();t.length?(c(i()),$(e.target).hasClass("intro")&&utils.setScrollTop($(n.top_element).offset().top)):o()},200)})};o(),r=!0},s=function(){$("body").removeClass("report-error-on"),$(n.text_element).off("mouseup"),m(),r=!1},d=function(){s(),m()},a=function(e){var o=e.find(".mistake-error").val(),t=e.find(".mistake-comment").val();return $.get("/ajax/article/report?id="+n.news_id+"&comments="+encodeURIComponent(t)+"&error="+encodeURIComponent(o))},u=function(){var e=$(n.holder).find(".success-holder").html();$.colorbox({inline:!0,href:e})},f=function(){$(n.holder).find(".success").hide()},m=function(){$("body").removeClass("report-error-on")};return o={on:l,off:s,cancel:d,send:a,showDialog:c,successShow:u,successClose:f,isActive:function(){return r}},n=$.extend(t,e),$("body").append('<div id="report-error-bg"></div>'),$("#report-error-bg").on("click",function(){s()}),o};
$(function(){if(window.__is_mobile_page||$(".inline-related, .explain-related").each(function(){var t=$(this),e=t.find("ul"),n=e.find(">li");if(!(n.length<=2)){var i=260*-(n.length-2);t.addClass("scrollable").find(".btn-nav-related").on("click",function(){var t=$(this),n=t.hasClass("btn-next")?"next":"prev",r=parseInt(e.css("left"));if(r<=i&&"next"===n)var o=0;else o=0===r&&"prev"===n?i:r+260*("next"===n?-1:1);e.css("left",o)})}}),new fontSize({text:".article",buttons:".article .sticky-bar .font-size, .tools .text-size"}),"function"==typeof ReportError){var t=new ReportError({news_id:$(".article").data("id")});$(".error-reporting ").off().on("click",".close, .overlay",function(){$(".error-reporting > div").hide(),t.cancel()});var e=function(){return t.isActive()?void t.cancel():void t.on()};$(document).keydown(function(t){t.ctrlKey&&13==t.keyCode&&e()}),$(".report-error, .report-error-fixed").on("click",e)}}),$(function(){var t=window.location.hash;t&&"#print"==t&&window.print();var e=$(".article");$("body.mobile-page").length&&$.each(e.find(".text .article-image a, .intro a"),function(){$(this).attr("href","/m/nuotrauka/?url="+encodeURIComponent($(this).attr("href"))+"&go=1"),$(this).append("<span class='icomoon-zoomin'></span>")});var n=e.find('.text a[name="page_marker"]');n.length&&$("html, body").animate({scrollTop:n.offset().top-45},300),$(".inner-table").wrap('<div class="touch-scroll" />'),window.responsiveFbVideos=function(){$(".embed-item.embed-holder iframe.embed-fb").each(function(){var t,e,n,i=$(this),r=i.parent().innerWidth(),o=i.attr("width"),a=i.attr("height"),s=i.parent().attr("class").split(" "),e=i.attr("src").match("&width=[0-9]{1,4}"),e=e[0].split("=")[1];$.inArray("embed-full-width",s)!==-1?(o=r,n=Math.round(a*o/e)):(o=o,o.indexOf("%")>=0&&("100%"===o?(o=r,n=Math.round(a*o/e)):(o=Math.round(o.split("%")[0]*r/100),n=Math.round(a*o/e)))),o<=r?(a=Math.round(a*o/e),t=n?n:a,i.attr("style","width: "+o+"px !important").height(t)):(a=n?n:a,t=Math.round(a*r/e),i.attr("style","width: "+r+"px !important").height(t))})},responsiveFbVideos(),$(".block-age-confirm.active .btn-yes").on("click",function(t){setTimeout(responsiveFbVideos,0)}),$(window).resize(function(){responsiveFbVideos()}),$(".article .article-content").on("click",'a[href^="#"]',function(t){var e=$(this).attr("href"),n=$('[name="'+e.substring(1)+'"]');if(0!==n.length){t.preventDefault();var i=n.offset().top-(window.__is_mobile_page?$(".header .tabs").height():$(".portal-nav").height());$("body, html").animate({scrollTop:i},2e3)}})});