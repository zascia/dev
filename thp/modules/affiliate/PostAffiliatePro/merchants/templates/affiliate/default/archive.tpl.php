
<?php if ($this->a_start_archive) { ?>
	<script>
		var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_Archive&action=processarchive&start=1&<?php echo SID?>","ArchiveImps","scrollbars=1, top=100, left=100, width=450, height=270, status=0")
    	wnd.focus();  
	</script>
<?php } ?>

<?php echo L_G_ARCHIVEHLP?>
<br><br>

<form name="ArchiveForm" id="ArchiveForm" action="index.php" method="post">
<table width="520" class=listing border=0 cellspacing=0 cellpadding=5>
<?php QUnit_Templates::printFilter(2, L_G_ARCHIVEIMPRESSIONS); ?>
<tr>
  <td colspan="2"><?php echo L_G_ARCHIVEIMPHLP?></td>
</tr>
<tr>
  <td  width="170">&nbsp;&nbsp;<?php echo L_G_AGGREGATIONBY?></td>
  <td width="350">
    <input type="radio" name="ar_aggregation" value="<?php echo AGGREGATION_DAY?>" checked><?php echo L_G_DAY?>
  </td>
</tr>
<tr>
  <td colspan="2">
    <?php $this->a_this->assign('a_timeselect_caption', L_G_ARCHIVERECORDSOLDERTHAN);
       $this->a_this->assign('a_timeselect_tworows', 1);
       QUnit_Global::includeTemplate('filter_time_older_than.tpl.php'); ?>
  </td>
</tr>
<tr>
  <td colspan="2"><input type="submit" class=formbutton value="<?php echo L_G_ARCHIVE?>"></td>
</tr>
</table>
<br>
<input type="hidden" name="md" value="Affiliate_Merchants_Views_Archive">
<input type="hidden" name="action" value="archiveimps">
<input type="hidden" name="commited" value="yes">  
</form>

<form name="ArchiveTransForm" id="ArchiveTransForm" action="index.php" method="post">
<table width="520" class=listing border=0 cellspacing=0 cellpadding=5>
<?php QUnit_Templates::printFilter(2, L_G_ARCHIVETRANSACTIONS); ?>
<tr>
  <td colspan="2"><?php echo L_G_ARCHIVETRANSHLP?></td>
</tr>
<tr>
  <td width="170" valign=top>&nbsp;&nbsp;<?php echo L_G_AGGREGATIONBY?></td>
  <td width="350">
    <input type="radio" name="art_aggregation" value="<?php echo AGGREGATION_HOUR?>" <?php echo ($_REQUEST['art_aggregation'] == AGGREGATION_HOUR) ? 'checked' : ''?>><?php echo L_G_HOUR?><br>
    <input type="radio" name="art_aggregation" value="<?php echo AGGREGATION_DAY?>"  <?php echo ($_REQUEST['art_aggregation'] == AGGREGATION_DAY)  ? 'checked' : ''?>><?php echo L_G_DAY?>
  </td>
</tr>
<tr>
  <td colspan="2">
    <?php $this->a_this->assign('a_timeselect_caption', L_G_ARCHIVERECORDSOLDERTHAN);
       $this->a_this->assign('a_timeselect_tworows', 1);
       $this->assign('a_form_preffix', 'art_');
       $this->assign('a_form_name', 'ArchiveTransForm');
       QUnit_Global::includeTemplate('filter_time_older_than.tpl.php'); ?>
  </td>
</tr>
<tr>
  <td colspan="2"><input type="submit" class=formbutton value="<?php echo L_G_ARCHIVE?>"></td>
</tr>
</table>
<br>
<input type="hidden" name="md" value="Affiliate_Merchants_Views_Archive">
<input type="hidden" name="action" value="archivetrans">
<input type="hidden" name="commited" value="yes">  
</form>