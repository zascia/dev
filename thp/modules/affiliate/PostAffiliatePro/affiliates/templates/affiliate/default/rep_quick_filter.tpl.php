<br>
<form id="FilterForm" name="FilterForm" action=index.php method=get>
<table class=listing border=0 cellspacing=0 cellpadding=0 width="780">
<?php QUnit_Templates::printFilter(1, L_G_QUICK); ?>
<tr class="listheaderNoLineLeft">
  <td valign=top align=left>
  <table border=0>
    <tr>
      <td align=left colspan="2" nowrap>
		<?php QUnit_Global::includeTemplate('filter_campaign.tpl.php'); ?>
      </td>
	</tr>
	<tr>
	  <td align=left nowrap colspan="2">
		<?php if ($this->a_list_users != '')
			  QUnit_Global::includeTemplate('filter_affiliate.tpl.php'); ?>
	  </td>
    </tr>
    <tr>
      <td align="left" colspan="2" nowrap>
		<?php QUnit_Global::includeTemplate('filter_time.tpl.php'); ?>
      </td>
	</tr>
    <tr>
	  <td align=left colspan=2>
      <input type=hidden name=commited value=yes>
	  <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden name=reporttype value='quick'>
      <input class=formbutton type=submit value='<?php echo L_G_APPLYFILTER?>'>
	  </form>
	  </td>
    </tr>
  </table>
  </form>

  </td>
</tr>
