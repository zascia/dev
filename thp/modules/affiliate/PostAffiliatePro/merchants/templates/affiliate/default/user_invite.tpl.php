
    <form action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
      <td class=formBText valign=top nowrap>&nbsp;<?php echo L_G_CHOOSE_CAMPAIGN_CATEGORIES;?>&nbsp;</td>
      <td>
        <?php if($this->a_count > 0) { ?>
          <select name='campaigncategories[]' size=5 multiple>
          <?php while($data=$this->a_list_data->getNextRecord()) { ?>
            <option value="<?php echo $data['campaignid']?>"><?php echo $data['name']?></option>
          <?php } ?>
          </select>
        <?php 
          } else {
            print L_G_PRIVATE_CAMPAIGN_CATEGORY_NOT_AVAILABLE;
        ?>
            <input type=hidden name=do_nothing value='1'>
        <?php
          }
        ?>
      </td>
    </tr>
    <tr>
      <td class=dir_form colspan=2 align=center>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
        <input type=hidden name=action value='<?php echo $_POST['action']?>'>
        <input type=hidden name=postaction value='<?php echo $_POST['postaction']?>'>
        <input type=hidden name=uids value='<?php echo $_POST['uids']?>'>
        <input type=hidden name=show_no_popup value='1'>
        <input type=submit class=formbutton value='<?php echo L_G_SUBMIT?>'>
      </td>
    </tr>
    </table>
    </form>

