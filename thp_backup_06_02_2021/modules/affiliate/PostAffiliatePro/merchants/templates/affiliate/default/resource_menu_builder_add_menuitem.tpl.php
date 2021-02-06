<form action="index.php" method="get">
<input type="hidden" name="md" value="<?php echo  $this->md?>">
<input type="hidden" name="action" value="<?php echo  $this->action?>">
<input type="hidden" name="header" value="<?php echo  $this->header?>">
<input type="hidden" name="commited" value="yes">
<table class=listing border=0 cellspacing=0 cellpadding=2 width="350" border="1">
<?php QUnit_Templates::printFilter(2, L_G_ADD.' '.L_G_MENUITEM); ?>
<tr>
    <td><?php echo  L_G_NAME?>: </td>
    <td>
        <input type="textbox" name="item_name" value="<?php echo  $this->item_name?>">
    </td>
</tr>
<tr>
    <td><?php echo  L_G_LINK?>: </td>
    <td>
        <input type="textbox" name="item_link" value="<?php echo  $this->item_link?>">
    </td>
</tr>
<tr>
    <td><?php echo  L_G_CAPTION?>: </td>
    <td>
        <input type="textbox" name="item_caption" value="<?php echo  $this->item_caption?>">
    </td>
</tr>
<tr>
    <td><?php echo  L_G_PERMISSION?>: </td>
    <td>
        <input type="textbox" name="item_permission" value="<?php echo  $this->item_permission?>">
    </td>
</tr>
<tr>
    <td colspan="2">
        <input type="submit" name="submit" value="<?php echo L_G_SUBMIT?>">
    </td>
</tr>
</table>
</form>