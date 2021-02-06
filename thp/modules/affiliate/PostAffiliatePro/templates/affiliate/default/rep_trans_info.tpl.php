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
<?php QUnit_Templates::printFilter(2, L_G_TRANSACTIONINFO); ?>
<tr>
    <td width="120"><strong><?php echo L_G_TRANSID?></strong></td>
    <td><?php echo $this->a_data['transid']?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_CREATED?></strong></td>
    <td><?php echo $this->a_data['dateinserted']?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_CAMOUNT?></strong></td>
    <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_data['commission']))?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_TOTALCOST?></strong></td>
    <td><?php echo Affiliate_Merchants_Bl_Settings::showCurrency(_rnd($this->a_data['totalcost']))?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_ORDERID?></strong></td>
    <td><?php echo getStringOrBlank($this->a_data['orderid'])?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_PRODUCTID?></strong></td>
    <td><?php echo getStringOrBlank($this->a_data['productid'])?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_TYPE?></strong></td>
    <td><?php      
            if($this->a_data['transkind'] > TRANSKIND_SECONDTIER)
                print L_G_SECONDTIER.' ';
            
            print $GLOBALS['Auth']->getComposedCommissionTypeString($this->a_data['transtype']);            
        ?>
    </td>
</tr>
<tr>
    <td><strong><?php echo L_G_IP?></strong></td>
    <td><?php echo getStringOrBlank($this->a_data['ip'])?></td>
</tr>
<?php if($this->a_geo_data != '') { ?>
	 <?php echo getGeoDataOrBlank(L_G_COUNTRYLONG, 'countryname', $this)?>
	 <?php echo getGeoDataOrBlank(L_G_IPREGION, 'region', $this)?>
	 <?php echo getGeoDataOrBlank(L_G_IPCITY, 'city', $this)?>
	 <?php echo getGeoDataOrBlank(L_G_IPLATITUDE, 'latitude', $this)?>
	 <?php echo getGeoDataOrBlank(L_G_IPLONGITUDE, 'longitude', $this)?>
	 <?php echo getGeoDataOrBlank(L_G_IPISP, 'isp', $this)?>
	 <?php echo getGeoDataOrBlank(L_G_IPDOMAIN, 'domain', $this)?>
<?php } ?>
<tr>
    <td><strong><?php echo L_G_STATUS?></strong></td>
    <td><?php echo $GLOBALS['Auth']->getTransactionStatusString($this->a_data['rstatus'])?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_DATEAPPROVED?></strong></td>
    <td><?php echo getStringOrBlank($this->a_data['dateapproved'])?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_PAID?></strong></td>
    <td><?php echo ($this->a_data['payoutstatus'] == AFFSTATUS_APPROVED) ? L_G_YES : L_G_NO?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_DATEPAID?></strong></td>
    <td><?php echo getStringOrBlank($this->a_data['datepayout'])?></td>
</tr>
<tr>
    <td valign="top"><strong><?php echo L_G_REFERER?></strong></td>
    <td><?php
    		if ($this->a_data['refererurl'] == '') echo "-----";
    		else {
    	?>
    		<a href="<?php echo $this->a_data['refererurl']?>" target="new">
    	<?php
    			define('maxLength', 25);
        		$str = $this->a_data['refererurl'];
        		while (strlen($str) > maxLength) {
        			echo substr($str, 0, maxLength)."<br>";
        			$str = substr($str, maxLength);
        		}
        		echo $str;
			}
    	?></a>
    </td>
</tr>
<tr>
    <td><strong><?php echo L_G_DATA1?></strong></td>
    <td><?php echo getStringOrBlank($this->a_data['data1'])?></td>
</tr>
<tr>
    <td><strong><?php echo L_G_DATA2?></strong></td>
    <td><?php echo getStringOrBlank($this->a_data['data2'])?></td>
</tr>
<?php if ($this->user_type == USERTYPE_ADMIN) {?>
<tr>
    <td><strong><?php echo L_G_DATA3?></strong></td>
    <td><?php echo getStringOrBlank($this->a_data['data3'])?></td>
</tr>
<?php }?>
<tr>
	<td colspan="2" align="center">
		<br><input type=button class=formbutton value='<?php echo L_G_CLOSE?>' onClick='javascript:window.close();'>
	</td>
</tr>
</table>
