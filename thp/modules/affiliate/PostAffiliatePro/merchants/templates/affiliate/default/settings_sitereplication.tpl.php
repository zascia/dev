<script language="JavaScript">
function replicatePages() {
    if (!document.myForm.sr_enable.checked) {
        alert('<?php echo L_G_SITEREPLICATIONISNOTENABLED?>');
        return false;
    }
        
    document.myForm.action.value = 'sitereplication';
    document.myForm.submit();
}
    
function insertValue(textarea, combo) {
	if (textarea.setSelectionRange) {
	    var scrollTop = textarea.scrollTop;
		var selectionStart = textarea.selectionStart;
		var selectionEnd = textarea.selectionEnd;
		textarea.value = textarea.value.substring(0, selectionStart) + combo.value + textarea.value.substring(selectionEnd);
		if (selectionStart != selectionEnd){ 
			setSelectionRange(textarea, selectionStart, selectionStart + combo.value.length);
		} else {
			setSelectionRange(textarea, selectionStart + combo.value.length, selectionStart + combo.value.length);
		}
		textarea.scrollTop = scrollTop;
	} else if (document.selection) {
	    textarea.focus();
	    var sel = document.selection.createRange();
        sel.text = combo.value;
	}
}
</script>

    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_SITEREPLICATION); ?>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_ENABLESITEREPLICATION;?></td>
      <td valign=top><input type="checkbox" name="sr_enable" value="1" <?php echo ($_POST['sr_enable'] == '1') ? 'checked' : ''?>></td>
      <td valign=top><?php showHelp('L_G_HLPSITEREPLICATION'); ?></td>
    </tr>
	<tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>    
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_DIRECTORYFORREPLICATION;?></td>
      <td valign=top colspan="2">
      	<input type="text" size="70" name="sr_directory" value="<?php echo $_POST['sr_directory']?>">
      	<br>
      	<?php showHelp('L_G_HLPDIRECTORYFORREPLICATION'); ?>
      </td>
    </tr>
    <tr>
      <td class=formBText valign=top nowrap><?php echo L_G_URLTODIRECTORYFORREPLICATION;?></td>
      <td valign=top colspan="2"><input type="text" size="70" name="sr_directoryurl" value="<?php echo $_POST['sr_directoryurl']?>"></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr>
      <td valign=top nowrap colspan="3">
      	<span class="formBText"><?php echo L_G_SITEREPLICATIONTEMPLATE;?></span><br>
      	<span style="position:relative; left:20px;">
        	<select name="insert_text" id="insert_text">
        	<?php  $const = explode("<br>",  L_G_HLP_SITEREPLICATION_CONSTANTS);
                foreach ($const as $cst) { ?>
          	 	<option value="<?php echo $cst?>"><?php echo @constant("L_G_CONST_".strtoupper(substr($cst, 1)))?> (<?php echo $cst?>)</option>
        	<?php	} ?>
        	</select>
        	<input type="button" onclick="javascript: insertValue(this.form.sr_template, this.form.insert_text);" value="<?php echo L_G_INSERT?>">
        </span>
      	<br>
      	<textarea style="position:relative; left:20px;" rows="20" cols="140" id="sr_template" name="sr_template"><?php echo stripslashes($_POST['sr_template'])?></textarea>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    <tr><td colspan=3>
    		<input type="button" name="test_msg" onclick="replicatePages();" value="<?php echo L_G_REPLICATEPAGES?>">
    	</td>
    </tr>
    </table>
