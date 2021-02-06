<!-- BEGIN: view_cart -->
<div class="boxContent">
			<span class="txtContentTitle">{LANG_VIEW_CART}</span></br></br>
			<div style="text-align: center; height: 25px;">
				<div class="cartProgress">
				<span {CLASS_STEP2}>{LANG_CART}</span> &raquo; <span {CLASS_STEP3}>{LANG_ADDRESS}</span> &raquo; {LANG_PAYMENT} &raquo; {LANG_COMPLETE}
				</div>
			</div>
			</br>
			<!-- <form action="{VAL_FORM_ACTION}" method="post" class="quickBuy" style="padding: 4px;">
			  {LANG_ADD_PRODCODE}
			  <input name="productCode" type="text" size="5" class="textbox" /> <input name="submit" type="submit" class="submit" value="{LANG_ADD}" /></form> -->
			  <!-- BEGIN: cart_false -->
			  <p>{LANG_CART_EMPTY}</p>
			  <!-- END: cart_false -->
			  <!-- BEGIN: cart_true -->
			  <form name="cart" method="post" id="cart" action="{VAL_FORM_ACTION}">
			  <!-- BEGIN: step_3 -->
			  <table width="100%"  border="0" cellspacing="0" cellpadding="3" style="margin-bottom: 10px;">
			  <tr>
				<td width="50%" class="tdcartTitle">{LANG_INVOICE_ADDRESS}</td>
				<td colspan="2" class="tdcartTitle">{LANG_DELIVERY_ADDRESS}</td>
				</tr>
			  <tr>
				<td width="50%">{VAL_TITLE} {VAL_FIRST_NAME} {VAL_LAST_NAME}</td>
				<td><strong>{TXT_TITLE}</strong></td>
				<td><input name="delInf[title]" type="text" class="textbox" id="title" value="{VAL_DEL_TITLE}" size="7" maxlength="30" /></td>
			  </tr>
			  <tr>
			    <td>{VAL_ADD_1}</td>
			    <td><strong>{TXT_FIRST_NAME}</strong></td>
			    <td><input name="delInf[firstName]" type="text" class="textbox" id="firstName" value="{VAL_DEL_FIRST_NAME}" maxlength="100" /></td>
			    </tr>
			  <tr>
			    <td>{VAL_ADD_2}</td>
			    <td><strong>{TXT_LAST_NAME}</strong></td>
			    <td><input name="delInf[lastName]" type="text" class="textbox" id="lastName" value="{VAL_DEL_LAST_NAME}" maxlength="100" /></td>
			    </tr>
			  <tr>
			    <td width="50%">{VAL_TOWN}</td>
			    <td><strong>{TXT_ADD_1}</strong></td>
			    <td><input name="delInf[add_1]" type="text" class="textbox" id="add_1" value="{VAL_DEL_ADD_1}" maxlength="100" /></td>
			  </tr>
			  <tr>
			    <td width="50%">{VAL_COUNTY}, {VAL_POSTCODE}</td>
			    <td><strong>{TXT_ADD_2}</strong></td>
			    <td><input name="delInf[add_2]" type="text" class="textbox" id="add_2" value="{VAL_DEL_ADD_2}" maxlength="100" /></td>
			  </tr>
			  <tr>
			    <td width="50%">{VAL_COUNTRY}</td>
			    <td><strong>{TXT_TOWN}</strong></td>
			    <td><input name="delInf[town]" type="text" class="textbox" id="town" value="{VAL_DEL_TOWN}" maxlength="100" /></td>
			  </tr>
			  <tr>
			    <td width="50%" rowspan="3" align="left" valign="bottom">
				<!-- BEGIN: change_invoice -->
				<a href="index.php?act=profile&amp;f={VAL_BACK_TO}" class="txtUpdate">{LANG_CHANGE_INV_ADD}</a>
				<!-- END: change_invoice -->
				</td>

			    <td><strong>{TXT_COUNTY}</strong></td>
			    <td><input name="delInf[county]" type="text" class="textbox" id="county" value="{VAL_DEL_COUNTY}" maxlength="100" /></td>
			  </tr>
			  <tr>
			    <td><strong>{TXT_POSTCODE}</strong></td>
			    <td><input name="delInf[postcode]" type="text" class="textbox" id="postcode" value="{VAL_DEL_POSTCODE}" maxlength="100" /></td>
			  </tr>
			  <tr>
			    <td><strong>{TXT_COUNTRY}</strong></td>
			    <td><select name="delInf[country]" id="country" class="textbox">
                  <!-- BEGIN: country_opts -->
                  <option value="{VAL_DEL_COUNTRY_ID}" {COUNTRY_SELECTED}>{VAL_DEL_COUNTRY_NAME}</option>
                  <!-- END: country_opts -->
                </select></td>
			  </tr>
			</table>
			<!-- END: step_3 -->
			<!-- BEGIN: step_4 -->
			  <table width="100%"  border="0" cellspacing="0" cellpadding="3" style="margin-bottom: 10px;">
			  <tr>
				<td width="50%" class="tdcartTitle">{LANG_INVOICE_ADDRESS}</td>
				<td class="tdcartTitle">{LANG_DELIVERY_ADDRESS}</td>
				</tr>
			  <tr>
				<td width="50%">{VAL_TITLE} {VAL_FIRST_NAME} {VAL_LAST_NAME}</td>
				<td>{VAL_DEL_TITLE} {VAL_DEL_FIRST_NAME} {VAL_DEL_LAST_NAME}</td>
				</tr>
			  <tr>
			    <td>{VAL_ADD_1}</td>
			    <td>{VAL_DEL_ADD_1}</td>
			    </tr>
			  <tr>
			    <td>{VAL_ADD_2}</td>
			    <td>{VAL_DEL_ADD_2}</td>
			    </tr>
			  <tr>
			    <td width="50%">{VAL_TOWN}</td>
			    <td>{VAL_DEL_TOWN}</td>
			    </tr>
<tr>
			    <td width="50%">{VAL_COUNTY} {VAL_POSTCODE}</td>
			    <td>{VAL_DEL_COUNTY} {VAL_DEL_POSTCODE}</td>
			    </tr>
							  <tr>
			    <td width="50%">{VAL_COUNTRY}</td>
			    <td>{VAL_DEL_COUNTRY}</td>
			    </tr>
			  <tr>
			    <td width="50%">
 <!-- BEGIN: change_invoice -->
<a href="index.php?act=profile&amp;f={VAL_BACK_TO}" class="{CLASSED}">{LANG_CHANGE_INV_ADD}</a>
<!-- END: change_invoice -->
</td>
			    <td>
				<!-- BEGIN: edit_btn -->
				<a href="cart.php?act=step3" class="txtUpdate">{LANG_CHANGE_DEL_ADD}</a>
				<!-- END: edit_btn -->
				</td>
			  </tr>
			</table>
			<!-- END: step_4 -->
			<br />
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td class="tdcartTitle">&nbsp;</td>
					<td align="center" class="tdcartTitle">{LANG_QTY}</td>
					<td align="center" class="tdcartTitle">&nbsp;</td>
					<td class="tdcartTitle">{LANG_PRODUCT}</td>
					<td class="tdcartTitle" align="right">{LANG_PRICE}</td>
					<td width="80" align="right" nowrap='nowrap' class="tdcartTitle">{LANG_LINE_PRICE}</td>
				</tr>
				<!-- BEGIN: repeat_cart_contents -->
				<tr>
					<td align="center" class="{TD_CART_CLASS}"><a href="cart.php?act={VAL_CURRENT_STEP}&amp;remove={VAL_PRODUCT_KEY}"><img src="skins/{VAL_SKIN}/styleImages/del.gif" alt="{LANG_DELETE}" width="12" height="12" border="0" title="{LANG_DELETE}" /></a></td>
					<td align="center" class="{TD_CART_CLASS}"><input name="quan[{VAL_PRODUCT_KEY}]" type="text" value="{VAL_QUANTITY}" size="2" class="{TEXT_BOX_CLASS}" style="text-align:center;" {QUAN_DISABLED} /></td>
					<td align="center" class="{TD_CART_CLASS}"><img src="{VAL_IMG_SRC}" alt="{VAL_PRODUCT_NAME}" title="{VAL_PRODUCT_NAME}" width="50px" height="34px" /></td>
					<td class="{TD_CART_CLASS}">
					
					<!-- start mod: Product Description on Checkout Pages -->
					<a href="index.php?act=viewProd&productId={VAL_PRODUCT_ID}">{VAL_PRODUCT_NAME}</a>
					<!-- end mod: Product Description on Checkout Pages -->
					
					<!-- BEGIN: options -->
					<br /><strong>{VAL_OPT_NAME}</strong>: {VAL_OPT_VALUE} 
					<!-- END: options -->
					</td>
					<td align="right" class="{TD_CART_CLASS}">{VAL_IND_PRICE}</td>
					<td width="80" align="right" class="{TD_CART_CLASS}">{VAL_LINE_PRICE}</td>
				</tr>
				<!-- BEGIN: stock_warn -->
				<tr>
				  <td align="center" class="{TD_CART_CLASS}">&nbsp;</td>
				  <td colspan="5" align="left" class="{TD_CART_CLASS}"><span class="txtStockWarn">{VAL_STOCK_WARN}</span></td>
			  	</tr>
				<!-- END: stock_warn -->
				<!-- END: repeat_cart_contents -->
				<tr>
					<td align="center" class="tdCartSubTotal"><img src="skins/{VAL_SKIN}/styleImages/del.gif" alt="{LANG_DELETE}" width="12" height="12" title="{LANG_DELETE}" /></td>
					<td colspan="3" class="tdCartSubTotal">- {LANG_REMOVE_ITEM}</td>
					<td align="right" class="tdCartSubTotal">{LANG_SUBTOTAL}</td>
					<td width="80" align="right" class="tdCartSubTotal">{VAL_SUBTOTAL}</td>
				</tr>
				<!-- BEGIN: coupon -->
				<tr>
				  <td colspan="5" align="right">{LANG_COUPON}<BR/>{VAL_COUPON}</td>
				  <td width="80" align="right">{VAL_COUPON_SAVING}</td>
			  	</tr>
				<!-- END: coupon -->
				<tr>
				  <td colspan="5" align="right">{LANG_TAX}</td>
				  <td width="80" align="right">{VAL_TAX}</td>
			  </tr>
			  </table>
			  
			  <table width="100%"  border="0" cellspacing="0" cellpadding="3">
				<tr>
					<!-- BEGIN: show_discount_group -->
				  <td align="left">
						<strong>{LANG_GROUP}:</strong> {TXT_GROUP_NAME}<br />
						<strong>{LANG_YOUSAVE}:</strong> {TXT_DISCOUNT} %
				  </td>
					<!-- END: show_discount_group -->
				  <td align="right">{LANG_SHIPPING}</td>
				  <td width="80" align="right">{VAL_SHIPPING}</td>
			  </tr>
			  </table>
			  <table width="100%"  border="0" cellspacing="0" cellpadding="3">
				<tr>
					<td align="right"><strong>{LANG_CART_TOTAL}</strong></td>
					<td width="80" align="right"><strong>{VAL_CART_TOTAL}</strong></td>
				</tr>
		  </table>
	<div style="float: left; line-height: 22px; margin-bottom: 3px;"><a href="javascript:submitDoc('cart');" class="txtUpdate">{LANG_UPDATE_CART}</a> {LANG_UPDATE_CART_DESC}</div>
	<br /><br /><br /><br />
	<!-- Quick Checkout by convict http://cubecartmods.eu START -->
<!-- BEGIN: quick_checkout_def -->
<script type="text/javascript">

function submitQ(step) {
var qch;
if (step==3) {
	qch=findObj('quick_checkout');
	qch.value=1;
	submitDoc('cart');
} else if(step==11) {
	window.location.replace("cart.php?act=reg&qch=1");
} else {
	window.location.replace("cart.php?act=step1");
}
}
</script>
	<input name="quick_checkout" type="hidden" value=""/><!-- END: quick_checkout_def -->
	<!-- BEGIN: quick_checkout -->
	<div style="float: left; margin-bottom: 3px;">{LANG_COMMENTS}<br /><textarea name="customer_comments" cols="40" rows="3" class="textbox">{VAL_CUSTOMER_COMMENTS}</textarea></div><br clear="all" />
	<!-- Quick Checkout by convict http://cubecartmods.eu END --><!-- END: quick_checkout -->	
	<!-- BEGIN: gateway -->
	<div style="text-align: center">
		<!-- BEGIN: choose_gate -->
		<p><b>{LANG_CHOOSE_GATEWAY}</b></p>
		<table width="200" border="0" align="center" cellspacing="3" cellpadding="3">
			<!-- BEGIN: gateways_true -->
			<tr>
				<td class="{TD_CART_CLASS}">{VAL_GATEWAY_DESC}</td>
			  	<td width="50" align="center" class="{TD_CART_CLASS}">
				<input name="gateway" type="radio" value="{VAL_GATEWAY_FOLDER}" {VAL_CHECKED} />
				</td>
			</tr>
			<!-- END: gateways_true -->
			<tr>
				<td colspan="2" align="left">{LANG_COMMENTS}</td>
		  	</tr>
			<tr align="center">
			  <td colspan="2"><textarea name="customer_comments" cols="40" rows="3" class="textbox">{VAL_CUSTOMER_COMMENTS}</textarea></td>
		  	</tr>
			<!-- BEGIN: gateways_false -->
			<tr>
				<td>{LANG_GATEWAYS_FALSE}</td>
			</tr>
			<!-- END: gateways_false -->
		</table>
		<!-- END: choose_gate -->
	</div>
	<!-- END: gateway --><!-- Quick Checkout by convict http://cubecartmods.eu END -->		  
<div style="text-align: right; margin-top: 4px; margin-bottom: 3px;"><a href="{CONT_VAL}" class="txtCheckout">{LANG_CHECKOUT}</a></div>
</form>
			<!-- END: cart_true -->
			
			<script>utmx_section("DiscountCode")</script>
			<!-- BEGIN: coupon_form -->
			<form action="{VAL_FORM_ACTION}" method="post" class="quickBuy" style="padding: 4px;">
			{LANG_ERROR_COUPONCODE} 
			{LANG_ADD_COUPONCODE} 
			<input name="coupon_code" type="text" size="20" class="textbox" /> <input name="submit" type="submit" class="submit" value="{LANG_ADD}" /></form> 
			<!-- END: coupon_form -->
			</noscript>
			
</div>
<!-- END: view_cart -->
