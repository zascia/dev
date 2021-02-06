<!-- BEGIN: reg -->
<div class="boxContent">
	<!-- <div style="padding-bottom: 3px;"><span class="txtContentTitle">{LANG_REGISTER}</span> -->
	<!-- BEGIN: quick_checkout -->
	<div style="position: relative; float: left; width: 49%; margin-top: 5px;">
	<fieldset>
		<legend class="txtContentTitle">{LANG_LOGIN_TITLE}</legend>
			{LANG_LOGIN_BELOW}<br /><br />
			<form name="clogin" action="index.php?act=login&redir={VAL_SELF}" target="_self" method="post">
				<table border="0" cellspacing="0" cellpadding="3">
					<tr>
						<td align="right"><strong>{LANG_USERNAME}</strong></td>
						<td><input type="text" name="username" class="textbox" value="{VAL_USERNAME}" size="16" /></td>
					</tr>
					<tr>
						<td align="right"><strong>{LANG_PASSWORD}</strong></td>
						<td><div id="pass"><input type="password" name="password" class="textbox" size="16" /></div></td>
					</tr>
					<tr>
						<td colspan="2" align="right"><input name="submit" type="submit" value="{TXT_LOGIN}" class="txtButton" /></td>
					</tr>
			  </table>
			</form>
	</fieldset></div>
	<div style="position: relative; float: right; width: 49%; margin-top: 5px;">
	<fieldset>
	<legend class="txtContentTitle">{LANG_CONT_SHOPPING}</legend>
	{LANG_CONT_SHOPPING_DESC}<br /><br />
	<a href="index.php" class="txtButton">{LANG_CONT_SHOPPING_BTN}</a>
	</fieldset></div>
	<br clear="left" />
	<!-- END: quick_checkout -->
	<!-- BEGIN: no_error -->
	<p>{LANG_REGISTER_DESC}</p>
	<!-- END: no_error -->
	<!-- BEGIN: error -->
	<p class="txtError">{VAL_ERROR}</p>
	<!-- END: error -->
	<form name="registerForm" method="post" action="{VAL_ACTION}" autocomplete="on">
	<table  border="0" cellspacing="0" cellpadding="3" width="100%">
	  <tr>
		<td colspan="2" class="tdcartTitle">{LANG_PERSONAL_DETAILS}</td>
		<td colspan="2" class="tdcartTitle">{LANG_ADDRESS}</td>
	  </tr>
	  <tr>
	    <td width="21%"></td>
	    <td width="29%"><input name="title" type="hidden" class="textbox" id="title" size="5" value="{VAL_TITLE}" />	      </td>
	    <td>&nbsp;</td>
		<td></td>
	    </tr>
	  <tr>
		<td>{LANG_FIRST_NAME}</td>
		<td><input name="firstName" type="text" class="textbox" id="firstName" size="16" value="{VAL_FIRST_NAME}"/> 
		  *</td>
		<td>&nbsp;</td>
		<td></td>
	  </tr>
	  <tr>
		<td>{LANG_LAST_NAME}</td>
		<td><input name="lastName" type="text" class="textbox" id="lastName" size="16" value="{VAL_LAST_NAME}" /> 
		  * </td>
		<td width="23%">{LANG_ADDRESS_FORM}</td>
	    <td width="27%"><input name="add_1" type="text" class="textbox" id="add_1" size="16" value="{VAL_ADD_1}" />
        *	  </tr>
	  <tr>
		<td>{LANG_EMAIL_ADDRESS}</td>
		<td><input name="email" type="email" class="textbox" id="email" size="16" value="{VAL_EMAIL}" /> 
		  * </td>
		<td></td>
		<td><input name="add_2" type="text" class="textbox" id="add_2" size="16" value="{VAL_ADD_2}" />
		<input name="county" type="hidden" class="textbox" id="county" size="16" value="-"  /></td>
	  </tr>
	  <tr>
		<td>{LANG_MOBILE}</td>
		<td><input name="phone" type="tel" class="textbox" id="phone" size="16" value="{VAL_PHONE}"  /> 
		  * </td>
			<td>{LANG_POSTCODE}/{LANG_TOWN}</td>
			<td><input name="postcode" type="tel" class="textbox" id="postcode" size="5" value="{VAL_POSTCODE}"  />
			<input name="town" type="text" class="textbox" id="town" size="13" value="{VAL_TOWN}"  />
*</td>
	  </tr>
	  <tr>
		<td>{LANG_TELEPHONE}</td>
		<td><input name="mobile" type="tel" class="textbox" id="mobile" size="16" value="{VAL_MOBILE}"  /></td>
	    <td>{LANG_COUNTRY}</td>
	    <td nowrap='nowrap'><select name="country" class="textbox" >
          <!-- BEGIN: repeat_countries -->
          <option value="{VAL_COUNTRY_ID}" {VAL_COUNTRY_SELECTED}>{VAL_COUNTRY_NAME}</option>
          <!-- END: repeat_countries -->
        </select></td>
	  </tr>
	  <tr>
		<td colspan="4" class="tdcartTitle">{LANG_SECURITY_DETAILS}</td>
	  </tr>
	  <tr>
		<td>{LANG_CHOOSE_PASSWORD}</td>
		<td><input name="password" type="password" class="textbox" id="password" size="16" value="{VAL_PASSWORD}" /> 
		  * </td>
		<td>{LANG_CONFIRM_PASSWORD}</td>
		<td><input name="passwordConf" type="password" class="textbox" id="passwordConf" size="16" value="{VAL_PASSWORD_CONF}" /> 
		  * </td>
	  </tr>
	  <tr>
		<td colspan="4" class="tdcartTitle">{LANG_PRIVACY_SETTINGS}</td>
	  </tr>
	  <tr>
		<td colspan="2">
		  <input type="checkbox" name="optIn1st"  value="" />
		  Ja tak, Jeg vil gerne modtage nyhedsmailen med tips, nyheder og tilbud fra Nyah-Beauty.</td>
		<td></td>
		<td>
		<input name="htmlEmail" type="hidden" value="1">   </td>
	  </tr>
	  <tr>
		<td colspan="4"><input type="checkbox" value="" />
		  {LANG_PLEASE_READ} <a target="_blank" href="../index.php?act=viewDoc&docId=3">{LANG_TANDCS}</a></td>
		</tr>
	  <tr>
		<td colspan="4">&nbsp;</td>
		</tr>
	  <tr>
		<td colspan="4" align="right"><a href="javascript:submitDoc('registerForm');" class="txtCheckout" >{LANG_REGISTER_SUBMIT}</a></td>
		</tr>
	</table>

	</form>
</div>
<!-- END: reg -->