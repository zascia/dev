<script>

function editUser(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManager&action=edit&aid="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus();
}

function swapUser(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManager&action=swap&u1="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus();
}
</script>

<?php function print_node_data(&$data,&$this) { ?>

    <td height="20" width="60"><?php echo $data['userid']?></td>
    <td width="165 align="left"><b><?php echo substr($data['username'],0,30)?></b></td>
    <td align="left">
        <font color="#0000ff"><?php echo substr($data['name'].' '.$data['surname'],0,50)?></font>
<?php $msg =  '<table cellpadding=2 cellspacing=0 border=0 width=100%>'.
            '<tr><td><b>'.L_G_USERNAME.'</b></td><td><a href=mailto:'.$data['username'].'>'.$data['username'].'</a></td></tr>'.
            '<tr><td><b>'.L_G_NAME.'</b></td><td>'.$data['name'].' '.$data['surname'].'</td></tr>'.
            '<tr><td><b>'.L_G_WEBURL.'</b></td><td><a href='.$data['weburl'].' target=new>'.$data['weburl'].'</a></td></tr>';
    $msg .=  '</table>';
    showQuickInfo($msg);
    //print '</td>';
?>
    </td>
<?php } ?>

<?php
function node_color($depth) {
    $maxdepth = 20.0;
    $depth %= $maxdepth;
    $depth = $maxdepth-$depth;
    $r = $depth*(hexdec('E8'))/$maxdepth;
    $g = $depth*(hexdec('ED'))/$maxdepth;
    $b = $depth*(hexdec('FA'))/$maxdepth;
    return '#'.dechex($r).dechex($g).dechex($b);
}?>


<?php $max_level = $this->a_max_level; ?>

<table class=listing border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(2, L_G_NUMBEROFSUBAFFILIATES); ?>
<?php for($i=0; $i<=$this->a_max_depth && $i < $max_level; $i++) { ?>
    <tr class="listrow<?php echo ($i%2)?>"><td><?php echo L_G_SUBAFFILIATESINTIER." ".($i+2).":"?></td>
        <td>&nbsp;<?php echo $this->a_sub_affilates[$i]?></td></tr>
<?php } ?>
</table>
<br><br>

<table class=listing border=0 cellspacing=0 cellpadding=2 width="750">
<?php QUnit_Templates::printFilter(1, L_G_TREEOFAFFILIATES); ?>
<tr><td><table width="100%" cellpadding="0" cellspacing="0" border="0">
    <?php $row = 0 ?>
	<?php $tree_level = 0 ?>
	<?php $tree_node_offset = 16 ?>
	<?php $node_img_width = 16 ?>
    <?php $node_color = node_color(0) ?>
	<?php while($data=$this->a_list_data->getNextRecord()) { ?>
	       
	       <?php if ($data['level'] >= $max_level) continue; ?>
	       
	       <?php if ($data['level'] > $tree_level) { ?>

	               <?php $node_color = node_color($data['level']) ?>
	               <tr style="background-color:<?php echo $node_color?>">
	                   <td colspan="5">
                           <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-left:<?php echo $tree_node_offset?>px">
                           <tr style="background-color:<?php echo $node_color?>">
                               <td style="width:<?php echo $node_img_width?>px;" valign="middle"><img src="<?php echo  $this->a_this->getImage('subnode.gif')?>"></td>
                               <?php print_node_data($data,$this)?>
	                       </tr>
                   <?php $tree_level = $data['level']; ?>
                   <?php $row = 1 ?>
                   <?php continue ?>
	       
	       <?php } ?>

	       <?php while ($data['level'] < $tree_level) {?>
                           </table>
	                   </td>
	               </tr>
                   <?php $tree_level-- ?>
	               <?php $node_color = node_color($data['level']) ?>
	       <?php } ?>
	       
	       <?php /*<tr class="listrow<?php echo $row=1-$row?>">*/ ?>
	       <tr style="background-color:<?php if ($row=1-$row) echo $node_color; else echo '#FFFFFF';?>">
               <td style="width:<?php echo $node_img_width?>px;" valign="middle"><img src="<?php echo  $this->a_this->getImage('subnode.gif')?>"></td>
               <?php print_node_data($data,$this) ?>
           </tr>
	<?php } ?>
	<?php while ($tree_level-- > 0) {?>
                         </table>
                    </td>
                 </tr>
    <?php } ?>
</table></td></tr>
</table>
