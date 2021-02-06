<form name=FilterForm id=FilterForm  action=index.php method=post>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="780" style="border-bottom: 0px;">
<?php QUnit_Templates::printAdvancedFilter(1, L_G_APPLIED, $this->a_form_preffix, $this->a_form_name); ?>
<tr><td class="listheaderNoLineLeft">
        <div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : ''?>>
        </div>
        <div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'?>>
            <table cellpadding="0" cellspacing="0" border="0">
            <tr><td><?php $_POST['allow_declined_trans'] = 'allow';
                       $_POST['allow_pending_trans'] = 'allow';
                       $this->a_this->assign('a_status_name', 'affstatus');
                       $this->a_this->assign('a_status_caption', L_G_AFFILIATESTATUS);
                       QUnit_Global::includeTemplate('filter_status.tpl.php') ?></td>
                <td width="50">&nbsp;</td>
                <td><?php QUnit_Global::includeTemplate('filter_campaignstatus.tpl.php') ?></td></tr>
            <tr><td colspan="3"><br>
                    <?php $this->a_this->assign('a_status_name', 'status');
                       $this->a_this->assign('a_status_caption', L_G_AFFILIATESTATUSINCAMPAIGN);
                       $this->a_this->assign('a_status_help', L_G_HLP_AFFILIATESTATUSINCAMPAIGN);
                       QUnit_Global::includeTemplate('filter_status.tpl.php') ?>
                </td></tr>
            </table>
           <br>
        </div>
    </td></tr>
<tr class="listheaderNoLineLeft">
  <td> 
    <table cellpadding="0" cellspacing="0" border="0">
    <tr><td><?php QUnit_Global::includeTemplate('filter_affiliate.tpl.php') ?></td>
        <td width="50">&nbsp;</td>
        <td><?php QUnit_Global::includeTemplate('filter_campaign.tpl.php') ?></td>
<?php if ($GLOBALS['Auth']->getSetting('Aff_join_campaign') == '1') { ?>
        <td width="50">&nbsp;</td>
        <td><input type="submit" class="formbutton" value="<?php echo L_G_ADDAFFILIATETOCAMPAIGN?>"
        	 onclick="javascript: document.getElementById('action').value='add_aff';"></td>
<?php } ?>
        </tr>
    </table>
      <hr class="filterline">
      &nbsp;&nbsp;<input type="submit" class="formbutton" value="<?php echo L_G_APPLYFILTER?>"><br>
</td></tr>
</table> 