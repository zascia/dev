<!-- BEGIN: view_cat -->
<div class="boxContent">
<h1 class="txtContentTitle">{TXT_CAT_TITLE}</h1>
<br clear="all" />
{TXT_CAT_DESC}
<!-- BEGIN: sub_cats -->
<div id="subCats">
	<!-- BEGIN: sub_cats_loop -->
	<span class="subCat">
		<a href="index.php?act=viewCat&amp;catId={TXT_LINK_CATID}" class="txtDefault"><img src="{IMG_CATEGORY}" alt="{TXT_CATEGORY}" border="0" title="{TXT_CATEGORY}" /></a><br />
		<a href="index.php?act=viewCat&amp;catId={TXT_LINK_CATID}" class="txtDefault">{TXT_CATEGORY}</a> ({NO_PRODUCTS})
	</span>
	<!-- END: sub_cats_loop -->
</div>
<!-- END: sub_cats -->
<br clear="left" />
<!-- BEGIN: cat_img -->
<img src="{IMG_CURENT_CATEGORY}" alt="{TXT_CURENT_CATEGORY}" border="0" title="{TXT_CURENT_CATEGORY}" />
<!-- END: cat_img -->
<div><strong>{LANG_CURRENT_DIR}</strong> {CURRENT_DIR}</div>
<div class="pagination">{PAGINATION}</div>
<!-- BEGIN: productTable -->
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="tblList">
  <tr>
    <td class="tdListTitle"><strong>{LANG_IMAGE}</strong></td>
    <td class="tdListTitle"><strong>{LANG_DESC}</strong></td>
    <td class="tdListTitle"><strong>{LANG_PRICE}</strong></td>
	<td class="tdListTitle">&nbsp;</td>
  </tr>
  <!-- BEGIN: products -->
  <tr>
    <td align="center" class="{CLASS}"><a href="index.php?act=viewProd&amp;productId={PRODUCT_ID}" target="_self"><img src="{SRC_PROD_THUMB}" alt="{TXT_TITLE}" border="0" title="{TXT_TITLE}" /></a></td>
    <td valign="top" class="{CLASS}"><a title="{TXT_TITLE}" href="index.php?act=viewProd&amp;productId={PRODUCT_ID}" target="_self" class="txtDefault"><strong>{TXT_TITLE}</strong></a><br />
	{TXT_DESC}<div class="txtOutOfStock">{TXT_OUTOFSTOCK}</div></td>
	<td align="center" class="{CLASS}">{TXT_PRICE}
    <div class="txtSale">{TXT_SALE_PRICE}</div></td>
	<!-- ### START ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz -->
    <td align="right" width="80px" class="{CLASS}">
	<form action="{CURRENT_URL}" method="post" name="prod{PRODUCT_ID}">
	<input type="button" value="{BTN_MORE}" onclick="window.location.href='index.php?act=viewProd&amp;productId={PRODUCT_ID}'" /></form>	<br />
		<!-- BEGIN: video_button -->
		<div style="margin-top: 2px;"><a href="index.php?act=viewProd&amp;productId={PRODUCT_ID}#video" target="_self" class="videoBtn" title="Se produktvideo"> </a></div>
		<!-- END: video_button -->
	</td>
	<!-- ### STOP ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz -->
</tr>
<!-- END: products -->
</table>
<!-- END: productTable -->
<!-- BEGIN: noProducts -->
<div>{TXT_NO_PRODUCTS}</div>
<!-- END: noProducts -->

<div class="pagination">{PAGINATION}</div>
</div>
<!-- END: view_cat -->