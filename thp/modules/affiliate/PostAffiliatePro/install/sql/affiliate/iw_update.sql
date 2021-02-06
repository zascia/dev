#= BEGIN ==================================================================#

delete from wd_pa_integration;
delete from wd_pa_integrationsteps;

insert into wd_pa_integration
values('general1',
'General solution', '',
'AffPlanet is compatible with nearly ALL merchant accounts, payment gateways, shopping carts and membership systems.<br/><br/><b>What integration means</b><br>
Integration is a way to connect the affiliate system to your current website, shopping cart or payment gateway in a way that affiliate system will
be notified about purchases. When notified, affiliate system registers the sale, finds referring affiliate (if any) and creates appropriate commission for him.
<br/><br/>
The general method of integration is putting an invisible image anywhere in the "thank you for order" or order confirmation page that is displayed to the customer
after the payment is processed.',
'This is all that is required. Now whenever there\'s sale, the sale tracking script sale.php is called, and it will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('general1', 'general1', 1,
'<b>Open your order confirmation or "thank you for order" page template, and put the following code somewhere onto the page</b>',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n<script type=\"text/javascript\"><!--\r\n\r\nvar TotalCost="XXXXXX.XX";\r\nvar OrderID="XXXXXX";\r\nvar ProductID="XXXXXX";\r\npapSale();\r\n--></script>',
'where the values XXXXXX should be replaced with correct values for:<br/>
<b>TotalCost</b> (mandatory for % commissions) - price of the product <br/>
<b>OrderID</b> (optional) - can be your unique generated order ID to cross-check the sale. <br/>
<b>ProductID</b> (optional) - the ID of the product bought.
<br/><br/>
All fields are optional, but without TotalCost system will be not able to compute percentage commissions.
<br/>
Also, ProductID is required if you plan to use <b>Force choosing commission by product ID</b> - this is available only in Pro version.
<br/><br/>
If you need to set total sale cost and order id, but you don\'t have access to their values in your "Thank you" page, the situation is more complicated.
There is no general solution for this. If you know that you can register sale in some other place, where those values (total cost and order id) are available, you can put the tracking code there.
Otherwise, consult us for advice and finding possible solution. ',
'english');


insert into wd_pa_integration
values('oscom01',
'osCommerce', '',
'Integration with osCommerce is made by placing sale tracking script into the confirmation page. To obtain the values of OrderID and TotalSale, snippet connects to osCommerce database and retrieves the values from there.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('oscom01', 'oscom01', 1,
'Find and open file <b>checkout_success.php</b>',
'',
'',
'english');


insert into wd_pa_integrationsteps
values('oscom02', 'oscom01', 2,
'Inside the file find this line <br>
<b><i>if ($global[\'global_product_notifications\'] != \'1\') {<br>
...
</i></b>',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('oscom03', 'oscom01', 3,
'insert the following code just above that line',
'  //--------------------------------------------------------------------------\n
  // integration code\n
  //--------------------------------------------------------------------------\n
  // get order id\n
  $sql = "select orders_id from ".TABLE_ORDERS.\n
         " where customers_id=\'".(int)$customer_id.\n
         "\' order by date_purchased desc limit 1";\n
  $pap_orders_query = tep_db_query($sql);\n
  $pap_orders = tep_db_fetch_array($pap_orders_query);\n
  $pap_order_id = $pap_orders[\'orders_id\'];\n
\n
  // get total amount of order\n
  $sql = "select value from ".TABLE_ORDERS_TOTAL.\n
         " where orders_id=\'".(int)$pap_order_id.\n
         "\' and class=\'ot_subtotal\'";\n
  $pap_orders_total_query = tep_db_query($sql);\n
  $pap_orders_total = tep_db_fetch_array($pap_orders_total_query);\n
  $pap_total_value = $pap_orders_total[\'value\'];\n
\n
  // draw invisible image to register sale\n
  if($pap_total_value != "" && $pap_order_id != "")\n
  {\n
    $img = \'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n<script type=\"text/javascript\"><!--\r\n\r\nvar TotalCost="\'.$pap_total_value.\'";\r\nvar OrderID="\'.$pap_order_id.\'";\r\nvar ProductID="";\r\npapSale();\r\n--></script>\';\n
    print $img;\n
  }\n
  //--------------------------------------------------------------------------\n
  // END of integration code\n
  //--------------------------------------------------------------------------\n
',
'',
'english');


insert into wd_pa_integrationsteps
values('oscom04', 'oscom01', 4,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');



insert into wd_pa_integration
values('2check01',
'2Checkout', '',
'2Checkout system has two versions (1 and 2). affiliate software can be easily integrated with both of them. They way of integration is the same, the versions differ only in structure of menu in 2checkout control panel.
2Checkout directly supports putting the hidden image tag on the sales confirmation page.',
'This is all that is required. Now whenever there\'s sale, 2checkout will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('2check01', '2check01', 1,
'Log-in to 2checkout vendor panel, go to <b>Look and Feel</b> and put the following URL to the <b>Affiliate URL</b> &lt;img src = field:',
'$SCRIPTDIRsale.php?TotalCost=$a_total&OrderID=$a_order',
'',
'english');


insert into wd_pa_integration
values('paypal01',
'PayPal', '',
'PayPal integrates using IPN callback.<br/>
Note! This is description of integration with PayPal if you use PayPal buttons on your web pages. If you use PayPal as a processing system in your shopping cart,
use the method for integrating with shopping cart, not these steps.
<br/>
Also, make sure you don\'t already use PayPal IPN for another purpose, such as some kind of digital delivery or membership registration.',
'This is all that is required. Now whenever there\'s sale, PayPal will use its IPN function to call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('paypal01', 'paypal01', 1,
'Now add the following code into EVERY PayPal button form',
'<input type="hidden" name="notify_url" value="$SCRIPTDIRpaypal.php">\n
<input type="hidden" name="custom" value="" id="pap_dx8vc2s5">\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\n
<script type="text/javascript"><!--\n
\n
paypalSale();\n
--></script>\n',
'This will tell PayPal that it should silently
call <b>$SCRIPTDIRpaypal.php</b> script upon every sale, and it will pass
all sale variables including the custom field to this script.', 'english');

insert into wd_pa_integrationsteps
values('paypal02', 'paypal01', 2,
'Example of updated PayPal form:<br/><br/>
<code>
&lt;!-- Begin PayPal Button --&gt;<br/>
&lt;form action="https://www.paypal.com/cgi-bin/webscr" method="post"&gt;<br/>
&lt;input type="hidden" name="cmd" value="_xclick"&gt;<br/>
&lt;input type="hidden" name="business" value="paypalemail@yoursite.com"&gt;<br/>
&lt;input type="hidden" name="undefined_quantity" value="1"&gt;<br/>
&lt;input type="hidden" name="item_name" value="Product Name"&gt;<br/>
&lt;input type="hidden" name="amount" value="19.95"&gt;<br/>
&lt;input type="hidden" name="image_url" value="https://yoursite.com/images/paypaltitle.gif"&gt;<br/>
&lt;input type="hidden" name="no_shipping" value="1"&gt;<br/>
&lt;input type="hidden" name="return" value="http://www.yoursite.com/paypalthanks.html"&gt;<br/>
&lt;input type="hidden" name="cancel_return" value="http://www.yoursite.com"&gt;<br/>
<b>&lt;input type="hidden" name="notify_url" value="$SCRIPTDIRpaypal.php"&gt;<br/>
&lt;input type="hidden" name="custom" value="" id="pap_dx8vc2s5"&gt;<br/>
&lt;script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"&gt;&lt;/script&gt;<br/>
&lt;script type="text/javascript"&gt;&lt;!--<br/>
<br/>
paypalSale();<br/>
--&gt;&lt;/script&gt;<br/></b>
&lt;input type="image" src="http://images.paypal.com/images/x-click-but5.gif" border="0" name="submit"&gt;<br/>
&lt;/form&gt;<br/>
&lt;!-- End PayPal Button --&gt;</code>',
'',
'', 'english');



insert into wd_pa_integration
values('stormp01',
'StormPay', '',
'StormPay integration is similar to PayPal, it also uses StormPay\'s IPN callback.<br/>
Note! This is description of integration with StormPay if you use StormPay buttons on your web pages. If you use StormPay as a processing system in your shopping cart,
use the method for integrating with shopping cart, not these steps.
<br/>
Also, make sure you don\'t already use StormPay IPN for another purpose, such as some kind of digital delivery or membership registration.',
'This is all that is required. Now whenever there\'s sale, StormPay will use its IPN function to call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('stormp01', 'stormp01', 1,
'Now add the following code into EVERY StormPay button form',
'<input type="hidden" name="user1" value="" id="pap_dx8vc2s5">\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\n
<script type="text/javascript"><!--\n
\n
paypalSale();\n
--></script>\n',
'This will tell StormPay that it should silently
call <b>$SCRIPTDIRstormpay.php</b> script upon every sale, and it will pass
all sale variables including the custom field to this script.', 'english');


insert into wd_pa_integrationsteps
values('stormp02', 'stormp01', 2,
'Example of updated StormPay form:<br/><br/>
<code>
&lt;form action="http://www.stormpay.com....&gt;<br/>
... <br/>
&lt;input type="hidden" name="user1" value="" id="pap_dx8vc2s5"&gt;<br/>
&lt;script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"&gt;&lt;/script&gt;<br/>
&lt;script type="text/javascript"&gt;&lt;!--<br/>
<br/>
paypalSale();<br/>
--&gt;&lt;/script&gt;<br/>
...<br/>
&lt;/form&gt;<br/>',
'',
'', 'english');

insert into wd_pa_integrationsteps
values('stormp04', 'stormp01', 3,
'Next step is to configure StormPay to use IPN callback to our
stormpay script.
There is an <b>IPN Cofiguration</b> section of your <b>Profile / Setup</b> page.
You should specify there full url to the stormpay script: ',
'$SCRIPTDIRstormpay.php',
'', 'english');



insert into wd_pa_integration
values('worldp01',
'WorldPay', '',
'WorldPay integration is similar to PayPal, it also uses WorldPay callback.<br/>
Note! This is description of integration with WorldPay if you use WorldPay buttons on your web pages. If you use WorldPay as a processing system in your shopping cart,
use the method for integrating with shopping cart, not these steps.
<br/>
Also, make sure you don\'t already use WorldPay callback for another purpose, such as some kind of digital delivery or membership registration.',
'This is all that is required. Now whenever there\'s sale, WorldPay will use its callback function to call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('worldp01', 'worldp01', 1,
'Now add the following code into EVERY WorldPay button form',
'<input type="hidden" name="M_aid" value="" id="pap_dx8vc2s5">\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\n
<script type="text/javascript"><!--\n
\n
paypalSale();\n
--></script>\n',

'This will tell WorldPay that it should silently
call <b>$SCRIPTDIRworldp.php</b> script upon every sale, and it will pass
all sale variables including the custom field to this script.', 'english');


insert into wd_pa_integrationsteps
values('worldp02', 'worldp01', 2,
'Example of updated WorldPay form:<br/><br/>
<code>
&lt;form action="http://www.worldpay.com....&gt;<br/>
... <br/>
&lt;input type="hidden" name="M_aid" value="" id="pap_dx8vc2s5"&gt;<br/>
&lt;script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"&gt;&lt;/script&gt;<br/>
&lt;script type="text/javascript"&gt;&lt;!--<br/>
<br/>
paypalSale();<br/>
--&gt;&lt;/script&gt;<br/>
...<br/>
&lt;/form&gt;<br/>',
'',
'', 'english');

insert into wd_pa_integrationsteps
values('worldp03', 'worldp01', 3,
'Next step is to configure WorldPay to use callback to our
worldpay script.
You should specify there full url to the worldpay script: ',
'$SCRIPTDIRworldpay.php',
'', 'english');



insert into wd_pa_integration
values('amembe01',
'aMember', '',
'aMember uses a variation of General solution, it tracks sales by invoking hidden script from "thank you" page.',
'This is all that is required. Now whenever there\'s sale, aMember will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('amembe01', 'amembe01', 1,
'Put the following code to the aMember thanks.html page',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n
<script type=\"text/javascript\"><!--\r\n
\r\n
var TotalCost="{$payment.amount}";\r\n
var OrderID="{$payment.payment_id}";\r\n
var ProductID="{$payment.product_id}";\r\n
papSale();\r\n
--></script>',
'',
'english');


insert into wd_pa_integration
values('snscar01',
'SecureNetShop (snscart)', '',
'To integrate with SecureNetShop you have to display affiliate-tracking code in the "receipt page" of the shopping cart.',
'This is all that is required. Now whenever there\'s sale, aMember will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('snscar01', 'snscar01', 1,
'Click on the <b>Settings</b> menu in your shopping cart administration area',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('snscar02', 'snscar01', 1,
'Click on <b>Order tracking</b> that will be displayed under "Marketing". ',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('snscar03', 'snscar01', 1,
'Click on the <b>Add new</b> button.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('snscar04', 'snscar01', 1,
'Choose your affiliate tracking provider from the list of options or else enter the tracking codes in the text box <b>Tracking code</b>. You can also choose the substitution codes for the affiliate tracking.<br/>
The tracking code is:',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n<script type=\"text/javascript\"><!--\r\n\r\nvar TotalCost="XXXXXXXX";\r\nvar OrderID="XXXXXX";\r\nvar ProductID="XXXXXX";\r\npapSale();\r\n--></script>',
'where the values XXXXXX should be replaced with correct values for:<br/>
<b>TotalCost</b> (mandatory for % commissions) - price of the product <br/>
<b>OrderID</b> (optional) - can be your unique generated order ID to cross-check the sale. <br/>
<b>ProductID</b> (optional) - the ID of the product bought.
<br/><br/>',
'english');

insert into wd_pa_integrationsteps
values('snscar05', 'snscar01', 1,
'Choose the placement conditions and than click on the save button.',
'',
'',
'english');



insert into wd_pa_integration
values('ccbill01',
'ccBill', '',
'Integration with ccBill can be made using the Approval URL supported by them.',
'This is all that is required. Now whenever there\'s sale, ccBill will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('ccbill01', 'ccbill01', 1,
'Login to your ccBill <b>Admin Center</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('ccbill02', 'ccbill01', 1,
'Go to <b>Account Maintenance -> Account Admin</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('ccbill03', 'ccbill01', 1,
'Click on the sub/account (if applicable),then on advanced (left side menu) and place the following code into the <b>Approval Post URL</b> section:.',
'$SCRIPTDIRsale.php?TotalCost=initialPrice&OrderID=subscription_id',
'',
'english');


insert into wd_pa_integration
values('psigat01',
'PSiGate', '',
'PSiGate uses a variation of General solution, it tracks sales by invoking hidden script from "thank you" page.',
'This is all that is required. Now whenever there\'s sale, PSiGate will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('psigat01', 'psigat01', 1,
'Specify your own thank you page for PsiGate and put there the following code',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n
<script type=\"text/javascript\"><!--\r\n
\r\n
var TotalCost="SubTotal";\r\n
var OrderID="OrdNo";\r\n
var ProductID="";\r\n
papSale();\r\n
--></script>',
'',
'english');



insert into wd_pa_integration
values('clicar01',
'ClickCartPro', '',
'Integration with ccBill can be made using the Approval URL supported by them.
 Go to Account Maintenance -> Account Admin. ',
'This is all that is required. Now whenever there\'s sale, ClickCartPro will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('clicar01', 'clicar01', 1,
'Login to your ClickCartPro <b>Admin Center</b> and go to the <b>Main Menu</b>. ',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('clicar02', 'clicar01', 1,
'go to <b>HTML Pages and Elements - > Manage Site Elements</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('clicar03', 'clicar01', 1,
'Open and update this template: <b>Order Confirmation - Third Party Affiliate Program Placeholder</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('clicar04', 'clicar01', 1,
'Place the following code anywhere in the box (all in one line) and click submit:',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\">\r\n<!--\r\n
\r\nvar TotalCost="(CGIVAR)tracking_subtotal(/CGIVAR)";\r\nvar OrderID="(CGIVAR)tracking_id(/CGIVAR)";\r\nvar ProductID="";\r\npapSale();\r\n-->\r\n</script>',
'',
'english');

insert into wd_pa_integration
values('hspher01',
'H-Sphere', '',
'Integration with any affiliate system is directly supported by H-Sphere.',
'This is all that is required. Now whenever there\'s sale, H-Sphere will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('hspher01', 'hspher01', 1,
'Log-in to your <b>H-Sphere Admin Center</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('hspher02', 'hspher01', 1,
'Go to <b>Settings - Affiliate Program</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('hspher03', 'hspher01', 1,
'Leave AutoInsert set to amount and place the following code into the area for Link 1:',
'$SCRIPTDIRsale.php?TotalCost=${amount}',
'',
'english');


insert into wd_pa_integration
values('mambop01',
'mambo-phpShop', '',
'Integration with mambo-phpShop is made by placing sale tracking script into the order confirmation page.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('mambop01', 'mambop01', 1,
'open and edit the temlate file that displays order confirmation page. It is the file
<b>/mambo/administrator/components/com_phpshop/classes/ps_checkout.php</b>',
'',
'',
'english');


insert into wd_pa_integrationsteps
values('mambop02', 'mambop01', 2,
'Find the following code which should already exist in the file.  <br>
<code>if (AFFILIATE_ENABLE == \'1\') { $ps_affiliate->register_sale($order_id); }</code>',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('mambop03', 'mambop01', 3,
'Cut/Paste the following code into the file, under the code found above:',
'print \'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\">\r\n<!--\r\n\r\nvar TotalCost=\"\'.$order_subtotal.\'\";\r\nvar OrderID=\"\'.$order_id.\'\";\r\nvar ProductID=\"\";\r\npapSale();\r\n-->\r\n</script>\';',
'',
'english');


insert into wd_pa_integrationsteps
values('mambop04', 'mambop01', 4,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');


insert into wd_pa_integration
values('shopsi01',
'ShopSite', '',
'Integration with ShopSite is made by placing sale tracking script into the order confirmation page.',
'This is all that is required. Now whenever there\'s sale, ShopSite will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('shopsi01', 'shopsi01', 1,
'Log-in to your <b>ShopSite Admin Center</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('shopsi02', 'shopsi01', 1,
'Click on <b>Commerce Setup -> Order System -> Thank You</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('shopsi03', 'shopsi01', 1,
'Cut/Paste the following code into the top box labeled <b>Information on the Thank You screen to return to storefront</b>:',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n
<script type=\"text/javascript\"><!--\r\n
\r\n
var TotalCost=ss_subtotal;\r\n
var OrderID=ss_ordernum;\r\n
var ProductID="";\r\n
papSale();\r\n
--></script>',
'',
'english');


insert into wd_pa_integration
values('yahoos01',
'Yahoo Stores', '',
'Integration with Yahoo Stores is made by placing sale tracking script into the order confirmation page.',
'This is all that is required. Now whenever there\'s sale, Yahoo Stores will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('yahoos01', 'yahoos01', 1,
'Login to your <b>Yahoo Store Manager and click Order Settings -> Order Form</b>',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('yahoos02', 'yahoos01', 1,
'Find the box labeled: <b>Order Confirmation : Message</b>, place the following code into the box and click done.',
'<script>
<!--\r\n
function getSaleInfo(){\r\n
var totalCost;\r\n
var orderId;\r\n
bs = bs2 = document.getElementsByTagName("b");\r\n
for(i=0;i<bs.length;i++) {\r\n
if(prz = bs[i].innerHTML.match(/(\d+\.\d{2})/)) { totalCost = prz[1];}\r\n
}\r\n
for(var i=0;i<bs2.length;i++) {\r\n
if(bs2[i].innerHTML.indexOf("Order Number:")!=-1) {\r\n
orderId = bs2[i].nextSibling.nodeValue;\r\n
}\r\n
}\r\n
document.getElementById(\'st_code\').innerHTML=\'<img src="$SCRIPTDIRsale.php?TotalCost=\' + totalCost + \'&OrderID=\' + orderId + \'" alt="" width=1 height=1>\';\r\n
}\r\n
window.onload = getSaleInfo;\r\n
// -->\r\n
</script> \r\n
<div id="st_code"></div>',
'',
'english');

insert into wd_pa_integrationsteps
values('yahoos03', 'yahoos01', 1,
'After inserting the code below you should click <b>Order Settings -> Publish Order Settings</b> to make the changes live.',
'',
'',
'english');


insert into wd_pa_integration
values('zencar01',
'ZenCart', '',
'Integration with ZenCart is made by placing sale tracking script into the order confirmation page.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('zencar01', 'zencar01', 1,
'To integrate ZenCart you should edit the order confirmation template. Open the file
<b>/zencart/tpl_checkout_success_default.php</b>',
'',
'',
'english');


insert into wd_pa_integrationsteps
values('zencar02', 'zencar01', 2,
'Find the line with following code which should already exist in the file.  <br>
<code>fields[\'orders_id\']; ?></code>',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('zencar03', 'zencar01', 3,
'Cut/Paste the following code into the file, under the line found above:',
'<?php\r\n
$dbreq = $db->Execute("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = \'".(int)$orders->fields[\'orders_id\']."\' AND class = \'ot_subtotal\'");\r\n
$totalCost = (number_format($dbreq->fields[\'value\'],2));\r\n
$orderId = $dbreq->fields[\'orders_id\'];\r\n
print \'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\">\r\n<!--\r\n\r\nvar TotalCost=\"\'.$totalCost.\'\";\r\nvar OrderID=\"\'.$orderId.\'\";\r\nvar ProductID=\"\";\r\npapSale();\r\n-->\r\n</script>\';\r\n
?>',
'',
'english');



insert into wd_pa_integration
values('vtmart01',
'Virtue Mart', '',
'Integration with Virtue Mart is made by placing sale tracking script into the confirmation page.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('vtmart01', 'vtmart01', 1,
'Find and open file <b>checkout.thankyou.php</b>',
'','', 'english');


insert into wd_pa_integrationsteps
values('vtmart02', 'vtmart01', 2,
'Replace last ?> with following code',
'$q = "SELECT * FROM #__{vm}_orders WHERE order_id=\'$order_id\'";\r\n
$db->query( $q );\r\n
$pap_order_total = $db->f(\'order_subtotal\' );\r\n
\r\n
$q = "SELECT * FROM #__{vm}_order_item WHERE order_id=\'$order_id\'";\r\n
$db->query( $q );\r\n
$pap_product_id = $db->f(\'product_id\');\r\n
?>\r\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
\r\n
var TotalCost="<?php echo  $pap_order_total ?>";\r\n
var OrderID="<?php echo  $order_id ?>";\r\n
var ProductID="<?php echo  $pap_product_id ?>";\r\n
papSale();\r\n
</script>',
'',
'english');


insert into wd_pa_integrationsteps
values('vtmart03', 'vtmart01', 3,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');


insert into wd_pa_integration
values('cartm01',
'Cart Manager', '',
'Integration with Cart Manager can be made using the Approval URL supported by them.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('cartm01', 'cartm01', 1,
'Login to your CartManager admin center and click <b>Advanced Settings</b>.',
'','', 'english');

insert into wd_pa_integrationsteps
values('cartm02', 'cartm01', 2,
'Find the box labeled: <b>HTML For Bottom of Receipt</b>.',
'','', 'english');

insert into wd_pa_integrationsteps
values('cartm03', 'cartm01', 3,
'Place the following code into the box.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
\r\n
var TotalCost=PRINTSUBTOTAL;\r\n
var OrderID=PRINTORDERNUMBER;\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('cartm04', 'cartm01', 4,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');


insert into wd_pa_integration
values('ecomt01',
'eCommerce Templates', '',
'Integration with eCommerce Templates is made by placing sale tracking script into the confirmation page.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('ecomt01', 'ecomt01', 1,
'Find and open file <b>thanks.php</b>.',
'','', 'english');

insert into wd_pa_integrationsteps
values('ecomt02', 'ecomt01', 2,
'Find the following line which already exists in the file: <b>&lt;?php include "vsadmin/inc/incthanks.php" ?&gt;</b>',
'','', 'english');

insert into wd_pa_integrationsteps
values('ecomt03', 'ecomt01', 3,
'Put following code right after this line.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
\r\n
var TotalCost="<?php echo  $ordGrandTotal ?>";\r\n
var OrderID="<?php echo  $ordID ?>";\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('ecomt04', 'ecomt01', 4,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');



insert into wd_pa_integration
values('mamchp01',
'Mambo-ChargePlus', '',
'Integration with Mambo-ChargePlus is made by placing sale tracking script into the confirmation page.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('mamchp01', 'mamchp01', 1,
'Find and open file <b>/components/com_mambocharge_plus/mambocharge_plus_thankyou.php</b>.',
'','', 'english');

insert into wd_pa_integrationsteps
values('mamchp02', 'mamchp01', 2,
'Put the following code into the very bottom of this file.',
'<?php\r\n
$aff_subtotal = $_POST[\'amount3\'];\r\n
$aff_orderid = $_POST[\'invoice\'];\r\n
?>\r\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
\r\n
var TotalCost="<?php echo  $aff_subtotal ?>";\r\n
var OrderID="<?php echo  $aff_orderid ?>";\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('mamchp04', 'mamchp01', 3,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');


insert into wd_pa_integration
values('swreg01',
'SWREG', '',
'Integration with SWREG is very simple - you only need to place sale tracking script into the template of order confirmation page.<br>
If you use Advanced ordering method, then you probably don\'t need to follow the steps below. Use the General Solution tracking code and put it to your own custom order confirmation page.
<br/>If you use standard ordering, follow the steps below.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('swreg01', 'swreg01', 1,
'Log in to SWREG admin panel and click to <b>edit your look and feel templates</b><br/>If your templates are disabled, you should enable them by clicking on the top link <b>enable templates</b>.',
'',
'',
'english');


insert into wd_pa_integrationsteps
values('swreg02', 'swreg01', 2,
'Open <b>Credit Card Confirmation Template</b> and edit it\'s code. If you don\'t have this template customized yet, you should download the system template and make the changes there.
<br/>Put the following code anywhere inside the &lt;body&gt; &lt;/body&gt; tags of the template.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>
<script type="text/javascript"><!--\r\n
\r\n
var TotalCost="###BASECURRENCYTOTAL###";\r\n
var OrderID="###ORDERNO###";\r\n
var ProductID="";\r\n
papSale();\r\n
--></script>',
'If you want to use secure images, only replace http:// with https:// in script src.<br/>When you added the code to template file, upload it back to server, then Activate it and make it Default. This will tell system to use your customized template with tracking code when displaying order confirmation page.',
'english');

insert into wd_pa_integrationsteps
values('swreg03', 'swreg01', 3,
'This way you added tracking code to <b>Credit Card Confirmation Template</b>. You should do the same for other ordering methods, like <b>PayPal Template</b>, <b>Wire Transfer Ordering Template</b> and <b>Check/Cheque Ordering Template</b>',
'',
'',
'english');

insert into wd_pa_integration
values('xcart01',
'X-Cart', '',
'Integration with X-Cart is made by placing sale tracking script into the order confirmation page.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('xcart01', 'xcart01', 1,
'Find and open file <b>/xcart/skin1/customer/main/order_message.tpl</b>.<br/>
If you use other skin, your skin directory could be different.',
'','', 'english');

insert into wd_pa_integrationsteps
values('xcart02', 'xcart01', 2,
'Put the following code right after the &lt;BR&gt;&lt;BR&gt;&lt;BR&gt;&lt;BR&gt; line.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
\r\n
var TotalCost="{$orders[oi].order.subtotal}";\r\n
var OrderID="{$orders[oi].order.orderid}";\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('xcart03', 'xcart01', 3,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');

insert into wd_pa_integration
values('1shop01',
'1ShoppingCart', '',
'Integration with 1ShoppingCart is made by placing sale tracking script into the than you page.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('1shop01', '1shop01', 1,
'1ShoppingCart allows you to have custom template of <b>thank you</b> page. They even provide sample custom thank you page.<br>
Find and open this custom thank you template file.',
'','', 'english');

insert into wd_pa_integrationsteps
values('1shop02', '1shop01', 2,
'Put the following code right after last presence of ?&gt mark.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
\r\n
var TotalCost="<?php echo  $_POST[\'Total\']; ?>";\r\n
var OrderID="<?php echo  $_POST[\'orderID\']; ?>";\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('1shop03', '1shop01', 3,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');


update wd_g_settings set value='1000007' where code='Aff_integration_version';


#= END ====================================================================#
