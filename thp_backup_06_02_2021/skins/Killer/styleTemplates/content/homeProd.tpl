<!-- BEGIN: view_prod -->
<div class="boxContent">
<strong><center><H3 style="color:#0000A0">{HPP_HEAD} - 20. december</H3></center></strong><br />
	<form action="{CURRENT_URL}" method="post" name="addtobasket" target="_self">
	
	<p class="txtContentTitle"><strong>{TXT_PRODTITLE}</strong></p>
	<div style="text-align: center;"><img src="{IMG_SRC}" alt="{TXT_PRODTITLE}" border="0" title="{TXT_PRODTITLE}" /></div>
	<!-- BEGIN: more_images -->
	<div style="text-align: center;"><a href="javascript:openPopUp('extra/prodImages.php?productId={PRODUCT_ID}', 'images', 548, 455, 0);" class="txtDefault">{LANG_MORE_IMAGES}</a></div>
	<!-- END: more_images -->
	<p>
		<strong>{LANG_PRODINFO}</strong>
	
		<br />
		
	  {TXT_DESCRIPTION}	</p>      
	
	<p>
		<h3><strong><img style="margin-left:20px;" src="http://www.nyah-beauty.com/images/ethnic_christmasGirl.jpg" alt="Gl�delig Jul" border="0" />{LANG_PRICE}</strong> {TXT_PRICE} 
	  <span class="txtSale">{TXT_SALE_PRICE}</span></h3>
	</p>      
	
	
	<!-- BEGIN: prod_opts -->
	<br />
	<strong>{TXT_PROD_OPTIONS}</strong>
	<table border="0" cellspacing="0" cellpadding="3">
		<!-- BEGIN: repeat_options -->
		<tr>
			<td><strong>{VAL_OPTS_NAME}</strong></td>
			<td>
				<select name="productOptions[]">
					<!-- BEGIN: repeat_values -->
					<option value="{VAL_ASSIGN_ID}">
					{VAL_VALUE_NAME}
					<!-- BEGIN: repeat_price -->
					({VAL_OPT_SIGN}{VAL_OPT_PRICE})
					<!-- END: repeat_price -->
					</option>
					<!-- END: repeat_values -->
				</select>
			</td>
		</tr>
		<!-- END: repeat_options -->
	</table>
	<!-- END: prod_opts -->
	<br />

	<strong>{LANG_PRODCODE}</strong> {TXT_PRODCODE} 

	<div>
	{TXT_INSTOCK}<span class="txtOutOfStock">{TXT_OUTOFSTOCK}</span>
	
    <!-- BEGIN: buy_btn -->
	<div style="position: relative; text-align: right;">{LANG_QUAN} 
	<input name="quan" type="text" value="1" size="2" class="textbox" style="text-align:center;" />
	<a href="javascript:submitDoc('addtobasket');" class="txtButton">{BTN_ADDBASKET}</a>
	</div>
	<!-- END: buy_btn -->
	</div>  
<input type="hidden" name="add" value="{PRODUCT_ID}" />
</form>
</div>
<!-- END: view_prod -->