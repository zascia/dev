  <form action=index.php method=post>
  <table class=listing border=0 cellspacing=0 cellpadding=3 width="750">
  <?php QUnit_Templates::printFilter(2, L_G_FILTER); ?>
   <tr class="listheader">
      <td align=left colspan=2>
        <?php QUnit_Global::includeTemplate('filter_campaign.tpl.php'); ?>
      </td>
    </tr> 
    <tr class="listheader">
     <td colspan=2 align=left>
      <input type=hidden name=filtered value=1>
      <input type=hidden name=list_page value="<?php echo $_REQUEST['list_page']?>">
      <input type=hidden name=md value='Affiliate_Affiliates_Views_AffEmailManager'>
      <input type=submit class=formbutton value="<?php echo L_G_FILTER?>">
     </td>
   </tr>  
   </table>
    </form>
