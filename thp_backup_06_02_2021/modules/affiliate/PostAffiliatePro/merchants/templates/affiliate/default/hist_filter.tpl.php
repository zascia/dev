<?php
function getShortFileName($filename) {
    $pos = strrpos($filename, "\\");
    if($pos !== false)
        $file = substr($filename, $pos+1);
    else
        $file = $filename;
    $pos = strrpos($file, '/');
    if($pos !== false)
        $file = substr($file, $pos+1);
    return  $file;
}

function printHourSelect($name, $maxi = 23) { ?>
    <select name="<?php echo $name?>">
<?php  for($i=0; $i<=$maxi; $i++) { ?>
        <option value="<?php echo $i?>" <?php echo ($_REQUEST[$name] == $i) ? 'selected' : ''?>><?php echo ($i < 10) ? '0' : ''?><?php echo $i?>:00</option>
<?php  } ?>
    </select>   
<?php
}
?>
    <form name=FilterForm id=FilterForm action=index.php method=post>
    <table class=listing border=0 cellspacing=0 style="border-bottom: 0px;" width="780">
    <?php QUnit_Templates::printAdvancedFilter(1, L_G_FILTER, $this->a_form_preffix, $this->a_form_name); ?>
    <tr class="listheaderNoLineLeft">
      <td>
      <div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : ''?>>
      </div>
      <div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'?>>
      <table cellspacing=0 border=0 width="100%">
      <tr>
        <td>
            <table border=0 cellspacing=0 width="1%">
            <tr>
                <td colspan="3" nowrap>
                <table cellpadding="2" cellspacing="0" border="0">
                <tr><td valign=top width="100">&nbsp;<b><?php echo L_G_HISTORYTYPE?></b>&nbsp;<?php showQuickHelp(L_G_HLP_HISTORYTYPE); ?><br>
                        &nbsp;<?php echo L_G_SELSELECT?> <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>historytype[]', true);"><?php echo L_G_SELALL?></a>
                        / <a class="simplelink" href="javascript:checkAll('<?php echo $this->a_form_preffix?>historytype[]', false);"><?php echo L_G_SELNONE?></a></td>
                    <td valign="top" nowrap>
                        <input type="hidden" name="historytype_comitted" value="1">
                        <input type="checkbox" name=<?php echo $this->a_form_preffix?>historytype[] value="<?php echo WLOG_DBERROR?>"
                            <?php echo (@in_array(WLOG_DBERROR, $_REQUEST[$this->a_form_preffix.'historytype'])) ? 'checked' : ''?>>
                        <?php echo L_G_LOG_DBERROR?>&nbsp;&nbsp;</td>
                    <td valign="top" nowrap>    
                        <input type="checkbox" name=<?php echo $this->a_form_preffix?>historytype[] value="<?php echo WLOG_ERROR?>"
                            <?php echo (@in_array(WLOG_ERROR, $_REQUEST[$this->a_form_preffix.'historytype'])) ? 'checked' : ''?>>
                        <?php echo L_G_LOG_ERROR?>&nbsp;&nbsp;</td>
                    <td valign="top" nowrap>    
                        <input type="checkbox" name=<?php echo $this->a_form_preffix?>historytype[] value="<?php echo WLOG_ACTIONS?>"
                            <?php echo (@in_array(WLOG_ACTIONS, $_REQUEST[$this->a_form_preffix.'historytype'])) ? 'checked' : ''?>>
                        <?php echo L_G_LOG_ACTIONS?>&nbsp;&nbsp;</td>
                    <td valign="top" nowrap>
                        <input type="checkbox" name=<?php echo $this->a_form_preffix?>historytype[] value="<?php echo WLOG_DEBUG?>"
                            <?php echo (@in_array(WLOG_DEBUG, $_REQUEST[$this->a_form_preffix.'historytype'])) ? 'checked' : ''?>>    
                        <?php echo L_G_LOG_DEBUG?>&nbsp;&nbsp;
                    </td></tr>
                </table>
                </td>
            </tr>
            <tr><td colspan="3"><hr class="filterLine"></td></tr>
            <tr class="listheaderNoLineLeft">
                <td width=1% valign="bottom" nowrap>&nbsp;<?php echo L_G_SHOWRESULTSWHERE?></td>
                <td valign="bottom" nowrap>&nbsp;<b><?php echo L_G_TEXTCONTAINS?></b>&nbsp;</td>
                <td valign="bottom" align="left"" nowrap><input type=text name=h_note size=35 value="<?php echo $_REQUEST['h_note']?>"></td>
            </tr>
            <tr class="listheaderNoLineLeft">
                <td width=1% valign="bottom" align="right" nowrap>&nbsp;<?php echo L_G_AND?></td>
                <td valign="bottom" nowrap>&nbsp;<b><?php echo L_G_IPISLIKE?></b>&nbsp;</td>
                <td valign="bottom" align="left" nowrap><input type=text name=h_ip size=35 value="<?php echo $_REQUEST['h_ip']?>"></td>
            </tr>
            </table>
        </td>
        <td width="10"></td>
        <td valign="top" align="left">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr><td width="60"><b><?php echo L_G_FILE?></b>&nbsp;<?php showQuickHelp(L_G_HLP_HISTORY_FILEFILTER); ?></td>
                <td align="left">
                <select name="h_file">
                        <option value="_" <?php echo ($_REQUEST['h_file'] == '_') ? 'selected' : ''?>><?php echo L_G_ALL?></option>
                     <?php if(count($this->a_files) > 0) {
                         foreach ($this->a_files as $filename) { ?>
                            <option value="<?php echo $filename?>" <?php echo (stripcslashes($_REQUEST['h_file']) == $filename) ? 'selected' : ''?>><?php echo getShortFileName($filename)?></option>
                     <?php  }
                        } ?>
                    </select>
                </td></tr>
            <tr><td colspan="2"><hr class="filterLine"></td></tr>
            <tr><td nowrap><b><?php echo L_G_TIME?></b>&nbsp;<?php showQuickHelp(L_G_HLP_HISTORY_TIMEFILTER); ?><br>
                    &nbsp;<?php echo L_G_SELSELECT?> 
                    <a class="simplelink" href="javascript:;"
                        onclick="javascript: document.getElementById('h_hour1').selectedIndex = 0;
                                             document.getElementById('h_hour2').selectedIndex = 24;">
                    <?php echo L_G_SELALLDAY?></a> / 
                    <a class="simplelink" href="javascript:;"
                        onclick="javascript: document.getElementById('h_hour1').selectedIndex = <?php echo date("G")?>;
                                             document.getElementById('h_hour2').selectedIndex = <?php echo date("G")+1?>">
                    <?php echo L_G_SELTHISHOUR?></a>&nbsp;&nbsp;&nbsp;
                    </td>
                <td><b><?php echo L_G_FROM?></b>&nbsp;&nbsp;<?php printHourSelect('h_hour1'); ?><b>&nbsp;&nbsp;<?php echo L_G_TO?>&nbsp;&nbsp;</b><?php printHourSelect('h_hour2', 24); ?></td></tr>    
            </table>
        </td>
      </tr>
      </table>
      <hr class="filterLine">
      </div>
    </td></tr>
    <tr>
      <td class="listheaderNoLineLeft">
        <?php QUnit_Global::includeTemplate('filter_time.tpl.php'); ?></td>
    </tr>
    <tr>
      <td align="left" class="listheaderNoLineLeft">
        &nbsp;<input class="formbutton" type=submit value='<?php echo L_G_APPLYFILTER?>'><br><br></td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_History'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>      
    <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
