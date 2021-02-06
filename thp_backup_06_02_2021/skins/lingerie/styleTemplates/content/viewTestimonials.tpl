<!-- BEGIN: view_testimonials -->
<div class="boxContent">
<table width="100%">
<tr>
	<td><strong>{TXT_TITLE}<br/></strong>{TXT_SUBTITLE}</td>
	<td align="right" valign="top" nowrap="1">
<!-- BEGIN: add_testimonial_button -->
	<form action="{CURRENT_URL}" method="post" name="addtestimonial" target="_self">
		<input type="hidden" name="act" value="addTestimonial" />
	<a href="{TXT_HREF_URL}" class="txtviewCart"><font size="1">{BTN_SUBMIT_TESTIMONIAL}</font></a>
	</form>
<!-- END: add_testimonial_button-->
	</td>
	</tr>
	</table>
<br clear="all" />
<div class="pagination">{PAGINATION}</div>
<table border="1" width="100%" cellspacing="0" cellpadding="3" class="tblList">
 <!-- BEGIN: testimonial_loop -->
  <tr>
    <td valign="top" class="{CLASS}" width="20%" align="center"><strong>{VAL_FIRSTNAME}</strong><br/><span class="txtCopyright">{VAL_CITY}{VAL_COUNTY}<br/>{VAL_DATE}</span></td>
  <td height="1" valign="top" class="{CLASS}"><span class="{CLASS_QUOTE}"><strong>{VAL_TESTIMONIAL_QUOTE}</strong></span><br/><span class="{CLASS}">{VAL_TESTIMONIAL}</span></td>
 </tr>
<!-- END: testimonial_loop -->
</table>
<div class="pagination">{PAGINATION}</div>
</div>
<!-- END: view_testimonials -->
<!-- BEGIN: write_testimonial -->
<div class="boxContent">
<form action="{CURRENT_URL}" method="post" name="saveTestimonial" target="_self">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="tblList">
<tr>
	<td valign="top"><strong>{TXT_BOX_TITLE}</strong></td><td>{TXT_TESTIMONIAL_QUOTE}<br/>
	<input type="text" name="review_quote" size="40" maxsize="50"><br/>
	{TXT_TESTIMONIAL}<br/>
	<textarea name="review" rows="3" cols="30"></textarea>
	</td>
</tr>
<tr>
	<td align="right" colspan="2">
		<input type="hidden" name="act" value="saveTestimonial" />
		<input type="hidden" name="customer_id" value="{VAL_CUSTOMER_ID}" />
	<a href="javascript:submitDoc('saveTestimonial');" class="txtviewCart"><font size="1">{BTN_SAVE_TESTIMONIAL}</font></a>
</td>
</tr>
</table>
</form>
</div>
<!-- END: write_testimonial -->
<!-- BEGIN: thanks_testimonial -->
<div class="boxContent">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="tblList">
<tr>
	<td>
		{TXT_TESTIMONIAL_THANKYOU}
	</td>
</tr>
</table>
</div>
<!-- END: thanks_testimonial -->
