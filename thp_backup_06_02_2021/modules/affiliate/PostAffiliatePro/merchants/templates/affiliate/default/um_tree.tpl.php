<script>

function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?php echo L_G_CONFIRMSUPPRESSAFF?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&showtree=1&aid="+ID+"&action="+action+"&<?php echo SID?>";
  }
  else if(action == "approve")
  {
    if(confirm("<?php echo L_G_CONFIRMAPPROVEAFF?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&showtree=1&aid="+ID+"&action="+action+"&<?php echo SID?>";
  }
}

function editUser(ID)
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=edit&aid="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0";
}

function swapUser(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManager&action=swap&u1="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function viewUser(ID)
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=view&aid="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=450, height=500, status=0";
}

function Delete(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEAFF?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&showtree=1&aid="+ID+"&action=delete"+"&<?php echo SID?>";
}
</script>

<?php function print_node_data(&$data,&$te) { ?>

    <td height="20" width="60"><?php echo $data['userid']?></td>
    <td width="165"><b><?php echo substr($data['username'],0,30)?></b></td>
    <td>
        <font color="#0000ff"><?php echo substr($data['name'].' '.$data['surname'],0,50)?></font>
<?php
/*    $msg =  '<table cellpadding=2 cellspacing=0 border=0 width=100%>'.
            '<tr><td><b>'.L_G_USERNAME.'</b></td><td><a href=index.php?md=Affiliate_Merchants_Views_BroadcastMessage&action=sendmsg&userid='.$data['userid'].'>'.$data['username'].'</a></td></tr>'.
            '<tr><td><b>'.L_G_NAME.'</b></td><td>'.$data['name'].' '.$data['surname'].'</td></tr>'.
            '<tr><td><b>'.L_G_WEBURL.'</b></td><td><a href='.$data['weburl'].' target=new>'.$data['weburl'].'</a></td></tr>'.
            '<tr><td align=left><a class=SimpleLink href=index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=view&aid='.$data['userid'].'><b>'.L_G_VIEWPROFILE.'</b></a></td>'.
                '<td align=right><a class=SimpleLink href=index.php?md=Affiliate_Merchants_Views_BroadcastMessage&action=sendmsg&userid='.$data['userid'].'><b>'.L_G_SENDEMAIL .'</b></a></td></tr>'.
            '</table>';
    showQuickInfo($msg);*/
    showQuickDetails("index_popup2.php?md=Affiliate_Merchants_Views_AffiliateManager&action=affdetails&aid=".$data['userid'], 300);
    //print '</td>';
?>
    </td>
<?php
    $actions = array();
    $i = 0;
    if($te->a_this->checkPermissions('view')) {
        $actions[$i++] = array('id'     => 'edit',
                               'img'    => 'icon_view.gif',
                               'desc'   => L_G_VIEWPROFILE,
                               'action' => "viewUser('".$data['userid']."');" );
    }
    if($te->a_this->checkPermissions('edit')) {
        $actions[$i++] = array('id'     => 'edit',
                               'img'    => 'icon_edit.gif',
                               'desc'   => L_G_EDIT,
                               'action' => "editUser('".$data['userid']."');" );
    }
    if($te->a_this->checkPermissions('swap')) {
        $actions[$i++] = array('id'     => 'swap',
                               'img'    => 'icon_swap.gif',
                               'desc'   => L_G_swap,
                               'action' => "swapUser('".$data['userid']."');" );
    }
    if($te->a_this->checkPermissions('approve')) {
        if($data['rstatus'] != AFFSTATUS_APPROVED) {
            $actions[$i] = array('id'     => 'approve',
                                 'img'    => 'icon_approve.gif',
                                 'desc'   => L_G_APPROVE,
                                 'action' => "ChangeState('".$data['userid']."','approve');");
        }
        if($data['rstatus'] != AFFSTATUS_SUPPRESSED) {
            $actions[$i+1] = array('id'     => 'suppress',
                                   'img'    => 'icon_suppress.gif',
                                   'desc'   => L_G_SUPPRESS,
                                   'action' => "ChangeState('".$data['userid']."','suppress');");
        }
        $i += 2;
    }
    if($te->a_this->checkPermissions('delete')) {
        $actions[$i++] = array('id'     => 'delete',
                               'img'    => 'icon_delete.gif',
                               'desc'   => L_G_DELETE,
                               'action' => "Delete('".$data['userid']."');" );
    }
    $te->a_this->initTemporaryTE();
    $te->a_this->temporaryAssign('a_actions', $actions);                        
    $te->a_this->temporaryAssign('a_action_count', $i);
    print '<td align="right">'.$te->a_this->temporaryFetch('actions_icon').'</td>';
    //print '<td></td>';
    //print '<td class=listresultnocenter align="left">'.$this->a_this->temporaryFetch('actions_combo').'</td>';
?>
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

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr><td><?php echo L_G_SUBAFFILIATES_DESCRIPTION?><br><br></td></tr>
</table>
    
<table class=listing border=0 cellspacing=0 cellpadding=2 width="100%">
<?php QUnit_Templates::printFilter(1, L_G_TREEOFAFFILIATES); ?>
<tr><td>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <?php $row = 0 ?>
	<?php $tree_level = 0 ?>
	<?php $tree_node_offset = 16 ?>
	<?php $node_img_width = 16 ?>
    <?php $node_color = node_color(0) ?>
	<?php while($data=$this->a_list_data->getNextRecord()) { ?>
	       
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
    </table>
    </td></tr>
</table>

<br>
