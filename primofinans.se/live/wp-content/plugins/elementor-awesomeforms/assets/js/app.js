/**
 * Created by ashu on 10-Mar-17.
 */
( function( $ ) {
/* dynamic calculator */
function applyDynamicCalculator() {
    /**
     *  * Constants or variables given by user
     *   */
    let years = document.getElementById("tenure").value;
    let loanAmount = document.getElementById("loan-amount-value").value;

    let calculatePayment = (loanAmount, years) => {
        loans = {
            "consumer-credit": {
                startupFee: 495,
                monthlyFee: 0,
                nomInterest: 0.05494
            }
        };
        var termInterest = loans["consumer-credit"].nomInterest / 12;
        var monthlyFee = loans["consumer-credit"].monthlyFee
        let monthlyTerms = years * 12;
        let payment = (Math.round((loanAmount * termInterest) / (1.0 - Math.pow((1.0 + termInterest), -monthlyTerms))) == 0) ? Math.round((loanAmount * termInterest) / (1.0 - Math.pow((1.0 + termInterest), -monthlyTerms))) : Math.round((loanAmount * termInterest) / (1.0 - Math.pow((1.0 + termInterest), -monthlyTerms))) + monthlyFee;
        return payment;
    };

    function updateNumbers(loanAmount, years) {
        let monthlyRate = calculatePayment(loanAmount, years);

        // Update monthly amount
        document.getElementById("monthly-amount").textContent = monthlyRate;

    }

    /* Listener on loanamount dropdown */
    document.getElementById("loan-amount-value").onchange = function () {
        loanAmount = document.getElementById("loan-amount-value").value;
        updateNumbers(loanAmount, years);
    }

    /* Listener on paytime dropdown */
    document.getElementById("tenure").onchange = function () {
        years = document.getElementById("tenure").value
        updateNumbers(loanAmount, years);
    }

    updateNumbers(loanAmount, years);
}

/* eo dynamic calculator */

$(document).ready(function() {
    var domain_val = $('#domain_val').val();
    /* validation on the fly */
    function addEventsValidate(formClass) {
        let inputArray = $(formClass).serializeArray();
        for (let i = 0; i < inputArray.length; i++) {
            if ($("input[name='" + inputArray[i].name + "']").length == 0) {
                $("select[name='" + inputArray[i].name + "']").change(function() {
                    changeValid(inputArray, formClass);
                })
            } else {
                $("input[name='" + inputArray[i].name + "']").keyup(function() {
                    changeValid(inputArray, formClass);
                })
            }

        }
    }

    function changeValid(inputArray, formClass) {
        for (let i = 0; i < inputArray.length; i++) {
            if ($("input[name='" + inputArray[i].name + "']").length == 0) {
                inputArray[i].valid = $("select[name='" + inputArray[i].name + "']")[0].validity.valid;
                checkInput(inputArray, formClass);
            } else {
                inputArray[i].valid = $("input[name='" + inputArray[i].name + "']")[0].validity.valid;
                checkInput(inputArray, formClass);
            }
        }
    }

    function checkInput(arr, formClass) {
        function checkForm(element, index, array) {
            return element.valid;
        }
        if (arr.every(checkForm)) {
            $('body').addClass('form-validate-OK');
            $('body').removeClass('form-validate-Error');
        } else {
            $('body').removeClass('form-validate-OK');
            $('body').addClass('form-validate-Error');
        }
    }
    addEventsValidate('#axo-form-small');
        /* eo validation on the fly */

    // localstorage for calculator state
    var calcState = {
        calcValues: {}
    };

    calcPageInit();

    /* permission widget */
    // get permission label text either from the label or form local storage
    // fill up the proper getresponse field on load
    if (calcState.calcValues['permission'] === undefined) {
        calcState.calcValues['permission'] = $.trim($("#permissionTextLabel").text()) || "No such text on the page";
    }
    $("#customPermission").prop("value", calcState.calcValues['permission']);
    /* eo permission widget */

    function calcPageInit() {
        checkCalcState();

        if (document.querySelectorAll('.elementor-widget-awesomeformsstep1').length > 0) {
            // initialize Axo script logic from sl-min.js
            AxoScript9473.setLanguage("sv");
            AxoScript9473.setCountry("SE");
            AxoScript9473.init("#axo-form-small");

            calcState.calcValues['reqid'] = getURLParameter('reqid') || 0;
            var affid = getURLParameter('utm_content') || 14611;

            $("#fictiveNextStep1").on("click", function(e) {
                e.preventDefault();
                $(".fictiveNextStep1Container").show();
                $(".fictiveNextStep1Head").hide();
                setTimeout(function() {AxoScript9473.validate();},0);
            });

            setTimeout(function() {applyDynamicCalculator();},0);

            btn = document.querySelector('.button.next.step');
            btn.addEventListener('click', step2Click);
        } else {
            if ($("#axo-form-small").length) {
                AxoScript9473.setLanguage("sv");
                AxoScript9473.setCountry("SE");

                AxoScript9473.init("#axo-form-small");

                restoreCurrentValues();

                setTimeout(function() {applyDynamicCalculator();},0);

                $form = document.querySelector('#axo-form-small');
                $form.addEventListener('submit', submitEvent);
                $("#changestep1").on("click", showhiddenstep1);
            }

            // fire accepted facebook pixel
            if( $(".accept-end-page").length > 0 ) {
                if (getURLParameter("tid")) {
                    var src = "https://www.facebook.com/tr?id=3374662439258353&ev=Completeregistration&noscript=1";
                    addTrackingPixel("accept-end-page", src);
                }

                if (localStorage.getItem('SEPRMValues')) {
                    localStorage.removeItem('SEPRMValues');
                }
            }

        }

    };

    function showhiddenstep1(e) {
        e.preventDefault();
        $(".form-top .collapse0").show("slow");
        $("#removeme").hide("slow");
    }



    function checkCalcState() {
        var data = localStorage.getItem('SEPRMValues');
        if (data) {
            calcState.calcValues = JSON.parse(data);
        }
    };

    function updateCalcState() {
        dataToPut = JSON.stringify(calcState.calcValues);
        localStorage.setItem('SEPRMValues', dataToPut);
    };

    function restoreCurrentValues() {
        document.querySelector('#email').value = calcState.calcValues['emailValue'] || '';
        document.querySelector('#loan-amount-value').value = calcState.calcValues['loanAmountValue'] || 0;
        document.querySelector('#loan-amount').value = calcState.calcValues['loanAmountValue'] || 0;
        document.querySelector('#mobile-number').value = calcState.calcValues['mobileNumberValue'] || 0;
        document.querySelector('#acceptedTerms').value = calcState.calcValues['accepts_marketing'];

        //if ( calcState.calcValues['consolidateDebt'] == 1 ) document.querySelector('#consolidate-debt-1').checked = true;

    };

    function getCalcCurrentValues() {
        calcState.calcValues['loanAmountValue'] = document.querySelector('#loan-amount-value').value || 0;
        calcState.calcValues['loanTenureValue'] = document.querySelector('#tenure').value || 0;
        calcState.calcValues['emailValue'] = document.querySelector('#email').value || '';
        calcState.calcValues['mobileNumberValue'] = document.querySelector('#mobile-number').value || 0;
        //calcState.calcValues['consolidateDebt'] = document.querySelector('[name=consolidate_debt]:checked').value || 0;

        calcState.calcValues['afid'] = getURLParameter('caid') || 0;
        calcState.calcValues['utm_content'] = getURLParameter('caid') || 0;
        calcState.calcValues['accepts_marketing'] = document.querySelector('#acceptedTerms').checked ? 1 : 0;
    }

    function sendCampaignForm(formID) {
        // campaign form submit
        if (fbq !== undefined) {
            fbq('track', 'Lead');
        }

        var $form = $('#' + formID);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize()
        }).done(function() {
            location.href = domain_val+"/step2";
        }).fail(function() {
            location.href = domain_val+"/step2";
        });
    }

    function sendStep2CampaignForm(formID) {
        // campaign form submit
        var $form = $('#' + formID);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize()
        }).done(function() {}).fail(function() {});
    }

    function prepareCampaignForm() {
        // fill the step1 campaign form values
        document.querySelector('#customEmailCampaign').value = calcState.calcValues['emailValue'] || '';
        document.querySelector('#customLoanamountCampaign').value = calcState.calcValues['loanAmountValue'] || 0;
        document.querySelector('#customMobilenumberCampaign').value = calcState.calcValues['mobileNumberValue'] || 0;
        document.querySelector('#customLoandurationCampaign').value = calcState.calcValues['loanTenureValue'] || 0;
        document.querySelector('#customAfID').value = calcState.calcValues['afid'];

        var newDate = new Date();
        var currentDate = newDate.toISOString().slice(0,10);
        $("#customCurrentDate").attr("value", currentDate);

    }

    function sendMainForm(formID) {
        var $form = $('#' + formID);
        var formArray = $form.serializeArray();
        var formArrayFiltered = $.grep(formArray, function(formField, i) {
            return formField.value !== "";
        });

        var dataToSend = "",
            responseStatus = "",
            transactionID = "",
            applicationComments = "",
            reqid = calcState.calcValues['reqid'];

        for (var i = 0; i < formArrayFiltered.length; i++) {
            dataToSend += formArrayFiltered[i]['name'] + "=" + formArrayFiltered[i]['value'];
            if (formArrayFiltered[i]['name'] === 'credit_loan_amount') {
                dataToSend += "&privateloan=" + formArrayFiltered[i]['value'] / 2 + "&creditloan=" + formArrayFiltered[i]['value'] / 2;
            }
            if (i != (formArrayFiltered.length - 1)) dataToSend += "&";
        }

        // filter living together when co applicant is 0
        if (dataToSend.indexOf("co_applicant=0") > -1) {
            dataToSend = dataToSend.replace(/&living_together=./, "");
        }

        // open loading image overlay
        $("#loading-modalbox").modal().open();

        // main form submit
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: dataToSend
        }).done(function(response) {
            // success here;
            var responseObj = JSON.parse(response);

            console.log("responseObj", responseObj);

            responseStatus = responseObj.status;
            transactionID = responseObj.transactionID;
            $.each(responseObj.errors, function(i, val) {
                applicationComments += val + " ";
            });

            //$("#loading-modalbox").modal().close();

            // reswitch active breadcrumb
            $(".breadcrumb-active").removeClass("breadcrumb-active").next().addClass("breadcrumb-active");

            $form.hide();
            if (responseStatus === "Accepted") {
                location.href = domain_val+"/a/?tid=" + responseObj.transactionID;

            } else if (responseStatus === "Rejected") {
                location.href = domain_val+"/r/?tid=" + responseObj.transactionID;
            }


        }).fail(function(response) {
            // fail here;
            /*var responseObj = JSON.parse(response);
            responseStatus = responseObj.status;*/

            location.href = domain_val+"/er";

        }).always(function() {

		});

    }

    function generateReqId() {
        /*$.ajax({
            'url': "/upwork/skabelon/trunk/modules/track/reqidgen.php",
            data: {
                "generate": true,
                partnerID: "SEAXO"
            },
            method: "POST"
        }).done(function(resp) {
            var generatedReqId = resp ? resp : 0;
            calcState.calcValues['reqid'] = generatedReqId;
        });*/

        calcState.calcValues['reqid'] = 0;
    }

    function getURLParameter(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
    }

    function addTrackingPixel(container, src) {
        var img = document.createElement("IMG");
        img.src = src;
        img.width = "1";
        img.height = "1";
        img.style.display = "none";
        document.querySelector("."+container).appendChild(img);
    }

    function step2Click(e) {
        e.preventDefault();

        // very bad workaround to avoid sending empty fields
        checkInputsEmptyStep1()
            // adding custom validation method to check terms and conditions on step1
        checktermsStep1();

        setTimeout(function() {
            var form = $("#axo-form-small");
            var errorsCount = checkErrors(form);

            if (errorsCount === 0) {
                getCalcCurrentValues();
                updateCalcState();

                prepareCampaignForm();
                sendCampaignForm('campaignForm');
            }
        }, 0);

    }

    function checkInputsEmptyStep1() {
        // very bad workaround to avoid sending empty fields
        if ($("#mobile-number").prop("value") === "") {
            $("#mobile-number").parent().addClass("error");
        }
        if ($("#email").prop("value") === "") {
            $("#email").parent().addClass("error");
        }

    }

    function checktermsStep1() {
        var termsCheckbox = $("input[name='accepted-terms-mandatory']");

        if (!$(termsCheckbox).is(":checked")) {
            termsCheckbox.parent().addClass("error");
        }
    }

    function checkErrors(form) {
        var errorsCount = 0;
        return errorsCount = form.find("input.not-valid").length + form.find(".text.error").length + form.find(".select.error").length + form.find("label.error").length;
    }

    function submitEvent(e) {
        // we use timeout to avoid function start before axoscript vallidation
        e.preventDefault();

        setTimeout(function() {
            var form = $("#axo-form-small");
            var errorsCount = checkErrors(form);

            if (errorsCount === 0) {
                normalizeData(form);
                sendMainForm("axo-form-small");
                // form.submit();
            }

        }, 0);

    }

    function normalizeData(form) {

        var numbersToNormalize = {
            "income": "",
            "monthly_income": "",
            "rent": "",
            "allimony_per_month": "",
            "rent_income": "",
            "mortgage": "",
            "education_loan": "",
            "spouse_income": "",
            "co_applicant_income": "",
            "co_applicant_monthly_income": "",
            "co_applicant_rent": "",
            "total_unsecured_debt": "",
            "car_boat_mc_loan": "",
            "total_unsecured_debt_balance": ""
        };

        var valuesToNormalize = {
            "employment_type": "",
            "education": "",
            "civilstatus": "",
            "living_conditions": "",
            "co_applicant_employment_type": "",
            "co_applicant_employment_since_month": "",
            "co_applicant_employment_last_month": "",
            "co_applicant_education": "",
            "co_applicant_civilstatus": "",
            "co_applicant_living_conditions": "",
            "co_applicant_address_since_month": "",
            "employment_since_month": "",
            "employment_last_month": "",
            "address_since_month": "",
            "loan_purpose": ""
        }

        /*var valuesToAddIntegers = {
            "employment_since_year": "",
            "employment_last_year": "",
            "rent": ""
        }*/

        // fix problem when unnecessary value doesn't contain integer
        /*$.each(valuesToAddIntegers, function(key, value) {
            var input = form.find('[name="' + key + '"]');
            if ( input.val() == "" ) {
                var newValue = 0;
                input.val(newValue);
            }
        });*/

        $.each(numbersToNormalize, function(key, value) {
            var input = form.find('input[name="' + key + '"]');
            if (input.is(':visible')) {
                var oldValue = input.val();
                var newValue = oldValue.replace(/kr/, "").replace(/,-/, "").replace(/\s*/g, "");
                input.val(newValue);
            }
        });

        // select value doesn't correspond to parameter type required by server so it is removed and new one with correct value created
        $.each(valuesToNormalize, function(key, value) {
            var select = form.find('select[name="' + key + '"]');
            if (select.is(':visible')) {
                var newValue = select.find('option:selected').text();
                select.parent().append("<input type='hidden' name='" + key + "' value='" + newValue + "'>");
                select.remove();
            }
        });

        // add utm_content parameter if it was present in URL on first step
        if (calcState.calcValues['utm_content'] != 0) {
            form.append("<input type='hidden' name='content' value='" + calcState.calcValues['utm_content'] + "'>");
        }

        /* section for the new fields version June 2019 */
        $("#useragentCtrl").prop("value", navigator.userAgent);
        /* eo section for the new fields version June 2019 */

        // remove unnecessary field from auto generated source
        var unnecessary = form.find('input[name="value_total_unsecured_debt"]');
        unnecessary.remove();

    }


});
} )( jQuery );