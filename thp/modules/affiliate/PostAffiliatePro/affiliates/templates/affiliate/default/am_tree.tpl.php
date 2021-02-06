<table class=listing border=0 cellspacing=0 cellpadding=3>
<?php QUnit_Templates::printFilter(1, L_G_TREEOFSUBAFFILIATES) ?>
<?php while($data=$this->a_list_data->getNextRecord()) { ?>
   <tr>
     <td align=left nowrap>&nbsp;
     <?php echo $data['tab']?><?php echo $data['userid'].': '.$data['name'].' '.$data['surname'].' - '?>
     <a class=blueLink href="mailto:<?php echo $data['username']?>"><?php echo $data['username']?></a>
     &nbsp;</td>
   </tr>
<?php } ?>

</table>

