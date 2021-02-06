<script>
function changeSheet(action, sheet)
{
    document.myForm.action.value = action;
    document.myForm.sheet.value = sheet;
    document.myForm.submit();
}

function changeTab(tabID) {
    
}

</script>
<?php echo $this->a_tab_desc?>
<br/><br/>
<form enctype="multipart/form-data" id=myForm name=myForm action=index.php method=post>
<table class=listing border=0 width="780" cellspacing=0 cellpadding=0>
<tr>
  <td  align="left" valig=="top">
      <?php echo $this->a_tab_content?>    
  </td>
</tr>
<tr>
    <td align=left style="padding: 5px">
    &nbsp;&nbsp;
             <input type=hidden name=commited value=yes>
             <input type=hidden name=md value="Affiliate_Merchants_Views_IntegrationWizard">
             <input type=hidden name=integration_tab_sheet value="<?php echo $_REQUEST['integration_tab_sheet']?>">
             <input type=hidden name=action value="<?php echo $_REQUEST['action']?>">
        <?php if ($_REQUEST['integration_tab_sheet'] != 'salestracking') { ?>
            <?php if ($this->a_this->checkPermissions('edit')) { ?>
                <input class=formbutton type=submit value='<?php echo L_G_SUBMIT; ?>'>
             <?php } ?>
        <?php } ?>
    </td>
</tr>
</table>
</form>

