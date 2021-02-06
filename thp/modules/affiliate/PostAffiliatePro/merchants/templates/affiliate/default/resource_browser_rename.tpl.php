<form action="index.php" method="GET">
    <input type="hidden" name="md" value="<?php echo  $this->md?>">
    <input type="hidden" name="file" value="<?php echo  $this->file?>">
    <input type="hidden" name="action" value="rename">
    <input type="hidden" name="commited" value="yes">
<table class=listing border=0 cellspacing=0 cellpadding=2 width="350" border="1">
<?php QUnit_Templates::printFilter(2, L_G_RENAME.' '.$this->file); ?>
<tr>
<td><?php echo L_G_RENAME?></td>
<td>
    <input type="textbox" name="new_name" value="<?php echo  $this->new_name?>">
</td>
<tr>
<td colspan="2"><input type="submit" value="<?php echo L_G_SUBMIT?>" /></td>
</tr>
</table>
</form>
<br>

