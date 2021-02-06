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
  if(confirm("<?php echo L_G_CONFIRMDELETEBANNER?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerManager&bid="+ID+"&action=delete"+"&<?php echo SID?>";
}

function addBanner(Type)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_Banner"+Type+"&campaign=<?php echo $campaignid?>&<?php echo SID?>";
}

function editBanner(Type, ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_Banner"+Type+"&action=edit&bid="+ID+"&<?php echo SID?>";
}

function addBannerCategory()
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerCategory&action=add&<?php echo SID?>";
}

function addBannersForCampaign()
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerManager&action=show&campid=<?php echo $campaignid?>"+"&<?php echo SID?>";
}

function backToCampaigns(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CampaignManager&action=addbanners&cid="+ID+"&<?php echo SID?>";
}

function showPopupPopunder(banner_content, btype, rwidth, rheight, rresizable, rstatus, rtoolbar, rlocation, rdirectories, rmenubar, rscrollbars)
{
  var TheNewWindow = window.open("<?php echo $this->a_Auth->getSetting('Aff_scripts_url')?>testPop.php?banner_content="+banner_content,'ThePop',
        'top=0,left=0,width='+rwidth+',height='+rheight+',toolbar='+rtoolbar+',location='+rlocation+',directories='+rdirectories+',status='+rstatus+',menubar='+rmenubar+',scrollbars='+rscrollbars+',resizable='+rresizable);

  if(btype == '<?php echo BANNERTYPE_POPUNDER?>')
    TheNewWindow.blur();
  else
    TheNewWindow.focus();
}
</script>

   <table border=0>
   <tr><td align=left>
        <?php echo L_G_BANNERMANAGER_DESCRIPTION?><br><br>
        </td>
   </tr>
    <tr>
        <td>
            <div class="bannerCategories">
            <table width="100%">
            <tr>
                <td>
                    <a href="index.php?md=Affiliate_Merchants_Views_BannerManager&bs_bannercategoryid=_"+"&<?php echo SID?>">
                    <?php if($_REQUEST['bs_bannercategoryid'] == '_') { ?><span style="font-weight: bold; color: #ff0000;"><?php } ?>
                    <?php echo L_G_NOBANNERCATEGORY?> [<?php echo  $this->noCategoryCount?>]
                    <?php if($_REQUEST['bs_bannercategoryid'] == '_') { ?></span><?php } ?>
                    </a>
                </td>
                <td>
                    <a href="index.php?md=Affiliate_Merchants_Views_BannerManager&bs_bannercategoryid=_all"+"&<?php echo SID?>">
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
                <a href="index.php?md=Affiliate_Merchants_Views_BannerManager&bs_bannercategoryid=<?php echo $id?>"+"&<?php echo SID?>">
                <?php if($_REQUEST['bs_bannercategoryid'] == $id) { ?><span style="font-weight: bold; color: #ff0000;"><?php } ?>
                <?php echo  $row['name']?>
                <?php if($_REQUEST['bs_bannercategoryid'] == $id) { ?></span><?php } ?>
                </a> [<?php echo  $row['num']?>]
                <?php if($this->a_action_permission['editcategory']) { ?>
                <a class=mainlink href="index.php?md=Affiliate_Merchants_Views_BannerCategory&action=edit&bannercategoryid=<?php echo $id?>"+"&<?php echo SID?>">edit</a>
                &nbsp;|&nbsp;
                <?php } ?>
                <?php if($this->a_action_permission['deletecategory']) { ?>
                <a class=mainlink href="index.php?md=Affiliate_Merchants_Views_BannerManager&action=delete_bannercategory&bannercategoryid=<?php echo $id?>"+"&<?php echo SID?>">delete</a>
                <?php } ?>
                </td>
            <?php } ?>
            </tr>
            </table>
            <?php if($this->a_action_permission['addcategory']) { ?>
            <p><input type=button class=formbutton value="<?php echo L_G_ADDBANNERCATEGORY?>"  onclick="javascript:addBannerCategory();"></p>
            <?php } ?>
            </div>
            <br><br>
        </td>
    </tr>
<?php if($this->a_action_permission['add']) { ?>
   <tr>
   <td align=left>
     <table border=0 cellspacing=0>
     <tr>
       <td><input type=button class=formbutton value="<?php echo L_G_ADDHTML?>"  onclick="javascript:addBanner('Html');">&nbsp;&nbsp;&nbsp;</td>
       <td><input type=button class=formbutton value="<?php echo L_G_ADDTEXT?>"  onclick="javascript:addBanner('Text');">&nbsp;&nbsp;&nbsp;</td>
       <td><input type=button class=formbutton value="<?php echo L_G_ADDIMAGE?>" onclick="javascript:addBanner('Image');">&nbsp;&nbsp;&nbsp;</td>
       <td><input type=button class=formbutton value="<?php echo L_G_ADDPOPUP?>" onclick="javascript:addBanner('Popup');">&nbsp;&nbsp;&nbsp;</td>
       <td><input type=button class=formbutton value="<?php echo L_G_ROTATOR?>"  onclick="javascript:addBanner('Rotator');">&nbsp;&nbsp;&nbsp;</td>
     </tr>
     <tr>
        <td>&nbsp;</td>
     </tr>
     </table>
   </td>
   </tr>
<?php } ?>   <tr>
   <td align=left>
   <?php QUnit_Global::includeTemplate('banner_show_filter.tpl.php'); ?>
   </td>
   </tr>
   <tr>
   <td align=left>
<?php
    if($this->a_numrows > $paging)
    {
      echo "<center>";
      echo '<b>'.L_G_PAGES.':&nbsp;<b>';
      // draw page numbers

      for($i=1; $i<=$pages; $i++)
      {
          if($i != $_REQUEST['list_page']) {
              echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Merchants_Views_BannerManager&list_page=$i&campaign=".$_REQUEST['campaign']."\">$i</a>&nbsp;";
          } else {
              echo "&nbsp;<b>$i</b>&nbsp;";
          }
      }
      echo "</center><br>";
    }

    if($this->a_numrows == 0)
        print '<br><br><b>'.L_G_NOBANNERS.'</b><br><br><br>';

   $count = 0;
   if (count($this->a_list_data) > 0) {
   foreach ($this->a_list_data as $bannerID => $data)
    {
      $count++;
      if(!(($_REQUEST['list_page']-1)*$paging<$count && $count<=($_REQUEST['list_page']*$paging)))
      {
        continue;
      }
      $data = $this->a_bannerData[$bannerID];
?>
    <br>
    <table class=listing width=750 border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=tableheader align=left>
        <table width="100%" border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td align=left valign="top">
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
                    <td><?php echo L_G_NAME2?>: <b><?php echo $data['name']?></b>
                        <?php echo ($data['hidden'] == '1') ? '&nbsp;&nbsp;|&nbsp;&nbsp;<b>'.L_G_HIDDEN.'</b>' : ''?>
                    </td>
                    <td width="20">&nbsp;&nbsp;|&nbsp;&nbsp;</td>
                    <td width="190"><?php echo L_G_DATECREATED?>: <b><?php echo $data['dateinserted']?></b></td>
                </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td><?php echo L_G_CAMPAIGN?>: <b><?php echo $data['campaignname']?></b></td>
                    <td width="20">&nbsp;&nbsp;|&nbsp;&nbsp;</td>
                    <td><?php if($data['bannertype'] != BANNERTYPE_ROTATOR) { ?>
                        <?php echo L_G_DESTURL?>: <b><a href="<?php echo $data['destinationurl']?>" target=_blank><?php echo $data['destinationurl']?></a></b>
                        <?php } ?></td>
                </tr>
                </table>
            </td>
            <td align=right valign="top">
            <?php if($this->a_action_permission['edit']) {
                 $btype = '';
                 switch ($data['bannertype']) {
                     case BANNERTYPE_TEXT:     $btype = 'Text'; break;
                     case BANNERTYPE_HTML:     $btype = 'Html'; break;
                     case BANNERTYPE_IMAGE:    $btype = 'Image'; break;
                     case BANNERTYPE_POPUNDER: $btype = 'Popup'; break;
                     case BANNERTYPE_POPUP:    $btype = 'Popup'; break;
                     case BANNERTYPE_ROTATOR:  $btype = 'Rotator'; break;
                 }
                 ?>
                <a class=mainlink href="javascript:editBanner('<?php echo $btype?>', '<?php echo $data['bannerid']?>');"><?php echo L_G_EDIT?></a>
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
        <td align=left class=listheaderNoLineLeft>
<?php if($_REQUEST['bs_userid'] != '' && $_REQUEST['bs_userid'] != '_') { ?>
        <?php echo L_G_STATISTICSFORALLAFFS?>
<?php } ?>
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
<?php if($_REQUEST['bs_userid'] != '' && $_REQUEST['bs_userid'] != '_') { ?>
      <tr>
        <td align=left class=listheaderNoLineLeft>
        <?php echo L_G_STATISTICSFORCHOSENAFF?>
        <table class=smalltext width=100%  border=0 cellspacing=0 cellpadding=0>
        <tr>
          <td class=smalltext width=10% align=left><?php echo L_G_INPERIOD?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?php echo L_G_IMPRESSIONS?> <?php echo L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?php echo $data[$_REQUEST['bs_userid']]['unique_impressions_period']?> / <?php echo $data[$_REQUEST['bs_userid']]['impressions_period']?></td>
          <td class=smalltext width=30% align=center><?php echo L_G_CLICKS?>:&nbsp;&nbsp;<?php echo $data[$_REQUEST['bs_userid']]['clicks_period']?></td>
          <td class=smalltext width=30% align=right><?php echo L_G_RATIO?>:&nbsp;&nbsp;<?php echo $data[$_REQUEST['bs_userid']]['ratio_period']?></td>
        </tr>
        <tr>
          <td class=smalltext width=10% align=left><?php echo L_G_ALL?>&nbsp;</td>
          <td class=smalltext width=30% align=left><?php echo L_G_IMPRESSIONS?> <?php echo L_G_IMPUNIQUEALL?>:&nbsp;&nbsp;<?php echo $data[$_REQUEST['bs_userid']]['unique_impressions_all']?> / <?php echo $data[$_REQUEST['bs_userid']]['impressions_all']?></td>
          <td class=smalltext width=30% align=center><?php echo L_G_CLICKS?>:&nbsp;&nbsp;<?php echo $data[$_REQUEST['bs_userid']]['clicks_all']?></td>
          <td class=smalltext width=30% align=right><?php echo L_G_RATIO?>:&nbsp;&nbsp;<?php echo $data[$_REQUEST['bs_userid']]['ratio_all']?></td>
        </tr>
        </table>
        </td>
      </tr>
<?php } ?>
      <tr><td class=settingsLine><img border=0 src="<?php echo $this->a_this->getImage('blank.gif')?>"></td></tr>
      <tr>
        <td align=center colspan=2>
<?php
 if($data['bannertype'] == BANNERTYPE_TEXT)
 {
//     if(isset($this->textbanner_tpl)) {
//          $code = $this->textbanner_tpl;
//          $code = str_replace('{TITLE}', $data['description'], $code);
//              $code = str_replace('{DESCRIPTION}', $data['description'], $code);
//              $code = str_replace('{DESTINATION}',
//                 $clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : ''), $code);
//              $code = str_replace('{IMPRESSION_TRACK}', "<IMG SRC='".$GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?".PARAM_A_AID."=".$GLOBALS['Auth']->userID."&".PARAM_A_BID."=".$bannerID."' WIDTH=1 HEIGHT=1 BORDER=0>", $code);
//
//              echo $code;
//     } else {
        echo "<b>".$data['sourceurl']."</b><br>".$data['description'];
//     }
 }
 else if($data['bannertype'] == BANNERTYPE_HTML)
 {
   echo $data['description'];
 }
 else if($data['bannertype'] == BANNERTYPE_IMAGE)
 {
   echo "<br><img src='".$data['sourceurl']."' border=0 alt='".$data['description']."'><br>";
 }
 else if($data['bannertype'] == BANNERTYPE_POPUP || $data['bannertype'] == BANNERTYPE_POPUNDER)
 {
    $banner_details = $this->a_this->parseBannerDescription($data['description'], false);

    $banner_content = '';
    if($banner_details['display'] == URL_EXIST)
    {
      $blBanners =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Banners');
      $original_banner = $blBanners->getBannerInfo(array('bannerid' => $data['sourceurl']));

      $bannerData = $original_banner[$data['sourceurl']];

      if($bannerData['bannertype'] == BANNERTYPE_TEXT)
      {
        $banner_content = "<b>".$bannerData['sourceurl']."</b><br>".$bannerData['description'];
      }
      else if($bannerData['bannertype'] == BANNERTYPE_HTML)
      {
        $banner_content = $bannerData['description'];
      }
      else if($bannerData['bannertype'] == BANNERTYPE_IMAGE)
      {
        $banner_content = "<br><img src=".$bannerData['sourceurl']." border=0 alt=".$bannerData['description']."><br>";
      }
    }
    else
    {
      $banner_content = "<iframe src=".$data['sourceurl']." scrolling=no frameborder=0 marginwidth=0 marginheight=0 width=".$banner_details['rwidth']." height=".$banner_details['rheight']."></iframe>";
    }

    echo '<input class=formbutton type="button" VALUE="'.L_G_TEST.' '.
         ($data['bannertype'] == BANNERTYPE_POPUNDER ? L_G_POPUNDER : L_G_POPUP).
         '" onClick="showPopupPopunder(\''.urlencode($banner_content).'\',\''.$data['bannertype'].'\',
                \''.$banner_details['rwidth'].'\',\''.$banner_details['rheight'].'\',
                \''.$banner_details['window_resizable'].'\',\''.$banner_details['window_status'].'\',
                \''.$banner_details['window_toolbar'].'\',\''.$banner_details['window_location'].'\',
                \''.$banner_details['window_directories'].'\',\''.$banner_details['window_menubar'].'\',
                \''.$banner_details['window_scrollbars'].'\')">';
 }
?>
        </td>
      </tr>
    </table>
    <br>
<?php
    }
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
          echo "&nbsp;<a class=\"paging\" href=\"index.php?md=Affiliate_Merchants_Views_BannerManager&list_page=$i&campaign=".$_REQUEST['campaign']."\">$i</a>&nbsp;";
        else
          echo "&nbsp;<b>$i</b>&nbsp;";
      }
      echo "</center>";
    }
?>
   </td>
   </tr>
   <tr>
     <td width=750 align=left>
     <?php showHelp(L_G_CLICKTHROUGHS); ?>
     </td>
   </tr>
   </table>
