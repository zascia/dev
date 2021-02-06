<script>
function customDynamicLink() {
    var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=custdynamiclink"+"&<?php echo SID?>","EditBanner","scrollbars=1, top=100, left=100, width=600, height=320, status=0")
    wnd.focus();
}
</script>

<?php if($this->a_Auth->isLogged()) { ?>
<table width="182" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="leftMenuContentBorder"></td>
  <td class="leftMenuMain" valign="bottom">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td style="height: 22px;">&nbsp;</td></tr>
<tr>
  <td class="leftMenuContent" valign="top">
<?php
    $permissions = $this->a_Auth->getPermissions();
    if(!isset($this->leftMenu) || !is_array($this->leftMenu)) {
        print 'NO MENU ARRAY FOUND';
    }
    else
    {
        // draw menu
        foreach($this->leftMenu as $menuTable)
        {
            $uniq = md5(uniqid(""));
            // draw table
            print '<table class="leftMenuTableOpened" id='.$uniq.' cellspacing="0" cellpadding="0">';

            $headerDrawn = false;
            $itemDrawn = false;
            $menuPart = '';

            // draw header
            $menuPart .= '<tr><td class="leftMenuHeader">'.$menuTable['caption'].'</td></tr><tr><td class="leftMenuTop"></td></tr>';

            // draw table content
            foreach($menuTable['items'] as $menuItem)
            {
                if($menuItem['permission'] != '' && !in_array($menuItem['permission'], $permissions))
                    continue;

                $menuPart .= '<tr><td valign="top" align="left"><DIV class=menuTree>';

                if(!$itemDrawn)
                {
                    $menuPart .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
                    $itemDrawn = true;
                }

                //if(!$headerDrawn)
                //$menuPart .= '<tr><td class="leftMenuTop"></td></tr>';

                // draw item
                $menuPart .= '<tr><td class="leftMenuItem"><a class="aLeftMenuItem" href="'.$menuItem['link'].'">'.$menuItem['caption'].'</a></div></td></tr>';
            }

            if($itemDrawn)
            {
                print $menuPart;
                print '<tr><td class="leftMenuBottom"></td></tr></table>';
                print '</div></td></tr></table>';

            }

            // spacer between menu tables
            print '<table width="100%" height="3" border="0" cellspacing="0" cellpadding="0"><tr><td></td></tr></table>';
        }
    }
?>
  </td>
</tr>
</table>

  </td>
  <td class="leftMenuContentBorder"></td>
</tr>
</table>
<?php } ?>
