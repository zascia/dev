	<!-- BEGIN: store -->
<div class="boxTitleLeft">Store selector</div>
<div class="boxContentLeft">
	<select name="store" class="dropDown" onchange="jumpMenu('parent',this,0)">
		<!-- BEGIN: home -->
		<option value="index.php">Main Shop Page</option>
		<!-- END: home -->
		<!-- BEGIN: option -->
		<option value="index.php?act=viewCat&catId={STORE_VAL}" {STORE_SELECTED}>{STORE_NAME}</option>
		<!-- END: option -->
	</select>
</div>
<!-- END: store -->