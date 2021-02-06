<!-- BEGIN: confirmation -->
<div class="boxContent">
	
	<span class="txtContentTitle">{LANG_CONFIRMATION_SCREEN}</span>
	
	<!-- BEGIN: session_true -->
	<div>
		<div style="text-align: center; height: 25px;">
			<div class="cartProgress">
			{LANG_CART} &raquo; {LANG_ADDRESS} &raquo; {LANG_PAYMENT} &raquo; <span class='txtcartProgressCurrent'>{LANG_COMPLETE}</span>
			</div>
		</div>
		<!-- BEGIN: order_success -->
		<p>{LANG_ORDER_SUCCESSFUL}</p>
			<!-- BEGIN: analytics -->
			<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
			</script>
			<script type="text/javascript">
			_uacct = "UA-1188757-1";
			urchinTracker();
			</script>			
			<script language="JavaScript" src="__utmSetTrans()">
			<form style="display:none;" name="utmform">
			<textarea id="utmtrans">UTM:T|{VAL_ORDER_ID}|Nyah-Beauty|{VAL_TOTAL}|0|{VAL_SHIPPING}|{VAL_CITY}|copenhagen|Danmark
			UTM:I|{VAL_ORDER_ID}|{VAL_PROD_NAME}|{VAL_CAT}|{VAL_PRICE}|{VAL_QTY}
			</textarea>
			</form>
			<!-- END: analytics -->
		
		<!-- BEGIN: aff_track -->
		{AFFILIATE_IMG_TRACK}
		<!-- END: aff_track -->
		<!-- END: order_success -->
		
		<!-- BEGIN: order_failed -->
		<p><H3>{LANG_ORDER_FAILED}</H3></p>
		<p><H3>{LANG_ORDER_RETRY}</H3></p>
		<div style="text-align: center; padding: 10px;"><a href="cart.php?act=step4"  class="txtCheckout">{LANG_RETRY_BUTTON}</a></div>
		<!-- END: order_failed -->
	</div>
	<!-- END: session_true -->
	
	<!-- BEGIN: session_false -->
	<p>{LANG_LOGIN_REQUIRED}</p>
	<!-- END: session_false -->
			
</div>
<!-- END: confirmation -->