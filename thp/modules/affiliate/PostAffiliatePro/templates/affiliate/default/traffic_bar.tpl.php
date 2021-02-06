<?php if ( (GLOBAL_DB_ENABLED == 1) && ($GLOBALS['Auth']->getUserType() == USERTYPE_ADMIN) && ($GLOBALS['Auth']->getSetting('Acct_limit_enabled') == '1') ) {
   $settings = QCore_Settings::getGlobalSettings();
   $accountType = ($settings['AffPlanet_account_type'] != '' ? $settings['AffPlanet_account_type'] : ACCOUNT_FREE);

   $transMonth  = $settings['Acct_limit_month_count'];
   $transBonus  = $settings['Acct_limit_month_bonus'];
   $transBought = $settings['Acct_limit_bought_trans'];
   $limitSoft   = $GLOBALS['trafficLimits'][$accountType][$settings['AffPlanet_account_trafficlevel']]['soft'];
   $limitHard   = $GLOBALS['trafficLimits'][$accountType][$settings['AffPlanet_account_trafficlevel']]['hard'];
?>
    <div>
        <table width="832" cellpadding="0" cellspacing="0" border=0 class="traffic">
            <tr>
                <td class=trafficCell align=left valign=middle>&nbsp;&nbsp;&nbsp;<b><?php echo L_G_WEBTRAFFIC?></b></td>
                <td class=trafficCell >
                    <?php
                        $transMonth2 = $transMonth;
                        $limitSoft2 = $limitSoft;
                        $transBonus2 = $transBonus;
                        $transBought2 = $transBought;

                        if($limitSoft > $transMonth) {
                            $limitSoft2 -= $transMonth;
                        } else if($limitSoft + $transBonus > $transMonth) {
                            $transBonus2 = ($limitSoft + $transBonus - $transMonth);
                            $limitSoft2 = 0;
                        } else if($limitSoft + $transBonus + $transBought > $transMonth) {
                            $transBought2 = $limitSoft + $transBonus + $transBought - $transMonth;
                            $limitSoft2 = 0;
                            $transBonus2 = 0;
                        } else {
                            $limitSoft2 = 0;
                            $transBonus2 = 0;
                            $transBought2 = 0;
                        }

                        $max = $transMonth + $limitSoft2 + $transBonus2 + $transBought2;

                        $graph = QUnit_Global::newobj('QUnit_Graphics_Graph');
                        $params = array(
                                        'type' => array('traffic'),
                                        'library' => 'xmlswf',
                                        'values' => array(array($transMonth2), array($limitSoft2), array($transBonus2), array($transBought2)),
                    //                    'values' => array(array(100), array(220), array(0), array(0)),
                                        'labels' => array ( "" ),
                                        'width' => '545',
                                        'height' => '18',
                                        'max' => $max,
                                        'link' => 'index.php?md=Affiliate_Merchants_Views_About',
                                        'background_color' => 'E0E4E5',
                                        'use_caching' => false,
                                      );
                        echo $graph->create($params);
                    ?>
                </td>
                <td class=trafficCell ><img src="<?php echo  $this->a_this->getImage('trafficSep.gif') ?>" border="0"></td>
                <td class=trafficCell align=left valign=middle>
                    &nbsp;&nbsp;<b><?php echo L_G_WEBACCOUNTTYPE?></b>
                    &nbsp;&nbsp;<b><i>
                    <a href="index.php?md=Affiliate_Merchants_Views_About">
                    <?php
                        if($settings['AffPlanet_account_type'] == ACCOUNT_FREE) echo L_G_ACCOUNT_FREE;
                        else if($settings['AffPlanet_account_type'] == ACCOUNT_LITE) echo L_G_ACCOUNT_LITE;
                        else echo L_G_ACCOUNT_FREE;
                    ?></a></i></b>&nbsp;&nbsp;
                </td>
                <td class=trafficCell ><img src="<?php echo  $this->a_this->getImage('trafficSep.gif') ?>" border="0"></td>
                <td class=trafficCell align=left valign=middle>&nbsp;&nbsp;<a class="smallLinkRed" href="index.php?md=Affiliate_Merchants_Views_GettingStarted"><?php echo L_G_GETTINGSTARTED?></a>&nbsp;</td>
                <td width="8px" align=left><img src="<?php echo  $this->a_this->getImage('trafficBorder.gif') ?>" border="0" width="8px"></td>
            </tr>

            <?php if ($transMonth > $limitSoft + $transBonus + $transBought) { ?>
            <?php    if ($transMonth > $limitSoft + $transBonus + $transBought + $limitHard) { ?>
            <tr>
                <td class="errorMessage" align=center colspan=2><h4><?php echo L_G_LIMIT_HARD_EXCEEDED?></h4></td>
            </tr>
            <?php    } else { ?>
            <tr>
                <td class="errorMessage" align=center colspan=2><h4><?php echo L_G_LIMIT_SOFT_EXCEEDED?></h4></td>
            </tr>
            <?php    } ?>
            <?php } ?>
        </table>
    </div>
<?php
   } else if(($GLOBALS['Auth']->getUserType() == USERTYPE_USER) && ($GLOBALS['Auth']->getSetting('Aff_link_style') == LINK_STYLE_NEW)) {
?>
    <div>
        <table width="780" cellpadding="0" cellspacing="0" border=0 class="traffic">
            <tr>
                <?php if($this->a_Auth->getSetting('Aff_main_site_url') != '') { ?>
                <td class=trafficCell align=left valign=middle>&nbsp;&nbsp;&nbsp;<b><?php echo L_G_GENERAL_MAIN_URL?></b>
                <?php echo  ': <font color="#ff0000">'.$GLOBALS['Auth']->getSetting('Aff_main_site_url').(substr($GLOBALS['Auth']->getSetting('Aff_main_site_url'), -1, 1) == '/' ? '' : '/').'?'.PARAM_A_AID.'='.$GLOBALS['Auth']->getRefD().'</font>'; ?>
                </td>
                <?php } ?>
                <td class=trafficCell align=right valign=middle>&nbsp;&nbsp;</td>
                <td width="8px" align=left><img src="<?php echo  $this->a_this->getImage('trafficBorder.gif') ?>" border="0" width="8px"></td>
            </tr>
        </table>
    </div>
<?php } ?>