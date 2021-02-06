<script>
    var t = parent.document.getElementById('progressTable');
    var x;
    <?php echo $this->a_message?>
</script>
<table class="listing" cellpadding="2" cellspacing="0" border="0" width="400">
<?php QUnit_Templates::printFilter(L_G_IMPORT); ?>
<tr><td align="center"><?php if ($this->a_line != -1) { ?><?php echo L_G_PLEASEWAIT?><?php } ?></td></tr>
<tr><td align="left">
<?php if ($this->a_line == -1) { ?>
    <?php echo L_G_ALLDONE?><br>
    <b><?php echo L_G_ROWS_OK?></b>: <?php echo $_SESSION['import_lineOK']?><br>
    <b><?php echo L_G_ROWS_ERROR?></b>: <?php echo $_SESSION['import_lineERROR']?><br>
    <?php if ($_SESSION['import_lineERROR'] > 0) { ?>
        <?php echo L_G_ERRORDURINGIMPORT?> <a target="new" href="<?php echo $this->a_filename?>"><?php echo L_G_HERE?></a><br>
    <?php } ?>
<?php } else { ?>
    <?php echo $this->a_line." ".L_G_ROWSDONE?>
<?php } ?>
</td></tr>
</table>