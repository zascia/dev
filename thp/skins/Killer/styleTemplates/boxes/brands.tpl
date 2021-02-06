<!-- BEGIN: categories -->
<div class="boxTitleLeft">{LANG_BRAND_TITLE}</div>


<div class="boxContentLeft">
<select name="brand" class="dropDown" onchange="jumpMenu('parent',this,0)">	

<option value="" selected>Select...</option>
<!-- BEGIN: option -->
<option value="index.php?act=viewCat&amp;catId={DATA.cat_id}" {SELECTED}>{DATA.cat_name}</option>
<!-- END: option -->
	
</select>	
		
</div>
<div class="boxFootLeft">&nbsp;</div>
<!-- END: categories -->
