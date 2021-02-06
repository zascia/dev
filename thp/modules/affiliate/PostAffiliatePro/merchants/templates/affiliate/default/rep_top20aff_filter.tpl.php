<form id="FilterForm" name="FilterForm" action=index.php method=get>
<table border=0 cellspacing=0 cellpadding=2 width="780">
<tr><td><?php echo L_G_TOP20AFFILIATES_DESCRIPTION?><br><br></td></tr>
</table>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="780" style="border-bottom: 0px;">
<?php QUnit_Templates::printFilter(6, L_G_TOPAFFILIATES); ?>
    <tr class="listheader">
      <td align=left valign="top" colspan="2">
        <br>
           <?php QUnit_Global::includeTemplate('filter_campaign.tpl.php'); ?>
           <hr class="filterline">
      </td>
    </tr>
    <tr class="listheader">
      <td align=left valign="top">
           <?php QUnit_Global::includeTemplate('filter_time.tpl.php'); ?>
      </td>
      <td align=left valign="middle">
        <b><?php echo L_G_NUMBEROFTOPAFFILIATES?></b>&nbsp;<?php showQuickHelp(L_G_HLP_NUMBEROFTOPAFFILIATES); ?>&nbsp;
        <select name=rt_topcount>
          <option value='_'><?php echo L_G_ALL?></option>
          <option value='10' <?php echo ($_REQUEST['rt_topcount'] == 10 ? 'selected' : '')?>>10</option>
          <option value='20' <?php echo ($_REQUEST['rt_topcount'] == 20 ? 'selected' : '')?>>20</option>
          <option value='30' <?php echo ($_REQUEST['rt_topcount'] == 30 ? 'selected' : '')?>>30</option>
          <option value='50' <?php echo ($_REQUEST['rt_topcount'] == 50 ? 'selected' : '')?>>50</option>
          <option value='100' <?php echo ($_REQUEST['rt_topcount'] == 100 ? 'selected' : '')?>>100</option>
      </select>&nbsp;&nbsp;<br>
      <input type="checkbox" name="rt_virtual_affiliates" value="yes"<?php echo ($_REQUEST['rt_virtual_affiliates'] == 'yes')? 'checked' : ''?>>&nbsp;<b><?php echo L_G_INCLUDEVIRTUALAFFILIATES?></b>
      </td>
    </tr>
    <tr class="listheader">
      <td colspan=2 align="left">
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden name=reporttype value='top20affiliates'>
      <input class=formbutton type=submit value='<?php echo L_G_APPLYFILTER; ?>'>
      </td>
    </tr>
  </table>
  </form>
