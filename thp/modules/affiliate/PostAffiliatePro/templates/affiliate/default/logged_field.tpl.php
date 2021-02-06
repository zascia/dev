<?php if($this->a_Auth->isLogged()) { ?>
    
<table width="100%" border="0" cellspacing="2" cellpadding="0">
<tr>
    <td align="right" nowrap><?php echo L_G_LOGGEDUSER?><b><?php echo $this->a_Auth->userName?></b></td>
    <td width="3px">&nbsp;</td>
</tr>
<tr>
    <td align="right"><a href="<?php echo $this->a_logged_field_url?>"><?php echo L_G_EDITUSERPROFILE?></a></td>
    <td width="3px">&nbsp;</td>
</tr>
<tr>
    <td align="right"><a href="logout.php"><b><?php echo L_G_LOGOUT?></b></a></td>
    <td width="3px">&nbsp;</td>
</tr>
</table>
<?php } ?>
