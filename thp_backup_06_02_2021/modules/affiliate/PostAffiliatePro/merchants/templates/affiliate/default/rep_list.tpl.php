<table cellpadding="2" cellspacing="0" border="0" width="780">
<tr><td>
    <?php echo $this->a_main_description?><br><br></td>
</tr>
<tr><td>
    <?php $columnCount = 2; ?>
    <table cellpadding="0" cellspacing="0" border="0">
     <?php $reports = $this->a_reports;
		reset($reports);
        for ($row=0; $row < ceil(count($reports)/$columnCount); $row++) { ?>
            <tr>
	 <?php     for ($column=0; $column < $columnCount; $column++) {
				$report = current($reports);
                if ($report == '') { ?>
                    <td></td>
        <?php         continue;
                } ?>       
                <td><table cellpadding="0" cellspacing="0" border="0">
                    <tr><td colspan="3">
                        <a href="<?php echo $report['url']?>">
                        <b><?php echo $report['name']?></b></a></td></tr>
                    <tr><td width="30"></td>
                        <td><?php echo $report['desc']?><br><br></td>
                        <td width="30"></td>
                    </tr>
                    </table>
                </td>
        <?php     next($reports);
            } ?>
            </tr>
     <?php } ?>
	</table></td>
</tr>
</table>
