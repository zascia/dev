<table cellpadding="0" cellspacing="0" border="0" width="780">
<tr><td><h5><?php echo $this->a_title?></h5><?php echo $this->a_progress_description?><br><br></td></tr>
<tr><td><div id="resultDiv"></div></td></tr>
<tr><td>
    <iframe marginheight="0" marginwidth="0" width="450" height="120" align="left" scrolling="No"
     src="index_popup.php?md=<?php echo $this->a_md?>&action=import&filename=<?php echo $this->a_filename?>&start=1" frameborder="0"></iframe></td></tr>
</table>
<table id="progressTable" class="listing" cellspacing="0" cellpadding="2" border="0" width="780">
<?php  $colspan = 2;
    $tableHeaders = "";
    foreach ($this->a_fieldsToDisplay as $name) {
        if (in_array($name, $this->a_selectedFields)) {
            $colspan++;
            $tableHeaders .= '<td class="listresult">'.$this->a_columns[$name]['description'].'</td>';
        }
    } 
    QUnit_Templates::printFilter($colspan, L_G_RESULTS); ?>
<tr><td class="listresult"><?php echo L_G_LINE?></td>
    <td class="listresult"><?php echo L_G_RESULT?></td>
    <?php echo $tableHeaders?>
</tr>