
<center>
<form action=index_popup.php method=post>
<table class=listing cellspacing=0 cellpadding=0>
  <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
  <tr>
    <td class=dir_form>&nbsp;<br>&nbsp;<b><?php echo $this->a_contact_user_data;?></b>&nbsp;<?php echo L_G_SWAP_WITH?>&nbsp;<br>&nbsp;</td>
    <td align=left nowrap>&nbsp;<br>
      <select name=u2>
      <?php while($data=$this->a_list_data->getNextRecord()) { 
           if($data['userid'] == $_POST['u1']) continue;
      ?>
           <option value='<?php echo $data['userid']?>' <?php echo ($_POST['u2'] == $data['userid'] ? ' selected' : '')?>><?php echo $data['userid'].' : '.$data['name'].' '.$data['surname']?></option>
      <?php } ?>
      </select>&nbsp;<br>&nbsp;
    </td>
  </tr>
  <tr>
    <td class=dir_form colspan=2 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
      <input type=hidden name=u1 value=<?php echo $_POST['u1']?>>
      <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
      <br>&nbsp;
    </td>
  </tr>
</table>
</form>
</center>
