<!-- BEGIN: index -->

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">

</script>

<script type="text/javascript">

_uacct = "UA-1188673-1";

urchinTracker();

</script>


<!-- BEGIN: home -->
<div class="boxContent">

<span class="txtContentTitle">{HOME_TITLE}</span>
	
<br />

{HOME_CONTENT}

</div>

<!-- END: home -->

<!-- BEGIN: sub_cats -->

<div class="boxContent">

<span class="txtContentTitle"></span>

  <div>

<!-- BEGIN: sub_cats_loop -->

<div style="float: left; text-align: center; possition:relative; margin:5px;">

    <a href="index.php?act=viewCat&amp;catId={TXT_LINK_CATID}" class="txtDefault"><img src="{IMG_CATEGORY}" alt="{TXT_CATEGORY}" border="0" title="{TXT_CATEGORY}" /></a><br />

  <a href="index.php?act=viewCat&amp;catId={TXT_LINK_CATID}" class="txtDefault">{TXT_CATEGORY}</a>

  </div>

  <!-- END: sub_cats_loop -->

  <br clear="all" />

  </div>

  <br clear="all" />

  </div>

<!-- END: sub_cats -->



<!-- BEGIN: latest_prods -->

	<div class="boxContent">

	<div class="txtContentTitle">{LANG_LATEST_PRODUCTS}</div>

	

		<div style="margin-top: 10px;">

		<!-- BEGIN: repeat_prods -->

			<div style="float: left; text-align: center; width: {VAL_WIDTH}px;">

				<a href="index.php?act=viewProd&amp;productId={VAL_PRODUCT_ID}"><img src="{VAL_IMG_SRC}" alt="{VAL_PRODUCT_NAME}" border="0" title="{VAL_PRODUCT_NAME}" /></a>

				<br />

				<a href="index.php?act=viewProd&amp;productId={VAL_PRODUCT_ID}" class="txtDefault">{VAL_PRODUCT_NAME}</a>

				<br /> 

				{TXT_PRICE} <span class="txtSale">{TXT_SALE_PRICE}</span>

			</div>

		<!-- END: repeat_prods -->

		<br clear="all" />

		</div>

		<br clear="all" />

		

		

	</div>

<!-- END: latest_prods -->

<!-- END: index -->