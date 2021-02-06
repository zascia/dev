<table width="80%" cellpadding="0" cellspacing="0">
<tr>
	<td class="tablelistheader">
		<form name=FilterForm action=index.php method=post>
		<table class=listing border=0 cellspacing=0 width="100%">
		<?php QUnit_Templates::printFilter(8); ?>
		<tr>
		  <td>&nbsp;<?php echo L_G_NAME2?>&nbsp;</td>
		  <td><input type=text name=filter_name size=20 value="<?php echo $_REQUEST['filter_name']?>">&nbsp;</td>
		  <td align=left nowrap>&nbsp;&nbsp;</td>
		  <td>
		  <!--
		  <select name=up_numrows onchange="javascript:FilterForm.list_page.value=0;">
			<option value=10 <?php print ($_REQUEST['up_numrows']==10 ? "selected" : ""); ?>>10</option>
			<option value=20 <?php print ($_REQUEST['up_numrows']==20 ? "selected" : ""); ?>>20</option>
			<option value=30 <?php print ($_REQUEST['up_numrows']==30 ? "selected" : ""); ?>>30</option>
			<option value=50 <?php print ($_REQUEST['up_numrows']==50 ? "selected" : ""); ?>>50</option>
			<option value=100 <?php print ($_REQUEST['up_numrows']==100 ? "selected" : ""); ?>>100</option>
			<option value=200 <?php print ($_REQUEST['up_numrows']==200 ? "selected" : ""); ?>>200</option>
			<option value=500 <?php print ($_REQUEST['up_numrows']==500 ? "selected" : ""); ?>>500</option>
			<option value=1000000 <?php print ($_REQUEST['up_numrows']==1000000 ? "selected" : ""); ?>><?php echo L_G_ALL?></option>
		  </select>&nbsp;
		  -->
		  </td>
		</tr>
		  <td><input class=formbutton type=submit value='<?php echo L_G_SEARCH?>'></td>
		</tr>

		<input type=hidden name=filtered value=1>
		<input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
		</table>
</td></tr>
