<!-- BEGIN: index -->
<!-- BEGIN: home -->
<div class="boxContent" >

<div class="filler">
	<script language=JavaScript>
	
	var img_width = "468";
	var img_height = "60";


	var img_title=new Array() 
	img_title[0]='Hair Extensions med Nyah-Beauty';
	img_title[1]='Hair Extentions på 2 min';
	img_title[2]='100% Naturlige Hair Extensions';
	img_title[3]='Hair Extensions hos Nyah-Beauty';

		
	var ad=new Array()
	//insert here your images src
	ad[0]='https://www.nyah-beauty.com/images/banner_dk/extensions_foraar_468x60.jpg';
	ad[1]='https://www.nyah-beauty.com/images/banner_dk/extensions_foraar_468x60.jpg';
	ad[2]='https://www.nyah-beauty.com/images/banner_dk/extensions_foraar_468x60.jpg';
	ad[3]='https://www.nyah-beauty.com/images/banner_dk/extensions_foraar_468x60.jpg';
	
		
	var links=new Array()
	//insert here your links
	links[0]='https://www.nyah-beauty.com/index.php?act=viewProd&productId=357';
	links[1]='https://www.nyah-beauty.com/index.php?act=viewProd&productId=357';
	links[2]='https://www.nyah-beauty.com/index.php?act=viewProd&productId=357';
	links[3]='https://www.nyah-beauty.com/index.php?act=viewProd&productId=357';
	
	
	var target=new Array()
	//insert here your targets
	target[0]='_blank';
	target[1]='_blank';
	target[2]='_blank';
	target[3]='_blank';
		
	var xy=Math.floor(Math.random()*ad.length);
	document.write('<a target="'+target[xy]+'" href="'+links[xy]+'"><img border="0" src="'+ad[xy]+'" width="'+img_width+'" height="'+img_height+'" alt="'+img_title[xy]+'"></a>');
	</SCRIPT>

</div>

<span style="padding-left: 10px; "class="txtContentTitle">{HOME_TITLE}</span>

<br />

<div style="padding-left: 10px;">{HOME_CONTENT}</div>

</div>
<!-- END: home -->
<!-- BEGIN: latest_prods -->

	<div class="boxContent">

	

	<span div style="padding-left: 10px;" class="txtContentTitle">{LANG_LATEST_PRODUCTS}</span>

	



	<div>

	<br />

		<!-- BEGIN: repeat_prods -->

<div class="featured">

<h3><a href="index.php?act=viewProd&amp;productId={VAL_PRODUCT_ID}" class="txtDefault"  title="{VAL_PRODUCT_NAME}">{VAL_PRODUCT_NAME}</a></h3>

<br />

<a href="index.php?act=viewProd&amp;productId={VAL_PRODUCT_ID}"><img src="{VAL_IMG_SRC}" alt="{VAL_PRODUCT_NAME}" border="0" /></a>

<br />

<p>

{TXT_PRICE}

<br />

<span class="txtSale">{TXT_SALE_PRICE}</span>
				<!-- ### START ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz -->
				<!-- BEGIN: video_button -->
				<div style="text-align:right; padding-right: 5px;">
				<a href="index.php?act=viewProd&amp;productId={VAL_PRODUCT_ID}#video" class="txtDefault" title="Se video af {VAL_PRODUCT_NAME}">
				<span style="font-size: 9px;">Video</span>
				<img src="images/videoMod/video_iconSm.gif" border="0" alt="" /></a>
				</div>
				<!-- END: video_button -->
				<!-- ### STOP ### Video Product Presentations Mod, 1.0.0 by MarksCarts, http://cc3.biz -->

</p>

</div>

<!-- END: repeat_prods -->

		<br clear="all" />

		</div>

		<br clear="all" />

		

		

	</div>

<!-- END: latest_prods -->

<!-- END: index -->
