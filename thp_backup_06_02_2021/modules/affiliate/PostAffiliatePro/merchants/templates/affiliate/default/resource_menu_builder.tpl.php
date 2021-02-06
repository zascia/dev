<script>

function changeLanguage(sel)
{
  if(sel.value != '')
  {
    document.location.href = 'index.php?md=<?php echo $this->md?>&language='+sel.value;
  }
}

</script>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="350" border="1">
<?php QUnit_Templates::printFilter(1, L_G_LANGUAGE); ?>
    <tr>
    	<td class="listresult">
    	      <select name=language onchange="changeLanguage(this);">
				<?php    while($data=$this->a_lang_data->getNextRecord()) { ?>
        				<option value="<?php echo $data?>" <?php echo ($_REQUEST['language'] == $data ? 'selected' : '')?>><?php echo $data?></option>
				<?php    } ?>
      		  </select>
    	</td>
	</tr>
</table>
<br>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="350" border="1">
<?php QUnit_Templates::printFilter(2, L_G_RESOURCE_MENU_BUILDER); ?>
    <tr>
    	<td class="actionheader" colspan="2">
    		<b><a href="index.php?md=<?php echo  $this->md?>&action=addheader" class="mainlink"><?php echo L_G_ADD.' '.L_G_HEADER?></a></b>
    	</td>
	</tr>
<?php if(count($this->a_list) == 0) { ?>
	<tr><td colspan="2"><?php echo L_G_NOFILES?></td></tr>
<?php } else { ?>
<?php foreach($this->a_list as $header => $items) { ?>
    <tr>
        <td class="listresultnocenter">&nbsp;<b><?php echo  $items['caption']?> (<?php echo  $header?>)<b></td>
        <td class="listresult" width="110">
            <select name=action_select OnChange="performAction(this);">
                <option value="-">-------------------</option>
                <option value="javascript:document.location.href = 'index.php?md=<?php echo  $this->md?>&action=addmenuitem&header=<?php echo $header?>';"><?php echo L_G_ADD.' '.L_G_MENUITEM?></a>
                <option value="javascript:document.location.href = 'index.php?md=<?php echo  $this->md?>&action=editheader&header=<?php echo $header?>';"><?php echo L_G_EDIT.' '.L_G_HEADER?></a>
                <option value="javascript:document.location.href = 'index.php?md=<?php echo  $this->md?>&action=deleteheader&header=<?php echo $header?>';"><?php echo L_G_DELETE.' '.L_G_HEADER?></a>
            </select></td>        
    </tr>
    <?php foreach($items['items'] as $item) {?>
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">    
    	<td class=listresultnocenter align="left">&nbsp;<?php echo $item['caption']?></td>
    	<td class=listresult width="110">
            <select name=action_select OnChange="performAction(this);">
                <option value="-">-------------------</option>
                <option value="javascript:document.location.href = 'index.php?md=<?php echo  $this->md?>&action=editmenuitem&header=<?php echo $header?>&item=<?php echo $item['name']?>';"><?php echo L_G_EDIT?></a>
                <option value="javascript:document.location.href = 'index.php?md=<?php echo  $this->md?>&action=deletemenuitem&header=<?php echo $header?>&item=<?php echo $item['name']?>';"><?php echo L_G_DELETE?></a>
            </select></td>        
   </tr>
   <?php } ?>
<?php } ?>
<?php } ?>
</table>
<br><br>
