!function(e,i){if("function"==typeof define&&define.amd)define(["exports","jquery"],function(e,r){return i(e,r)});else if("undefined"!=typeof exports){var r=require("jquery");i(exports,r)}else i(e,e.jQuery||e.Zepto||e.ender||e.$)}(this,function(e,i){var r={validate:/^[a-z_][a-z0-9_]*(?:\[(?:\d*|[a-z0-9_]+)\])*$/i,key:/[a-z0-9_]+|(?=\[\])/gi,push:/^$/,fixed:/^\d+$/,named:/^[a-z0-9_]+$/i};function t(e,t){var n={},a={};function s(e,i,r){return e[i]=r,e}function u(){return n}this.addPair=function(u){if(!r.validate.test(u.name))return this;var f=function(e,i){for(var t,n=e.match(r.key);void 0!==(t=n.pop());)r.push.test(t)?i=s([],(u=e.replace(/\[\]$/,""),void 0===a[u]&&(a[u]=0),a[u]++),i):r.fixed.test(t)?i=s([],t,i):r.named.test(t)&&(i=s({},t,i));var u;return i}(u.name,function(e){switch(i('[name="'+e.name+'"]',t).attr("type")){case"checkbox":return"on"===e.value||e.value;default:return e.value}}(u));return n=e.extend(!0,n,f),this},this.addPairs=function(i){if(!e.isArray(i))throw new Error("formSerializer.addPairs expects an Array");for(var r=0,t=i.length;r<t;r++)this.addPair(i[r]);return this},this.serialize=u,this.serializeJSON=function(){return JSON.stringify(u())}}return t.patterns=r,t.serializeObject=function(){return new t(i,this).addPairs(this.serializeArray()).serialize()},t.serializeJSON=function(){return new t(i,this).addPairs(this.serializeArray()).serializeJSON()},void 0!==i.fn&&(i.fn.serializeObject=t.serializeObject,i.fn.serializeJSON=t.serializeJSON),e.FormSerializer=t,t});

// Offer form
$(document).ready(function() {
    var $form = $('form#form-ajax'),
        //url = 'https://script.google.com/macros/s/AKfycbw3pMx-9BxDwLrXXPhqYX1FciyRn65zw42y_m-Wghc6-LxGvw8/exec';
        url = 'https://script.google.com/macros/s/AKfycbynf8ioNXu2IeETg3dToMfIeFgHI_eKSjYBDdMpyOiBiwOy6nM5/exec';

    function addEventsValidate(inputArray) {
        for (let i = 0; i < inputArray.length - 1; i++) {
            inputArray[i].valid = $("input[name='" + inputArray[i].name + "']")[0].validity.valid;       
            inputArray[12].valid = true;                
        }

        console.log(inputArray)
        checkInput(inputArray)
    }

    function checkInput(arr) {
        function checkForm(element, index, array) {
            return element.valid;
        }
        if (arr.every(checkForm)) {
            var jqxhr = $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            data: $form.serializeObject(),
            beforeSend: function(){
                $('.popup-wrapper').css('display', 'flex');
            }
            }).done(function (data) {
                console.log("data", JSON.parse(data));
                setTimeout(function(){ $('.popup-wrapper').css('display', 'none') }, 1500); 
                $(':input:visible').first().focus();       
                $("#form-ajax").prepend("<p style='color:green; font-size: 25px; margin-bottom: 20px'>Succes</p>");
            })
        }
        else {
            $('#form-ajax').append('<style>input:invalid { border: 2px solid red; } input:valid { border: 2px solid green; }</style>');
            $(':input:visible').first().focus();
        }
    }

    $form.submit(function( e ) {
        e.preventDefault();
        addEventsValidate($form.serializeArray())
    })
});
// End Offer form

$(document).ready(function() {
    var $form2 = $("form[data-test='email-form']"),
        url = 'https://script.google.com/macros/s/AKfycbxhxs2vUn5k8hP86kSPSohvhMNMETZxQycBLL115xDYE0CJOpo/exec',
        sended = false;

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    $form2.submit(function( e ) {
        e.stopPropagation();
        e.preventDefault();
        if($('.form1-inputa').val()){
            $('input[name="userEmail"]').val($('.form1-inputa').val())
        }

        if(!sended){
            if(validateEmail($('input[name="userEmail"]').val())){
                sended = true;
                var jqxhr = $.ajax({
                    url: url,
                    method: "GET",
                    dataType: "json",
                    data: $form2.serializeObject(),
                    }).done(function (data) {     
                        $('.email-form-status').remove()
                        $form2.append('<p class="email-form-status" style="color: green; font-size: 18px ">Succes</p>')
                    })
            }
            else{
                $('.email-form-status').remove()
                $form2.append('<p class="email-form-status" style="color: red; font-size: 18px">Error</p>')
            }
        }        
    });
    
    $('div.bg-near-white.pv2.pv3-ns button').click(function(e){
        e.preventDefault();
        $(this).parent().parent().parent().remove()
    });
    $('.li-tabs').click(function(){
        $('.open-li p').slideUp()
        $('.open-li p').slideUp()
        if( !$(this).children('.open-li').children('p').is(":visible") ) {
            $(this).children('button').children('div').children('.li-arrow').css('transform','rotate(-180deg)')
            $(this).children('.open-li').children('p').slideDown();
        }
        else{
            $('.li-arrow').css('transform','rotate(-0deg)')
            $('.open-li p').slideUp()
        }           
    });

    $('.sc-bwzfXH.ipEByn').on('click', function (e) {
        e.preventDefault();
        var tab_content = $(this).parent().find('.kmNCuS');
        tab_content.slideToggle();
    });

    var coockie_accept = getCookie('coockie_accept');
    if ( typeof coockie_accept == 'undefined') {
        $('.bg-near-white').slideDown();
    }
    $('.bg-near-white button').on('click', function () {
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + 365);
        setCookie('coockie_accept','true', {expires: exdate, path : "/" });
    });
    $('.review-list span.pt0').on('click', function () {
        $(this).parent().find('.short_review').css('display', 'none');
        $(this).parent().find('.full_review').css('display', 'block');
        $(this).detach();
    });

    $('#lg-init-main, .lg-init-1').on('click', function () {
        lightGallery(document.getElementById('lg-init-main'), {
            dynamic: true,
            dynamicEl: [{
                "src": '../images/solceller-lantbruk-324b15ce5436e24119626e793c70cb5e.jpg',
            }, {
                'src': '../images/solceller-kommersiell-fastighet-c4ecfac490dd696bd773d334fae10225.jpg',
            }, {
                'src': '../images/solceller-havsnara-skargarden-908da7f207bf647a062e54d34c153d30.jpg',
            }]
        })
    });

    $('.lg-init-2').on('click', function () {
        lightGallery(document.getElementById('lg-init-main'), {
            dynamic: true,
            dynamicEl: [
            {
                'src': '../images/solceller-kommersiell-fastighet-c4ecfac490dd696bd773d334fae10225.jpg',
            },
            {
                'src': '../images/solceller-havsnara-skargarden-908da7f207bf647a062e54d34c153d30.jpg',
            },
            {
                "src": '../images/solceller-lantbruk-324b15ce5436e24119626e793c70cb5e.jpg',
            }
            ]
        })
    });

    $('.lg-init-3').on('click', function () {
        lightGallery(document.getElementById('lg-init-main'), {
            dynamic: true,
            dynamicEl: [
                {
                    'src': '../images/solceller-havsnara-skargarden-908da7f207bf647a062e54d34c153d30.jpg',
                },
                {
                    "src": '../images/solceller-lantbruk-324b15ce5436e24119626e793c70cb5e.jpg',
                },
                {
                    'src': '../images/solceller-kommersiell-fastighet-c4ecfac490dd696bd773d334fae10225.jpg',
                }
            ]
        })
    });


    $('#lg-init-main_, .lg-init-11').on('click', function () {
        lightGallery(document.getElementById('lg-init-main_'), {
            dynamic: true,
            dynamicEl: [{
                "src": '../images/solceller-garage-svea-solar-8a6289ed73779f583d1a047004867052.jpg',
            }, {
                'src': '../images/solceller-lantbruk-svea-solar-2abad91112579d53edc210a2a8ad80a4.jpg',
            }, {
                'src': '../images/solceller-markinstallation-svea-solar-5347b28ed70184d8396993a06607fad4.jpg',
            }]
        })
    });

    $('.lg-init-21').on('click', function () {
        lightGallery(document.getElementById('lg-init-main_'), {
            dynamic: true,
            dynamicEl: [
                {
                    'src': '../images/solceller-lantbruk-svea-solar-2abad91112579d53edc210a2a8ad80a4.jpg',
                },
                {
                    'src': '../images/solceller-markinstallation-svea-solar-5347b28ed70184d8396993a06607fad4.jpg',
                },
                {
                    "src": '../images/solceller-garage-svea-solar-8a6289ed73779f583d1a047004867052.jpg',
                }
            ]
        })
    });

    $('.lg-init-31').on('click', function () {
        lightGallery(document.getElementById('lg-init-main_'), {
            dynamic: true,
            dynamicEl: [
                {
                    'src': '../images/solceller-markinstallation-svea-solar-5347b28ed70184d8396993a06607fad4.jpg',
                },
                {
                    "src": '../images/solceller-garage-svea-solar-8a6289ed73779f583d1a047004867052.jpg',
                },
                {
                    'src': '../images/solceller-lantbruk-svea-solar-2abad91112579d53edc210a2a8ad80a4.jpg',
                }
            ]
        })
    });

    $('#accordian-control-read-more-box').click(function(e){
        e.preventDefault();
        if( !$(this).next().is(":visible") ) {
            $('#arrow-read-more').css('transform', 'rotate(180deg)')
            $(this).next().slideDown();
        }
        else{
            $(this).find('#arrow-read-more').css('transform', 'rotate(0deg)')
            $(this).next().slideUp();
        }
    })

    $('#slick-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '#slick-slider-dots'
    });
    $('#slick-slider-dots').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '#slick-slider',
      dots: true,
      centerMode: true,
      focusOnSelect: true
    });


    $('#slick-slider').on('afterChange', function(slick, currentSlide){
        $('#gallery li').removeClass('trigger-slider')
        $('#gallery li:nth-child(' + (currentSlide.currentSlide + 1) + ')').toggleClass("trigger-slider");
    });
    lightGallery(document.getElementById('gallery')) 

    $("#slick-slider .slick-slide button").click(function(){
        $('#gallery .trigger-slider').click();  
    }); 

    $("button.sc-bdVaJa").click(function(){
        $(".trigger-slider").attr("data-src", $(this).find('img').attr('src'));
        $(".trigger-slider img").attr("src", $(this).find('img').attr('src'));
        $('#gallery .trigger-slider').click();  
    }); 
    
});
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}
function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}
