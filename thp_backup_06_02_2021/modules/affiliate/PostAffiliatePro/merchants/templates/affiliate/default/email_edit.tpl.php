
    <form enctype="multipart/form-data" action=index.php method=post>
    <table border=0 class=listing cellspacing=0 width=780 cellpadding=3>
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td width="5%" class=dir_form nowrap><?php echo L_G_PCNAME;?></td>
      <td>
        <select name=campaign>
<?php      while($data=$this->a_list_data->getNextRecord()) { ?>
          <option value='<?php echo $data['campaignid']?>' <?php echo ($_REQUEST['campaign'] == $data['campaignid'] ? 'selected' : '')?>><?php echo $data['name']?></option>
<?php      } ?>          
        </select>&nbsp;*
      </td>
    </tr>    
    <tr>
      <td class=dir_form nowrap><?php echo L_G_DESTURL;?></td>
      <td>
        <input type=text name=desturl id="desturl" size=60 value="<?php echo $_POST['desturl']?>">&nbsp;*
      </td>
    </tr>
    <tr>
      <td class=dir_form nowrap><?php echo L_G_SUBJECT;?></td>
      <td><input type=text name=sourceurl size=83 value="<?php echo $_POST['sourceurl']?>"></td>
    </tr>

    <tr>
        <td class=dir_form nowrap valign=top>
<?php if($_REQUEST['type'] == 'textemail') { ?>
      <?php echo L_G_EMAILTEXT;?>
<?php } else if($_REQUEST['type'] == 'htmlemail') { ?>
      <?php echo L_G_EMAILBODY;?>
<?php } ?>
        </td>
      <td>
      <textarea name=desc rows=20 cols=80><?php echo $_POST['desc']?></textarea>
      </td>
    </tr>

    <tr>
      <td class=dir_form colspan=2 align=left>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_EmailManager'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=type value=<?php echo $_REQUEST['type']?>>
      <input type=hidden name=cid value=<?php echo $_POST['cid']?>>
      <input type=hidden name=bid value=<?php echo $_POST['bid']?>>
      <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
      <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?php echo $this->a_this->getImage('blank.png')?>"></td></tr> 
    <tr>
      <td class=smalltexthelp colspan=2>
<?php 
      if($_REQUEST['type'] == 'textemail') {
          showHelp(L_G_TEXTEMAILHELP);
      } else if($_REQUEST['type'] == 'htmlemail') {
          showHelp(L_G_HTMLEMAILHELP);
      }
?>
      </td>
    </tr>
    </table>
    </form>

