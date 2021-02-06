    <form name=FilterForm action=index.php method=post>
    <table cellpadding="0" cellspacing="0" width="780">
    <tr><td align="left"><?php echo L_G_COMMUNICATIONDESCRIPTION?><br><br></td></tr>
    </table>
    <table class=listing border=0 cellspacing=0 cellpadding="2" style="border-bottom: 0px;" width="780">
    <?php QUnit_Templates::printAdvancedFilter(2, L_G_FILTER, $this->a_form_preffix, $this->a_form_name); ?>
    <tr class="listheaderNoLineLeft">
      <td colspan="2">
        <div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : ''?>>
        </div>
        <div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'?>>
        <table cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td width="1%" align="left" valign="top">
            <?php QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
        </td>
        <td width="10"></td>
        <td align="left" valign="top">
            <table width="1%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td nowrap align="right">&nbsp;&nbsp;<?php echo L_G_SHOWRESULTSWHERE?></td>
                <td width=1% nowrap>&nbsp;<b><?php echo L_G_TITLE?></b> <?php echo L_G_CONTAINS?>&nbsp;</td>
                <td nowrap>&nbsp;<input type=text name=c_title size=35 value="<?php echo $_REQUEST['c_title']?>"></td>
            </tr>
            <tr>
                <td align="right"><?php echo L_G_AND?></td>
                <td nowrap>&nbsp;<b><?php echo L_G_MESSAGE_TEXT?></b> <?php echo L_G_CONTAINS?>&nbsp;</td>
                <td nowrap>&nbsp;<input type=text name=c_text size=35 value="<?php echo $_REQUEST['c_text']?>"></td>
            </tr>
            <tr>
                <td align="right"><?php echo L_G_AND?></td>
                <td nowrap>&nbsp;<b><?php echo L_G_EMAIL?></b> <?php echo L_G_CONTAINS?>&nbsp;</td>
                <td nowrap>&nbsp;<input type=text name=c_email size=35 value="<?php echo $_REQUEST['c_email']?>"></td>
            </tr>
            </table>
        </td>
        </tr>
        </table>
        <hr class="filterLine">
        </div>
      </td>
    </tr>
    <tr>
      <td class="listheaderNoLineLeft" align="left" valign="top">
        <?php QUnit_Global::includeTemplate('filter_time.tpl.php'); ?></td>
      <td class="listheaderNoLineLeft" valign="top" align="left">
        <table cellpadding="2" cellspacing="0" border="0">
        <tr>
        <?php if($this->a_Auth->getSetting('Aff_display_news') == '1') { ?>
            <td valign=top width="100">&nbsp;<b><?php echo L_G_TYPE?></b>&nbsp;<?php showQuickHelp(L_G_HLP_MESSAGETYPE); ?><br>
                &nbsp;<?php echo L_G_SELSELECT?> <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>type[]', true);"><?php echo L_G_SELALL?></a>
                / <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>type[]', false);"><?php echo L_G_SELNONE?></a></td>
            <td valign="top" nowrap>
                <input type="hidden" name="type_comitted" value="1">
                <input type="checkbox" name=<?php echo $this->a_form_preffix?>type[] value="<?php echo MESSAGETYPE_EMAIL?>"
                    <?php echo (@in_array(MESSAGETYPE_EMAIL, $_REQUEST[$this->a_form_preffix.'type'])) ? 'checked' : ''?>>
                <?php echo L_G_EMAIL?>&nbsp;&nbsp;</td>
            <td valign="top" nowrap>    
                <input type="checkbox" name=<?php echo $this->a_form_preffix?>type[] value="<?php echo MESSAGETYPE_NEWS?>"
                    <?php echo (@in_array(MESSAGETYPE_NEWS, $_REQUEST[$this->a_form_preffix.'type'])) ? 'checked' : ''?>>
                <?php echo L_G_NEWS?>&nbsp;&nbsp;</td>
            <?php } else { ?>
            <td colspan="3" nowrap>&nbsp;</td>
            <?php } ?>
        </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td class="listheaderNoLineLeft" align="left" colspan="2">
        &nbsp;<input class="formbutton" type=submit value='<?php echo L_G_APPLYFILTER?>'><br>&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_Communications'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>      
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">