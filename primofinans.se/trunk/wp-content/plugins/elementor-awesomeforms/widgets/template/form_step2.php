<?php
$change = plugins_url('/elementor-awesomeforms/assets/images/change-arrow.png');
$loading_icon = plugins_url('/elementor-awesomeforms/assets/images/loading_icon.gif');
?>
<div class="second-step-form">
    <div class="swedish-version">
        <!--<form action="https://www.axofinans.se/partner" id="axo-form-small" method="post" class="form small-form swedish-version" novalidate="novalidate">-->
        <form action="https://nyweb.axofinans.se/partner" id="axo-form-small" method="post" class="form small-form swedish-version"
              novalidate="novalidate">
            <input id="source" value="Primofinans" name="source" type="hidden">
            <input id="useragentCtrl" value="" name="useragent" type="hidden">
            <input id="conversionPageCtrl" value="https://primofinans.se" name="conversion_page" type="hidden">
            <input id="acceptedTerms" value="" name="accepts_marketing" type="hidden">
            <input id="privacyPolicyUrlCtrl" value="https://primofinans.se/villkor-och-sekretesspolicy/"
                   name="privacy_policy_url" type="hidden">
            <div class="form-top">
                <!-- first step fields -->
                <div class="collapse0">
                    <fieldset class="form-set loan-amount">
                        <div class="col-set">
                            <div class="col">
                                <label class="label loan-amount-label">
                                    <span class="desc first" id="centermobile">
                                        Hur mycket vill du låna?
                                    </span>
                                    <div class="value text large green">
                                        <input id="loan-amount" value=" kr  100 000" type="tel">
                                        <input id="loan-amount-value" value="100000" name="loan_amount" type="hidden">

                                    </div>
                                </label>

                                <label id="refinancing-footnote" class="label" style="display: none;">
                                    <span class="label inline center nomargin"><span
                                            class="hide-mobile">Besparelse inntil:</span><span
                                            class="hide-desktop">Besparelse:</span></span>
                                    <span class="amount-wrapper smaller">
                                        <span class="amount-number-wrapper">
                                            <span class="hide-mobile-inherit">inntil </span><span id="monthly-saving" class="amount color first">2 194</span><span
                                                class="hide-mobile-inherit"> kr</span>
                                        </span>
                                    </span>


                                    <span class="monthly-saving-text">pr mnd hvis du refinansierer kr <span
                                            id="loan-amount-saving"> 100 000</span></span>


                                    <small class="forminfo">*) Utgifter til smågjeld/kredittkort per måned: kr <span id="debt">3 120</span>,-,
                                        terminbeløp: kr <span id="payment"> 926</span>,-, nedbetalingstid: <span
                                            id="annual-terms-info">15</span> år, nom.rente: <span
                                            id="nom-interest">7.49</span>%
                                    </small>
                                </label>

                                <label id="amount-slider-col" class="label slider-label">
                                    <span class="desc no-desc slider"></span>
                                    <div class="ui-slider-wrapper">
                                        <div id="loan-amount-slider"
                                             class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                            <div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min"
                                                 style="width: 18.3673%;"></div>
                                            <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"
                                                  style="left: 18.3673%;"></span></div>
                                    </div>
                                </label>


                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-set annual-terms">
                        <div class="col-set">
                            <div class="col">
                                <label id="form-annual-terms" class="label">
                                    <span class="desc">
                                        Återbetalningstid:
                                    </span>
                                    <div class="value select">
                                        <select name="tenure" id="tenure">

                                        </select>
                                        <!--<input type="tel" name="tenure_new" id="tenureNew">-->
                                        <input class="value-field" name="value_tenure" value="15" type="hidden">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-set monthly-amount">
                        <div class="col-set">
                            <div class="col">
                                <label class="label">
                                    <span class="label inline" id="monthlytext">Månadskostnad för lån:</span>
                                    <span class="amount-wrapper" id="monthly-amount-span">
                                        <span class="amount-number-wrapper">från <span id="monthly-amount" class="amount"> 926</span> kr
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <div class="clearfix form-set main-personal-info">
                        <div class="col-set">
                            <div class="col">
                                <label class="label">
                                    <span class="desc">
                                        E-post:
                                    </span>
                                    <div class="value text parent-valid">
                                        <input name="email" id="email" class="input-text validate-email validate required"
                                               value="" type="email">
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Fyll ut din E-postadresse, eks:<br>
                                                kundeservice@axofinans.se<br>
                                                Kan ikke inneholde ä, ö, å
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div class="col">
                                <label class="label">
                                    <span class="desc">
                                        Mobil:
                                    </span>
                                    <div class="value text parent-valid">
                                        <input name="mobile_number" id="mobile-number"
                                               class="input-text validate-mobile validate required" value=""
                                               type="tel">
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Mobilnummer må fylles ut, 8 siffer
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="hide-mobile inline-block" id="removeme">
                    <div class="hide-mobile" id="form-top-additional">
                        <a id="changestep1" class="no-text-decoration" href="#" style="">
                            <div class="col removediv">
                                <p><span class="underlined"> Ändra lånebelopp</span> <img class="arrow-img" src="<?php echo $change; ?>" alt="Endre steg 1"></p>

                            </div>
                        </a>

                    </div>
                </div>
            </div>
            <div class="form-main">
                <fieldset class="form-set">
                    <h2>Personuppgifter</h2>
                    <div class="col-set">
                        <div class="collapse1">

                            <div class="form-set status-switchers">
                                <div class="col">
                                    <label class="label">
                                        <span class="desc space">
                                            Vill du lösa befintliga lån?
                                        </span>
                                        <label class="radio-option first">
                                            <input id="consolidate-debt-1" type="radio" name="consolidate_debt" value="1"><span>Ja</span>
                                        </label>
                                        <label class="radio-option last">
                                            <input id="consolidate-debt-" type="radio" name="consolidate_debt" value="0" checked="checked"><span>Nej</span>
                                        </label>
                                    </label>
                                </div>
                            </div>

                            <div id="form-employment-type" class="col">
                                <label class="label">
                                    <span class="desc">
                                        Anställningsform:
                                    </span>
                                    <div class="value select">
                                        <select name="employment_type" class="select-valg required">

                                        </select>
                                    </div>
                                </label>
                            </div>
                            <div id="form-monthly-income" class="col" style="display: none;">
                                <label class="label">
                                    <span class="desc">
                                        Månadsinkomst före skatt:
                                    </span>
                                    <div class="value text">
                                        <input type="tel" name="monthly_income" value=""
                                               class="currency validate validate-currency required">
                                        <span class="warning-message-wrapper">
                                            <span class="warning-message-arrow"></span>
                                            <span class="warning-message">
                                                Inkomst före skatt per månad.
                                            </span>
                                        </span>
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Inkomst före skatt per månad, ex. 25 000kr.
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div id="form-employer" class="col" style="display: none;">
                                <label class="label">
                                    <span class="desc">
                                        Arbetsgivare:
                                    </span>
                                    <div class="value text">
                                        <input type="text" name="employer" value=""
                                               class="input-tekst validate required">
                                        <span class="warning-message-wrapper">
                                            <span class="warning-message-arrow"></span>
                                            <span class="warning-message">
                                                Namn på arbetsplats
                                            </span>
                                        </span>
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Namn på arbetsplats
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div id="form-employed-since" class="col" style="display: none;">
                                <div class="label">
                                    <label for="employed-since-year">
                                        <span class="desc">
                                            Anställd sedan:
                                        </span>
                                    </label>
                                    <div class="form-two-column">
                                        <div class="form-col small">
                                            <div class="value select">
                                                <select name="employment_since_year" id="employed-since-year" class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-col large">
                                            <div class="value select">
                                                <select name="employment_since_month" id="employed-since-month" class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-employed-last" class="col" style="display: none;">
                                <div class="label">
                                    <label for="employed-last-year">
                                        <span class="desc">
                                            Anställd tom:
                                        </span>
                                    </label>
                                    <div class="form-two-column">
                                        <div class="form-col small">
                                            <div class="value select">
                                                <select name="employment_last_year" id="employed-last-year"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-col large">
                                            <div class="value select">
                                                <select name="employment_last_month" id="employed-last-month"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-work-number" class="col" style="display: none; padding: 0;">
                                <label class="label" style="display: none">
                                    <span class="desc">
                                        Telefon arbete:
                                    </span>
                                    <div class="value text" style="display: none">
                                        <input type="text" name="work_number" value="" maxlength="15"
                                               class="input-tekst" disabled>
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Telefonnummer till arbetsgivare krävs. Endast siffror.
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div id="form-civilstatus" class="col">
                                <label class="label">
                                    <span class="desc">
                                        Civilstånd:
                                    </span>
                                    <div class="value select">
                                        <select name="civilstatus" class="required">

                                        </select>
                                    </div>
                                </label>
                            </div>
                            <div id="form-number-of-children" class="col" style="display: none;">
                                <label class="label">
                                    <span class="desc">
                                        Antal barn i hushållet under 18:
                                    </span>
                                    <div class="value select">
                                        <select name="number_of_children" class="required">

                                        </select>
                                    </div>
                                </label>
                            </div>
                            <div id="form-living-conditions" class="col">
                                <label class="label">
                                    <span class="desc">
                                        Bostadsform:
                                    </span>
                                    <div class="value select">
                                        <select name="living_conditions" class="required">

                                        </select>
                                    </div>
                                </label>
                            </div>
                            <div id="form-rent" class="col" style="display: none;">
                                <label class="label">
                                    <span class="desc">
                                        Boendekostnad per månad:
                                    </span>
                                    <div class="value text">
                                        <input type="tel" name="rent" value=""
                                               class="currency validate validate-currency required">
                                        <span class="warning-message-wrapper">
                                            <span class="warning-message-arrow"></span>
                                            <span class="warning-message">
                                                Ta inte med bolån/lånekostnader.
                                            </span>
                                        </span>
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Ta inte med bolån/lånekostnader.
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div id="form-address-since" class="col" style="display: none;">
                                <div class="label">
                                    <label for="address-since-year">
                                        <span class="desc">
                                            Adress sedan:
                                        </span>
                                    </label>
                                    <div class="form-two-column">
                                        <div class="form-col small">
                                            <div class="value select">
                                                <select name="address_since_year" id="address-since-year"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-col large">
                                            <div class="value select">
                                                <select name="address_since_month" id="form-address-since-month"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-loan-purpose" class="col" style="">
                                <label class="label">
                                    <span class="desc">
                                        Lånet ska användas till:
                                    </span>
                                    <div class="value select">
                                        <select name="loan_purpose" class="required">

                                        </select>
                                    </div>
                                </label>
                            </div>
                            <div id="form-refinancing" class="form-set col" style="display: none;">
                                <label class="label">
                                    <span class="desc">
                                        Lån/kreditkortskulder att lösa(ej bolån/studielån):
                                    </span>
                                    <div class="value text large parent-valid">
                                        <input id="credit-loan-amount" type="tel"
                                               class="validate required strip-non-numeric bluetext valid">
                                        <input id="credit-loan-amount-value" type="hidden" value="0"
                                               name="credit_loan_amount">
                                    </div>
                                </label>
                                <label id="amount-slider-col" class="label slider-label">
                                    <span class="desc no-desc slider"></span>
                                    <div class="ui-slider-wrapper">
                                        <div id="credit-loan-amount-slider"
                                             class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                            <div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min blue"
                                                 style="width: 0%;"></div>
                                            <span class="ui-slider-handle ui-state-default ui-corner-all"
                                                  tabindex="0" style="left: 0%;"></span></div>
                                    </div>
                                </label>
                            </div>
                            <div id="form-social-number" class="col">
                                <label class="label">
                                    <span class="desc">
                                        Personnummer:
                                    </span>
                                    <div class="value text">
                                        <input type="tel" name="social_number" value=""
                                               class="input-tekst validate-birth-number validate required strip-non-numeric">
                                        <span class="warning-message-wrapper">
                                            <span class="warning-message-arrow"></span>
                                            <span class="warning-message">
                                                Personnummer krävs, 10 eller 12 siffror.
                                            </span>
                                        </span>
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Fel i personnummer, 10 eller 12 siffror.
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="form-set">
                    <h2>Medsökandes personuppgifter</h2>
                    <div class="col-set">

                        <!-- co applicant switcher -->
                        <div class="col">
                            <label class="label co-applicant-label">
                                <span class="desc">
                                    Är ni två sökande som söker lån?
                                </span>
                                <label class="radio-option first">
                                    <input id="co-applicant-1" type="radio" name="co_applicant" value="1"><span>Ja</span>
                                </label>
                                <label class="radio-option last">
                                    <input id="co-applicant-" type="radio" name="co_applicant" value="0" checked="checked"><span>Nej</span>
                                </label>
                            </label>
                        </div>
                        <!-- eo co applicant switcher -->

                        <!-- co applicant fields -->
                        <div class="collapse1">

                            <fieldset id="personal-details-co-applicant" class="" style="display: none;">



                                <div class="col-set">

                                    <div class="col">
                                        <label class="label">
                                            <span class="desc">
                                                Bor du med din medsökande?
                                            </span>
                                            <label class="radio-option first">
                                                <input id="live-together-1" type="radio" name="living_together" value="1"
                                                       checked="checked"><span>Ja</span>
                                            </label>
                                            <label class="radio-option last">
                                                <input id="live-together-" type="radio" name="living_together"
                                                       value="0"><span>Nej</span>
                                            </label>
                                        </label>
                                    </div>

                                    <div id="form-co-social-number" class="col">
                                        <label class="label">
                                            <span class="desc">
                                                Personnummer:
                                            </span>
                                            <div class="value text">
                                                <input type="tel" name="co_applicant_social_number" value=""
                                                       class="input-tekst validate-birth-number validate required strip-non-numeric">
                                                <span class="warning-message-wrapper">
                                                    <span class="warning-message-arrow"></span>
                                                    <span class="warning-message">
                                                        Personnummer krävs, 10 eller 12 siffror.
                                                    </span>
                                                </span>
                                                <span class="error-message-wrapper">
                                                    <span class="error-message-arrow"></span>
                                                    <span class="error-message">
                                                        Fel i personnummer, 10 eller 12 siffror.
                                                    </span>
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                    <div id="form-co-mobile-number" class="col">
                                        <label class="label">
                                            <span class="desc">
                                                Telefon mobil:
                                            </span>
                                            <div class="value text">
                                                <input type="tel" name="co_applicant_mobile_number" value=""
                                                       class="input-tekst validate-mobile validate required strip-non-numeric">
                                                <span class="warning-message-wrapper">
                                                    <span class="warning-message-arrow"></span>
                                                    <span class="warning-message">
                                                        Mobilnummer krävs, 10 siffror. Exempel: 07XXXXXXXX.
                                                    </span>
                                                </span>
                                                <span class="error-message-wrapper">
                                                    <span class="error-message-arrow"></span>
                                                    <span class="error-message">
                                                        Mobilnummer krävs, 10 siffror. Exempel: 07XXXXXXXX.
                                                    </span>
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                    <div id="form-co-email" class="col">
                                        <label class="label">
                                            <span class="desc">
                                                E-post:
                                            </span>
                                            <div class="value text">
                                                <input type="email" name="co_applicant_email" value=""
                                                       class="input-tekst validate-email validate required">
                                                <span class="error-message-wrapper">
                                                    <span class="error-message-arrow"></span>
                                                    <span class="error-message">
                                                        E-post krävs, exempel kundservice@smartlaanet.se. Kan inte innehålla å, ä, ö.
                                                    </span>
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                    <div id="form-co-employment-type" class="col">
                                        <label class="label">
                                            <span class="desc">
                                                Anställningsform:
                                            </span>
                                            <div class="value select">
                                                <select name="co_applicant_employment_type" class="select-valg required">

                                                </select>
                                            </div>
                                        </label>
                                    </div>

                                </div>
                            </fieldset>
                        </div>
                        <!-- end co applicant fields -->


                    </div>
                </fieldset>
                <fieldset class="form-set">
                    <h2>&nbsp;</h2>
                    <div class="col-set">

                        <div class="collapse2" style="display: none">
                            <div id="form-co-monthly-income" class="col" style="display: none;">
                                <label class="label">
                                    <span class="desc">
                                        Månadsinkomst före skatt:
                                    </span>
                                    <div class="value text">
                                        <input type="tel" name="co_applicant_monthly_income" value=""
                                               class="currency validate validate-currency required">
                                        <span class="warning-message-wrapper">
                                            <span class="warning-message-arrow"></span>
                                            <span class="warning-message">
                                                Inkomst före skatt per månad.
                                            </span>
                                        </span>
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Inkomst före skatt per månad, ex. 25 000kr.
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div id="form-co-employer" class="col" style="display: none;">
                                <label class="label">
                                    <span class="desc">
                                        Arbetsgivare:
                                    </span>
                                    <div class="value text">
                                        <input type="text" name="co_applicant_employer" value=""
                                               class="input-tekst validate required">
                                        <span class="warning-message-wrapper">
                                            <span class="warning-message-arrow"></span>
                                            <span class="warning-message">
                                                Namn på arbetsplats
                                            </span>
                                        </span>
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Namn på arbetsplats
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div id="form-co-employed-since" class="col" style="display: none;">
                                <div class="label">
                                    <label for="co-employed-since-year">
                                        <span class="desc">
                                            Anställd sedan:
                                        </span>
                                    </label>
                                    <div class="form-two-column">
                                        <div class="form-col small">
                                            <div class="value select">
                                                <select name="co_applicant_employment_since_year"
                                                        id="co-employed-since-year"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-col large">
                                            <div class="value select">
                                                <select name="co_applicant_employment_since_month"
                                                        id="co-employed-since-month"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-co-employed-last" class="col" style="display: none;">
                                <div class="label">
                                    <label for="co-employment-last-year">
                                        <span class="desc">
                                            Anställd tom:
                                        </span>
                                    </label>
                                    <div class="form-two-column">
                                        <div class="form-col small">
                                            <div class="value select">
                                                <select name="co_applicant_employment_last_year"
                                                        id="co-employment-last-year"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-col large">
                                            <div class="value select">
                                                <select name="co_applicant_employment_last_month"
                                                        id="co-employment-last-month"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-co-work-number" class="col" style="display: none; padding: 0;">
                                <label class="label" style="display: none;">
                                    <span class="desc">
                                        Telefon arbete:
                                    </span>
                                    <div class="value text" style="display: none;">
                                        <input type="text" name="co_applicant_work_number" maxlength="15"
                                               disabled
                                               value=""
                                               class="input-tekst">
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Telefonnummer till arbetsgivare krävs. Endast siffror.
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div id="form-co-civilstatus" class="col">
                                <label class="label">
                                    <span class="desc">
                                        Civilstånd:
                                    </span>
                                    <div class="value select">
                                        <select name="co_applicant_civilstatus" class="required">

                                        </select>
                                    </div>
                                </label>
                            </div>
                            <div id="form-co-living-conditions" class="col" style="display: none;">
                                <label class="label">
                                    <span class="desc">
                                        Bostadsform:
                                    </span>
                                    <div class="value select">
                                        <select name="co_applicant_living_conditions" class="required">

                                        </select>
                                    </div>
                                </label>
                            </div>
                            <div id="form-co-rent" class="col" style="display: none;">
                                <label class="label">
                                    <span class="desc">
                                        Boendekostnad per månad:
                                    </span>
                                    <div class="value text">
                                        <input type="tel" name="co_applicant_rent" value=""
                                               class="currency validate validate-currency required">
                                        <span class="warning-message-wrapper">
                                            <span class="warning-message-arrow"></span>
                                            <span class="warning-message">
                                                Ta inte med bolån/lånekostnader.
                                            </span>
                                        </span>
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message">
                                                Ta inte med bolån/lånekostnader.
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div id="form-co-address-since" class="col" style="display: none;">
                                <div class="label">
                                    <label for="co-address-since-year">
                                        <span class="desc">
                                            Adress sedan:
                                        </span>
                                    </label>
                                    <div class="form-two-column">
                                        <div class="form-col small">
                                            <div class="value select">
                                                <select name="co_applicant_address_since_year" id="co-address-since-year"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-col large">
                                            <div class="value select">
                                                <select name="co_applicant_address_since_month"
                                                        id="co-address-since-month"
                                                        class="select-valg required">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="form-bottom-controls">
                            <div class="col border-col">
                                <div class="accept-terms">
                                    <label>
                                        <input name="accepted-terms" class="required"
                                               title="Jeg godtar at modtage lånetilbud fra SmartLånet" type="checkbox">
                                        <span>Jag samtycker till att Axo Finans AB får behandla mina/våra <a id="open-terms-modal" href="#">personuppgifter</a></span>
                                        <span class="error-message error-message-custom">Vänligen godkän användaravtalet.</span>
                                    </label>
                                </div>

                            </div>

                            <div id="form-morgage" class="col">
                                <label class="label">
                                    <button type="submit" class="button next step" id="submitbutton">Ansök nu
                                        <span class="next-arrow">&#8680;</span>
                                    </button>
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="terms-modal" id="terms-modalbox" style="display: none">
                <a href="#" class="close">×</a>
                <h2>Kreditupplysning</h2>
                <p>Axo Finans samarbetar med UC AB, som garanterar att endast en kreditupplysning registreras på dig och din eventuella medsökande när vi gör förfrågningar till våra banker och låneinstitut som är Bluestep Bank, Collector Bank, Frogtail, Marginalen Bank, Nordax Bank, Santander Bank, Sevenday Finans, Spring Finance, FOREX Bank, Wasa Kredit och Lendify. I enstaka fall kan vissa av våra samarbetspartners utöver detta ta in ytterligare information som tillägg till informationen från UC för att förbättra kvaliteten i kreditbeslutet.</p>

                <h2>PUL – Personuppgiftslagen</h2>
                <p>Personuppgiftslagen (PUL 1998:204) trädde i kraft i oktober 1998 och gäller fullt ut från och med den 1 oktober 2001. Lagen ger dig som kund rätt till information om behandling av personuppgifter.</p>

                <h2>Personuppgiftsansvarig</h2>
                <p>Axo Finans AB med organisationsnummer 556907-5673 är ansvariga för de personuppgifter som du lämnar och behandlingen sker i enlighet med gällande lagstiftning.</p>

                <h2>Användning av dina personuppgifter</h2>
                <p>Vi lagrar och använder dina personuppgifter för att kunna förmedla lån till dig. Dina personuppgifter kan komma att lämnas ut för behandling av våra banker och låneinstitut i syfte att kunna tillhandahålla begärd tjänst. Med din låneansökan så godkänner du att dina uppgifter används vidare i informationssyfte samt för marknadsföring via telefon och elektronisk kommunikation (t.ex. e-post och sms). Du samtycker härmed även att uppgifterna kan användas för utveckling av nya tjänster samt för att anpassa annonsering och erbjudanden som är mest relevant för dig. Du godkänner genom dessa användarvillkor att Axo Finans AB har rätt att kontinuerligt skicka erbjudanden och nyhetsbrev till den e-postadress du uppger. Du kan avanmäla dig från vårt nyhetsbrev när som helst via den avanmälningslänk som tillhandahålls i alla nyhetsbrev. Uppgifterna kan även komma att lämnas ut till våra samarbetspartners i ovan nämnda syften. Du kan kontakta oss på 0771-323 400 om du inte vill att dina personuppgifter används i samband med marknadsföring.</p>

                <h2>PEP - Politiskt exponerad person</h2>
                <p>Begreppet PEP omfattar i huvudsak politiker på nationell nivå, andra högre ämbetsmän, samt familjemedlemmar till dessa. Är du politiskt exponerad person behöver du meddela detta till oss innan du skickar in din ansökan eftersom det är tillämplig på Axo finans verksamhet enligt Lag (2009:62) om åtgärder mot penningtvätt och finansiering av terrorism samt Finansinspektionens föreskrifter (FFFS 2009:1) och allmänna råd om åtgärder mot penningtvätt och finansiering av terrorism. Genom att godkänna din låneansökan bekräftar du att du inte är en politiskt exponerad person och även att syftet med din låneansökan inte är för att begå allvarlig brottslighet s k. terrorism eller penningtvätt.</p>
            </div>

            <div class="terms-modal" id="loading-modalbox" style="display: none">
                <h2 class="loading-modalbox-title">Väntar på besked...</h2>
                <img class="loading-modalbox-ico" src="<?php echo $loading_icon; ?>" alt="loading" />
            </div>

        </form>

    </div>
</div>