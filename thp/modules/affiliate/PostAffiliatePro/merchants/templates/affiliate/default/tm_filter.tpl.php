<table class=listing border=0 cellspacing=0 cellpadding=2 style="border-bottom: 0px;" width="780">
<?php QUnit_Templates::printAdvancedFilter(1, L_G_FILTER, $this->a_form_preffix, $this->a_form_name); ?>
<tr><td class="listheaderNoLineLeft">
        <div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : ''?>>
        </div>
        <div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'?>>
        <br>
        <table cellpadding="2" cellspacing="0" border="0" width="100%">
        <tr><td valign="top">
                <?php QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
                <hr class="filterline">
                <table cellpadding="0" cellspacing="0">
                <tr><td>&nbsp;&nbsp;<?php echo L_G_SHOWRESULTSWHERE?>&nbsp;</td>
                    <td><b><?php echo L_G_ORDERID?></b></td>
                    <td>&nbsp;<?php echo L_G_ISLIKE?>&nbsp;</td>
                    <td><input type=text name="<?php echo $this->a_form_preffix?>orderid" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'orderid']?>"></td></tr>
				<tr><td align="right">&nbsp;<?php echo L_G_AND?>&nbsp;</td>
                    <td><select name="<?php echo $this->a_form_preffix?>custom1">
                        <?php foreach($this->a_filterColumns as $key => $value) { ?>
                            <option value="<?php echo $key?>" <?php echo ($_REQUEST[$this->a_form_preffix.'custom1'] == $key) ? 'selected' :''?>><?php echo $value?></option>
                        <?php } ?>
                        </select>&nbsp;</td>
                    <td>&nbsp;<?php echo L_G_ISLIKE?>&nbsp;</td>
                    <td><input type=text name="<?php echo $this->a_form_preffix?>custom1data" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'custom1data']?>"></td></tr>
                <tr><td align="right">&nbsp;<?php echo L_G_AND?>&nbsp;</td>
                    <td><select name="<?php echo $this->a_form_preffix?>custom2">
                        <?php foreach($this->a_filterColumns as $key => $value) { ?>
                            <option value="<?php echo $key?>" <?php echo ($_REQUEST[$this->a_form_preffix.'custom2'] == $key) ? 'selected' :''?>><?php echo $value?></option>
                        <?php } ?>
                        </select>&nbsp;</td>
					<td>&nbsp;<?php echo L_G_ISLIKE?>&nbsp;</td>
                    <td><input type=text name="<?php echo $this->a_form_preffix?>custom2data" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'custom2data']?>"></td>
                </tr>
                </table>
            </td>
            <td width="10"></td>
            <td valign="top">
                <?php QUnit_Global::includeTemplate('filter_transtype.tpl.php'); ?>
                <hr class="filterline">
                <?php QUnit_Global::includeTemplate('filter_status.tpl.php'); ?>
            </td>
        </tr>

        </table>
        <hr class="filterline">
        <?php QUnit_Global::includeTemplate('filter_campaign.tpl.php') ?>
        <hr class="filterline">
        </div>
    </td></tr>
<tr><td class="listheaderNoLineLeft">
        <?php QUnit_Global::includeTemplate('filter_time.tpl.php') ?>
        &nbsp;&nbsp;<input type="submit" class="formbutton" value="<?php echo L_G_APPLYFILTER?>"><br></td></tr>
</table>
