<script>
function changeCategory(sel)
{
  if(sel.value != '')
  {
    document.location.href = 'index.php?md=Affiliate_Merchants_Views_BroadcastMessage&emailcategory='+sel.value+"&<?php echo SID?>";
  }
}

function broadcastEmail()
{
  document.location.href = 'index.php?md=Affiliate_Merchants_Views_BroadcastMessage'+"&<?php echo SID?>";
}

function moveFromSelectToSelect(from,to)
{   
  for(i=1; i<from.options.length; i++)
  {
    if(from.options[i].selected == true)
    {
      var option0 = new Option(from.options[i].text,from.options[i].value);
      from.options[i] = null;
      to.options[to.options.length++] = option0;
      i--;
    }
  }
}

function moveAllFromSelectToSelect(from,to)
{   
  for(i=1; i<from.options.length; i++)
  {
      var option0 = new Option(from.options[i].text,from.options[i].value);
      from.options[i] = null;
      to.options[to.options.length++] = option0;
      i--;
  }
}

function validate_selects(form)
{
  form.selectedusers.value = codeSelected(form.chosenaff);
}

function codeSelected(select_object)
{
  codedString = '';
  for (i=1; i<select_object.options.length; i++)
  {
    codedString = codedString + ',' + select_object.options[i].value;
  }
  return codedString.substring(1,codedString.length);
}

function validate(form)
{
  if (form.chosenaff.options.length==1)
  {
    if( (document.getElementById('br_sheet').value != 'news') ||
        (!document.getElementById('br_show_all').checked) )
    {
      alert("<?php echo L_G_ERRNOAFFILIATES?>");
      return false;
    }
  }

  if(form.emailsubject.value == '')
  {
    alert("<?php echo L_G_ERRNOSUBJECT?>");
    return false;
  }

  if(form.emailtext.value == '')
  {
    alert("<?php echo L_G_ERRNOTEXT?>");
    return false;
  }

  validate_selects(form);
}

function setSelectionRange(input, selectionStart, selectionEnd) {
  if (input.setSelectionRange) {
    input.focus();
    input.setSelectionRange(selectionStart, selectionEnd);
  }
  else if (input.createTextRange) {
    var range = input.createTextRange();
    range.collapse(true);
    range.moveEnd('character', selectionEnd);
    range.moveStart('character', selectionStart);
    range.select();
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

<?php if ($this->a_sendemails) { ?>
    var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_BroadcastMessage&action=sendemails&start=1","Sending","scrollbars=1, top=100, left=100, width=500, height=160, status=0");
  	wnd.focus();
<?php } ?>
</script>


<?php if(/*$_POST['action'] != 'edit'*/1) { ?>
     <form name="FilterForm" id="FilterForm" action=index.php method=post onsubmit="return validate(this)">
<?php } else { ?>
     <form name="FilterForm" id="FilterForm" action=index_popup.php method=post onsubmit="return validate(this)">
<?php } ?>
<table border=0 cellspacing=0 cellpadding=2 width="780">
<tr><td><?php echo L_G_BROADCASTMESSAGEHELP?><br><br></td></tr>
</table>
<table border=0 cellspacing=0 cellpadding=2 width="780">
  <tr>
  <td valign=top width="630">
    <?php QUnit_Templates::drawDivTabs($this->a_tabs, 'br_', ($GLOBALS['Auth']->getSetting('Aff_display_news') == '1' ? 2 : 1), 610, false, true, true); ?>
    <table class=listing border=0 cellspacing=0 cellpadding=4 width="610" style="border-top: 0px;">
    <tr class="listrow0">
      <td align=left colspan="2">
        <div id="brdesc_news" style="padding:4px 4px 4px 4px; <?php echo ($_REQUEST['br_sheet'] == 'news') ? '' : 'display: none;'?>">
            <?php echo L_G_BROADCASTNEWS_DESCRIPTION?>
        </div>
        <div id="brdesc_mail" style="padding:4px 4px 4px 4px; <?php echo ($_REQUEST['br_sheet'] == 'mail') ? '' : 'display: none;'?>">
            <?php echo L_G_BROADCASTMAIL_DESCRIPTION?>
        </div>
      </td>
    </tr>

    <tr class="listrow0">
      <td colspan=2 align=left nowrap>&nbsp;<b><?php echo L_G_CHOOSEAFFILIATES?></b></td>
    </tr>

    <tr class="listrow0">
      <td align=left colspan=2>
        <table border=0>
          <tr>
            <td class=artdata nowrap>&nbsp;<input type="hidden" name="selectedusers">
              <select multiple name='allaff' size=5 width="270" style="width: 270px">
                <option value=0>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </option>
<?php
              $data3 = $this->a_list_data3;
              while($data1=$this->a_list_data1->getNextRecord()) {
                if(is_array($data3) && in_array($data1['userid'], $data3)) continue;

                //echo "<option value=".$data1['userid'].">".$data1['userid']." : ".$data1['name']." ".$data1['surname']." : ".$data1['username'];
                echo "<option value=".$data1['userid'].">".$data1['surname']." ".$data1['name']." : ".$data1['username'];
                if($data1['rstatus'] == AFFSTATUS_SUPPRESSED) echo " - ".strtoupper(L_G_SUPPRESSED);
                if($data1['rstatus'] == AFFSTATUS_NOTAPPROVED) echo " - ".strtoupper(L_G_PENDING);
                echo "</option>\n";
              }
?>      
              </select>
            </td>
            <td class=artdata align=center nowrap>
              <INPUT TYPE="button" class=formbutton VALUE=">>" onClick="moveAllFromSelectToSelect(this.form.allaff,this.form.chosenaff)"><br>
              <INPUT TYPE="button" class=formbutton VALUE=">" onClick="moveFromSelectToSelect(this.form.allaff,this.form.chosenaff)"><br><font size=1>&nbsp;</font><br>
              <INPUT TYPE="button" class=formbutton VALUE="<" onClick="moveFromSelectToSelect(this.form.chosenaff,this.form.allaff)"><br>
              <INPUT TYPE="button" class=formbutton VALUE="<<" onClick="moveAllFromSelectToSelect(this.form.chosenaff,this.form.allaff)">
            </td>
            <td class=artdata nowrap>
              <select multiple name='chosenaff' size=5 width="270" style="width: 270px">
                <option value=0>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </option>

<?php
              if(($_POST['action'] == 'edit') || ($_GET['fromsession'] == '1') || ($_GET['userid'] != '') || ($_REQUEST['action'] == 'broadcast')) {
                while($data2=$this->a_list_data2->getNextRecord()) {
                  if(is_array($data3) && !in_array($data2['userid'], $data3)) continue;

                  echo "<option value=".$data2['userid'].">".$data2['surname']." ".$data2['name']." : ".$data2['username'];
                  if($data2['rstatus'] == AFFSTATUS_SUPPRESSED) echo " - ".strtoupper(L_G_SUPPRESSED);
                  if($data2['rstatus'] == AFFSTATUS_NOTAPPROVED) echo " - ".strtoupper(L_G_PENDING);
                  echo "</option>\n";                }
              }
?>      
              </select>
              &nbsp;&nbsp;<a href=cat_add.php><?php print $lu_addnewcat; ?></a>
            </td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
    <tr>
      <td align=left colspan="2" nowrap  style="padding:0px 0px 0px 0px;">
        <div id="br_mail" <?php echo ($_REQUEST['br_sheet'] == 'mail') ? '' : 'style="display: none;"'?>>
            <?php QUnit_Global::includeTemplate('broadcast_mail.tpl.php') ?>
        </div>
        <div id="br_news" <?php echo ($_REQUEST['br_sheet'] == 'news') ? '' : 'style="display: none;"'?>>
            <?php QUnit_Global::includeTemplate('broadcast_news.tpl.php') ?>
        </div>
      </td>    
    </tr>
    <tr class="listrow1">
      <td align=left nowrap>&nbsp;<b><?php echo L_G_SUBJECT1?></b>&nbsp;</td>
      <td align=left><input type=text size=106 name=emailsubject value='<?php echo str_replace("'",'',$_POST['emailsubject'])?>'></td>
    </tr>
    <tr class="listrow0">
      <td colspan=2 align=left nowrap>&nbsp;<b><?php echo L_G_MESSAGE_TEXT?></b></td>
    </tr>   
    <tr>
      <td colspan=2>&nbsp;
        <textarea name=emailtext id=emailtext rows=15 cols=110><?php echo $_POST['emailtext']?></textarea>&nbsp;
      </td>
    </tr>
    <tr>
      <td colspan=2>&nbsp;<br>&nbsp;
        <input type=hidden name=commited value=yes>
        <?php if(1/*$_POST['action'] != 'edit'*/) { ?>
             <input type=hidden name=md value='Affiliate_Merchants_Views_BroadcastMessage'>
        <?php } else { ?>
            <input type=hidden name=md value='Affiliate_Merchants_Views_Communications'>
        <?php } ?>
        <input type=hidden name=action value='<?php echo $_POST['action']?>'>
        <input type=hidden name=postaction value='<?php echo $_POST['postaction']?>'>
        <input type=hidden name=mid value='<?php echo $_REQUEST['mid']?>'>
        <input type=hidden name=emailcategory value='<?php echo $_POST['emailcategory']?>'>
        <input type=submit value='<?php echo L_G_SUBMIT; ?>'> 
        <br>&nbsp;
      </td>
    </tr>
    </table>
  </td>
  <td align=left valign=top>   
    <table class=listing border=0 cellspacing=0 cellpadding=1 width="150">
      <?php QUnit_Templates::printFilter(1, L_G_ALLOWEDCONSTANTS); ?>
      <tr>
        <td valign=top align=left><?php showHelp('L_G_HLPEMAILTEMPLATES'); ?></td>
      </tr>    
      <tr>
        <td valign=top align=left>
        <?php  // union of global constants and specific constants for template
            $const = explode("<br>",  L_G_HLP_AFF_EMAIL_GLOBAL_CONSTANTS);
            if (isset($_POST['emailcategory']) && (in_array($_POST['emailcategory'], array(AFF_EMAIL_SIGNUP, AFF_EMAIL_FORGOTPAS1, AFF_EMAIL_FORGOTPAS2, AFF_EMAIL_AF_DL_REP, AFF_EMAIL_AF_ML_REP)))) {
            	$const = array_merge($const, explode("<br>",  constant('L_G_HLP_'.$_POST['emailcategory'])));
            	$const = array_unique($const);
			}
          	foreach ($const as $cst)
        		echo $cst."<br>";
        ?>
        <?php if (!isset($_POST['emailcategory']) || (!in_array($_POST['emailcategory'], array(AFF_EMAIL_SIGNUP, AFF_EMAIL_FORGOTPAS1, AFF_EMAIL_FORGOTPAS2, AFF_EMAIL_AF_DL_REP, AFF_EMAIL_AF_ML_REP)))) { ?>
        <div id="brcons_mail" style="<?php echo ($_REQUEST['br_sheet'] == 'mail') ? '' : 'display: none;'?>">
            
            <?php echo L_G_HLP_AFF_EMAIL_STATS_CONSTANTS?>
        </div>
        <?php } ?>
        </td>
      </tr>
    </table>
  </td>
  </tr>
</table>
</form>