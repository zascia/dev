<!-- BEGIN: account -->
<div class="boxContent">
	
	<span class="txtContentTitle">{LANG_YOUR_ACCOUNT}</span>
	
	<!-- BEGIN: session_true -->
	<div style="margin-left: 120px;">	
		<ul>
			<li class="account"><a href="index.php?act=profile" class="txtDefault">{TXT_PERSONAL_INFO}</a></li>
			<li class="account"><a href="cart.php?act=viewOrders" class="txtDefault">{TXT_ORDER_HISTORY}</a></li>
			<li class="account"><a href="index.php?act=changePass" class="txtDefault">{TXT_CHANGE_PASSWORD}</a></li>
			<!-- <li class="account"><a href="index.php?act=newsletter" class="txtDefault">{TXT_NEWSLETTER}</a></li>-->
		</ul>
	</div>
	<!-- END: session_true -->
	
	<!-- BEGIN: session_false -->
	<p>{LANG_LOGIN_REQUIRED}</p>
	<!-- END: session_false -->
			
</div>
<!-- END: account -->