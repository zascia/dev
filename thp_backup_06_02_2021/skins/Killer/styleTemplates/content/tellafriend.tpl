<!-- BEGIN: tellafriend -->
<div class="boxContent">

	<span class="txtContentTitle">{TAF_TITLE}</span>
	
	<p>{TAF_DESC}</p>
	
		<form action="index.php?act=taf&amp;productId={PRODUCT_ID}" target="_self" method="post">
			<table border="0" cellspacing="0" cellpadding="3" align="center">
				<tr>
					<td align="right"><strong>{TXT_RECIP_NAME}</strong></td>
					<td><input type="text" name="recipName" class="textbox" /></td>
				</tr>
				<tr>
					<td align="right"><strong>{TXT_RECIP_EMAIL}</strong></td>
					<td><input type="text" name="recipEmail" class="textbox" /></td>
				</tr>
				<tr>
					<td align="right"><strong>{TXT_SENDER_NAME}</strong></td>
					<td><input type="text" name="senderName" class="textbox" value="{VAL_SENDER_NAME}" /></td>
				</tr>
				<tr>
					<td align="right"><strong>{TXT_SENDER_EMAIL}</strong></td>
					<td><input type="text" name="senderEmail" class="textbox" value="{VAL_SENDER_EMAIL}" /></td>
				</tr>
				<tr>
					<td align="right" valign="top"><strong>{TXT_MESSAGE}</strong></td>
					<td><textarea name="message" cols="30" rows="5" class="textbox">{VAL_MESSAGE}</textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input name="submit" type="submit" value="{TXT_SUBMIT}" class="submit" /></td>
				</tr>
		</table>
	</form>

</div>
<!-- END: tellafriend -->