<!-- BEGIN: form -->
<p align="center">{LANG_INFO_TITLE}</p>
<input type='hidden' name='merchantnumber' value='{MERCHANT}' />
<input type='hidden' name='orderid' value='{ORDERID}' />
<input type='hidden' name='amount' value='{AMOUNT}' />
<input type='hidden' name='currency' value='{CURRENCY}' />
<input type='hidden' name='windowstate' value='0' />
<input type='hidden' name='language' value='{LANG}' />
<input type='hidden' name='accepturl' value='{AURL}' />
<input type='hidden' name='declineurl' value='{DURL}' />
<input type='hidden' name='addfee' value='{ADDFEE}' />
<input type='hidden' name='instantcapture' value='{INSTANT}' />
<input type='hidden' name='use3D' value='{3D}' />
<input type='hidden' name='subscription' value='{SUBSCRIBE}' />
<input type='hidden' name='cardtype' value='{ALLOWED}' />
<!-- BEGIN: authmail -->
<input type='hidden' name='authmail' value='{AUTHMAIL}' />
<!-- END: authmail -->
<!-- BEGIN: autsms -->
<input type='hidden' name='authsms' value='{AUTHSMS}' />
<!-- END: autsms -->
<!-- BEGIN: callback -->
<input type='hidden' name='callbackurl' value='{CALLBACK}' />
<!-- END: callback -->
<!-- BEGIN: md5 -->
<input type='hidden' name='md5key' value='{MD5}' />
<!-- END: md5 -->
<div>
	 <!-- BEGIN: repeat_cards -->	
		<div style="float: left; height: 70px; width: 100px">
		 <img src="modules/gateway/Betalingskort/{VAL_CARD_IMG}.gif" alt="{VAL_CARD_NAME}" /><br />
		 <input type="radio" name="precardtype" value="{VAL_CARD}" {CARD_SELECTED} />
		</div>
	<!-- END: repeat_cards -->
  <br clear="all" />	
</div>
<!-- END: form -->
