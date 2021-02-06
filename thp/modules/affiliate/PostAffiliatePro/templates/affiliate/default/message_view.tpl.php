
    <form action=index_popup.php method=post>
    <table class=listing width=100% border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, L_G_VIEW_MESSAGE); ?>
    <tr>
      <td colspan=2>&nbsp;</td>
    </tr>
    <tr>
      <td align=left width=1% nowrap>&nbsp;<b><?php echo L_G_TYPE?></b>&nbsp;
      <td align=left nowrap><?php echo ($_POST['message_type'] == MESSAGETYPE_EMAIL ? L_G_EMAIL : L_G_NEWS)?>
        &nbsp;
      </td>
    </tr>

    <tr>
      <td align=left nowrap>&nbsp;<b><?php echo L_G_TITLE?></b>&nbsp;</td>
      <td align=left><?php echo str_replace("'",'',$_POST['emailsubject'])?></td>
    </tr>
    <tr>
      <td align=left valign=top nowrap>&nbsp;<b><?php echo L_G_MESSAGE_TEXT?></b>&nbsp;</td>
    </tr>
    <tr>
      <td colspan=2 align=left><?php echo nl2br($_POST['emailtext'])?>&nbsp;</td>
    </tr>
    <tr>
      <td colspan=2 align=left valign='top' nowrap>&nbsp;<b><?php echo L_G_LISTOFUSERS?></b>&nbsp;</td>
    </tr>
    <?php if($this->a_message_users_count > 0) { ?>
    <tr>
      <td align=left colspan=2>
        <table class=listing border=0 cellspacing=0 cellpadding=2>
          <tr class=listheader>
            <td class=listheader align=left>&nbsp;<?php echo L_G_ID?>&nbsp;</td>
            <td class=listheader align=left>&nbsp;<?php echo L_G_NAME?>&nbsp;</td>
            <td class=listheader align=left>&nbsp;<?php echo L_G_SURNAME?>&nbsp;</td>
            <td class=listheader align=left>&nbsp;<?php echo L_G_EMAIL?>&nbsp;</td>
            <?php if($_POST['message_type'] != MESSAGETYPE_EMAIL) { ?>
              <td class=listheader align=left>&nbsp;<?php echo L_G_STATUS?>&nbsp;</td>
            <?php } ?>
          </tr>
      <?php
        while($data = $this->a_list_data->getNextRecord()) {
      ?>
          <tr>
            <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['userid']?>&nbsp;</td>
            <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['name']?>&nbsp;</td>
            <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['surname']?>&nbsp;</td>
            <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['email']?>&nbsp;</td>
            <?php if($_POST['message_type'] != MESSAGETYPE_EMAIL) { ?>
              <td class=listresultnocenter align=left nowrap>&nbsp;<?php
                  if($data['rstatus'] == MESSAGESTATUS_NOT_READED) print L_G_NOT_READED;
                  else if($data['rstatus'] == MESSAGESTATUS_SHOW) print L_G_READED;
                  else if($data['rstatus'] == MESSAGESTATUS_NOT_SHOW) print L_G_NOT_READ_AGAIN;
                  else print L_G_NOT_REACHABLE;
                ?>
                &nbsp;</td>
            <?php } ?>
          </tr>
      <?php
        }
      ?>
        </table>
      </td>
    </tr>
    <?php } else { ?>
    <tr>
      <td align=left colspan=2>&nbsp;<?php echo L_G_NO_AVAILABLE_USER?>&nbsp;</td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan=2 align=center>&nbsp;<br>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='<?php echo $this->a_md?>'>
        <input type=hidden name=action value='view'>
        <input type=hidden name=postaction value=''>
        <input class=formbutton type=button value='<?php echo L_G_BACK?>' onClick='javascript:document.location.href="index.php?md=<?php echo $this->a_md?>&<?php echo SID?>";'>
        <br>&nbsp;
      </td>
    </tr>
    </table>
    </form>
