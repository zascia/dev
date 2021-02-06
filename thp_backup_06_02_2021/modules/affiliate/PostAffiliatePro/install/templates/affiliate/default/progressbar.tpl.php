<table border=0 width=100% cellpadding=0>
<tr>
<?php while($item = $this->model->getStep()) { ?>  
  <td width="8%" class="<?php echo  ($item['done']) ? 'done' : 'waiting'?>"><?php echo  $item['caption']?>&nbsp;</td>
<?php } ?>
</tr>
</table>   
