<table class=listing border=0 cellspacing=0 cellpadding=2 width="780" style="border-bottom: 0px;">
<?php QUnit_Templates::printAdvancedFilter(1, L_G_FILTER, $this->a_form_preffix, $this->a_form_name); ?>
<tr><td class="listheaderNoLineLeft">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr><td>&nbsp;&nbsp;<?php echo L_G_SHOWAFFILIATESWHERE?>&nbsp;</td>
			<td><b><?php echo L_G_NAME?></b>&nbsp;</td>
			<td><?php echo L_G_ISLIKE?>&nbsp;</td>
			<td><input type=text name=<?php echo $this->a_form_preffix?>name size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'name']?>"></td>
			<td>&nbsp;&nbsp;<?php echo L_G_AND?>&nbsp;</td>
			<td><b><?php echo L_G_SURNAME?></b>&nbsp;</td>
			<td><?php echo L_G_ISLIKE?>&nbsp;</td>
			<td><input type=text name=<?php echo $this->a_form_preffix?>surname size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'surname']?>"></td>
		</tr>
		</table>
		<div id="<?php echo $this->a_form_preffix?>standard_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? 'style="display:none;"' : ''?>>
		</div>
		<div id="<?php echo $this->a_form_preffix?>advanced_filter" <?php echo ($_REQUEST[$this->a_form_preffix.'advanced_filter_show'] == '1') ? '' : 'style="display:none;"'?>>
		<hr class="filterline">
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<tr><td valign="top" width="50%">
				<?php $this->a_this->assign('a_list_users', 'yes');
				   QUnit_Global::includeTemplate('filter_status.tpl.php'); ?>
				<hr class="filterline">
				<?php $this->a_this->assign('a_timeselect_tworows', '1');
				   $this->a_this->assign('a_timeselect_caption', '<b>'.L_G_JOINED.'</b>');
				   QUnit_Global::includeTemplate('filter_time.tpl.php'); ?>
            </td>
			<td width="10"></td>
            <td valign="top">
                <table cellpadding="0" cellspacing="0">
				<tr><td>&nbsp;&nbsp;<?php echo L_G_SHOWAFFILIATESWHERE?>&nbsp;</td>
                    <td><b><?php echo L_G_AFFILIATEID?></b>&nbsp;</td>
                    <td><?php echo L_G_ISLIKE?>&nbsp;</td>
					<td><input type=text name=<?php echo $this->a_form_preffix?>aid size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'aid']?>"></td></tr>
                <tr><td align="right">&nbsp;&nbsp;<?php echo L_G_AND?>&nbsp;</td>
                    <td><b><?php echo L_G_USERNAME2?></b>&nbsp;</td>
					<td><?php echo L_G_ISLIKE?>&nbsp;</td>
					<td><input type=text name=<?php echo $this->a_form_preffix?>username size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'username']?>"></td>
                    <td colspan="4"></td>
                </tr>
				<tr>
					<td align="right">&nbsp;&nbsp;<?php echo L_G_AND?>&nbsp;</td>
					<td><select name="<?php echo $this->a_form_preffix?>custom1">
						<?php foreach($this->a_filterColumns as $key => $value) { ?>
							<option value="<?php echo $key?>" <?php echo ($_REQUEST[$this->a_form_preffix.'custom1'] == $key) ? 'selected' :''?>><?php echo $value?></option>
						<?php } ?>
                        </select>&nbsp;</td>
                    <td><?php echo L_G_ISLIKE?>&nbsp;</td>
					<td><input type=text name="<?php echo $this->a_form_preffix?>custom1data" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'custom1data']?>"></td></tr>
                <tr><td align="right">&nbsp;&nbsp;<?php echo L_G_AND?>&nbsp;</td>
					<td><select name="<?php echo $this->a_form_preffix?>custom2">
						<?php foreach($this->a_filterColumns as $key => $value) { ?>
							<option value="<?php echo $key?>" <?php echo ($_REQUEST[$this->a_form_preffix.'custom2'] == $key) ? 'selected' :''?>><?php echo $value?></option>
                        <?php } ?>
						</select>&nbsp;</td>
                    <td><?php echo L_G_ISLIKE?>&nbsp;</td>
					<td><input type=text name="<?php echo $this->a_form_preffix?>custom2data" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'custom2data']?>"></td></tr>
                <tr><td align="right">&nbsp;&nbsp;<?php echo L_G_AND?>&nbsp;</td>
					<td><select name="<?php echo $this->a_form_preffix?>custom2">
                        <?php foreach($this->a_filterColumns as $key => $value) { ?>
							<option value="<?php echo $key?>" <?php echo ($_REQUEST[$this->a_form_preffix.'custom2'] == $key) ? 'selected' :''?>><?php echo $value?></option>
                        <?php } ?>
						</select>&nbsp;</td>
					<td><?php echo L_G_ISLIKE?>&nbsp;</td>
					<td><input type=text name="<?php echo $this->a_form_preffix?>custom2data" size=12 value="<?php echo $_REQUEST[$this->a_form_preffix.'custom2data']?>"></td>
				</tr>
				</table>
			</td></tr>
		</table>
		<hr class="filterline">
		</div>
	</td></tr>
<tr><td class="listheaderNoLineLeft">
		&nbsp;&nbsp;<input type="submit" class="formbutton" value="<?php echo L_G_APPLYFILTER?>"><br></td></tr>
</table>