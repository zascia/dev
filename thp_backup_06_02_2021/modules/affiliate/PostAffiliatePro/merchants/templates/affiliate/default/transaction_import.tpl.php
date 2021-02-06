<br>
<table class="listing" cellpadding="2" cellspacing="0" width="100%">
<? QUnit_Templates::printFilter(2, L_G_TRANSACTIONIMPORTSETTINGS); ?>
<tr><td class="listheaderNoLineLeft" valign=top width="10%" nowrap>
        &nbsp;<b><?=L_G_MATCHTRANSACTIONSBY?></b>&nbsp;<? showQuickHelp(L_G_HLP_MATCHTRANSACTIONSBY); ?></td>
    <td class="listheaderNoLineLeft" valign=top>
    	<select name="match_by">
    		<option value="_"       <?=$_REQUEST['match_by'] == '_'       ? 'selected' : ''?>><?=L_G_DONOTMATCH?></option>
    		<option value="orderid" <?=$_REQUEST['match_by'] == 'orderid' ? 'selected' : ''?>><?=L_G_ORDERID?></option>
    	</select>
	</td></tr>
<tr><td class="listheaderNoLineLeft" valign=top width="10%" nowrap>
        &nbsp;<b><?=L_G_STATUSOFIMPORTEDTRANSACTIONS?></b>&nbsp;<? showQuickHelp(L_G_HLP_STATUSOFIMPORTEDTRANSACTIONS); ?></td>
    <td class="listheaderNoLineLeft" valign=top>
    	<select name="import_status">
    		<option value="<?=IMPORTSTATUS_FROMFILE?>" <?=$_REQUEST['match_by'] == IMPORTSTATUS_FROMFILE ? 'selected' : ''?>>
    			<?=L_G_FROMINPUTDATA?></option>
    		<option value="<?=AFFSTATUS_NOTAPPROVED?>" <?=$_REQUEST['match_by'] == AFFSTATUS_NOTAPPROVED ? 'selected' : ''?>>
    			<?=L_G_PENDING?></option>
    		<option value="<?=AFFSTATUS_APPROVED?>" <?=$_REQUEST['match_by'] == AFFSTATUS_APPROVED ? 'selected' : ''?>>
    			<?=L_G_APPROVED?></option>
    		<option value="<?=AFFSTATUS_SUPPRESSED?>" <?=$_REQUEST['match_by'] == AFFSTATUS_SUPPRESSED ? 'selected' : ''?>>
    			<?=L_G_SUPPRESSED?></option>
    		<option value="<?=IMPORTSTATUS_PAID?>" <?=$_REQUEST['match_by'] == IMPORTSTATUS_PAID ? 'selected' : ''?>>
    			<?=L_G_PAID?></option>
    	</select>
	</td></tr>
</table>
