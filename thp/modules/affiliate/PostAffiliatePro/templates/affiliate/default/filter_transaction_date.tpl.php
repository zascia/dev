<table>
    <tr>
	<td>&nbsp;<b><?php echo L_G_DATE_SELECT_MODE ?></b><?php showQuickHelp(L_G_TRANSACTIONDATEHELP); ?>&nbsp;</td>
	<td>
	    <select name="<?php echo $this->a_form_preffix?>date_select_mode">
		<option value='<?php echo DATE_SELECT_MODE_INSERTED?>' <?php echo ($_REQUEST[$this->a_form_preffix.'date_select_mode'] == DATE_SELECT_MODE_INSERTED) ? 'selected' : '' ?> ><?php echo L_G_DATE_SELECT_MODE_INSERTED?></option>
		<option value='<?php echo DATE_SELECT_MODE_APPROVED?>' <?php echo ($_REQUEST[$this->a_form_preffix.'date_select_mode'] == DATE_SELECT_MODE_APPROVED) ? 'selected' : '' ?> ><?php echo L_G_DATE_SELECT_MODE_APPROVED?></option>
	    </select>
	</td>
    </tr>
</table>