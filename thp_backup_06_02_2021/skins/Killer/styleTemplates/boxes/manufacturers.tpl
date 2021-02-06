<!-- BEGIN: manufacturers -->
<div class="boxTitleLeft">{LANG_TITLE}</div>
<div class="boxContentLeft"><!-- BEGIN: list -->
	<ul><!-- BEGIN: li -->
		<li class="bullet"><a href="index.php?act=viewCat&amp;manuf={MANUFACTURER_C}" class="txtDefault">{MANUFACTURER}</a></li><!-- END: li -->
	</ul><!-- END: list --><!-- BEGIN: dropdown -->	
	<select name="lang" style="width: 145px;" onchange="jumpMenu('parent',this,0)">
	<option value="">{SELECT_MANUFACTURER}</option><!-- BEGIN: option -->
	<option value="index.php?act=viewCat&amp;manuf={MANUFACTURER_C}" {SELECTED}>{MANUFACTURER}</option><!-- END: option -->
	</select><!-- END: dropdown -->
</div>
<!-- END: manufacturers -->