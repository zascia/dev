<script>

function showLayer(layerID, show) {
	if(show) {
		document.getElementById(layerID).style.display = "block";
	} else {
		document.getElementById(layerID).style.display = "none";
	}
}

</script>
<?php
	define('MT_COLS', 3);
?>
<table border=0 width="100%" cellspacing=0 cellpadding=3>
<?php if($this->a_Auth->getSetting('Aff_support_cpm_commissions') == '1') { ?>
  <tr class="detailrow0"><td class="tableheader2">
  		<input type=checkbox id="cpm_check" name="commtype[]" value="<?php echo TRANSTYPE_CPM?>" <?php echo (is_array($_POST['commtype']) ? (in_array(TRANSTYPE_CPM, $_POST['commtype']) ? 'checked' : '') : '')?>
				onclick="javascript: showLayer('cpm_settings', document.getElementById('cpm_check').checked );">
    	     &nbsp;<?php echo L_G_ALLOWCPMCOMMISSIONS?>
    	&nbsp;<?php showQuickHelp(L_G_HLP_ALLOWCPMCOMM); ?>
  	  </td></tr>
  <tr class="detailrow0">
    <td align="left" valign="top">
        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td align=left>
          <div id=cpm_settings style="display: <?php echo (is_array($_POST['commtype']) ? (in_array(TRANSTYPE_CPM, $_POST['commtype']) ? 'block' : 'none') : 'none')?>;">
          	<b><?php echo L_G_COMMISSION?></b>
          	&nbsp;
          	<?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               	print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          	?>
          	&nbsp;<input class="forminput" type=text name=cpmcommission size=6 maxlength="6" value='<?php echo $_POST['cpmcommission']?>'>
          	<?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
               	print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          	?>
          </div>
          </td>
        </tr>
        </table>
      </td>
    </tr>
<?php } ?>

<?php if($this->a_Auth->getSetting('Aff_support_click_commissions') == '1') { ?>
  <tr><td class="tableheader2">
  		<input type=checkbox id="click_check" name="commtype[]" value="<?php echo TRANSTYPE_CLICK?>" <?php echo (is_array($_POST['commtype']) ? (in_array(TRANSTYPE_CLICK, $_POST['commtype']) ? 'checked' : '') : '')?>
				onclick="javascript: showLayer('click_settings', document.getElementById('click_check').checked );">
    	     &nbsp;<?php echo L_G_ALLOWCLICKCOMMISSIONS?>
    	     &nbsp;<?php showQuickHelp(L_G_HLP_ALLOWCLICKCOMM); ?>
  	  </td></tr>
  <tr class="detailrow0">
    <td align=left>
        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td align=left>
            <div id=click_settings style="display: <?php echo (is_array($_POST['commtype']) ? (in_array(TRANSTYPE_CLICK, $_POST['commtype']) ? 'block' : 'none') : 'none')?>;">
            	<table cellpadding="0" cellspacing="0" border="0">
            	<tr><td valign="top" width="350">
            	<b><?php echo L_G_COMMISSION?></b>
          		&nbsp;
          		<?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               		print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          		?>
          		<input class="forminput" type=text name=clickcommission size=6 maxlength="6" value='<?php echo $_POST['clickcommission']?>'>
          		<?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
               		print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          		?>
          		</td>
          		<td valign="top">
		<?php     if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?>
          			&nbsp;<?php echo L_G_OFFERSECONDTIER?>&nbsp;<?php showQuickHelp(L_G_HLPCOMTYPE); ?>
          			<table border=0 width=100%>
			<?php        for($i=2; $i<=$this->a_Auth->getSetting('Aff_maxcommissionlevels'); $i++)
        			  {
            			  if(($i-2)%MT_COLS == 0) echo "<tr>";
?>
            				<td align=right>&nbsp;<?php echo $i.' - '.L_G_TIER?>&nbsp;
            				<?php if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
                 				print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
            				?>
            				<input class="forminput" type=text name=st<?php echo $i?>clickcommission size=6 maxlength="6" value='<?php echo $_POST['st'.$i.'clickcommission']?>'>
            				<?php if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
                 				print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
            				?>
			<?php
            			  if(($i-2)%MT_COLS == MT_COLS-1) echo "</tr>";
          					} ?>
          			</table>
                <?php } ?>
          		 </td></tr>
          		 </table>
          		</div>
          	</td>
        </tr>
        </table>
      </td>
    </tr>
<?php } ?>

<?php if($this->a_Auth->getSetting('Aff_support_sale_commissions') == '1' || $this->a_Auth->getSetting('Aff_support_lead_commissions') == '1') { ?>
        <tr><td class="tableheader2">
  		<input type=checkbox id="salelead_check" name="commtype[]" value="_" <?php echo (is_array($_POST['commtype']) ? (in_array('_', $_POST['commtype']) ? 'checked' : '') : '')?>
				onclick="javascript: showLayer('salelead_settings', document.getElementById('salelead_check').checked );
									 if (document.getElementById('salelead_check').checked) {
									 	showLayer('saleleadrec_header', document.getElementById('salelead_check').checked);
									 	showLayer('saleleadrec_settings', document.getElementById('saleleadrec_check').checked);
									 } else {
										showLayer('saleleadrec_header', false);
									 	showLayer('saleleadrec_settings', false);
									 } ">
    	     &nbsp;<?php echo L_G_ALLOWSALELEADCOMMISSIONS?>
    	     &nbsp;<?php showQuickHelp(L_G_HLP_ALLOWSALELEADCOMM); ?>
  	  </td></tr>
  <tr class="detailrow0">
    <td align=left>
		<div id=salelead_settings style="display: <?php echo (is_array($_POST['commtype']) ? (in_array('_', $_POST['commtype']) ? 'block' : 'none') : 'none')?>;">
        <table border=0 cellspacing=0 cellpadding=0>
        <tr><td valign="top" width="3"></td>
            <td align=left valign="top" width="347">
            <b><?php echo L_G_COMMISSIONTYPE?></b>&nbsp;&nbsp;
            <?php if($this->a_Auth->getSetting('Aff_support_sale_commissions') == '1') { ?>
                <input type="radio" name="commtype2" value="<?php echo TRANSTYPE_SALE?>" <?php echo ($_POST['commtype2'] == TRANSTYPE_SALE || $this->a_Auth->getSetting('Aff_support_lead_commissions') != '1' ? 'checked' : '')?>><?php echo L_G_PERSALE?>
                <?php showQuickHelp(L_G_HLP_COMMTYPESALE); ?>
                &nbsp;&nbsp;&nbsp;&nbsp;
            <?php } ?>
            <?php if($this->a_Auth->getSetting('Aff_support_lead_commissions') == '1') { ?>
          	    <input type="radio" name="commtype2" value="<?php echo TRANSTYPE_LEAD?>" <?php echo ($_POST['commtype2'] == TRANSTYPE_LEAD || $this->a_Auth->getSetting('Aff_support_sale_commissions') != '1' ? 'checked' : '')?>><?php echo L_G_PERLEAD?>
          	    <?php showQuickHelp(L_G_HLP_COMMTYPELEAD); ?>
          	<?php } ?>
          	<br><br>
          	<b><?php echo L_G_COMMISSION?></b>&nbsp;&nbsp;
            <select name=salecommtype>
              <option value='$' <?php print ($_POST['salecommtype'] == '$' ? 'selected' : ''); ?>><?php echo $this->a_Auth->getSetting('Aff_system_currency')?></option>
              <option value='%' <?php print ($_POST['salecommtype'] == '%' ? 'selected' : ''); ?>>%</option>
            </select>

            &nbsp;<input class="forminput" type=text name=salecommission size=6 maxlength="6" value='<?php echo $_POST['salecommission']?>'>
          </td>

<?php     if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?>
          <td colspan=3 align=left nowrap valign="top">
          &nbsp;<?php echo L_G_OFFERSECONDTIER?>&nbsp;
          <select name=stsalecommtype>
            <option value='$' <?php print ($_POST['stsalecommtype'] == '$' ? 'selected' : ''); ?>><?php echo $this->a_Auth->getSetting('Aff_system_currency')?></option>
            <option value='%' <?php print ($_POST['stsalecommtype'] == '%' ? 'selected' : ''); ?>>%</option>
          </select>
          &nbsp;
          <?php showQuickHelp(L_G_HLPCOMTYPE); ?>
          <table border=0 width=100%>
<?php        for($i=2; $i<=$this->a_Auth->getSetting('Aff_maxcommissionlevels'); $i++)
          {
              if(($i-2)%MT_COLS == 0) echo "<tr>";
?>
            <td align=right>&nbsp;<?php echo $i.' - '.L_G_TIER?>&nbsp;
            <input class="forminput" type=text name=st<?php echo $i?>salecommission size=6 maxlength="6" value='<?php echo $_POST['st'.$i.'salecommission']?>'>
<?php
              if(($i-2)%MT_COLS == MT_COLS-1) echo "</tr>";
          } ?>
          </table>
          </td>
        </tr>
<?php     } ?>

        </table>
        </div>
      </td>
    </tr>


<?php  if($this->a_Auth->getSetting('Aff_support_recurring_commissions') == 1) { ?>
  <tr class="detailrow0"><td style="padding-left: 0px; padding-right: 0px;">
  		<div id="saleleadrec_header" style="display: <?php echo (is_array($_POST['commtype']) ? (in_array('_', $_POST['commtype']) ? 'block' : 'none') : 'none')?>;">
  			<table cellpadding="0" cellspacing="0" border="0" width="100%">
  			<tr><td class="tableheader2">
  			&nbsp;<b>-------></b>&nbsp;
    		<input type=checkbox id="saleleadrec_check" name=recurring value="1" <?php echo $_POST['recurring'] == '1' ? 'checked' : ''?>
				onclick="javascript: showLayer('saleleadrec_settings', document.getElementById('saleleadrec_check').checked );">
    	     &nbsp;<?php echo L_G_ALLOWSALELEADRECURRINGCOMMISSIONS?>
    	     &nbsp;<?php showQuickHelp(L_G_HLP_ALLOWSALELEADRECURRINGCOMM); ?>
    	     </td></tr>
    	     </table>
    	</div>
  	  </td></tr>
  <tr class="detailrow0">
    <td align=left>
    	<div id="saleleadrec_settings" style="display: <?php echo (is_array($_POST['commtype']) && in_array('_', $_POST['commtype']) && ($_POST['recurring'] == '1')) ? 'block' : 'none'?>">
        <table border=0 cellspacing=0 cellpadding=0>
        <tr><td align=left width="53"></td>
          <td colspan=3 align=left valign="top" width="347">
          <b><?php echo L_G_COMMISSION?></b>&nbsp;&nbsp;
            <select name=recurringcommtype>
              <option value='$' <?php print ($_POST['recurringcommtype'] == '$' ? 'selected' : ''); ?>><?php echo $this->a_Auth->getSetting('Aff_system_currency')?></option>
              <option value='%' <?php print ($_POST['recurringcommtype'] == '%' ? 'selected' : ''); ?>>%</option>
            </select>

            <input class="forminput" type=text name=recurringcommission size=6 maxlength="6" value='<?php echo $_POST['recurringcommission']?>'>
            &nbsp;&nbsp;<?php showQuickHelp(L_G_HLPRECURRINGCOMM); ?>
          <br><br>
          <b><?php echo L_G_RECURRINGPERIOD?></b>&nbsp;
            <select name=recurringdatetype>
              <option value='<?php echo RECURRINGTYPE_WEEKLY?>' <?php print ($_POST['recurringdatetype'] == RECURRINGTYPE_WEEKLY ? 'selected' : ''); ?>><?php echo L_G_WEEKLY?></option>
              <option value='<?php echo RECURRINGTYPE_MONTHLY?>' <?php print ($_POST['recurringdatetype'] == RECURRINGTYPE_MONTHLY ? 'selected' : ''); ?>><?php echo L_G_MONTHLY?></option>
              <option value='<?php echo RECURRINGTYPE_QUARTERLY?>' <?php print ($_POST['recurringdatetype'] == RECURRINGTYPE_QUARTERLY ? 'selected' : ''); ?>><?php echo L_G_QUARTERLY?></option>
              <option value='<?php echo RECURRINGTYPE_BIANNUALLY?>' <?php print ($_POST['recurringdatetype'] == RECURRINGTYPE_BIANNUALLY ? 'selected' : ''); ?>><?php echo L_G_BIANNUALLY?></option>
              <option value='<?php echo RECURRINGTYPE_YEARLY?>' <?php print ($_POST['recurringdatetype'] == RECURRINGTYPE_YEARLY ? 'selected' : ''); ?>><?php echo L_G_YEARLY?></option>
            </select>
            &nbsp;&nbsp;<?php showQuickHelp(L_G_HLPRECURRINGCOMMPAYMENT); ?>
          </td>

<?php     if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?>
          <td colspan=3 align=left>
          &nbsp;<?php echo L_G_OFFERSECONDTIER?>&nbsp;
          <select name=strecurringcommtype>
            <option value='$' <?php print ($_POST['strecurringcommtype'] == '$' ? 'selected' : ''); ?>><?php echo $this->a_Auth->getSetting('Aff_system_currency')?></option>
            <option value='%' <?php print ($_POST['strecurringcommtype'] == '%' ? 'selected' : ''); ?>>%</option>
          </select>
          &nbsp;
          <?php showQuickHelp(L_G_HLPCOMTYPE); ?>
          <table border=0 width=100%>
<?php        for($i=2; $i<=$this->a_Auth->getSetting('Aff_maxcommissionlevels'); $i++)
          {
              if(($i-2)%MT_COLS == 0) echo "<tr>";
?>
            <td align=right>&nbsp;<?php echo $i.' - '.L_G_TIER?>&nbsp;
            <input class="forminput" type=text name=st<?php echo $i?>recurringcommission size=6 maxlength="6" value='<?php echo $_POST['st'.$i.'recurringcommission']?>'>
<?php
              if(($i-2)%MT_COLS == MT_COLS-1) echo "</tr>";
          } ?>
          </table>
          </td>
        </tr>
<?php     } ?>
		</div>
        </table>
      </td>
    </tr>
<?php  } ?>
<?php } ?>


        </td>
      </tr>
</table>

