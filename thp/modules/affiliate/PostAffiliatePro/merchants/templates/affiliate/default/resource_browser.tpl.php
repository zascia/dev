<div><a href="index.php?md=<?php echo  $this->md?>&action=upload"><?php echo  L_G_UPLOAD?> <?php echo  L_G_FILE?></a></div>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="350" border="1">
<?php QUnit_Templates::printFilter(2, L_G_RESOURCE_BROWSER); ?>
<?php if(count($this->a_files) == 0) { ?>
	<tr><td colspan="2"><?php echo L_G_NOFILES?></td></tr>
<?php } else { ?>
<?php foreach($this->a_files as $file) { ?>
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">    
    	<td class=listresultnocenter align="left">&nbsp;<?php echo $file?></td>
    	<td class=listresult width="60">
    		<select name=action_select OnChange="performAction(this);">
        		<option value="-">--------</option>
        		<option value="javascript:document.location.href = 'index.php?md=<?php echo  $this->md?>&action=rename&file=<?php echo $file?>';"><?php echo L_G_RENAME?></a>
        		<option value="javascript:document.location.href = 'index.php?md=<?php echo  $this->md?>&action=delete&file=<?php echo $file?>';"><?php echo L_G_DELETE?></a>
    		</select></td>
   </tr>
<?php } ?>
<?php } ?>
</table>
