<!-- BEGIN: view_prod -->


<!-- Product Images Mod start -->
<script language="JavaScript">
  <!--
	function change_preview_image(file_name) 
	{
		document.images['preview'].src = file_name;
	}
  //-->
</script>
<!-- Product Images Mod end -->
 <div class="boxContent"> 
  <!-- BEGIN: prod_true --> 
  <strong>{LANG_DIR_LOC}</strong> 
  {CURRENT_DIR} 
  <form action="{CURRENT_URL}" method="post" name="addtobasket" target="_self"> 
     <p><h1 class="txtContentTitle">&raquo; 
       {TXT_PRODTITLE} 
       </h1></p> 
<!-- Product Images Mod start -->
	<table border="0" cellspacing="0" cellpadding="0" align="center">
	<tr valign="top">
	<td>
		<img src="{IMG_SRC}" alt="{TXT_PRODTITLE}" id="img_preview" name="preview" style="border: 1px solid #CCCCCC;" />
		<br />
		<br />
		
		<!-- ### START ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz -->
	<!-- BEGIN: show_video -->
	<a name="video" id="video" style="text-decoration: none">&nbsp;</a>
	<p><!--<strong>{TXT_VIDTITLE}</strong> -->
	<!-- BEGIN: embed_youTube --><br />
	Afspil video</p>
	<div align="center">{EMBED_YOUTUBE}</div><!-- END: embed_youTube -->
	<!-- BEGIN: download_video -->
	<br clear="all" />
	<div style="margin-top: 20px; padding: 3px; background-color: #FFFFFF; border: 1px solid #cacaca;">
	<div style="float: left; margin-right: 3px;"><a href="{FILENAME}" target="_blank" title="Download copi af denne video til din PC" class="videoBtn"> </a></div>
	<span class="txtDefault"><strong>Download video?</strong></span>
	<br /><span class="txtDefault">Click here to open a video in your default player!</span>
	</div>
	<!-- END: download_video -->
	<!-- END: show_video -->
	<!-- ### STOP ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz -->

	</td>
	<!-- BEGIN: more_images -->
	<td>
		<div style="text-align: center; padding: 0 20px; margin-bottom: 5px;">{LANG_MORE_IMAGES_2}</div>
		<!-- BEGIN: repeat_thumbs -->
		<div style="text-align: center; padding: 0 20px; margin-bottom: 10px;">
			<a href="javascript:change_preview_image('{VALUE_SRC}')"><img src="{VALUE_THUMB_SRC}" {VALUE_THUMB_WIDTH} alt="{TXT_PRODTITLE}" border="0" style="border: 1px solid #CCCCCC;" /></a>
		</div>
		<!-- END: repeat_thumbs -->
	</td>
	<!-- END: more_images -->
	</tr>
	</table>
	<!-- Product Images Mod end -->
	<!-- ### START ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz -->
	<!-- <div style="display: {VISIBILITY}">  -->
	<!-- <a href="#video" class="txtDefault"><span style="font-size: large">&raquo;</span> View a video of this product!</a>  -->
	<!-- </div  >-->
	<!-- ### STOP ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz  -->
 
      <br /> 
     <strong class="prodInfo">&raquo; {LANG_PRODINFO}</strong> 
     <br />
 
 
    <div class="prodDescription">{TXT_DESCRIPTION}</div> 
     <br /> 
	<!-- BEGIN: show_discount_group -->
	<p>
		<strong>{LANG_GROUP}:</strong> {TXT_GROUP_NAME}<br />
		<strong>{LANG_YOUSAVE}:</strong> {TXT_DISCOUNT} %
	</p>      
	<!-- END: show_discount_group -->
     <p><strong class="prodInfo">&raquo; {LANG_PRICE}</strong> 
      <span style="font-size:16px; font-weight:bold;">{TXT_PRICE} </span>
      <span class="txtProductSale">{TXT_SALE_PRICE}</span>
	  <br /><br />
     <!-- BEGIN: buy_btn --> 
    <div style="position: relative; text-align: left;"> 
      {LANG_QUAN} 
      <input name="quan" type="text" value="1" size="2" class="textbox" style="text-align:center;" /> 
      <input name="Submit" type="submit" class="button" value="{BTN_ADDBASKET}" />
    </div> 
     <!-- END: buy_btn --> 
      </p> 
	 <!-- BEGIN: prod_opts --> 
     <strong class="prodInfo">&raquo; {TXT_PROD_OPTIONS}</strong> 
     <div class="prodDescription"> 
      <table border="0" cellspacing="0" cellpadding="3"> 
         <!-- BEGIN: repeat_options --> 
         <tr> 
          <td>
          <strong>{VAL_OPTS_NAME}</strong>
          </td> 
          <td><select name="productOptions[]"> 
              <!-- BEGIN: repeat_values --> 
              <option value="{VAL_ASSIGN_ID}"> 
              {VAL_VALUE_NAME} 
              <!-- BEGIN: repeat_price --> 
              ( 
              {VAL_OPT_SIGN} 
              {VAL_OPT_PRICE} 
              )
              <!-- END: repeat_price --> 
              </option> 
              <!-- END: repeat_values --> 
            </select></td> 
        </tr> 
         <!-- END: repeat_options --> 
       </table> 
    </div> 
     <br /> 
     <!-- END: prod_opts --> 
	<!-- Manufacturers mod by convict http://cubecartmods.eu START -->
	<!-- BEGIN: manufacturer -->
	<strong>{MANUFACTURER_LANG}</strong>: {MANUFACTURER_VAL}<br/>
	<!-- END: manufacturer -->
	<!-- Manufacturers mod by convict http://cubecartmods.eu START -->
     <strong class="prodInfo">&raquo; {LANG_PRODCODE} </strong>
     <strong>{TXT_PRODCODE}</strong> 
     {TXT_INSTOCK} 
     <span class="txtOutOfStock">{TXT_OUTOFSTOCK}&nbsp;</span><br /><br /> 
	 &nbsp;&nbsp;&nbsp;<div id="fb-root"></div><script src="https://connect.facebook.net/da_DK/all.js#appId=139460452814863&amp;xfbml=1"></script><fb:like href="https://www.nyah-beauty.com/index.php?act=viewProd&amp;productId={PRODUCT_ID}" send="false" width="450" show_faces="false" action="like" font=""></fb:like>
	 <br />
     <br />
     <ul> 
      <li class="bulletLrg"><a href="index.php?act=taf&amp;productId={PRODUCT_ID}" target="_self" class="txtDefault"> 
        {LANG_TELLFRIEND} 
        </a></li> 
    </ul>
	
	<!-- start mod Related Items -->
	<table cellpadding="0" cellspacing="0" border="0" align="center">
	<tr valign="top">
	<!-- BEGIN: related_prods_true -->
	<td>
		<div style="text-align: center; padding: 0 10px; margin-bottom: 5px;">{TXT_RELATED_PRODUCTS}</div>
		
		
		<!-- BEGIN: repeat_related_prods -->
		<div class="related">
		<h3><a href="{VALUE_RELATED_LINK}" class="txtDefault">{VALUE_RELATED_NAME}</a></h3>
		<br/>
			<a href="{VALUE_RELATED_LINK}"><img src="{VALUE_RELATED_THUMB}" {VALUE_THUMB_WIDTH} alt="{VALUE_RELATED_NAME}" title="{VALUE_RELATED_NAME}" border="0" /></a>
		</div>
		<!-- END: repeat_related_prods -->
		
		
	</td>
	<!-- END: related_prods_true -->
	</tr>
	</table>
<!-- end mod Related Items -->
<br />
     <input type="hidden" name="add" value="{PRODUCT_ID}" /> 
   </form> 
	
  <!-- END: prod_true --> 
  
  
<!-- BEGIN: prod_also --><!-- >> Customer Also Bouught by convit http://cubecart-mods-skins.com >> -->
<br /><br /><strong>{CPA_TXT}:</strong>
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="tblList">
 <!-- BEGIN: repeat_prod -->
 <tr>
  <!-- BEGIN: prod_image --><td class="{CLASS}" align="center"><a href="index.php?act=viewProd&amp;productId={CPA_PRODID}" target="_self"><img src="{CPA_PRODIMAGE}" alt="{CPA_PRODNAME}" border="0" title="{CPA_PRODNAME}" /></a></td> <!-- END: prod_image -->
  <td class="{CLASS}"><a href="index.php?act=viewProd&amp;productId={CPA_PRODID}" target="_self" class="txtDefault"><strong>{CPA_PRODNAME}</strong></a><!-- BEGIN: prod_desc --><br />{CPA_PROD_DESC}<!-- END: prod_desc -->
  </td>
  <!-- BEGIN: prod_cat --><td class="{CLASS}">{CPA_PRODCAT}</td> <!-- END: prod_cat -->
  <!-- BEGIN: prod_price --><td class="{CLASS}" align="right">{CPA_PRICE}<div class="txtSale">{CPA_SALE_PRICE}</div></td> <!-- END: prod_price -->
  <!-- BEGIN: prod_buy --><td class="{CLASS}"><!-- BEGIN: prod_buy2 --><form action="{CURR_URL}" method="post" name="p{CPA_PRODID}" target="_self">
	<input type="hidden" name="add" value="{CPA_PRODID}" />
	<input type="hidden" name="quan" value="1" /><a href="javascript:submitDoc('p{CPA_PRODID}');" target="_self" class="txtButton">{BTN_BUY}</a><!-- END: prod_buy2 --></form>
  </td><!-- END: prod_buy -->
  <!-- BEGIN: prod_more --><td class="{CLASS}" align="right"><a href="index.php?act=viewProd&amp;productId={CPA_PRODID}" target="_self" class="txtButton">{BTN_MORE}</a></td> <!-- END: prod_more -->
 </tr>
 <!-- END: repeat_prod -->
</table><!-- << Customer Also Bouught by convit http://cubecart-mods-skins.com << -->
<!-- END: prod_also -->  
  <!-- BEGIN: prod_false --> 
  <p>{LANG_PRODUCT_EXPIRED}</p> 
  <!-- END: prod_false --> 
</div> 
{REVIEW_CONTENT}
<!-- END: view_prod --> 
