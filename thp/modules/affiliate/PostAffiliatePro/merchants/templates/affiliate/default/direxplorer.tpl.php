<script>
function deleteFile(filename, dir) {
    if (confirm("<?php echo L_G_CONFIRMDELETE?>") == true) {
		document.location = "index.php?md=<?php echo $this->a_md?>&file=" +filename + "&action=delete&dir=" + dir;
	}
}

function deleteDir(dirdelete, dir) {
	if (confirm("<?php echo L_G_CONFIRMDELETE?>") == true) {
		document.location = "index.php?md=<?php echo $this->a_md?>&action=dirdelete&ddir=" + dirdelete + "&dir=" + dir;
	}
}

function previewFile(filename, dir) {
	var wnd = window.open("index_popup.php?md=<?php echo $this->a_md?>&file=" +filename + "&action=preview&dir=" + dir, "Preview" ,"scrollbars=1, top=10, left=10, width=820, height=580, resizable=1, status=0")
}

</script>
<table class=listing width=80% border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(4, L_G_RESOURCE_BROWSER); ?>
<tr class=actionheader>
	<td class="actionheader" colspan="4"><?php echo L_G_CURRENTDIR?>: <b>/<?php echo ltrim($this->a_dir, '/')?></b></td>
</tr>
<tr class=actionheader>
	<td class="actionheader" colspan="4" valign="top">
	  <form action=index.php method=post enctype="multipart/form-data">    
      <input type=radio name=postaction value='createdir' checked>
      <?php echo L_G_CREATENEWDIR?> <input type=text name=newdir value='<?php echo $_POST['newdir']?>' size=10>
      <input type=radio name=postaction value='uploadfile'>
      <?php echo L_G_UPLOADFILE?> <input type=file size="20" name=userfile value=''>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <input type=submit value='<?php echo L_G_SUBMIT?>'>
      <input type=hidden name=md value='<?php echo $this->a_md?>'>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=dir value='<?php echo $_REQUEST['dir']?>'>
      </form>
    </td>
</tr>
<tr class=header>
	<td class="listheader"><?php echo L_G_NAME?></td>
    <td class="listheader" width="60"><?php echo L_G_SIZE?></td>
    <td class="listheader" width="130"><?php echo L_G_LASTMODIFIED?></td>
    <td class="listheader" width="100"><?php echo L_G_ACTIONS?></td>
</tr>
<?php  if($this->a_dir != '') {
   		$pos = strrpos($this->a_dir, "/");
   		if ($pos === false) {
	       	$dirup = '';
	   	} else {
       		// remove last part of directory string
       		$dirup = substr($this->a_dir, 0, $pos);
   		} ?>
		<tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
			<td class=listresultnocenter align="left">
				<a href="?md=<?php echo $this->a_md?>&dir=<?php echo urlencode($dirup)?>">
		  		<b><img src='<?php echo $this->a_this->getImage('dirup.gif')?>' border=0>
		  		&nbsp;..</a></b></td>
			<td class=listresult>&nbsp;</td>
			<td class=listresult>&nbsp;</td>
			<td class=listresult>&nbsp;</td>
		</tr>
<?php  } 
    // first show directories
    if(is_array($this->a_files) && count($this->a_files)>0) {
    	foreach($this->a_files as $file){
        	if($file['dir'] == true) {
          		$partname = str_replace($this->a_baseDir.'/', '/', $file['fullname']); ?>
          		<tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
          			<td class=listresultnocenter align="left"><a href="?md=<?php echo $this->a_md?>&dir=<?php echo urlencode($this->a_dir.'/'.$file['name'])?>">
          			   <img src='<?php echo $this->a_this->getImage('dir.gif')?>' border=0>&nbsp;<?php echo $file['name']?></td>
          			<td class=listresultnocenter align="right">&nbsp;</td>
          			<td class=listresultnocenter align="right"><?php echo strftime("%d.%m.%Y %H:%M:%S",$file['lastmodified'])?>&nbsp;</td>
          			<td class=listresultnocenter align="right">
          				<select name=action_select OnChange="performAction(this);">
        					<option value="-">----------------</option>
	  		        		<option value="javascript:document.location.href = 'index.php?md=<?php echo $this->md?>&action=rename&file=<?php echo $file['name']?>';"><?php echo L_G_RENAME?></option>
        					<option value="javascript:deleteDir('<?php echo $file['name']?>', '<?php echo $this->a_dir?>');"><?php echo L_G_DELETE?></option>
    					</select>
    				</td>
          		</tr>
<?php        	}
      	}

      // now show the files
      foreach($this->a_files as $file)
      {
        if(($file['dir'] == false) && ($file['name'] != 'menu_left.txt')) {
          // get image accordig to type(extension) of te file
          $ext = $this->a_this->GetExtension($file['name']);
          ?>
          <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
            <td class=listresultnocenter align="left">
          	<?php
          		if(in_array(strtolower($ext), Array('htm','html')))
          	  		echo "<img src='".$this->a_this->getImage('html.gif')."' border=0>";
          		else if(in_array(strtolower($ext), Array('php','asp','css','js','txt')))
              		echo "<img src='".$this->a_this->getImage('text.gif')."' border=0>";
          		else if(in_array(strtolower($ext), Array('jpg','gif','png','bmp','jpeg','tiff','tif')))
              		echo "<img src='".$this->a_this->getImage('image.gif')."' border=0>";
          		else
              		echo "<img src='".$this->a_this->getImage('file.gif')."' border=0>";
          	?>
          	&nbsp;<?php echo $file['name']?></td>
          	<td class=listresultnocenter align="right"><?php echo $file['size']?> B</td>
          	<td class=listresultnocenter align="right"><?php echo strftime("%d.%m.%Y %H:%M:%S",$file['lastmodified'])?>&nbsp;</td>
          	<td class=listresultnocenter align="right">
	          <select name=action_select OnChange="performAction(this);">
        			<option value="-">----------------</option>
	  		        <option value="javascript:document.location.href = 'index.php?md=<?php echo $this->md?>&action=rename&file=<?php echo $file['name']?>';"><?php echo L_G_RENAME?></option>
        			<option value="javascript:deleteFile('<?php echo $file['name']?>', '<?php echo $this->a_dir?>');"><?php echo L_G_DELETE?></option>
        		 <?php if(in_array(strtolower($ext), Array('htm','html'))) { ?>
          	  			<option value="javascript:previewFile('<?php echo $this->a_dir.'/'.$file['name']?>', '<?php echo $this->a_dir?>');"><?php echo L_G_PREVIEW?></option>
          	  	 <?php } ?>
    			</select>
          	</td>
          </tr>
	<?php  }
      }
    } ?>    
</table>
<br><br>
      
