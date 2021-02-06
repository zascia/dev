<!-- BEGIN: view_reviews -->
<div class="boxContent">
<table width="100%">
<tr>
	<td valign="top"><strong>{TXT_BOX_TITLE}</strong><img src="images/general/stars_{VAL_OVERALL_STARS}.gif"></td>
	<td valign="top">{TXT_OVERALL_STARS}</td>
	<td align="right" nowrap="1" valign="top">
<!-- BEGIN: add_review_button -->
		{TXT_BE1ST_TO_REVIEW}
	<form action="{CURRENT_URL}" method="post" name="addreview" target="_self">
		<input type="hidden" name="act" value="addReview" />
	<a href="{TXT_HREF_URL}" class="txtviewCart"><font size="1">{BTN_SUBMIT_REVIEW}</font></a>
	</form>
<!-- END: add_review_button-->
	</td>
	</tr>
	</table>
<br clear="all" />
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="tblList">
 <!-- BEGIN: review_loop -->
  <tr>
    <td align="center" class="{CLASS}" width="10%">
    <img src="images/general/stars_{VAL_STARS}.gif">
    </td>
    <td valign="top" class="{CLASS_QUOTE}" ><strong>{VAL_REVIEW_QUOTE}</strong></td>
</tr>
  <tr>
    <td align="center" class="{CLASS}" width="10%">
    {TXT_NAME}<br />{TXT_DATE}
    </td>
    <td valign="top" class="{CLASS}" >{VAL_REVIEW}</td>
</tr>
<!-- END: review_loop -->

</table>
</div>
<!-- END: view_reviews -->
<!-- BEGIN: write_review -->
<div class="boxContent">
<form action="{CURRENT_URL}" method="post" name="savereview" target="_self">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="tblList">
<tr>
	<td valign="top"><strong>{TXT_BOX_TITLE}</strong></td><td>{TXT_REVIEW_QUOTE}<br />
	<input type="text" name="review_quote" size="45" maxsize="60"></td>
</tr>
<tr>
    <td align="center" class="{CLASS}" width="10%">{TXT_REVIEW_RATING}</td>
    <td class="{CLASS}" width="10%">{TXT_YOUR_REVIEW}</td>
    
  <tr>
    <td align="center" class="{CLASS}" width="10%">
    <img src="images/general/stars_5.gif"><input name="product_rating" value="5" type="radio" checked="checked"><br />
    <img src="images/general/stars_4.gif"><input name="product_rating" value="4" type="radio"><br />
    <img src="images/general/stars_3.gif"><input name="product_rating" value="3" type="radio"><br />
    <img src="images/general/stars_2.gif"><input name="product_rating" value="2" type="radio"><br />
    <img src="images/general/stars_1.gif"><input name="product_rating" value="1" type="radio"><br />
    </td>
    <td valign="top" class="{CLASS}" ><textarea name="review" cols="34" rows="5"></textarea></td>
</tr>
<tr>
	<td align="right" colspan="2">
		<input type="hidden" name="act" value="saveReview" />
		<input type="hidden" name="product_id" value="{VAL_PRODUCT_ID}" />
		<input type="hidden" name="reviewer_id" value="{VAL_REVIEWER_ID}" />
	<a href="javascript:submitDoc('savereview');" class="txtviewCart"><font size="1">{BTN_SAVE_REVIEW}</font></a>
</td>
</tr>
</table>
</div>
</form>
<!-- END: write_review -->
<!-- BEGIN: first_review -->
<div class="boxContent">
	<form action="{CURRENT_URL}" method="post" name="gotoreview" target="_self">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="tblList">
<tr>
	<td>
		{TXT_BE1ST_TO_REVIEW}
	</td>
	<td align="right">
		<input type="hidden" name="act" value="addReview" />
	<a href="javascript:submitDoc('gotoreview');" class="txtviewCart"><font size="1">{BTN_SUBMIT_REVIEW}</font></a>
</td>
</tr>
</table>
</form>
</div>
<!-- END: first_review -->
<!-- BEGIN: login_to_review -->
<div class="boxContent">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="tblList">
<tr>
	<td align="right">
	<a href="index.php?act=login&amp;redir={VAL_SELF}" class="txtButton">{BTN_LOGIN_TO_REVIEW}</a>
</td>
</tr>
</table>
</div>
<!-- END: login_to_review -->
<!-- BEGIN: thanks_review -->
<div class="boxContent">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="tblList">
<tr>
	<td>
		{TXT_REVIEW_THANKYOU}
	</td>
</tr>
</table>
</div>
<!-- END: thanks_review -->
