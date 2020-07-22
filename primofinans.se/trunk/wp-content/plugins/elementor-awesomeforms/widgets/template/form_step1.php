<?php
$form_step1 = get_field('form_step1', 'option');
if (!empty($form_step1)) {
    ?>
<div class="first-step-form">
    <form action="" id="axo-form-small" method="post" class="form small-form swedish-version" novalidate="novalidate">
        <div class="form-body form-main">

            <!-- amount slider -->
            <fieldset class="form-set loan-amount">
                <div class="col-set">
                    <div class="col">
                        <label class="label loan-amount-label">
                            <span class="desc first" id="centermobile"><?php echo $form_step1['loan-amount-label'];?></span>
                            <div class="value text large green">
                                <input id="loan-amount" value="<?php echo $form_step1['loan-amount'];?>" type="tel">
                                <input id="loan-amount-value" value="<?php echo $form_step1['loan-amount-value'];?>" name="loan_amount" type="hidden">
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
                                    <!--div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min"
                                         style="width: 18.3673%;"></div-->
                                    <span class="ui-slider-handle ui-state-default ui-corner-all"
                                          tabindex="0" style="left: 18.3673%;"></span>
                                </div>
                            </div>
                        </label>
                        <div class="label-amount-container">
                            <div class="calculator-slider-start">
                                <?php echo $form_step1['label-amount-start'];?> kr
                            </div>
                            <div class="calculator-slider-end">
                                <?php echo $form_step1['label-amount-end'];?> kr
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <!-- amount slider -->

            <fieldset class="form-set annual-terms">
                <div class="col-set">
                    <div class="col">
                        <label id="form-annual-terms" class="label">
                            <span class="desc"><?php echo $form_step1['annual-terms-label'];?></span>
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
                            <span class="label inline" id="monthlytext"><?php echo $form_step1['monthlytext'];?></span>
                            <span class="amount-wrapper" id="monthly-amount-span">
                                <span class="amount-number-wrapper"><?php echo $form_step1['monthly-amount-befor'];?><span id="monthly-amount" class="amount"><?php echo $form_step1['monthly-amount'];?></span><?php echo $form_step1['monthly-amount-after'];?></span>
                            </span>
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="div-next-container fictiveNextStep1Head">
                <a href="#" id="fictiveNextStep1" class="button next custom-submit"><?php echo $form_step1['next-fictive-text'];
                ?></a>
            </div>

            <div class="form-set up main-applicant">
                <!-- first step hidden fields -->
                <div class="collapse0 fictiveNextStep1Container">
                    <div class="form-set main-personal-info">
                        <div class="col-set">
                            <div class="col">
                                <label class="label">
                                    <span class="desc"><?php echo $form_step1['email-label'];?></span>
                                    <div class="value text parent-valid">
                                        <input name="email" id="email" class="input-text validate-email validate required" value="" type="email">
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message"><?php echo $form_step1['email-error'];?></span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <div class="col">
                                <label class="label">
                                    <span class="desc"><?php echo $form_step1['mobile-label'];?></span>
                                    <div class="value text parent-valid">
                                        <input name="mobile_number" id="mobile-number" required class="input-text validate-mobile validate required" value="" maxlength="<?php echo $form_step1['mobile-maxlength'];?>" type="tel" pattern="<?php echo $form_step1['mobile-pattern'];?>">
                                        <span class="error-message-wrapper">
                                            <span class="error-message-arrow"></span>
                                            <span class="error-message"><?php echo $form_step1['mobile-error'];?></span>
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
                                <span id="permissionTextLabel"><?php echo $form_step1['accepted-terms'];?></span>
                                <span class="error-message error-message-custom"><?php echo $form_step1['accepted-terms-error'];?></span>
                            </label>
                        </div>

                    </div>

                    <div class="div-next-container">
                        <!--<a href="step2.htm" class="button next step">Neste</a>-->
                        <button type="button" class="button next step custom-submit"><?php echo $form_step1['button-text'];?></button>
                    </div>

                    <center>
                        <a href="#"
                           onClick="window.open('<?php echo $form_step1['personuppgiftspolicy-url'];?>', 'personuppgiftspolicy', 'resizable,height=900,width=500,scrollbars=yes'); return false;"><?php echo $form_step1['personuppgiftspolicy'];?></a>
                    </center>
                </div>
                <!-- first step hidden fields -->
            </div>
        </div>
    </form>
<div>

    <!-- Campaign form -->
    <form id="campaignForm" action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" style="display: none">
        <input type="text" id="customEmailCampaign" name="email" />
        <input name="custom_loanamount" id="customLoanamountCampaign" type="text" value="" />
        <input name="custom_loanduration" id="customLoandurationCampaign" type="text" value="" />
        <input name="custom_mobilenumber" id="customMobilenumberCampaign" type="text" value="" />
        <input type="hidden" id="customAfID" name="custom_afid" value="" />
        <input type="hidden" id="customCurrentDate" name="custom_signup_date" value="" />
        <input type="hidden" id="customPermission" name="custom_permissiontext" value="" />
        <input type="hidden" name="campaign_token" value="KXcKY" />
        <input type="hidden" name="start_day" value="0" />
    </form>
    <!-- Campaign form -->

</div>
<?php } ?>