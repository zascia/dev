<!-- BEGIN: reg -->
<div class="boxContent">
	<div style="padding-bottom: 3px;"><span class="txtContentTitle">{LANG_REGISTER}</span> 
	<!-- BEGIN: no_error -->
	<p>Express checkout</p>
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
	    <td></td>
	    <td><input name="title" type="hidden" class="textbox" id="title" size="5" value="{VAL_TITLE}" /> 
	      </td></tr>
							<tr>
		<td>{LANG_FIRST_NAME}</td>
		<td><input name="firstName" type="text" class="textbox" id="firstName" size="16" value="{VAL_FIRST_NAME}" /> 
		  *</td>
	  </tr>
			<tr>
		<td>{LANG_LAST_NAME}</td>
		<td><input name="lastName" type="text" class="textbox" id="lastName" size="16" value="{VAL_LAST_NAME}"  /> 
		  * </td></tr>
				<tr>
		<td>{LANG_EMAIL_ADDRESS}</td>
		<td><input name="email" type="email" class="textbox" id="email" size="16" value="{VAL_EMAIL}" /> 
		  * </td></tr>
				<tr>
		<td>{LANG_MOBILE}</td>
		<td><input name="phone" type="tel" class="textbox" id="phone" size="16" value="{VAL_PHONE}" /> 
		  * </td></tr>
							<tr>
	    <td>{LANG_ADDRESS_FORM}</td>
	    <td><input name="add_1" type="text" class="textbox" id="add_1" size="16" value="{VAL_ADD_1}"  />
*</td>
	    </tr>
					<tr>
					<td>&nbsp;</td>
				<td><input name="add_2" type="text" class="textbox" id="add_2" size="16" value="{VAL_ADD_2}" /> </td>	
	  
	  </tr>
			<tr>
		<td></td>
		<td></td>
	  </tr>
	  <tr>
		<td>{LANG_POSTCODE} / {LANG_TOWN}</td>
		<td><input name="postcode" type="tel" class="textbox" id="postcode" size="6" value="{VAL_POSTCODE}" />
		<input name="town" type="text" class="textbox" id="town" size="16" value="{VAL_TOWN}" />
		<input name="county" type="hidden" class="textbox" id="county" value="-"  />
*</td>
	  </tr>
	  <tr>
		<td>{LANG_COUNTRY}</td>
	    <td nowrap='nowrap'><select name="country" class="textbox" >
          <!-- BEGIN: repeat_countries -->
          <option value="{VAL_COUNTRY_ID}" {VAL_COUNTRY_SELECTED}>{VAL_COUNTRY_NAME}</option>
          <!-- END: repeat_countries -->
        </select>
		  *</td>
	  </tr>
	  <tr>
	    <td></td>
	    <td>
<input name="password" type="hidden" value="aa"/> 
<input name="passwordConf" type="hidden" value="aa" />
<input name="mobile" type="hidden" value="88888888" />
</td>
	  </tr>
	  <tr>
	    <td> </td>
		<td>{LANG_RECIEVE_EMAILS}
		  <input type="checkbox" name="optIn1st" value="1" checked="checked" {VAL_OPTIN1ST_CHECKED}/>
		</td>
	  </tr>
	  <tr>
	    <td> </td>
		<td>{LANG_EMAIL_FORMAT}	<select name="htmlEmail" class="textbox" >
		<option value="1">{LANG_HTML_FORMAT}</option>
		<option value="0" {VAL_HTMLEMAIL_SELECTED}>{LANG_PLAIN_TEXT}</option>
		</select>
	    </td></tr>
	  </tr>
	  <tr>
		<td colspan="4"></td>
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
</div>
<!-- END: reg -->