<script>
function viewMessage(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_Communications&action=view&mid="+ID+"&<?php echo SID?>";
}

function editMessage(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_BroadcastMessage&action=edit&mid="+ID+"&<?php echo SID?>";
  //var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_Communications&action=edit&mid="+ID+"&<?php echo SID?>","Communication","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
  //wnd.focus();
}

function deleteMessage(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEMESSAGE?>"))
    document.location.href = "index.php?md=Affiliate_Merchants_Views_Communications&mid="+ID+"&action=delete"+"&<?php echo SID?>";
}

function activateMessage(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_Communications&action=activate&mid="+ID+"&<?php echo SID?>";
}

function deactivateMessage(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_Communications&action=deactivate&mid="+ID+"&<?php echo SID?>";
}

</script>
    <table class=listing border=0 cellspacing=0 cellpadding=1 width="780">
    <tr>
      <td class=listheader colspan=8 align=center>
        <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
      </td>
    </tr>
    <tr>
      <td class=listheaderLeft colspan=8 align=left>
        <?php if($this->a_this->checkPermissions('send')) { ?>
            <input type="button" value="<?php echo L_G_SENDEMAIL?>"
              onclick="javascript:document.location.href='index.php?md=Affiliate_Merchants_Views_BroadcastMessage&br_sheet=mail';">
        <?php } ?>
        &nbsp;&nbsp;
        <?php if($this->a_this->checkPermissions('send') && ($GLOBALS['Auth']->getSetting('Aff_display_news') == '1')) { ?>
            <input type="button" value="<?php echo L_G_SENDNEWS?>"
              onclick="javascript:document.location.href='index.php?md=Affiliate_Merchants_Views_BroadcastMessage&br_sheet=news';">
        <?php } ?>
      </td>
    </tr>

    <tr class=listheader>
<?php
    QUnit_Templates::printHeader(L_G_ID, 'm.messageid');
    QUnit_Templates::printHeader(L_G_CREATED, 'm.dateinserted');
    QUnit_Templates::printHeader(L_G_TITLE, 'm.title');
    QUnit_Templates::printHeader(L_G_MESSAGE_TEXT, 'm.rtext');
    if($this->a_Auth->getSetting('Aff_display_news') == '1') {
        QUnit_Templates::printHeader(L_G_HISTORYTYPE, 'm.rtype');
    }
    QUnit_Templates::printHeader(L_G_RECIPIENT, 'users_count');
    QUnit_Templates::printHeader(L_G_EMAIL, 'mu.email');
    QUnit_Templates::printHeader(L_G_ACTIONS);
?>
    </tr>
<?php
    $nodata = true;
    while($data=$this->a_list_data->getNextRecord())
    {
        $nodata = false;
?>    
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult>&nbsp;<?php echo $data['messageid']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['dateinserted']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['title']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;
      <?php
      $text = $data['rtext'];
      if(strlen($text) > 30) $text = substr($text,0,30).' ...';
      print $text;
      ?>
      &nbsp;
      </td>
      <?php if($this->a_Auth->getSetting('Aff_display_news') == '1') { ?>
        <td class=listresult nowrap>&nbsp;
        <?php if($data['rtype'] == MESSAGETYPE_EMAIL) print L_G_EMAIL;
           else if($data['rtype'] == MESSAGETYPE_NEWS) print L_G_NEWS;
           else print L_G_UNKNOWN_TYPE;
        ?>
        &nbsp;
        </td>
      <?php } ?>
      <td class=listresult nowrap>&nbsp;
        <?php
          if($data['showtoall'] == '1') print L_G_ALL;
          else if($data['users_count'] > 1) print L_G_MULTIPLE;
          else if($data['users_count'] > 0) print $this->a_message_users[$data['messageid']][$data['messagetouserid']]['userid'].': '.$this->a_message_users[$data['messageid']][$data['messagetouserid']]['name'].' '.$this->a_message_users[$data['messageid']][$data['messagetouserid']]['surname'];
        ?>
        &nbsp;
      </td>
      <td class=listresult nowrap>&nbsp;
        <?php
          if($data['showtoall'] == '1') print L_G_ALL;
          else if($data['users_count'] > 1) print L_G_MULTIPLE;
          else if($data['users_count'] > 0) print $this->a_message_users[$data['messageid']][$data['messagetouserid']]['email'];
        ?>
        &nbsp;
      </td>
      <td class=listresult>
<?php          $actions = array();
            $i = 0;
            if($this->a_action_permission['view']) {
                $actions[$i++] = array('id'     => 'view',
                                       'img'    => 'icon_view.gif',
                                       'desc'   => L_G_VIEW,
                                       'action' => "viewMessage('".$data['messageid']."');" );
            }
            if($data['rtype'] == MESSAGETYPE_NEWS && $this->a_action_permission['edit']) {
                $actions[$i] = array('id'     => 'edit',
                                     'img'    => 'icon_edit.gif',
                                     'desc'   => L_G_EDIT,
                                     'action' => "editMessage('".$data['messageid']."');" );
            }
            $i++;
            if($data['rtype'] == MESSAGETYPE_NEWS && $data['active'] != '1' && $this->a_action_permission['edit']) {
                $actions[$i] = array('id'     => 'activate',
                                     'img'    => 'icon_approve.gif',
                                     'desc'   => L_G_ACTIVATE,
                                     'action' => "activateMessage('".$data['messageid']."');" );
            }
            $i++;
            if($data['rtype'] == MESSAGETYPE_NEWS && $data['active'] == '1' && $this->a_action_permission['edit']) {
                $actions[$i] = array('id'     => 'deactivate',
                                     'img'    => 'icon_suppress.gif',
                                     'desc'   => L_G_DEACTIVATE,
                                     'action' => "deactivateMessage('".$data['messageid']."');" );
            }
            $i++;
            if($this->a_action_permission['delete']) {
                $actions[$i++] = array('id'     => 'delete',
                                       'img'    => 'icon_delete.gif',
                                       'desc'   => L_G_DELETE,
                                       'action' => "deleteMessage('".$data['messageid']."');" );
            }
            $this->a_this->initTemporaryTE();
            $this->a_this->temporaryAssign('a_actions', $actions);                        
            $this->a_this->temporaryAssign('a_action_count', $i);
?>
            <?php echo $this->a_this->temporaryFetch('actions_icon')?>
      </td>
    </tr>
<?php
    }
?>
<?php  if ($nodata) { ?>
    <tr><td colspan="8" align="center"><b><?php echo L_G_NORECORDSFOUND?></b></td></tr>
<?php  } ?>
  </table>
  </form>

  <br>
