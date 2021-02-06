<script>
function customDynamicLink() {
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=custdynamiclink"+"&<?php echo SID?>","EditBanner","scrollbars=1, top=100, left=100, width=600, height=320, status=0")
    wnd.focus();
}
</script>

<?php
//dbg($this->a_menu);
$logoWidth = 184;
$spacerWidth = 6;
$menuButtonWidth = 81;

$menuStartPos = $logoWidth + $spacerWidth;
$menuTotalLength = 780 - $menuStartPos; //count($this->a_menu) * $menuButtonWidth;
$submenuPos = array();

$menuPos = 0;
foreach($this->a_menu as $header => $dummy) {
    $headerTextLength = 0;

    foreach($this->a_menu[$header]['items'] as $item) {
        $headerTextLength += 10; // for img and space;
        $headerTextLength += strlen($item['caption'])*6;
    }

    $menuButtonStart = $menuPos * $menuButtonWidth;
    $menuButtonEnd = $menuButtonStart + $menuButtonWidth;

    $menuRemainingToRight = $menuTotalLength - $menuButtonStart;
    $menuRemainingToLeft = $menuButtonEnd;
    $menuRemainingToTheLeftTotal = $menuButtonEnd + $menuStartPos;

    if($headerTextLength < $menuRemainingToRight) {
        $submenuPos[$header] = "left: ".($menuStartPos+$menuButtonStart)."px; width: {$headerTextLength}px;";
        $menuPos++;
        continue;
    }

    if($headerTextLength < $menuRemainingToLeft) {
        $submenuPos[$header] = "left: ".($menuStartPos+$menuButtonEnd-$headerTextLength)."px; width: {$headerTextLength}px;";
        $menuPos++;
        continue;
    }

    if($headerTextLength < $menuRemainingToTheLeftTotal) {
        $submenuPos[$header] = "left: ".($menuStartPos+$menuButtonEnd-$headerTextLength)."px; width: {$headerTextLength}px;";
        $menuPos++;
        continue;
    }

    $submenuPos[$header] = "left: 20px; width: {$headerTextLength}px;";
    $menuPos++;
}
?>

<div onmouseover="pa_mover1(event);" onmouseout="pa_mout0(event);">
<table id=pam_menuTable width="100%" border="0" cellspacing="0" cellpadding="0">
<tr id=pam_bigMenu>
    <td rowspan=2 id=pam_logo class="headerLogo">
        <?php 
            
            $logoUrl = $GLOBALS['Auth']->getSetting('Aff_style_logo_url');
            if ($logoUrl != '') {
                $size = GetImageSize($logoUrl);
                $width = $size[0];
                $height = $size[1];
                if ($height > 60) {
                    $ratio = 60 / $height;
                    $height = round($height * $ratio);
                    $width  = round($width  * $ratio);
                }
        ?>
                <img id=pam_logo src="<?php echo $logoUrl?>" class="logo333" border="0" width="<?php echo $width?>" height="<?php echo $height?>">
        <?php  } else { ?>
                <img id=pam_logo src="<?php echo $this->a_this->getImage('web_logo.gif')?>" class="logo333" border="0">
        <?php  } ?>
    </td>
    <td id=pam_spacer class="headerTopMenuUpperSpacer" colspan="<?php echo count($this->a_menu)*3+2?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px">
    <?php if($this->a_Auth->isLogged()) { ?>
        <b><?php echo $this->a_Auth->userName?>&nbsp;&nbsp;</b>
    <?php } ?>
    </td>
</tr>
<tr id=pam_bigMenu2>
    <td id=pam_spacer class="headerTopMenuTopSpacer">
        <img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" class="logo333" border="0" width="6px">
    </td>

    <!--Begin top menu-->
    <?php foreach($this->a_menu as $header => $dummy) { ?>
        <?php $uniq = md5(uniqid("")); ?>

    <td id="toppam_mnu<?php echo $this->a_menu[$header]['name']?>L" class="headerTopMenuLeft"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td>
    <td id="toppam_mnu<?php echo $this->a_menu[$header]['name']?>" class="headerTopMenu">
    <?php if($this->a_menu[$header]['link'] != '') { ?>
        <a id="toppam_mnu<?php echo $this->a_menu[$header]['name']?>" class="papTopMenuLink" href="<?php echo $this->a_menu[$header]['link']?>">
    <?php } ?>
        <img id="pam_mnu<?php echo $this->a_menu[$header]['name']?>" src="<?php echo  ($this->a_menu[$header]['image'] != '' ? $this->a_this->getImage($this->a_menu[$header]['image']) : $this->a_this->getImage('top_menu1.png')) ?>" class="logo333" border="0">
        <br id="toppam_mnu<?php echo $this->a_menu[$header]['name']?>" />
        <?php echo $this->a_menu[$header]['caption']?>
    <?php if($this->a_menu[$header]['link'] != '') { ?>
        </a>
    <?php } ?>
    </td>
    <td id="toppam_mnu<?php echo $this->a_menu[$header]['name']?>R" class="headerTopMenuRight"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td>

    <?php } ?>
    <!--End top menu-->

    <td class="topUserInfo" align="right" valign="top">
        <!--Start logged field-->
        <?php echo $this->a_this->fetchTemplate('logged_field') ?>
        <!--End logged field-->
    </td>
</tr>
<tr id=pam_smallMenu>
    <td id=pam_smallMenuArea class=topSmallMenu align=center colspan="<?php echo count($this->a_menu)*3+3?>" valign=top>

    <?php foreach($this->a_menu as $header => $dummy) { ?>
        <?php $uniq = md5(uniqid("")); ?>

     <TABLE id="pam_mnu<?php echo $this->a_menu[$header]['name']?>_" style="Z-INDEX: 816; height: 24px; VISIBILITY: hidden; POSITION: absolute; <?php echo $submenuPos[$header]?> background-color: #B2C3CF"
        cellSpacing=0 cellPadding=3 width=0 height=20 border=0>
      <TR>

        <?php  $numberOfItems = 0;
            $count = 0;
            foreach($this->a_menu[$header]['items'] as $item) { $numberOfItems++; }

            foreach($this->a_menu[$header]['items'] as $item) {
                $count++;
        ?>
          <TD id="pam_<?php echo $uniq?>" align=left nowrap>
          <?php echo ($count == 1 ? '&nbsp;&nbsp;' : '')?><a id="pam_<?php echo $uniq?>" class=pa_menuLink href="<?php echo $item['link']?>"><?php echo $item['caption']?></a><?php echo ($count == $numberOfItems ? '&nbsp;&nbsp;' : '')?>
          </TD>
        <?php      if($count != 0 && $count != $numberOfItems) { ?>
                <TD id="pam_null" align=left nowrap><font color="#777777">|</font></TD>
        <?php      }
            }
        ?>

      </TR>
      </TABLE>
    <?php } ?>
  </td>
</tr>
<tr>
  <td id=pam_null bgcolor="#A5ADB5" colspan="<?php echo count($this->a_menu)*3+3?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td>
</tr>
<tr>
  <td class=topSmallNavigation  id=pam_null align="left" valign="middle" colspan="<?php echo count($this->a_menu)*3+3?>"><div id="pam_navigation" style="padding:2px; height:18px;"></td>
</tr>
<tr>
  <td id=pam_null bgcolor="#A5ADB5" colspan="<?php echo count($this->a_menu)*3+3?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td>
</tr>
</table>
</div>
