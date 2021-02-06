<?php echo L_G_DBMAINTENANCEDESC?>
<br/><br/>

<?php  if($this->a_action_permission['backup'] || $this->a_action_permission['restore']) { ?>
<table width="420" class=listing border=0 cellspacing=0 cellpadding=2>
<tr>
  <td align=left valign=top width="55">
    <a href="index.php?md=Affiliate_Merchants_Views_Maintenance&action=backres"><img src="<?php echo $this->a_this->getImage('icon_backup.gif') ?>"></a>
  </td>
  <td>&nbsp;&nbsp;</td>
  <td align=left valign=top>
    <a href="index.php?md=Affiliate_Merchants_Views_Maintenance&action=backres"><b><?php echo L_G_DBBACKUPRESTORE?></b></a>
    <br>
    <?php echo L_G_DBBACKUPRESTOREHLP?>
  </td>
</tr>
</table>
<br>
<?php } ?>

<?php  if($this->a_action_permission['repair']) { ?>
<table width="420" class=listing border=0 cellspacing=0 cellpadding=2>
<tr>
  <td align=left valign=top width="55">
    <a href="index.php?md=Affiliate_Merchants_Views_Maintenance&action=optrep"><img src="<?php echo $this->a_this->getImage('icon_optimize_big.gif') ?>"></a>
  </td>
  <td>&nbsp;&nbsp;</td>
  <td align=left valign=top>
    <a href="index.php?md=Affiliate_Merchants_Views_Maintenance&action=optrep"><b><?php echo L_G_DBOPTIMIZEREPAIR?></b></a>
    <br>
    <?php echo L_G_DBOPTIMIZEREPAIRHLP?>
  </td>
</tr>
</table>
<br>
<?php } ?>

<?php  if($this->a_action_permission['archive']) { ?>
<table width="420" class=listing border=0 cellspacing=0 cellpadding=2>
<tr>
  <td align=left valign=top width="55">
    <a href="index.php?md=Affiliate_Merchants_Views_Archive"><img src="<?php echo $this->a_this->getImage('icon_performance.gif') ?>"></a>
  </td>
  <td>&nbsp;&nbsp;</td>
  <td align=left valign=top>
    <a href="index.php?md=Affiliate_Merchants_Views_Archive"><b><?php echo L_G_DBARCHIVE?></b></a>
    <br>
    <?php echo L_G_DBARCHIVEHLP?>
  </td>
</tr>
</table>
<br>
<?php } ?>

