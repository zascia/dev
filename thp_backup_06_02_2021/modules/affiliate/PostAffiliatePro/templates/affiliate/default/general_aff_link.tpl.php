<?php if(($GLOBALS['Auth']->getUserType() == USERTYPE_USER) && ($GLOBALS['Auth']->getSetting('Aff_link_style') == LINK_STYLE_NEW) && ($this->a_Auth->getSetting('Aff_main_site_url') != '')) {
?>
    <tr height=20>
      <td class="leftMenuBorder" style="height: 20px" colspan=2 height=20>&nbsp;</td>
      <td align="left" valign="middle" height=20>
      <table border=0 width="100%" cellspacing=0 cellpadding=0 height=22>
      <tr>
        <td align=left height=22 valign=middle>
        <b><?php echo L_G_YOURAFFILIATELINK?></b><?php echo  ': <font color="#ff0000">'.$GLOBALS['Auth']->getSetting('Aff_main_site_url').'?'.PARAM_A_AID.'='.$GLOBALS['Auth']->getRefD().'</font>'; ?>
        &nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_GENAFFLINK); ?>
        </td>
        <td align=right valign=middle><b><?php echo L_G_YOURBALANCE?>: <font color="#ff0000"><?php echo Affiliate_Merchants_Bl_Settings::showCurrency($GLOBALS['Auth']->getEarned())?></font></b>
        &nbsp;&nbsp;&nbsp;&nbsp;
        </td>
      </tr>
      </table>
      </td>
    </tr>
<?php } ?>
