<script>
function customDynamicLink()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=custdynamiclink"+"&<?php echo SID?>","EditBanner","scrollbars=1, top=100, left=100, width=600, height=320, status=0")
    wnd.focus(); 
}
</script>
        <table width="150" height="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" height="10"></td>
        </tr>
<?php
if($this->a_Auth->isLogged()) 
{
    if(!isset($this->leftMenu) || !is_array($this->leftMenu))
        print 'NO MENU ARRAY FOUND';
    else
    {
        // draw menu
?>


        
<?php
        foreach($this->leftMenu as $menuItem)
        {
            if(!is_array($menuItem))
            {
                // draw main menu items
?>

        <tr>
          <td class="superadminleftMenu" valign="middle" align="left" height="16">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $menuItem?>
          </td>
        </tr>
        <tr>
          <td valign="middle" height="1"></td>
        </tr>

<?php
            }
            else
            {
                // draw subitems
                foreach($menuItem as $subMenuItem)
                {
                    if(!is_array($subMenuItem))
                    {
                        // draw submenu item
?>
        <tr>
          <td valign="middle" height="17">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;
          <?php echo $subMenuItem?>
          </td>
        </tr>

<?php
                    }
                    else
                    {
?>
        <tr>
          <td valign="top" height="17">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;
          SUBMENU CANNOT BE ARRAY
          </td>
        </tr>
<?php
                    }
                    
                }
?>
        <tr>
          <td valign="top" height="1"></td>
        </tr>
<?php                
            }
        }
    }
}
?>
        <tr>
          <td valign="top" height="100%"></td>
        </tr>
        </table>
