<!-- BEGIN: body -->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<script language='javascript'>
	function GetInnerSize () {
	var x,y;
	if (self.innerHeight) // all except Explorer
	{
		x = self.innerWidth;
		y = self.innerHeight;
	}
	else if (document.documentElement && document.documentElement.clientHeight)
		// Explorer 6 Strict Mode
	{
		x = document.documentElement.clientWidth;
		y = document.documentElement.clientHeight;
	}
	else if (document.body) // other Explorers
	{
		x = document.body.clientWidth;
		y = document.body.clientHeight;
	}
	return [x,y];
}

function ResizeToInner (w, h, x, y) {
	// make sure we have a final x/y value
	// pick one or the other windows value, not both
	if (x==undefined) x = window.screenLeft || window.screenX;
	if (y==undefined) y = window.screenTop || window.screenY;
	// for now, move the window to the top left
	// then resize to the maximum viewable dimension possible
	window.moveTo(0,0);
	window.resizeTo(screen.availWidth,screen.availHeight);
	// now that we have set the browser to it's biggest possible size
	// get the inner dimensions.  the offset is the difference.
	var inner = GetInnerSize();
	var ox = screen.availWidth-inner[0];
	var oy = screen.availHeight-inner[1];
	// now that we have an offset value, size the browser
	// and position it
	window.resizeTo(w+ox, h+oy);
	window.moveTo(x,y);
}

</script>

<meta http-equiv="Content-Type" content="text/html; charset={VAL_ISO}" />

<title>Nyah-Beauty Julekonkurrence</title>

<meta name="description" content="{META_DESC}" />

<meta name="keywords" content="Jul, konkurrence, vind, gavekort, blingthing.dk, mp3, {META_KEYWORDS}" />



<link href="skins/{VAL_SKIN}/styleSheets/layout.css" rel="stylesheet" type="text/css" />

<link href="skins/{VAL_SKIN}/styleSheets/style.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="js/jslibrary.js" type="text/javascript"></script>
</head>



<body onload="ResizeToInner(470, 545)" style="text-align:center;">
<div>
	{MAIL_LIST}
</div>


</body>

</html>

<!-- END: body -->
