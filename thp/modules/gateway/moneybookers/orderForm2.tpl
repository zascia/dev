<!-- BEGIN: order_form -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{VAL_STORE_URL}</title>
<script type="text/javascript">
		
			function checkChar(obj)
			{
				if (isNaN(obj.value))
				{	
					obj.value = obj.value.substr(0, obj.value.length - 1);
					
					if(isNaN(obj.value))
						obj.value = "";
				}
				else
					return true;
			}
			
			function checkForm()
			{
				if(document.payment.orderid.value.length < 2)
				{
					alert("Ordreid skal angives!\nSkal være unikt.");
					document.payment.orderid.focus();
					return false;
				}
				
				var objAmount = document.payment.amount;
				var re = /,/g;
				var result = objAmount.value.replace(re, ".");
				
				objAmount.value = result;
				
				if(isNaN(objAmount.value) || objAmount.value.length < 1)
				{
					alert("Du mangler at angive dit beløb!");
					objAmount.focus();
					return false;
				}
				
				if(document.payment.cardno.value.length < 16)
				{
					alert("Du skal indtaste et gyldigt kortnummer!");
					document.payment.cardno.focus();	
					return false;
				}
				
				if(isNaN(document.payment.cvc.value) || document.payment.cvc.value.length != 3)
				{
					alert("Du mangler at angive dine kontrolcifre!");
					document.payment.cvc.focus();	
					return false;
				}
				
				//use this line to convert to minor units
				//var minorUnits = 100
				//var amount = parseFloat(objAmount.value) * minorUnits;
				
				document.payment.orderid.value = escape(document.payment.orderid.value);
				
				return true;
			}
			
		</script>
<meta http-equiv="Content-Type" content="text/html; charset={VAL_ISO}" />
<style type="text/css">
<!--
.copyText {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;}
.txtCopyright, a.txtCopyright {color:#FFFFFF; font-size: 6px;}
-->
</style>
</head>
<body>
<CENTER><table border="1" bordercolor="#999999">
<TR><TD>
<form action="https://ssl.ditonlinebetalingssystem.dk/auth/default.aspx"  method="post" name="payment" onSubmit="return checkForm()">

		<div align="center">
		  <p>&nbsp;</p>
		  <p><img src="../../../images/uploads/Nyah-logo_02.gif" /></p>
		  <p>&nbsp;</p>
		  <table cellspacing="0" cellpadding="2" border="0">
		    <tr>
		      <td>OrdreID :</td>
		      <td><input name="orderid" type="text" style="width: 180px" value="{VAL_CART_ORDER_ID}" maxlength="20" readonly="true"/></td>
		    </tr>
		    <tr>
		      <td>Beløb :</td>
  
			  <td><input name="totalprice" type="text" style="width: 180px;" value="{VAL_GRAND_TOTAL}" readonly="true"/></td>
		    </tr>
		    <tr>
		      <td>Kortnummer :</td>
		      <td><input type="text" name="cardno" maxlength="19" style="width: 180px" onKeyUp="return checkChar(this)" value="5555555555555000"/></td>
		    </tr>
		    
		    <tr>
		      <td>Udløbsdato :</td>
			    <td>
				    <select name="expmonth" style="width: 45px">
				      <option value="01">01</option>
				      <option value="02">02</option>
				      <option value="03">03</option>
				      
				      <option value="04">04</option>
				      <option value="05">05</option>
				      <option value="06">06</option>
				      <option value="07">07</option>
				      <option value="08">08</option>
				      <option value="09">09</option>
				      
				      <option value="10">10</option>
				      <option value="11">11</option>
				      <option value="12">12</option>
			        </select>&nbsp;<select name="expyear" style="width: 45px">
				        <option value="06">06</option>
				        <option value="07">07</option>
				        <option value="08">08</option>
				        <option value="09">09</option>
				        <option value="10">10</option>
				        <option value="11">11</option>
				        <option value="12">12</option>
				        <option value="13">13</option>
				        <option value="14">14</option>
				        <option value="15" SELECTED>15</option>
				        <option value="16">16</option>
				        <option value="17">17</option>
				        <option value="18">18</option>
				        <option value="19">19</option>
						<option value="20">20</option>
			          </select>		        </td>
		    </tr>
		    <tr>
		      <td>Kontrolcifre :</td>
			    <td><input type="text" name="cvc" maxlength="3" style="width: 93px" value="123" onKeyUp="return checkChar(this)"/> &laquo; <a href="http://www.betaling.dk/cgi-bin/betaling/over_go.pl?go=handel&article=kontrolcifre.htm" target="_blank">Hvad er det ?</a></td>
			</tr>
		    <tr>
		      <td>&nbsp;</td>
			    <td><br><input type="submit" value="BETAL" style="width: 140px"/></td>
		    </tr>
		    <tr>
		      <td colspan="2" align="center"><br/><a href="https://ssl.ditonlinebetalingssystem.dk/" title="Powered By ePay"><img src="https://ssl.ditonlinebetalingssystem.dk/images/powered_by/2.gif" width="64" height="53" border="0"/></a></td>
		    </tr>
	      </table>
		  <div align="center">
			<input type="hidden" name="amount" value="{EPAY_AMOUNT}"/>
		    <input type="hidden" name="merchantnumber" value="88888888"/>
		    <input type="hidden" name="currency" value="208"/>
		    <input type="hidden" name="debug" value="0"/>
		    <input type="hidden" name="accepturl" value="https://relay.ditonlinebetalingssystem.dk/relay/relay.cgi/nyah-beauty.com/godken"/>
		    <input type="hidden" name="declineurl" value="https://relay.ditonlinebetalingssystem.dk/relay/relay.cgi/nyah-beauty.com/annull"/>
          </div>
  </div>
</form></TR><td bordercolor="#000099"></TD>
<TR><TD><CENTER>
	<div style="margin: auto; width: 550px; border: 2px solid #cccccc; background-color:#FFFFFF;">

<p  class="copyText" style="font-size: 16px;">{LANG_THANK_YOU}</p>
<p  class="copyText">{LANG_SEND_TO} {VAL_STORE_ADDRESS}</p>
</div></CENTER></TD></TR>
</table></CENTER>
</body>
</html>
<!-- END: order_form -->