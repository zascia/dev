<?php echo L_G_BACKUPRESTOREDESCRIPTION?>
<br/><br/>
<?php if($this->a_action_permission['backup']) { ?>
<table width="520" class=listing border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(2, L_G_DBBACKUP); ?>
<tr>
  <td class=dir_form valign=top align="center" colspan="2"><?php echo L_G_DBBACKUPHLP?></td>
</tr>
<tr>
  <td class=dir_form valign=top align="center" nowrap>
<?php if(AFF_DEMO != 1) { ?>   
  <form enctype="multipart/form-data" action=index.php method=post>
<?php } ?>
  <input type="submit" class=formbutton value="<?php echo L_G_DBBACKUPSQL?>">
<?php if(AFF_DEMO != 1) { ?>
  <input type="hidden" name="gzipcompress" value="0">
  <input type="hidden" name="md" value="Affiliate_Merchants_Views_Maintenance">
  <input type="hidden" name="action" value="backup">
  <input type="hidden" name="commited" value="yes">
  </form>
<?php } ?>
  </td>
  <td class=dir_form valign=top align="center" nowrap>
  <?php if(AFF_DEMO != 1) { ?>   
  <form enctype="multipart/form-data" action=index.php method=post>
<?php } ?>
  <input type="submit" class=formbutton value="<?php echo L_G_DBBACKUPSQLZIP?>">
<?php if(AFF_DEMO != 1) { ?>
  <input type="hidden" name="gzipcompress" value="1">
  <input type="hidden" name="md" value="Affiliate_Merchants_Views_Maintenance">
  <input type="hidden" name="action" value="backup">
  <input type="hidden" name="commited" value="yes">
  </form>
<?php } ?>
  </td>
</tr>
</table>
<br>
<?php } ?>

<?php if($this->a_action_permission['restore']) { ?>
<table width="520" class=listing border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(1, L_G_DBRESTORE); ?>
<tr>
  <td class=dir_form valign=top align="center" >
  <?php echo L_G_DBRESTOREHLP?>
  <br>
  <font color="#ff0000"><?php echo L_G_DBRESTOREWARNING?></font>
  <br>
  <?php echo L_G_DBRESTOREHLP2?>
  </td>
</tr>
<tr>
  <td class=dir_form valign=top align="center" nowrap>
<?php if(AFF_DEMO != 1) { ?>   
  <form enctype="multipart/form-data" action=index.php method=post>
<?php }
  print L_G_DBBACKUPFILE?> <input type="file" name="sqlfile"><br><br>
  <input type="submit" class=formbutton value="<?php echo L_G_DBRESTOREBTN?>">
<?php if(AFF_DEMO != 1) { ?>
  <input type="hidden" name="md" value="Affiliate_Merchants_Views_Maintenance">
  <input type="hidden" name="action" value="restore">
  <input type="hidden" name="commited" value="yes">
  </form>
  </td>
</tr>
<?php } ?>
</table>
<?php } ?>

