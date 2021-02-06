<script>
function Delete(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETECAT?>") && '<?php echo $_REQUEST['cid']?>' != '')
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_CampCategoriesManager&catid="+ID+"&cid=<?php echo $_REQUEST['cid']?>&action=delete"+"&<?php echo SID?>";
}

function addAffCategory()
{
    var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_CampCategoriesManager&action=add&cid=<?php echo $_REQUEST['cid']?>"+"&<?php echo SID?>","AddAffCategory","scrollbars=1, top=100, left=100, width=800, height=600, status=0");
    wnd.focus();
}

function editAffCategory(ID)
{
    var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_CampCategoriesManager&action=edit&catid="+ID+"&cid=<?php echo $_REQUEST['cid']?>"+"&<?php echo SID?>","AddAffCategory","scrollbars=1, top=100, left=100, width=800, height=480, status=0");
    wnd.focus();
}
</script>
    <table border=0 cellspacing=0 cellpadding=5>
    <tr>
      <td>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
   
    <tr>
      <td class=actionheader align=left colspan=6 height=25 valign=top><b><a class=mainlink href="javascript:addAffCategory();"><?php echo L_G_ADDCATEGORY?></a></b></td>
    </tr>
  
    <tr class=listheader>
     <td class=listheader><?php echo L_G_CATEGORY?></td>
     <td class=listheader><?php echo L_G_CLICKCOMMISSION?></td>
     <td class=listheader><?php echo L_G_SALECOMMISSION?></td>
     <td class=listheader><?php echo L_G_NOAFFILIATES?></td>
     <td class=listheader width=10%><?php echo L_G_ACTIONS?></td>
    </tr>    
<?php
    while($data=$this->a_list_data->getNextRecord())
    {
        if($data['basiccategory'])
            continue;
?>      
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult nowrap><?php echo $data['name']?> <?php echo showQuickInfo("<b>".L_G_CAMPCATEGORYID."</b>: ".$data['campcategoryid'])?></td>
      <td class=listresult nowrap>
<?php      if($data['clickcommission'] != '-')
        {
            print Affiliate_Merchants_Bl_Settings::showUnroundedCurrency($data['clickcommission']);
        }
        else
            print '-';
?>            
      </td>
      <td class=listresult nowrap>
<?php      if($data['salecommission'] != '-')
        {
            print ($data['salecommtype'] != '$' ? $data['salecommission'].' '.$data['salecommtype'] : Affiliate_Merchants_Bl_Settings::showUnroundedCurrency($data['salecommission']));
        }
        else
            print '-';
?>            
      
      </td>
      <td class=listresult nowrap>
      <?php echo $data['affiliatescount'];?>
      </td>
      <td class=listresult>
<?php      $actions = array();
        $i = 0;
        $actions[$i++] = array('id'     => 'edit',
                               'img'    => 'icon_edit.gif',
                               'desc'   => L_G_EDIT,
                               'action' => "editAffCategory('".$data['campcategoryid']."')" );
        if($data['basiccategory'] != true) {
            $actions[$i++] = array('id'     => 'delete',
                                   'img'    => 'icon_delete.gif',
                                   'desc'   => L_G_DELETE,
                                   'action' => "Delete('".$data['campcategoryid']."');" );
        }
        $this->a_this->assign('a_actions', $actions);                        
        $this->a_this->assign('a_action_count', $i);
                        
        QUnit_Global::includeTemplate('actions_icon.tpl.php');
?>
                        
      </td>
    </tr>    
<?php
    }
?>    
   </table>
   
   </td>
   </tr>
   </table>
   
