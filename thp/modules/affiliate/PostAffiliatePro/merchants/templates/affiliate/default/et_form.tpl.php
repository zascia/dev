<script>
function changeCategory(sel)
{
  if(sel.value != '')
  {
    document.location.href = 'index.php?md=Affiliate_Merchants_Views_AffEmailTemplates&emailcategory='+sel.value+'&language=<?php echo $_REQUEST['language']?>'+"&<?php echo SID?>";
  }
}

function changeLanguage(sel)
{
  if(sel.value != '')
  {
    document.location.href = 'index.php?md=Affiliate_Merchants_Views_AffEmailTemplates&emailcategory=<?php echo $_REQUEST['emailcategory']?>&language='+sel.value+"&<?php echo SID?>";
  }
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

<?php $i=0; ?>
<table border=0 cellspacing=0 cellpadding=5 width="780">
<tr>
  <td align=left><?php echo L_G_EMAILTEMPLATES_DESCRIPTION?><br></td>
</tr>
<tr>
  <td align=left valign=top>
    <form action=index.php id="FilterForm" method=post name=form>
    <table class=listing border=0 cellspacing=0 cellpadding=4 width="610">
    <?php QUnit_Templates::printFilter(3, L_G_ETMANAGEMENT); ?>
<?php if($this->a_Auth->getSetting('Aff_allow_choose_lang') == 1)
   {
?>
    <tr class="listrow<?php echo ($i++)%2?>">
     <td align=left>&nbsp;<b><?php echo L_G_LANGUAGE?></b></td>
     <td align=left colspan=2 >
      <select name=language onchange="changeLanguage(this);">
<?php    while($data=$this->a_list_data3->getNextRecord()) { ?>
        <option value="<?php echo $data?>" <?php echo ($_REQUEST['language'] == $data ? 'selected' : '')?>><?php echo $data?></option>
<?php    } ?>
      </select>
     </td>
    </tr>
<?php } else { ?>
    <input type=hidden name=language value="<?php echo $this->a_Auth->getSetting('Aff_default_lang')?>">
<?php } ?>
    <tr class="listrow<?php echo ($i++)%2?>">
     <td align=left nowrap valign=top>&nbsp;<b><?php echo L_G_CATEGORY?></b></td>
     <td align=left>
     <select name=emailcategory onchange="changeCategory(this);">
<?php
      while($data=$this->a_list_data2->getNextRecord())
        echo "<option value='".$data."' ".($_REQUEST['emailcategory'] == $data ? "selected" : "").">".constant('L_G_'.$data)."</option>\n";
?>
     </select>
     <br/>
     <?php echo (defined('L_G_DESC_'.$_REQUEST['emailcategory']) ? constant('L_G_DESC_'.$_REQUEST['emailcategory']) : 'L_G_DESC_'.$_REQUEST['emailcategory'])?>
     </td>
     <td align=right>
     </td>
    </tr>
<?php $data=$this->a_list_data->getNextRecord(); ?>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td align="left" colspan="3" nowrap>&nbsp;<b><?php echo L_G_INSERTVALUETOTEXT?></b>&nbsp;<?php showQuickHelp(L_G_HLP_INSERTVALUETOTEXT); ?></td>
    </tr>
    <tr class="listrow<?php echo ($i-1)%2?>">
      <td></td>
      <td align="left" colspan="2" nowrap>
        <select name="br_insert_text" id="br_insert_text">
        <?php  $const = explode("<br>",  constant('ALLOWEDCONST_'.$_REQUEST['emailcategory']));
            foreach ($const as $cst) { ?>
          	 <option value="<?php echo $cst?>"><?php echo @constant("L_G_CONST_".strtoupper(substr($cst, 1)))?> (<?php echo $cst?>)</option>
        <?php	} ?>
        </select>
        <input type="button" onclick="javascript: insertValue(this.form.emailtext, this.form.br_insert_text);" value="<?php echo L_G_INSERT?>">
      </td>
    </tr>
    <tr class="listrow<?php echo ($i++)%2?>">
     <td align=left nowrap>&nbsp;<b><?php echo L_G_SUBJECT?></b></td>
     <td align=left colspan=2>
     <input type=text size=100 name=emailsubject id="emailsubject" value='<?php echo str_replace("'",'',$data['emailsubject'])?>'>
     </td> 
    </tr>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td colspan=3 align=left>&nbsp;<b><?php echo L_G_TEXT?></b></td>
    </tr>
    <tr class="listrow<?php echo ($i-1)%2?>">
      <td colspan=3 align=center>&nbsp;
      <textarea name=emailtext id="emailtext" rows=20 cols=110><?php echo $data['emailtext']?></textarea>&nbsp;
      </td>
    </tr>
    <tr class="listrow<?php echo ($i++)%2?>">
      <td colspan=3 align=center>
      <?php if($this->a_action_permission['edittemplate']) { ?>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_AffEmailTemplates'>
        <input type=hidden name=action value=<?php echo $_POST['action']?>>
        <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
        <?php if(defined('L_G_DEFAULT_TEXT_'.$_REQUEST['emailcategory']) && defined('L_G_DEFAULT_SUBJ_'.$_REQUEST['emailcategory'])) {
            ?>        
            <input type=button value='<?php echo L_G_DEFAULTTEMPLATE?>'
                onclick="javascript: document.getElementById('emailtext').value    = '<?php echo str_replace("'", "\'", constant('L_G_DEFAULT_TEXT_'.$_REQUEST['emailcategory']));?>';
                                     document.getElementById('emailsubject').value = '<?php echo str_replace("'", "\'", constant('L_G_DEFAULT_SUBJ_'.$_REQUEST['emailcategory']));?>';">
            <br><br>
        <?php } ?>
        <input class=formbutton type=submit value='<?php echo L_G_SAVECHANGES; ?>'>
        <?php if ( in_array($_REQUEST['emailcategory'], 
        		array('AFF_EMAIL_SIGNUP', 'AFF_EMAIL_FORGOTPAS1', 'AFF_EMAIL_FORGOTPAS2',
        			  'AFF_EMAIL_AF_DL_REP', 'AFF_EMAIL_AF_ML_REP' ))) {?>
        <br><br>
        <input class=formbutton type=submit onclick="javascript: document.form.md.value = 'Affiliate_Merchants_Views_BroadcastMessage'; return true;" value="<?php echo L_G_SENDEMAILFROMTEMPLATE?>">
        <?php } ?>
      <?php } ?>
      </td>
    </tr>
    <tr class="listrow<?php echo ($i-1)%2?>">
      <td colspan=3>&nbsp;</td>
    </tr>
    </table>
    </form>

  </td>
  <td align=left valign=top>

    <table class=listing width="200" border=0 cellspacing=0 cellpadding=1>
    <?php QUnit_Templates::printFilter(3, L_G_ALLOWEDCONSTANTS); ?>
    <tr>
      <td valign=top align=left style="padding: 5px;">
      <?php showHelp('L_G_HLPEMAILTEMPLATES'); ?>
      </td>
    </tr>
    <tr>
      <td valign=top align=left style="padding: 5px;">
      <?php echo constant('ALLOWEDCONST_'.$_REQUEST['emailcategory'])?>
      </td>
    </tr>
    </table>

  </td>
</tr>
</table>
