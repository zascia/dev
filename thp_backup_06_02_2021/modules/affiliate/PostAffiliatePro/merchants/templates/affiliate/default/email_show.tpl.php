<?php
    $paging = $this->a_Auth->getSetting('Aff_paging');
    if($paging == '' || $paging == 0) {
        $paging = 10;
    }
    
    if($this->a_numrows > $paging) {
        $pages = floor($this->a_numrows / $paging);
        if($this->a_numrows%$paging) $pages++;
    }
    
    if($_REQUEST['list_page'] == '' || $_REQUEST['list_page'] > $pages) {
        $_REQUEST['list_page'] = 1;
    }
?>
<script>
function deleteBanner(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEEMAIL?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_EmailManager&bid="+ID+"&action=delete"+"&<?php echo SID?>";
}

function addBanner(Type)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_EmailManager&action=add&campaign=<?php echo $campaignid?>&type="+Type+"&<?php echo SID?>";
}

function editBanner(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_EmailManager&action=edit&bid="+ID+"&<?php echo SID?>";
}

function addBannersForCampaign()
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_EmailManager&action=show&campid=<?php echo $campaignid?>"+"&<?php echo SID?>";
}

function backToCampaigns(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CampaignManager&action=addbanners&cid="+ID+"&<?php echo SID?>";
}
</script>

   <table border=0>
   <tr><td align=left>
        <?php echo L_G_EMAILMANAGER_DESCRIPTION?><br><br>
        </td>
   </tr>   
<?php if($this->a_action_permission['add']) { ?>
   <tr>
   <td align=left>
     <table border=0 cellspacing=0>
     <tr>
       <td><input type=button class=formbutton value="<?php echo L_G_ADDTEXTEMAIL?>"  onclick="javascript:addBanner('textemail');">&nbsp;&nbsp;&nbsp;</td>
       <td><input type=button class=formbutton value="<?php echo L_G_ADDHTMLEMAIL?>"  onclick="javascript:addBanner('htmlemail');">&nbsp;&nbsp;&nbsp;</td>
     </tr>
     <tr>
        <td colspan="2">&nbsp;</td>
     </tr>
     </table>
   </td>
   </tr>
<?php } ?>
   <tr>
   <td align=left>
   <?php QUnit_Global::includeTemplate('email_show_filter.tpl.php'); ?>
   </td>   
   </tr>   
   <tr>
   <td align=center>
<?php
    if($this->a_numrows > $paging)
    {
      echo "<center>";      
      echo '<b>'.L_G_PAGES.':&nbsp;<b>';
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
          if($i != $_REQUEST['list_page']) {
              echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Merchants_Views_EmailManager&list_page=$i&campaign=".$_REQUEST['campaign']."\">$i</a>&nbsp;";
          } else {
              echo "&nbsp;<b>$i</b>&nbsp;";
          }
      }
      echo "</center><br>";
    }
    
    if($this->a_numrows == 0)
        print L_G_NOEMAILSINCAMPAIGN;
        
    $count = 0;
    while($data=$this->a_list_data->getNextRecord())
    {
      $count++;
      if(!(($_REQUEST['list_page']-1)*$paging<$count && $count<=($_REQUEST['list_page']*$paging)))
      {
        continue;
      }

      // get statistics data (impressions and clicks)
      $stat_data = $this->a_bannerStats[$data['bannerid']];      
?>  
    <br>
    <table class=listing width=750 border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=tableheader align=left>
        <table width="100%" border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td align=left>
                <?php echo L_G_ID?>: <?php echo $data['bannerid']?>&nbsp;&nbsp;|&nbsp;&nbsp;
                <?php echo L_G_CAMPAIGN?>: <b><?php echo $data['campaignname']?></b>&nbsp;&nbsp;
            </td>
            <td align=right>
            <?php if($this->a_action_permission['edit']) { ?>
                <a class=mainlink href="javascript:editBanner('<?php echo $data['bannerid']?>');"><?php echo L_G_EDIT?></a>
            <?php } ?>
            <?php if($this->a_action_permission['delete']) { ?>
                &nbsp;&nbsp;
                <a class=mainlink href="javascript:deleteBanner('<?php echo $data['bannerid']?>');"><?php echo L_G_DELETE?></a>
            <?php } ?>
            </td>
        </tr>
        </table>
         </td>
      </tr>
      <tr>
        <td align=left colspan=2>
<?php
 if($data['bannertype'] == BANNERTYPE_TEXTEMAIL || $data['bannertype'] == BANNERTYPE_HTMLEMAIL)
 {
        echo L_G_SUBJECT.": <b>".$data['sourceurl']."</b><br>".L_G_EMAILTEXT.": <textarea rows=\"8\" style=\"width:100%\" readonly>".$data['description'].'</textarea>';
 } 
?>        
        </td>
      </tr>
    </table>
    <br>
<?php
    }
    
    if($this->a_numrows>$paging)
    {
      $pages = floor($this->a_numrows/$paging);
      if($this->a_numrows%$paging) $pages++;

      echo "<br><center>";      
      echo '<b>'.L_G_PAGES.':&nbsp;<b>';
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
        if($i != $_REQUEST['list_page'])
          echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Merchants_Views_EmailManager&list_page=$i&campaign=".$_REQUEST['campaign']."\">$i</a>&nbsp;";
        else
          echo "&nbsp;<b>$i</b>&nbsp;";
      }
      echo "</center>";
    }    
?>    
   </td>
   </tr>
   </table>
