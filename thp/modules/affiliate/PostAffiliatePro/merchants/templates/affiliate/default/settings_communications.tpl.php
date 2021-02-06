<script language="JavaScript">
    function send_test_mail() {
        if (document.myForm.smtp_server.value == '') {
            alert('<?php echo L_G_SMTPEMPTYERROR;?>');
            return false;
        }

        document.myForm.action.value = 'testmsg';
        document.myForm.submit();
    }
</script>

<table width="100%" border=0 cellspacing=0 cellpadding=3>
    <?php QUnit_Templates::printFilter2(3, L_G_COMMUNICATION); ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SYSTEMEMAILNAME;?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=system_email_name value="<?php echo $_POST['system_email_name']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SYSTEMEMAIL;?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=system_email value="<?php echo $_POST['system_email']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPSYSTEMEMAIL'); ?></td>
    </tr>
    <tr>
      <td nowrap><b><?php echo L_G_MAIL_SEND_TYPE?></b></td>
      <td valign=top nowrap>
        <input type=radio name=mail_send_type value='<?php echo EMAILBY_MAIL?>' <?php echo ($_POST['mail_send_type'] == EMAILBY_MAIL ? ' checked' : '')?>><?php echo L_G_SENDBYMAIL?>
      </td>
      <td><?php showHelp('L_G_HLPSENDBYMAIL'); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign=top nowrap>
        <input type=radio name=mail_send_type value='<?php echo EMAILBY_SMTP?>' <?php echo ($_POST['mail_send_type'] == EMAILBY_SMTP ? ' checked' : '')?>><?php echo L_G_SENDUSINGSMTP?>
      </td>
      <td><?php showHelp('L_G_HLPSENDUSINGSMTP'); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign=top nowrap colspan=2>
      <table border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td align="left">&nbsp;<?php echo L_G_SMTPSERVER?></td>
        <td align="left">&nbsp;<input type=text name='smtp_server' size=40 value='<?php echo $_POST['smtp_server']?>'></td>
        <td align="left">&nbsp;<?php echo L_G_SMTPSERVER_PORT?></td>
        <td align="left">&nbsp;<input type=text name='smtp_server_port' size=4 value='<?php echo $_POST['smtp_server_port']?>'></td>
        <td align="left">&nbsp;<?php echo L_G_SMTPSERVER_TLS?></td>
        <td align="left">&nbsp;<input type="checkbox" name='smtp_server_tls' value="1" <?php echo ($_POST['smtp_server_tls'] == '1') ? 'checked' : ''?>></td>
      </tr>
      <tr>
        <td align="left">&nbsp;<?php echo L_G_SMTPUSERNAME?></td>
        <td align="left" colspan="5">&nbsp;<input type=text name='smtp_username' size=40 value='<?php echo $_POST['smtp_username']?>'></td>
      </tr>
      <tr>
        <td align="left">&nbsp;<?php echo L_G_SMTPPASSWORD?></td>
        <td align="left" colspan="3">&nbsp;<input type="password" name="smtp_password" size="40" value="<?php echo $_POST['smtp_password']?>"></td>
        <td align="right" colspan="2" >&nbsp;<input type="button" name="test_msg" onclick="send_test_mail();" value="<?php echo L_G_SMTPSENDTESTMSG?>"></td>
      </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_MAIL_TYPE;?></b></td>
      <td valign=top nowrap>
   		<input type=radio name=mail_type value='<?php echo MAIL_TEXT?>' <?php echo ($_POST['mail_type'] == MAIL_TEXT ? ' checked' : '')?>><?php echo L_G_SENDASTEXT?>
   	  </td>
   	  <td><?php showHelp('L_G_HLPMAILTYPETEXT'); ?></td>
   	</tr>
    <tr>
   	  <td>&nbsp;</td>
   	  <td valign="top" nowrap>
   		<input type=radio name=mail_type value='<?php echo MAIL_HTML?>' <?php echo ($_POST['mail_type'] == MAIL_HTML ? ' checked' : '')?>><?php echo L_G_SENDASHTML?>
   	  </td>
   	  <td><?php showHelp('L_G_HLPMAILTYPEHTML'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_CHARSET;?></b></td>
      <td valign=top nowrap>
      	<select name="mail_charset">
      		<option value="no_charset" <?php echo ($_POST['mail_charset'] == 'no_charset') ? 'selected' : ''?>><?php echo L_G_NOCHARSET?></option>
      	    <?php foreach ($this->a_charsets as $charset) { ?>
      	    	  <option value='<?php echo $charset?>' <?php echo ($_POST['mail_charset'] == $charset) ? 'selected' : ''?>><?php echo $charset?></option>
      	    <?php } ?>
      		<option value="other" <?php echo (!in_array($_POST['mail_charset'], $this->a_charsets) && $_POST['mail_charset'] != 'no_charset') ? 'selected' : ''?>><?php echo L_G_OTHER?></option>
      	</select>
   	  </td>
   	  <td><?php echo L_G_OTHER?> <input type=text name='mail_charset_other' size=20 value='<?php echo $_POST['mail_charset_other']?>'></td>
   	</tr>
   	<tr>
      <td class=dir_form valign=top nowrap></td>
      <td valign=top nowrap colspan="2">
        <input type="checkbox" name="mail_encode_subject" value="1" <?php echo ($_POST['mail_encode_subject'] == '1') ? 'checked' : ''?>>
        <?php echo L_G_MAILENCODESUBJECT?>
   	  </td>
   	</tr>
   	<tr>
   	  <td>&nbsp;</td>
   	  <td colspan="2"><?php showHelp('L_G_HLPMAILCHARSET'); ?></td>
    </table>