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
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=showcode&bid="+ID+"&<?php echo SID?>","ShowBannerCodeBanner","scrollbars=0, top=100, left=100, width=450, height=270, status=0")
    wnd.focus();
}

function showBannerCode(ID)
{
    if(document.getElementById('bs_show_code_'+ID).style.display != "none")
    {
        document.getElementById('bs_show_code_'+ID).style.display="none";
        document.getElementById('bs_show_code_link_'+ID).innerHTML='<?php echo L_G_SHOWBANNERCODE?>';
    }
    else
    {
        document.getElementById('bs_show_code_'+ID).style.display="block";
        document.getElementById('bs_show_code_link_'+ID).innerHTML='<?php echo L_G_HIDEBANNERCODE?>';
    }


    return;

}

function goToPage(list_page) {
    document.getElementById('list_page').value = list_page;
    document.getElementById('FilterForm').submit();
}

</script>

<div class="bannerCategories"  width="750">
    <h5><?php echo L_G_BANNERCATEGORIES?></h5>
    <table width="750">
    <tr>
        <td>
            <a href="index.php?md=Affiliate_Affiliates_Views_AffBannerManager&bs_bannercategoryid=_"+"&<?php echo SID?>">
            <?php if($_REQUEST['bs_bannercategoryid'] == '_') { ?><span style="font-weight: bold; color: #ff0000;"><?php } ?>
            <?php echo L_G_NOBANNERCATEGORY?> [<?php echo  $this->noCategoryCount?>]
            <?php if($_REQUEST['bs_bannercategoryid'] == '_') { ?></span><?php } ?>
            </a>
        </td>
        <td>
            <a href="index.php?md=Affiliate_Affiliates_Views_AffBannerManager&bs_bannercategoryid=_all"+"&<?php echo SID?>">
            <?php if($_REQUEST['bs_bannercategoryid'] == '_all') { ?><span style="font-weight: bold; color: #ff0000;"><?php } ?>
            <?php echo L_G_ALLBANNERCATEGORY?> [<?php echo  $this->allCategoryCount?>]
            <?php if($_REQUEST['bs_bannercategoryid'] == '_all') { ?></span><?php } ?>
            </a>
        </td>
    </tr>
    <tr>
    <?php $i = 0; ?>
    <?php foreach($this->bannerCategories as $id => $row) { ?>
        <?php if($i % 2 == 0) { ?></tr><tr><?php } ?>
        <?php $i++; ?>
        <td>
        <a href="index.php?md=Affiliate_Affiliates_Views_AffBannerManager&bs_bannercategoryid=<?php echo $id?>"+"&<?php echo SID?>">
        <?php if($_REQUEST['bs_bannercategoryid'] == $id) { ?><span style="font-weight: bold; color: #ff0000;"><?php } ?>
        <?php echo  $row['name']?><?php if($_REQUEST['bs_bannercategoryid'] == $id) { ?></span><?php } ?></a>
        &nbsp;[<?php echo  $row['num']?>]
        </td>
    <?php } ?>
    </tr>
    </table>
</div>
<br><br>

<?php QUnit_Global::includeTemplate('banner_show_filter.tpl.php'); ?>

<br>
<table border=0>
<?php  if($this->a_numrows>$paging) { ?>
     <tr>
     <td align=center>
      <b><?php echo L_G_PAGES?>:&nbsp;<b>
<?php
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
        if($i != $_REQUEST['list_page'])
          echo "&nbsp;<a class=\"paging\" href=\"javascript: goToPage('$i');\">$i</a>&nbsp;";
        else
          echo "&nbsp;<b>$i</b>&nbsp;";
      }
      echo "</td></tr>";
    }
?>
   <tr>
   <td align=center>
<script>
function makeDynamicLink(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=dynamiclink&bid="+ID+"&<?php echo SID?>","EditBanner","scrollbars=1, top=100, left=100, width=600, height=320, status=0")
    wnd.focus();
}

function showPopupPopunder(banner_content, btype, rwidth, rheight, rresizable, rstatus, rtoolbar, rlocation, rdirectories, rmenubar, rscrollbars)
{
  var TheNewWindow = window.open("<?php echo $GLOBALS['WEB_ROOT_PATH'].'/scripts/'?>testPop.php?banner_content="+banner_content,'ThePop',
        'top=0,left=0,width='+rwidth+',height='+rheight+',toolbar='+rtoolbar+',location='+rlocation+',directories='+rdirectories+',status='+rstatus+',menubar='+rmenubar+',scrollbars='+rscrollbars+',resizable='+rresizable);

  if(btype == '<?php echo BANNERTYPE_POPUNDER?>')
    TheNewWindow.blur();
  else
    TheNewWindow.focus();
}
</script>

<?php
   if($this->a_numrows == 0)
        print '<br><br><b>'.L_G_NOBANNERS.'</b><br><br><br></td></tr>';

   $count = 0;
   $params = $this->a_params;
   if (count($this->a_list_data) > 0) {
   foreach ($this->a_list_data as $bannerID => $data)
    {
      $count++;
      if(!(($_REQUEST['list_page']-1)*$paging<$count && $count<=($_REQUEST['list_page']*$paging)))
      {
        continue;
      }
      
      // get statistics data (impressions and clicks)
      $data = $this->a_bannerData[$bannerID];
      
      $clickUrlOnly = Affiliate_Affiliates_Views_AffBannerManager::getClickUrl($data['destinationurl'], $params);
?>

    <br>
    <table class=listing width=750 border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=tableheader align=left>
        <table width="100%" border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td align=left>
                <table cellpadding="0" cellspacing="0" border="0">
                <tr><td width="70"><?php echo L_G_ID?>: <?php echo $data['bannerid']?></td>
                    <td width="20">&nbsp;&nbsp;|&nbsp;&nbsp;</td>
                    <td width="100">
                        <?php echo L_G_TYPE?>: <b>
                        <?php switch ($data['bannertype']) {
                            case BANNERTYPE_HTML:     echo L_G_BANNERTYPE_HTML; break;
                            case BANNERTYPE_TEXT:     echo L_G_BANNERTYPE_TEXT; break;
                            case BANNERTYPE_IMAGE:    echo L_G_BANNERTYPE_IMAGE; break;
                            case BANNERTYPE_POPUP:    echo L_G_BANNERTYPE_POPUP; break;
                            case BANNERTYPE_POPUNDER: echo L_G_BANNERTYPE_POPUNDER; break;
                            case BANNERTYPE_ROTATOR:  echo L_G_BANNERTYPE_ROTATOR; break;
                            default: echo L_G_UNKNOWN; break;
                           } ?></b></td>
                    <td width="20">&nbsp;&nbsp;|&nbsp;&nbsp;</td>
                    <td><?php if($data['bannertype'] != BANNERTYPE_ROTATOR) { ?>
                        <?php echo L_G_DESTURL?>: <b><?php echo $data['destinationurl']?></b>
                        <?php } ?></td>
                </tr>
                <tr><td width="100%" colspan="5"><?php echo L_G_NAME2?>: <b><?php echo $data['name']?></b></td>
                </tr>
                </table>
            </td>
            <td align=right>
            <?php
                if (!$this->a_hide_dynamic_link) {
            ?>
                    <a class=mainlink href="javascript:makeDynamicLink('<?php echo $data['bannerid']?>');"><?php echo L_G_DYNAMICLINK?></a>
            <?php
                }
            ?>   
            </td>
        </tr>
        </table>
        </td>
      </tr>
      <?php if($_REQUEST['bs_show_stats'] == '1') { ?>
      <?php if($this->a_Auth->getSetting('Aff_display_banner_stats_all') == '1') { ?>
      <tr>
        <td align=left class=listheaderNoLineLeft>
        <?php echo L_G_STATISTICSFORALLAFFS?>
        <table class=smalltext width=100%  border=0 cellspacing=0 cellpadding=0>
        <tr>
          <td class=smalltext width=10% align=left><?php echo L_G_INPERIOD?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?php echo L_G_IMPRESSIONS?> <?php echo L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?php echo $data['unique_impressions_period']?> / <?php echo $data['impressions_period']?></td>
          <td class=smalltext width=30% align=center><?php echo L_G_CLICKS?>:&nbsp;&nbsp;<?php echo $data['clicks_period']?></td>
          <td class=smalltext width=30% align=right><?php echo L_G_RATIO?>:&nbsp;&nbsp;<?php echo $data['ratio_period']?></td>
        </tr>
        <tr>
          <td class=smalltext width=10% align=left><?php echo L_G_ALL?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?php echo L_G_IMPRESSIONS?> <?php echo L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?php echo $data['unique_impressions_all']?> / <?php echo $data['impressions_all']?></td>
          <td class=smalltext width=30% align=center><?php echo L_G_CLICKS?>:&nbsp;&nbsp;<?php echo $data['clicks_all']?></td>
          <td class=smalltext width=30% align=right><?php echo L_G_RATIO?>:&nbsp;&nbsp;<?php echo $data['ratio_all']?></td>
        </tr>
        </table>
        </td>
      </tr>
      <?php } ?>
      <tr>
        <td align=left class=listheaderNoLineLeft>
        <?php echo L_G_MYSTATISTICS?>
        <table class=smalltext width=100%  border=0 cellspacing=0 cellpadding=0>
        <tr>
          <td class=smalltext width=10% align=left><?php echo L_G_INPERIOD?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?php echo L_G_IMPRESSIONS?> <?php echo L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?php echo $data[$this->a_Auth->getUserID()]['unique_impressions_period']?> / <?php echo $data[$this->a_Auth->getUserID()]['impressions_period']?></td>
          <td class=smalltext width=30% align=center><?php echo L_G_CLICKS?>:&nbsp;&nbsp;<?php echo $data[$this->a_Auth->getUserID()]['clicks_period']?></td>
          <td class=smalltext width=30% align=right><?php echo L_G_RATIO?>:&nbsp;&nbsp;<?php echo $data[$this->a_Auth->getUserID()]['ratio_period']?></td>
        </tr>
        <tr>
          <td class=smalltext width=10% align=left><?php echo L_G_ALL?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?php echo L_G_IMPRESSIONS?> <?php echo L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?php echo $data[$this->a_Auth->getUserID()]['unique_impressions_all']?> / <?php echo $data[$this->a_Auth->getUserID()]['impressions_all']?></td>
          <td class=smalltext width=30% align=center><?php echo L_G_CLICKS?>:&nbsp;&nbsp;<?php echo $data[$this->a_Auth->getUserID()]['clicks_all']?></td>
          <td class=smalltext width=30% align=right><?php echo L_G_RATIO?>:&nbsp;&nbsp;<?php echo $data[$this->a_Auth->getUserID()]['ratio_all']?></td>
        </tr>
        </table>
        </td>
      </tr>
      <tr><td class=settingsLine><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
      <?php } ?>
      <tr>
        <td class=listresultNoLin align=center colspan=2>
<?php
        $banner = $this->a_this->showBannerAndGetCode($clickUrlOnly, $data['bannertype'], $data['bannerid'], $data['sourceurl'], $data['description'], $params);
        echo $banner['titleDescription'];
?>
        </td>
      </tr>
      <tr>
        <td align=right valign=middle>
          <a class=mainlink id="bs_show_code_link_<?php echo $data['bannerid']?>"  href="javascript:showBannerCode('<?php echo $data['bannerid']?>', this);"><?php echo L_G_SHOWBANNERCODE?></a>&nbsp;<a href="javascript:showBannerCode('<?php echo $data['bannerid']?>', this);"><img src="<?php echo $this->a_this->getImage('icon_opendown.gif')?>"></a>
        </td>
      </tr>
      <!--<tr><td class=settingsLine><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>-->
      <tr >
        <td align=left colspan=2 style="padding: 0px;">
            <div id="bs_show_code_<?php echo $data['bannerid']?>" style="display:none; padding: 4px;">
            <b><?php echo L_G_CODETOINSERT?></b><br>
          <center><textarea cols="110" rows=4 readonly><?php echo htmlspecialchars($banner['bannerCode'])?></textarea></center>
          </div>
        </td>
      </tr>
    </table>
    <br>
<?php
    }
?>
   </td>
   </tr>
<?php  if($this->a_numrows>$paging) { ?>
     <tr>
     <td align=center>
      <b><?php echo L_G_PAGES?>:&nbsp;<b>
<?php
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
        if($i != $_REQUEST['list_page'])
          echo "&nbsp;<a class=\"paging\" href=\"javascript: goToPage('$i');\">$i</a>&nbsp;";
        else
          echo "&nbsp;<b>$i</b>&nbsp;";
      }
      echo "<br><br></td></tr>";
    }
?>
<?php
   }
?>
   </table>
   </form>
