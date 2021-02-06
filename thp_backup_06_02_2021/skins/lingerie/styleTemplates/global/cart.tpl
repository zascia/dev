<!-- BEGIN: body -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={VAL_ISO}" />
<title>{META_TITLE}</title>
<meta name="description" content="{META_DESC}" />
<meta name="keywords" content="{META_KEYWORDS}" />

<script type="text/javascript">
var cpm = {};
(function(h,u,b){
var d=h.getElementsByTagName("script")[0],e=h.createElement("script");
e.async=true;e.src='https://cookiehub.net/c2/94ce44d9.js';
e.onload=function(){u.cookiehub.load(b);}
d.parentNode.insertBefore(e,d);
})(document,window,cpm);
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KL5MJW');</script>
<!-- End Google Tag Manager -->

<link href="skins/{VAL_SKIN}/styleSheets/layout.css" rel="stylesheet" type="text/css" />
<link href="skins/{VAL_SKIN}/styleSheets/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/jslibrary.js" type="text/javascript"></script>

<!-- BEGIN PRIVY ASYNCHRONOUS WIDGET CODE -->
<script type='text/javascript'>
   var _d_site = _d_site || 'C3C5F46B3BC0649B6F59AEFC';
   (function(p, r, i, v, y) {
     p[i] = p[i] || function() { (p[i].q = p[i].q || []).push(arguments) };
     v = r.createElement('script'); v.async = 1; v.src = 'https://widget.privy.com/assets/widget.js';
     y = r.getElementsByTagName('script')[0]; y.parentNode.insertBefore(v, y);
   })(window, document, 'Privy');
</script>
<!-- END PRIVY ASYNCHRONOUS WIDGET CODE -->

</head>

<body>
<!-- BEGIN PRIVY WIDGET CODE -->
<script type='text/javascript'> var _d_site = _d_site || 'C3C5F46B3BC0649B6F59AEFC'; </script>
<script src='https://widget.privy.com/assets/widget.js'></script>
<!-- END PRIVY WIDGET CODE -->
<div id="pageSurround">
	
	<div id="subSurround">
	
		<div id="topHeader">
									<div id="headRight">{SESSION}
						
						
						</div>
		</div>
		</div>
	
	<div>
	
		<div class="colLeftCheckout">
			{CART_NAVI}	
	{FAQ_CATS} <!-- added for FAQ management mod by MarksCarts, http://cc3.biz -->
	<br><br>
	<script>utmx_section("SITE_TESTIMONIALS")</script>
	{SITE_TESTIMONIALS}
	</noscript>
		</div>
		
		<div class="colMainCheckout">
			{PAGE_CONTENT}
		</div>
	
	</div>
	
	<br clear="all" />
	
	{SITE_DOCS}
	
	</div>

</div>

</body>
</html>
<!-- END: body -->