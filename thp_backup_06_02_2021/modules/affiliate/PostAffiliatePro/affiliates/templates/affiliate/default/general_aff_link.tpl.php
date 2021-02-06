<?php if($GLOBALS['Auth']->getUserType() == USERTYPE_USER) { ?>
	<tr height=20>
      <td class="leftMenuBorder" style="height: 20px" colspan=2 height=20>&nbsp;</td>
      <td align="left" valign="middle" height=20>
      <table border=0 width="100%" cellspacing=0 cellpadding=0 height=22>
      <tr>
        <td align=left height=22 valign=middle>
        	<table>
        	<?php if (($GLOBALS['Auth']->getSetting('Aff_link_style') == LINK_STYLE_NEW) && ($this->a_Auth->getSetting('Aff_main_site_url') != '') && ($this->a_Auth->getSetting('Aff_default_campaign') != '_')) { ?>
        		<tr><td><b><?php echo L_G_YOURAFFILIATELINK?>:</b></td>
        			<td><?php echo  ' <font color="#ff0000">'.$GLOBALS['Auth']->getSetting('Aff_main_site_url').'?'.PARAM_A_AID.'='.$GLOBALS['Auth']->getRefD().'</font>'; ?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_GENAFFLINK); ?></td>
        		</tr>
        	<?php } ?>        	
        	<?php if (($GLOBALS['Auth']->getSetting('Aff_replication_enable') == '1') && ($this->a_Auth->getSetting('Aff_replication_url') != '')) { ?>
        		<tr><td><b><?php echo L_G_YOURSITELINK?>:</b></td>
        			<td><?php echo  ' <font color="#ff0000">'.rtrim($GLOBALS['Auth']->getSetting('Aff_replication_url'), "/\\").'/'.$GLOBALS['Auth']->getRefD().'.html</font>'; ?>&nbsp;&nbsp;<?php showQuickHelp(L_G_HLP_SITELINK); ?></td>
        		</tr>
        	<?php } ?>
        	</table>
        </td>
        <?php $ballance = $GLOBALS['Auth']->getEarnedCommissions()?>
        <td align=right valign=top><b><?php echo L_G_YOURBALANCE?>:
        	<font color="#ff0000"><?php echo L_G_APPROVED?> <?php echo Affiliate_Merchants_Bl_Settings::showCurrency($ballance['approved'])?></font>
        	</b>
        	(<font color="#000000"><?php echo L_G_PENDING?> <?php echo Affiliate_Merchants_Bl_Settings::showCurrency($ballance['pending'])?></font>)
        	&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
      </tr>
      </table>
      </td>
    </tr>
<?php } ?>