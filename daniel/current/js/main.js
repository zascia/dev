!function(e,i){if("function"==typeof define&&define.amd)define(["exports","jquery"],function(e,r){return i(e,r)});else if("undefined"!=typeof exports){var r=require("jquery");i(exports,r)}else i(e,e.jQuery||e.Zepto||e.ender||e.$)}(this,function(e,i){var r={validate:/^[a-z_][a-z0-9_]*(?:\[(?:\d*|[a-z0-9_]+)\])*$/i,key:/[a-z0-9_]+|(?=\[\])/gi,push:/^$/,fixed:/^\d+$/,named:/^[a-z0-9_]+$/i};function t(e,t){var n={},a={};function s(e,i,r){return e[i]=r,e}function u(){return n}this.addPair=function(u){if(!r.validate.test(u.name))return this;var f=function(e,i){for(var t,n=e.match(r.key);void 0!==(t=n.pop());)r.push.test(t)?i=s([],(u=e.replace(/\[\]$/,""),void 0===a[u]&&(a[u]=0),a[u]++),i):r.fixed.test(t)?i=s([],t,i):r.named.test(t)&&(i=s({},t,i));var u;return i}(u.name,function(e){switch(i('[name="'+e.name+'"]',t).attr("type")){case"checkbox":return"on"===e.value||e.value;default:return e.value}}(u));return n=e.extend(!0,n,f),this},this.addPairs=function(i){if(!e.isArray(i))throw new Error("formSerializer.addPairs expects an Array");for(var r=0,t=i.length;r<t;r++)this.addPair(i[r]);return this},this.serialize=u,this.serializeJSON=function(){return JSON.stringify(u())}}return t.patterns=r,t.serializeObject=function(){return new t(i,this).addPairs(this.serializeArray()).serialize()},t.serializeJSON=function(){return new t(i,this).addPairs(this.serializeArray()).serializeJSON()},void 0!==i.fn&&(i.fn.serializeObject=t.serializeObject,i.fn.serializeJSON=t.serializeJSON),e.FormSerializer=t,t});

$(document).ready(function() {
    var $form2 = $("form[data-test='email-form']"),
        url = 'https://script.google.com/macros/s/AKfycbxhxs2vUn5k8hP86kSPSohvhMNMETZxQycBLL115xDYE0CJOpo/exec';
        function validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
        $form2.submit(function( e ) {
            e.preventDefault();
            if(validateEmail($('input[name="userEmail"]').val())){
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
            
        })
    
    $('div.bg-near-white.pv2.pv3-ns button').click(function(e){
        e.preventDefault();
        $(this).parent().parent().parent().remove()
    })
    $('.li-tabs').click(function(){
        $('.li-arrow').css('transform','rotate(-0deg)')
        $('.open-li p').slideUp()
        $(this).children('button').children('div').children('.li-arrow').css('transform','rotate(-180deg)')
        $(this).children('.open-li').children('p').slideDown()
    })
});
