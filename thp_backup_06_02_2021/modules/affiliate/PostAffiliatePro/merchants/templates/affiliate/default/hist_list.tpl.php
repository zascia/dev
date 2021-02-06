<script>
function purgeHistory()
{
  if(confirm("<?php echo L_G_CONFIRMPURGEHISTORY?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_History&action=purge"+"&<?php echo SID?>";
}
</script>
    <?php QUnit_Global::includeTemplate('hist_filter.tpl.php'); ?>
    <table class=listing border=0 cellspacing=0 cellpadding=1 width="780">
    <?php if($this->a_action_permission['purge']) { ?>
      <tr>
        <td class=listheaderLeft align=left colspan=10>
          &nbsp;<b><input type="button" onclick="javascript:purgeHistory();" value="<?php echo L_G_PURGEHISTORY?>"></b>
        </td>
      </tr>
    <?php } ?>
    <tr>
      <td class=listheader colspan=11 align=center>
        <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
      </td>
    </tr>    
    
    <tr class=listheader>
<?php
    QUnit_Templates::printHeader(L_G_HISTORYID, 'historyid');
    QUnit_Templates::printHeader(L_G_CREATED, 'dateinserted');
    QUnit_Templates::printHeader(L_G_HISTORYTYPE, 'rtype');
    QUnit_Templates::printHeader(L_G_LOGMSG, 'value');
    QUnit_Templates::printHeader(L_G_IP, 'ip');
    QUnit_Templates::printHeader(L_G_FILE, 'hfile');
    QUnit_Templates::printHeader(L_G_LINE, 'line');
?>    
    </tr>    
<?php
    $nodata = true;
    while($data=$this->a_list_data->getNextRecord())
    {
        $nodata = false;
?>    
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult valign=top>&nbsp;<?php echo $data['historyid']?>&nbsp;</td>
      <td class=listresult valign=top nowrap>&nbsp;<?php echo $data['dateinserted']?>&nbsp;</td>
      <td class=listresult valign=top nowrap>&nbsp;
      <?php
      switch($data['rtype'])
      {
        case WLOG_DBERROR :
            echo '<span class=style_log_dberror>'.L_G_LOG_DBERROR.'</span>';
        break;

        case WLOG_ERROR :
            echo '<span class=style_log_error>'.L_G_LOG_ERROR.'</span>';
        break;

        case WLOG_ACTIONS :
            echo '<span class=style_log_actions>'.L_G_LOG_ACTIONS.'</span>';
        break;

        case WLOG_DEBUG :
            echo '<span class=style_log_debug>'.L_G_LOG_DEBUG.'</span>';
        break;

        default :
            echo '<span class=style_log_default>'.L_G_LOG_DEBUG.'</span>';
        break;
      }
      ?>
      &nbsp;
      </td>
      <td class=listresultnocenter align=left valign=top>&nbsp;
      <?php
      switch($data['rtype'])
      {
        case WLOG_DBERROR :
            echo '<span class=style_log_dberror>'.nl2br(htmlspecialchars($data['value'])).'</span>';
        break;

        case WLOG_ERROR :
            echo '<span class=style_log_error>'.nl2br(htmlspecialchars($data['value'])).'</span>';
        break;

        case WLOG_ACTIONS :
            echo '<span class=style_log_actions>'.nl2br(htmlspecialchars($data['value'])).'</span>';
        break;

        case WLOG_DEBUG :
            echo '<span class=style_log_debug>'.nl2br(htmlspecialchars($data['value'])).'</span>';
        break;
        
        default :
            echo '<span class=style_log_default>'.nl2br(htmlspecialchars($data['value'])).'</span>';
        break;
      }
      ?>
      &nbsp;
      </td>
      <td class=listresult valign=top nowrap>&nbsp;<?php echo $data['ip']?>&nbsp;</td>
      <td class=listresult valign=top nowrap>&nbsp;
      <?php 
      $pos = strrpos($data['hfile'], "\\");
      if($pos !== false)
        $file = substr($data['hfile'], $pos+1);
      else
        $file = $data['hfile'];

      $pos = strrpos($file, '/');
      if($pos !== false)
        $file = substr($file, $pos+1);
      
      print $file;
      ?>
      &nbsp;
      </td>
      <td class=listresult valign=top nowrap>&nbsp;<?php echo $data['line']?>&nbsp;</td>
    </tr>      
<?php
    }
?>
<?php  if($nodata) { ?>
        <tr><td colspan="7" align="center"><b><?php echo L_G_NORECORDSFOUND?></b></td></tr>
<?php  } ?>
  </table>
  </form>
  
  <br>
