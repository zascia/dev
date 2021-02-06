<script>
function Repair(name) {
  document.location.href = "index.php?md=Affiliate_Merchants_Views_Maintenance&action=repair&tablename="+name;
}

function Optimize(name) {
  document.location.href = "index.php?md=Affiliate_Merchants_Views_Maintenance&action=optimize&tablename="+name;
}
</script>
<?php echo L_G_DBREPAIROPITIMIZE?>
<br><br>
<table width="520" class=listing border=0 cellspacing=0 cellpadding=2>
<?php QUnit_Templates::printFilter(6, L_G_TABLES); ?>
<tr>
        <td class=listheader align=left><?php echo L_G_NAME?></td>
        <td class=listheader align=left><?php echo L_G_NUMROWS?></td>
        <td class=listheader align=left><?php echo L_G_SIZE?></td>
        <td class=listheader align=left><?php echo L_G_DATASIZE?></td>
        <td class=listheader align=left><?php echo L_G_INDEXSIZE?></td>
        <td class=listheader align=left><?php echo L_G_ACTIONS?></td>
</tr>
<?php if(count($this->a_tables) == 0) { ?>
	<tr><td colspan="6">&nbsp;<?php echo L_G_NOTABLES?></td></tr>
<?php } else { ?>
<?php foreach($this->a_tables as $table) { ?>
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
    	<td class=listresultnocenter align="left">&nbsp;<?php echo $table["Name"]?></td>
    	<td class=listresultnocenter align="right" nowrap><?php echo $table["Rows"]?></td>
    	<td class=listresultnocenter align="right" nowrap><?php printf("%.1f", ($table["Data_length"]+$table["Index_length"])/1024); ?> KB</td>
    	<td class=listresultnocenter align="right" nowrap><?php printf("%.1f", $table["Data_length"]/1024); ?> KB</td>
    	<td class=listresultnocenter align="right" nowrap><?php printf("%.1f", $table["Index_length"]/1024); ?> KB</td>
    	<td class=listresultnocenter align="left">
<?php          $actions = array();
            $i = 0;
            $actions[$i++] = array('id'     => 'repair',
                                   'img'    => 'icon_repair.gif',
                                   'desc'   => L_G_REPAIR,
                                   'action' => (AFF_DEMO==1) ? "alert('".L_G_DISABLED_IN_DEMO."');" : "Repair('".$table["Name"]."');" );
            $actions[$i++] = array('id'     => 'optimize',
                                   'img'    => 'icon_optimize.gif',
                                   'desc'   => L_G_OPTIMIZE,
                                   'action' => (AFF_DEMO==1) ? "alert('".L_G_DISABLED_IN_DEMO."');" : "Optimize('".$table["Name"]."');" );
            $this->a_this->initTemporaryTE();
            $this->a_this->temporaryAssign('a_actions', $actions);                        
            $this->a_this->temporaryAssign('a_action_count', $i);
?>
            <?php echo $this->a_this->temporaryFetch('actions_icon')?>
    	</td>
   </tr>
<?php } ?>
<?php } ?>
</table>
<br>

