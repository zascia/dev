<?php
	function getStringOrBlank($value) {
		return ($value == '') ? '-----' : $value;
	}
	
	function getGeoDataOrBlank($caption, $field, $this) {
		if (!in_array($field, $this->a_geo_columns)) return '';
		return "<tr>\n".
    		   "	<td><strong>".$caption."</strong></td>\n".
    		   "    <td>".getStringOrBlank($this->a_geo_data[$field])."</td>\n".
    		   "</tr>\n";
	}
?>
<table class=listing border=0 cellspacing=0 cellpadding=2 width="280">
<?php QUnit_Templates::printFilter(2, L_G_IPINFO); ?>
<tr>
    <td><strong><?php echo L_G_IP?></strong></td>
    <td><?php echo getStringOrBlank($this->a_data['ip'])?></td>
</tr>
<?php echo getGeoDataOrBlank(L_G_COUNTRYLONG, 'countryname', $this)?>
<?php echo getGeoDataOrBlank(L_G_IPREGION, 'region', $this)?>
<?php echo getGeoDataOrBlank(L_G_IPCITY, 'city', $this)?>
<?php echo getGeoDataOrBlank(L_G_IPLATITUDE, 'latitude', $this)?>
<?php echo getGeoDataOrBlank(L_G_IPLONGITUDE, 'longitude', $this)?>
<?php echo getGeoDataOrBlank(L_G_IPISP, 'isp', $this)?>
<?php echo getGeoDataOrBlank(L_G_IPDOMAIN, 'domain', $this)?>
<tr>
	<td colspan="2" align="center">
		<br><input type=button class=formbutton value='<?php echo L_G_CLOSE?>' onClick='javascript:window.close();'>
	</td>
</tr>
</table>
