<!-- BEGIN: body -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={VAL_ISO}" />
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
		{CART_NAVI}	
		{FAQ_CATS} <!-- added for FAQ management mod by MarksCarts, http://cc3.biz -->

		
		<div>
			{PAGE_CONTENT}
		</div>
		
		{SITE_DOCS}
	
	</div>
	
	<br clear="all" />
	
	</div>

</div>
</body>
</html>
<!-- END: body -->