<form enctype="multipart/form-data" action="index.php" method="POST">
    <input type="hidden" name="action" value="upload">
    <input type="hidden" name="commited" value="yes">
    <input type="hidden" name="md" value="<?php echo  $this->md?>">
<table class=listing border=0 cellspacing=0 cellpadding=2 width="350" border="1">
<?php QUnit_Templates::printFilter(2, L_G_UPLOAD.' '.L_G_FILE); ?>
<tr>
<td><?php echo L_G_BROWSE?></td>
<td>
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <!-- Name of input element determines name in $_FILES array -->
     <input name="userfile" type="file" />
</td>
</tr>
<tr>
<td colspan="2"><input type="submit" value="<?php echo L_G_SUBMIT?>" /></td>
</tr>
</table>
</form>
<br>