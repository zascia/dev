<form action="" id="axo-form-small" method="post" class="form small-form swedish-version" novalidate="novalidate">
    <div class="form-body form-main">
        <fieldset class="form-set loan-amount">
            <div class="col-set">
                <div class="col">
                    <label class="label loan-amount-label">
                        <span class="desc first" id="centermobile">
                            Hur mycket vill du låna?
                        </span>
                        <div class="value text large green">
                            <input id="loan-amount" value=" kr  100 000" type="tel">
                            <input id="loan-amount-value" value="100000" name="loan_amount"
                                   type="hidden">

                        </div>
                    </label>

                    <label id="refinancing-footnote" class="label" style="display: none;">
                        <span class="label inline center nomargin"><span
                                class="hide-mobile">Besparelse inntil:</span><span
                                class="hide-desktop">Besparelse:</span></span>
                        <span class="amount-wrapper smaller">
                            <span class="amount-number-wrapper">
                                <span class="hide-mobile-inherit">inntil </span><span
                                    id="monthly-saving" class="amount color first">2 194</span><span
                                    class="hide-mobile-inherit"> kr</span>
                            </span>
                        </span>


                        <span class="monthly-saving-text">pr mnd hvis du refinansierer kr <span
                                id="loan-amount-saving"> 100 000</span></span>


                        <small class="forminfo">*) Utgifter til smågjeld/kredittkort per måned: kr
                            <span id="debt">3 120</span>,-,
                            terminbeløp: kr <span id="payment"> 926</span>,-, nedbetalingstid: <span
                                id="annual-terms-info">18</span> år, nom.rente: <span
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
                                <span class="ui-slider-handle ui-state-default ui-corner-all"
                                      tabindex="0" style="left: 18.3673%;"></span>
                            </div>
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
                            <span class="amount-number-wrapper">från <span id="monthly-amount"
                                                                           class="amount"> 926</span> kr
                            </span>
                        </span>
                    </label>
                </div>
            </div>
        </fieldset>

        <div class="form-set up main-applicant">
            <!-- first step fields -->
            <div class="collapse0">
                <div class="form-set main-personal-info">
                    <div class="col-set">
                        <div class="col">
                            <label class="label">
                                <span class="desc">
                                    E-post:
                                </span>
                                <div class="value text parent-valid">
                                    <input name="email" id="email"
                                           class="input-text validate-email validate required" value=""
                                           type="email">
                                    <span class="error-message-wrapper">
                                        <span class="error-message-arrow"></span>
                                        <span class="error-message">
                                            Fyll ut din E-postadresse, eks:<br>
                                            mail@smartlaanet.se<br>
                                            Kan ikke inneholde æ, ø, å
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
                                    <input name="mobile_number" id="mobile-number" required class="input-text validate-mobile validate required" value="" maxlength="10" type="tel" pattern="^0(10|70|72|73|74|76)(\d{7})$">
                                    <span class="error-message-wrapper">
                                        <span class="error-message-arrow"></span>
                                        <span class="error-message">
                                            Mobilnummer må fylles ut, 10 siffer
                                        </span>
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col border-col">
                    <div class="accept-terms">
                        <label>
                            <input name="accepted-terms" id="acceptedTerms"
                                   title="Jeg godtar at modtage lånetilbud fra SmartLånet"
                                   type="checkbox">
                            <span id="permissionTextLabel">Jag samtycker till att Smartlaanet and Axo Finans AB håller mig uppdaterad om lån och krediter via e-post eller sms. Jag kan närsomhelst avanmäla mig detta.</span>
                            <span class="error-message error-message-custom">Vänligen acceptera villkoren från Smartlånet</span>
                        </label>
                    </div>

                </div>

                <div class="div-next">
                    <!--<a href="step2.htm" class="button next step">Neste</a>-->
                    <button type="button" class="button next step custom-submit">Nästa</button>
                </div>

                <center>
                    <a href="#"
                       onClick="window.open('./persondatapolitik_t&c_se_sl.html', 'personuppgiftspolicy', 'resizable,height=900,width=500,scrollbars=yes'); return false;">Läs
                        v&aring;re personuppgiftspolicy</a>
                </center>
            </div>
            <div class="collapse1">

                <div id="form-employment-type" class="col">
                    <label class="label">
                        <span class="desc">
                            Anställningsform:
                        </span>
                        <div class="value select">
                            <select name="employment_type" class="select-valg required">
                                <option value=""></option>
                                <option value="1">Fast anställd</option>
                                <option value="3">Vikariat</option>
                                <option value="4">Egen rörelse</option>
                                <option value="5">Pensionär</option>
                                <option value="6">Studerande</option>
                                <option value="9">Arbetslös</option>
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
                                        <option value=""></option>
                                        <option value="2017">2017</option>
                                        <option value="2016">2016</option>
                                        <option value="2015">2015</option>
                                        <option value="2014">2014</option>
                                        <option value="2013">2013</option>
                                        <option value="2012">2012</option>
                                        <option value="2011">2011</option>
                                        <option value="2010">2010</option>
                                        <option value="2009">2009</option>
                                        <option value="2008">2008</option>
                                        <option value="2007">2007</option>
                                        <option value="2006">2006</option>
                                        <option value="2005">2005</option>
                                        <option value="2004">2004</option>
                                        <option value="2003">2003</option>
                                        <option value="2002">2002</option>
                                        <option value="2001">2001</option>
                                        <option value="2000">2000</option>
                                        <option value="1999">1999</option>
                                        <option value="1998">1998</option>
                                        <option value="1997">1997</option>
                                        <option value="1996">1996</option>
                                        <option value="1995">1995</option>
                                        <option value="1994">1994</option>
                                        <option value="1993">1993</option>
                                        <option value="1992">1992</option>
                                        <option value="1991">1991</option>
                                        <option value="1990">1990</option>
                                        <option value="1989">1989</option>
                                        <option value="1988">1988</option>
                                        <option value="1987">1987</option>
                                        <option value="1986">1986</option>
                                        <option value="1985">1985</option>
                                        <option value="1984">1984</option>
                                        <option value="1983">1983</option>
                                        <option value="1982">1982</option>
                                        <option value="1981">1981</option>
                                        <option value="1980">1980</option>
                                        <option value="1979">1979</option>
                                        <option value="1978">1978</option>
                                        <option value="1977">1977</option>
                                        <option value="1976">1976</option>
                                        <option value="1975">1975</option>
                                        <option value="1974">1974</option>
                                        <option value="1973">1973</option>
                                        <option value="1972">1972</option>
                                        <option value="1971">1971</option>
                                        <option value="1970">1970</option>
                                        <option value="1969">1969</option>
                                        <option value="1968">1968</option>
                                        <option value="1967">1967</option>
                                        <option value="1966">1966</option>
                                        <option value="1965">1965</option>
                                        <option value="1964">1964</option>
                                        <option value="1963">1963</option>
                                        <option value="1962">1962</option>
                                        <option value="1961">1961</option>
                                        <option value="1960">1960</option>
                                        <option value="1959">1959</option>
                                        <option value="1958">1958</option>
                                        <option value="1957">1957</option>
                                        <option value="1956">1956</option>
                                        <option value="1955">1955</option>
                                        <option value="1954">1954</option>
                                        <option value="1953">1953</option>
                                        <option value="1952">1952</option>
                                        <option value="1951">1951</option>
                                        <option value="1950">1950</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-col large">
                                <div class="value select">
                                    <select name="employment_since_month" id="employed-since-month" class="select-valg required">
                                        <option value=""></option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Mars</option>
                                        <option value="4">April</option>
                                        <option value="5">Maj</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Augusti</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
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
                                    <select name="employment_last_year" id="employed-last-year" class="select-valg required">
                                        <option value=""></option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-col large">
                                <div class="value select">
                                    <select name="employment_last_month" id="employed-last-month" class="select-valg required">
                                        <option value=""></option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Mars</option>
                                        <option value="4">April</option>
                                        <option value="5">Maj</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Augusti</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="form-work-number" class="col" style="display: none;">
                    <label class="label">
                        <span class="desc">
                            Telefon arbete:
                        </span>
                        <div class="value text">
                            <input type="text" name="work_number" value="" maxlength="15"
                                   class="input-tekst required validate">
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
                                <option value=""></option>
                                <option value="1">Gift</option>
                                <option value="2">Sambo</option>
                                <option value="3">Ensamstående</option>
                                <option value="4">Skild</option>
                                <option value="5">Änka/änkling</option>
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
                                <option value=""></option>
                                <option value="0">0 barn</option>
                                <option value="1">1 barn</option>
                                <option value="2">2 barn</option>
                                <option value="3">3 barn</option>
                                <option value="4">4 barn</option>
                                <option value="5">5 barn</option>
                                <option value="6">6 barn</option>
                                <option value="7">7 barn</option>
                                <option value="8">8 barn</option>
                                <option value="9">9 barn</option>
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
                                <option value=""></option>
                                <option value="2">Villa/radhus</option>
                                <option value="3">Bostadsrätt</option>
                                <option value="4">Inneboende</option>
                                <option value="6">Hyresrätt</option>
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
                                    <select name="address_since_year" id="address-since-year" class="select-valg required">
                                        <option value=""></option>
                                        <option value="2017">2017</option>
                                        <option value="2016">2016</option>
                                        <option value="2015">2015</option>
                                        <option value="2014">2014</option>
                                        <option value="2013">2013</option>
                                        <option value="2012">2012</option>
                                        <option value="2011">2011</option>
                                        <option value="2010">2010</option>
                                        <option value="2009">2009</option>
                                        <option value="2008">2008</option>
                                        <option value="2007">2007</option>
                                        <option value="2006">2006</option>
                                        <option value="2005">2005</option>
                                        <option value="2004">2004</option>
                                        <option value="2003">2003</option>
                                        <option value="2002">2002</option>
                                        <option value="2001">2001</option>
                                        <option value="2000">2000</option>
                                        <option value="1999">1999</option>
                                        <option value="1998">1998</option>
                                        <option value="1997">1997</option>
                                        <option value="1996">1996</option>
                                        <option value="1995">1995</option>
                                        <option value="1994">1994</option>
                                        <option value="1993">1993</option>
                                        <option value="1992">1992</option>
                                        <option value="1991">1991</option>
                                        <option value="1990">1990</option>
                                        <option value="1989">1989</option>
                                        <option value="1988">1988</option>
                                        <option value="1987">1987</option>
                                        <option value="1986">1986</option>
                                        <option value="1985">1985</option>
                                        <option value="1984">1984</option>
                                        <option value="1983">1983</option>
                                        <option value="1982">1982</option>
                                        <option value="1981">1981</option>
                                        <option value="1980">1980</option>
                                        <option value="1979">1979</option>
                                        <option value="1978">1978</option>
                                        <option value="1977">1977</option>
                                        <option value="1976">1976</option>
                                        <option value="1975">1975</option>
                                        <option value="1974">1974</option>
                                        <option value="1973">1973</option>
                                        <option value="1972">1972</option>
                                        <option value="1971">1971</option>
                                        <option value="1970">1970</option>
                                        <option value="1969">1969</option>
                                        <option value="1968">1968</option>
                                        <option value="1967">1967</option>
                                        <option value="1966">1966</option>
                                        <option value="1965">1965</option>
                                        <option value="1964">1964</option>
                                        <option value="1963">1963</option>
                                        <option value="1962">1962</option>
                                        <option value="1961">1961</option>
                                        <option value="1960">1960</option>
                                        <option value="1959">1959</option>
                                        <option value="1958">1958</option>
                                        <option value="1957">1957</option>
                                        <option value="1956">1956</option>
                                        <option value="1955">1955</option>
                                        <option value="1954">1954</option>
                                        <option value="1953">1953</option>
                                        <option value="1952">1952</option>
                                        <option value="1951">1951</option>
                                        <option value="1950">1950</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-col large">
                                <div class="value select">
                                    <select name="address_since_month" id="form-address-since-month" class="select-valg required">
                                        <option value=""></option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Mars</option>
                                        <option value="4">April</option>
                                        <option value="5">Maj</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Augusti</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
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
                                <option value=""></option>
                                <option value="1">Köpa fordon</option>
                                <option value="2">Renovering/köpa möbler</option>
                                <option value="3">Konsumtion</option>
                                <option value="4">Resa</option>
                                <option value="5">Övrigt</option>
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
                                      tabindex="0" style="left: 0%;"></span>
                            </div>
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

        <!-- co applicant fields -->
        <div class="collapse1">

            <fieldset id="personal-details-co-applicant" class="form-set up" style="display: none;">

                <p class="personuppgifter">Medsökandes personuppgifter:</p>

                <div class="col-set">

                    <div class="col">
                        <label class="label">
                            <span class="desc">
                                Bor du med din medsökande?
                            </span>
                            <label class="radio-option first">
                                <input id="live-together-1" type="radio" name="live_together"
                                       value="1" checked="checked"><span>Ja</span>
                            </label>
                            <label class="radio-option last">
                                <input id="live-together-" type="radio" name="live_together"
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
                                <input type="tel" name="co_social_number" value=""
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
                                <input type="tel" name="co_mobile_number" value=""
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
                                <input type="email" name="co_email" value=""
                                       class="input-tekst validate-email validate required">
                                <span class="error-message-wrapper">
                                    <span class="error-message-arrow"></span>
                                    <span class="error-message">
                                        E-post krävs, exempel kundservice@smartlaanet.se. Kan inte
                                        innehålla å, ä, ö.
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
                                <select name="co_employment_type" class="select-valg required">
                                    <option value=""></option>
                                    <option value="1">Fast anställd</option>
                                    <option value="3">Vikariat</option>
                                    <option value="4">Egen rörelse</option>
                                    <option value="5">Pensionär</option>
                                    <option value="6">Studerande</option>
                                    <option value="9">Arbetslös</option>
                                </select>
                            </div>
                        </label>
                    </div>
                    <div id="form-co-monthly-income" class="col" style="display: none;">
                        <label class="label">
                            <span class="desc">
                                Månadsinkomst före skatt:
                            </span>
                            <div class="value text">
                                <input type="tel" name="co_monthly_income" value=""
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
                                <input type="text" name="co_employer" value=""
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
                                        <select name="co_employment_since_year" id="co-employed-since-year" class="select-valg required">
                                            <option value=""></option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                            <option value="2012">2012</option>
                                            <option value="2011">2011</option>
                                            <option value="2010">2010</option>
                                            <option value="2009">2009</option>
                                            <option value="2008">2008</option>
                                            <option value="2007">2007</option>
                                            <option value="2006">2006</option>
                                            <option value="2005">2005</option>
                                            <option value="2004">2004</option>
                                            <option value="2003">2003</option>
                                            <option value="2002">2002</option>
                                            <option value="2001">2001</option>
                                            <option value="2000">2000</option>
                                            <option value="1999">1999</option>
                                            <option value="1998">1998</option>
                                            <option value="1997">1997</option>
                                            <option value="1996">1996</option>
                                            <option value="1995">1995</option>
                                            <option value="1994">1994</option>
                                            <option value="1993">1993</option>
                                            <option value="1992">1992</option>
                                            <option value="1991">1991</option>
                                            <option value="1990">1990</option>
                                            <option value="1989">1989</option>
                                            <option value="1988">1988</option>
                                            <option value="1987">1987</option>
                                            <option value="1986">1986</option>
                                            <option value="1985">1985</option>
                                            <option value="1984">1984</option>
                                            <option value="1983">1983</option>
                                            <option value="1982">1982</option>
                                            <option value="1981">1981</option>
                                            <option value="1980">1980</option>
                                            <option value="1979">1979</option>
                                            <option value="1978">1978</option>
                                            <option value="1977">1977</option>
                                            <option value="1976">1976</option>
                                            <option value="1975">1975</option>
                                            <option value="1974">1974</option>
                                            <option value="1973">1973</option>
                                            <option value="1972">1972</option>
                                            <option value="1971">1971</option>
                                            <option value="1970">1970</option>
                                            <option value="1969">1969</option>
                                            <option value="1968">1968</option>
                                            <option value="1967">1967</option>
                                            <option value="1966">1966</option>
                                            <option value="1965">1965</option>
                                            <option value="1964">1964</option>
                                            <option value="1963">1963</option>
                                            <option value="1962">1962</option>
                                            <option value="1961">1961</option>
                                            <option value="1960">1960</option>
                                            <option value="1959">1959</option>
                                            <option value="1958">1958</option>
                                            <option value="1957">1957</option>
                                            <option value="1956">1956</option>
                                            <option value="1955">1955</option>
                                            <option value="1954">1954</option>
                                            <option value="1953">1953</option>
                                            <option value="1952">1952</option>
                                            <option value="1951">1951</option>
                                            <option value="1950">1950</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-col large">
                                    <div class="value select">
                                        <select name="co_employment_since_month" id="co-employed-since-month" class="select-valg required">
                                            <option value=""></option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Mars</option>
                                            <option value="4">April</option>
                                            <option value="5">Maj</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Augusti</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
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
                                        <select name="co_employment_last_year" id="co-employment-last-year" class="select-valg required">
                                            <option value=""></option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-col large">
                                    <div class="value select">
                                        <select name="co_employment_last_month" id="co-employment-last-month" class="select-valg required">
                                            <option value=""></option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Mars</option>
                                            <option value="4">April</option>
                                            <option value="5">Maj</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Augusti</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="form-co-work-number" class="col" style="display: none;">
                        <label class="label">
                            <span class="desc">
                                Telefon arbete:
                            </span>
                            <div class="value text">
                                <input type="text" name="co_work_number" maxlength="15" value=""
                                       class="input-tekst required validate">
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
                                <select name="co_civilstatus" class="required">
                                    <option value=""></option>
                                    <option value="1">Gift</option>
                                    <option value="2">Sambo</option>
                                    <option value="3">Ensamstående</option>
                                    <option value="4">Skild</option>
                                    <option value="5">Änka/änkling</option>
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
                                <select name="co_living_conditions" class="required">
                                    <option value=""></option>
                                    <option value="2">Villa/radhus</option>
                                    <option value="3">Bostadsrätt</option>
                                    <option value="4">Inneboende</option>
                                    <option value="6">Hyresrätt</option>
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
                                <input type="tel" name="co_rent" value=""
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
                                        <select name="co_address_since_year" id="co-address-since-year" class="select-valg required">
                                            <option value=""></option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                            <option value="2012">2012</option>
                                            <option value="2011">2011</option>
                                            <option value="2010">2010</option>
                                            <option value="2009">2009</option>
                                            <option value="2008">2008</option>
                                            <option value="2007">2007</option>
                                            <option value="2006">2006</option>
                                            <option value="2005">2005</option>
                                            <option value="2004">2004</option>
                                            <option value="2003">2003</option>
                                            <option value="2002">2002</option>
                                            <option value="2001">2001</option>
                                            <option value="2000">2000</option>
                                            <option value="1999">1999</option>
                                            <option value="1998">1998</option>
                                            <option value="1997">1997</option>
                                            <option value="1996">1996</option>
                                            <option value="1995">1995</option>
                                            <option value="1994">1994</option>
                                            <option value="1993">1993</option>
                                            <option value="1992">1992</option>
                                            <option value="1991">1991</option>
                                            <option value="1990">1990</option>
                                            <option value="1989">1989</option>
                                            <option value="1988">1988</option>
                                            <option value="1987">1987</option>
                                            <option value="1986">1986</option>
                                            <option value="1985">1985</option>
                                            <option value="1984">1984</option>
                                            <option value="1983">1983</option>
                                            <option value="1982">1982</option>
                                            <option value="1981">1981</option>
                                            <option value="1980">1980</option>
                                            <option value="1979">1979</option>
                                            <option value="1978">1978</option>
                                            <option value="1977">1977</option>
                                            <option value="1976">1976</option>
                                            <option value="1975">1975</option>
                                            <option value="1974">1974</option>
                                            <option value="1973">1973</option>
                                            <option value="1972">1972</option>
                                            <option value="1971">1971</option>
                                            <option value="1970">1970</option>
                                            <option value="1969">1969</option>
                                            <option value="1968">1968</option>
                                            <option value="1967">1967</option>
                                            <option value="1966">1966</option>
                                            <option value="1965">1965</option>
                                            <option value="1964">1964</option>
                                            <option value="1963">1963</option>
                                            <option value="1962">1962</option>
                                            <option value="1961">1961</option>
                                            <option value="1960">1960</option>
                                            <option value="1959">1959</option>
                                            <option value="1958">1958</option>
                                            <option value="1957">1957</option>
                                            <option value="1956">1956</option>
                                            <option value="1955">1955</option>
                                            <option value="1954">1954</option>
                                            <option value="1953">1953</option>
                                            <option value="1952">1952</option>
                                            <option value="1951">1951</option>
                                            <option value="1950">1950</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-col large">
                                    <div class="value select">
                                        <select name="co_address_since_month" id="co-address-since-month" class="select-valg required">
                                            <option value=""></option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Mars</option>
                                            <option value="4">April</option>
                                            <option value="5">Maj</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Augusti</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <!-- end co applicant fields -->

    </div>
    <footer></footer>

</form>