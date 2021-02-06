<?php echo L_G_ADMINSMAIN?>
<br/><br/>

<table width="420" class=listing border=0 cellspacing=0 cellpadding=2>
<tr>
  <td align=left valign=top width="55">
    <a href="index.php?md=Affiliate_Merchants_Views_AdminsManager"><img src="<?php echo $this->a_this->getImage('icon_big_user.gif') ?>"></a>
  </td>
  <td width=1>&nbsp;&nbsp;</td>
  <td align=left valign=top>
    <a href="index.php?md=Affiliate_Merchants_Views_AdminsManager"><b><?php echo L_G_ADMINSMANAGEMENT?></b></a>
    <br>
    <?php echo L_G_ADMINSHLP?>
  </td>
</tr>
</table>
<br>

<?php if($this->a_this->checkPermissions('viewprofiles')) { ?>
<table width="420" class=listing border=0 cellspacing=0 cellpadding=2>
<tr>
  <td align=left valign=top width="55">
    <a href="index.php?md=Affiliate_Merchants_Views_UserProfiles"><img src="<?php echo $this->a_this->getImage('icon_big_perm.gif') ?>"></a>
  </td>
  <td width=1>&nbsp;&nbsp;</td>
  <td align=left valign=top>
    <a href="index.php?md=Affiliate_Merchants_Views_UserProfiles"><b><?php echo L_G_USERPROFILESMANAGEMENT?></b></a>
    <br>
    <?php echo L_G_USERPROFILESMANAGEMENTHLP?>
  </td>
</tr>
</table>
<br>
<?php } ?>

