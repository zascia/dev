<script>
function viewMessage(ID)
{
  document.location.href = "index.php?md=<?php echo $this->a_md?>&action=view&mid="+ID+"&<?php echo SID?>";
}

function editMessage(ID)
{
  var wnd = window.open("index_popup.php?md=<?php echo $this->a_md?>&action=edit&mid="+ID+"&<?php echo SID?>","Communication","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
  wnd.focus();
}

function deleteMessage(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEMESSAGE?>"))
    document.location.href = "index.php?md=<?php echo $this->a_md?>&mid="+ID+"&action=delete"+"&<?php echo SID?>";
}
</script>

    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=listheader colspan=8 align=center>
        <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
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
    while($data=$this->a_list_data->getNextRecord())
    {
?>    
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult>&nbsp;<?php echo $data['messageid']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['dateinserted']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?php echo $data['title']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;
      <?php 
      $pos = strrpos($data['rtext'], "\\");
      if($pos !== false)
        $file = substr($data['rtext'], $pos+1);
      else
        $file = $data['rtext'];

      $pos = strrpos($file, '/');
      if($pos !== false)
        $file = substr($file, $pos+1);

      if(strlen($file) > 30) $file = substr($file,0,30).' ...';

      print $file;
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
      <td class=listresult>&nbsp;
        <?php
          if($data['users_count'] > 1) print L_G_MULTIPLE;
          else if($data['users_count'] > 0) print $this->a_message_users[$data['messageid']][$data['messagetouserid']]['userid'].': '.$this->a_message_users[$data['messageid']][$data['messagetouserid']]['name'].' '.$this->a_message_users[$data['messageid']][$data['messagetouserid']]['surname'];
        ?>
        &nbsp;
      </td>
      <td class=listresult nowrap>&nbsp;
        <?php
          if($data['users_count'] > 1) print L_G_MULTIPLE;
          else if($data['users_count'] > 0) print $this->a_message_users[$data['messageid']][$data['messagetouserid']]['email'];
        ?>
        &nbsp;
      </td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
          <option value="-">------------------------</option>
          <?php if($this->a_action_permission['view']) { ?>
               <option value="javascript:viewMessage('<?php echo $data['messageid']?>');"><?php echo L_G_VIEW?></option>
          <?php }
             if($data['rtype'] == MESSAGETYPE_NEWS && $this->a_action_permission['edit']) { ?>
               <option value="javascript:editMessage('<?php echo $data['messageid']?>');"><?php echo L_G_EDIT?></option>
          <?php }
             if($this->a_action_permission['delete']) { ?>
               <option value="javascript:deleteMessage('<?php echo $data['messageid']?>');"><?php echo L_G_DELETE?></option>
          <?php } ?>
        </select>
      </td>
    </tr>      
<?php
    }
?>
  </table>
  </form>
  
  <br>
