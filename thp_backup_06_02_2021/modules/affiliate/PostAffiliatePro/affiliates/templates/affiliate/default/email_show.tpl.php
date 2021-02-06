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
function showCode(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffEmailManager&action=showcode&bid="+ID+"&<?php echo SID?>","ShowBannerCodeBanner","scrollbars=0, top=100, left=100, width=450, height=270, status=0")
    wnd.focus(); 
}
</script>
<?php 
    QUnit_Global::includeTemplate('email_show_filter.tpl.php'); 
    
    if($this->a_numrows>$paging)
    {
      echo "<br><center>";
      echo '<b>'.L_G_PAGES.':&nbsp;<b>';
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
        if($i != $_REQUEST['list_page'])
          echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Affiliates_Views_AffEmailManager&list_page=$i&campaign=$campaignid\">$i</a>&nbsp;";
        else
          echo "&nbsp;<b>$i</b>&nbsp;";
      }
      echo "</center><br>";
    }
?>    
   <table border=0>
   <tr>
   <td align=center>
<?php
    if($this->a_numrows == 0)
        print L_G_NOEMAILSINCAMPAIGN;

    $count = 0;
    $params = $this->a_params;    
    while($data=$this->a_list_data2->getNextRecord())
    {
      $count++;
      if(!(($_REQUEST['list_page']-1)*$paging<$count && $count<=($_REQUEST['list_page']*$paging)))
      {
        continue;
      }

      $clickUrlOnly = Affiliate_Affiliates_Views_AffEmailManager::getClickUrl($data['destinationurl'], $params);

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
        <td class=listresultNoLin align=left colspan=2>
<?php
        $bannerCode = Affiliate_Affiliates_Views_AffEmailManager::showBannerAndGetCode($clickUrlOnly, $data['bannertype'], $data['bannerid'], $data['sourceurl'], $data['description'], $params);
?>
        <?php echo L_G_EMAILTEXT?>: <br/>
        <textarea rows=10 style="width:100%"><?php echo $bannerCode?></textarea>
        </td>   
      </tr>
    </table>
    <br>
<?php
    }
?>
   </td>
   </tr>
   </table>
   </form>
   </center> 
<?php
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
          echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Affiliates_Views_AffEmailManager&list_page=$i&campaign=$campaignid\">$i</a>&nbsp;";
        else
          echo "&nbsp;<b>$i</b>&nbsp;";
      }
      echo "</center>";
    }
?>
