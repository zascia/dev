<!-- BEGIN: body -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://opengraphprotocol.org/schema/"
xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={VAL_ISO}" />
<meta property="og:type" content="product">
<meta property="og:site_name" content="Nyah-Beauty">
<meta property="og:image" content="{VAL_IMAGE}">
<meta property="fb:admins" content="533196049">
<title>{META_TITLE}</title>
<meta name="description" content="{META_DESC}" />
<meta name="keywords" content="{META_KEYWORDS}" />
<link href="skins/{VAL_SKIN}/styleSheets/layout.css" rel="stylesheet" type="text/css" />
<link href="skins/{VAL_SKIN}/styleSheets/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/jslibrary.js" type="text/javascript"></script>
</head>
<body>
<div id="pageSurround">
	
		<div id="topHeader">
			<div id="sessionBox">
				<div style="padding: 15px 8px 15px 15px; margin: 0px;">
				{SEARCH_FORM}
				{SESSION}
				</div>
			</div>
		</div>
		
		
		<div id="subSurround">
		
		{CATEGORIES}
		<table border="0" cellspacing="0" width="100%" cellpadding="0">
		  <tr valign="top">
			<td width="175">
{STORE}
	{FAQ_CATS} <!-- added for FAQ management mod by MarksCarts, http://cc3.biz -->
{MANUFACTURERS}
			{BRANDS}
				{LANGUAGE}
   			    {SHOPPING_CART}		
			<!-- 	{INFORMATION}	-->	
<div class=”boxContentRight”>
<Center>
<script type="text/javascript">
var uri = 'http://impdk.tradedoubler.com/imp?type(js)pool(194499)a(1189910)' + new String (Math.random()).substring (2, 11);
document.write('<sc'+'ript type="text/javascript" src="'+uri+'" charset="ISO-8859-1"></sc'+'ript>');
</script><br /><br /><br />
<p><img src="http://www.nyah-beauty.com/images/dankort_22.gif" alt="Dankort" width="40" height="22" />
  <img src="http://www.nyah-beauty.com/images/edankort_22.gif" alt="E-Dankort" width="50" height="22" />
  <img src="http://www.nyah-beauty.com/images/visa_22.gif" alt="Visakort" width="36" height="22" />
  <img src="http://www.nyah-beauty.com/images/electron_22.gif" alt="VisaElectron" width="35" height="22" /></p>
<p><img src="http://www.nyah-beauty.com/images/master_22.gif" alt="Mastercard" />
   <img src="http://www.nyah-beauty.com/images/maestro_22.gif" alt="Maestro" width="35" height="22" /> <img src="http://www.nyah-beauty.com/images/amex_22.gif" alt="American Express" width="30" height="22" /> <img src="http://www.nyah-beauty.com/images/diners_22.gif" alt="Diners Card" width="35" height="22" /> <img src="http://www.nyah-beauty.com/images/jcb_22.gif" alt="JCB" width="18" height="22" /></p>
<br />
<script language=JavaScript>
var img_width = "140";
var img_height = "261";
var img_title = "Klik her";
var ad=new Array()
//insert here your images src
ad[0]='http://www.nyah-beauty.com/images/tall-banner.jpg';
ad[1]='http://www.nyah-beauty.com/images/banner_{LINGU}/motionsAdd.jpg';
ad[2]='http://www.nyah-beauty.com/images/tall-banner3.jpg';
ad[3]='http://www.nyah-beauty.com/images/motionsAdd.jpg';
ad[4]='http://www.nyah-beauty.com/images/tall-banner5.jpg';
var links=new Array()
//insert here your links
links[0]='http://www.nyah-beauty.com/index.php?act=viewCat&catId=62';
links[1]='http://www.nyah-beauty.com';
links[2]='http://www.nyah-beauty.com/index.php?act=viewCat&catId=62';
links[3]='http://www.nyah-beauty.com/index.php?act=viewCat&manuf=T3B0aW11bQ==';
links[4]='http://www.nyah-beauty.com/index.php?act=viewCat&catId=62';
var xy=Math.floor(Math.random()*ad.length);
document.write('<a href="'+links[xy]+'"><img border="0" src="'+ad[xy]+'" width="'+img_width+'" height="'+img_height+'" alt="'+img_title+'"></a>');
</SCRIPT>
</Center>
</div>
	

				</td>
			<td style="padding: 0px 5px 0px 5px;">{PAGE_CONTENT}</td>
			<td width="175">
					<!--{RANDOM_PROD}-->
					{SLIDESHOW}
					
					{SALE_ITEMS}
						<div class=”boxContentRight”>					
						</div>
					
					{MAIL_LIST}
			</td>
		  </tr>
		</table>
	
	
	</div>
	{SITE_DOCS}
	
	
</div>
</body>
</html>
<!-- END: body -->
