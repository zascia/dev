<script>
function customDynamicLink()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=custdynamiclink"+"&<?php echo SID?>","EditBanner","scrollbars=1, top=100, left=100, width=600, height=320, status=0")
    wnd.focus(); 
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td class="leftMenuContent" height="6"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" width="1" height="6" border="0"></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="leftMenuContent" valign="top">

<?php foreach($this->a_menu as $header => $dummy) { ?>
    <?php $uniq = md5(uniqid("")); ?>
    <table class="leftMenuTableOpened" id=<?php echo $uniq?> cellspacing="0" cellpadding="0">
    <?php if($this->a_menu[$header]['caption'] != '') { ?>
    <tr>
        <td class="leftMenuHeader" onclick="openMenuItems('<?php echo $uniq?>');"><?php echo  $this->a_menu[$header]['caption']?></td>
    </tr>
    <?php } ?>
    <tr>
        <td class="leftMenuTop"></td>
    </tr>
    <tr>
        <td valign="top" align="left">
        <DIV class=menuTree>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?php foreach($this->a_menu[$header]['items'] as $item) { ?>
        <tr>
            <td class="leftMenuItem">
                <a class="aLeftMenuItem" href="<?php echo  $item['link']?>"><?php echo  $item['caption']?></a>
                </div>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td class="leftMenuBottom"></td>
            </tr>
         </table>
         </div>
         </td>
     </tr>
     </table>
     <table width="100%" height="3" border="0" cellspacing="0" cellpadding="0">
     <tr>
        <td></td>
     </tr>
     </table>
<?php } ?>
</tr>
</table>
