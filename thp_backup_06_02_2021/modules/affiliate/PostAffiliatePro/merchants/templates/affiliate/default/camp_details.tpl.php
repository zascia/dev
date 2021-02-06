<?php
    function wrapString($str, $length) {
        $output = '';
        for ($i=0; $i < ceil(strlen($str)/$length); $i++) {
            $output .= substr($str, $i * $length, $length)."<br>";
        }
        return $output;
    }
?>
<?php  if ($this->a_error != '') { ?>
    <?php echo $this->a_error?>
<?php  } else { ?>
    <table cellpadding="2" cellspacing="0" border="0" width="100%">
    <tr><td><b><?php echo L_G_CAMPAIGNID?></b></td>
        <td><?php echo $this->a_campdetails['campaignid']?></td></tr>
    <tr><td><b><?php echo L_G_CAMPAIGNNAME?></b></td>
        <td><?php echo $this->a_campdetails['name']?></td></tr>
    <tr><td><b><?php echo L_G_CAMPAIGNSTATUS?></b></td>
        <td><?php echo ($this->a_campdetails['status'] == AFF_CAMP_PUBLIC) ? L_G_PUBLIC : L_G_PRIVATE?></td></tr>
    <tr><td><b><?php echo L_G_CAMPAIGNTYPE?></b></td>
        <td><?php echo $this->a_Auth->getComposedCommissionTypeString($this->a_campdetails['commtype'])?></td></tr>
    <tr><td valign="top"><b><?php echo L_G_COMMISSIONS?></b></td>
        <td><?php $this->a_this->drawCommissionField($this->a_campdetails); ?></td></tr>
<?php if ($GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels') > 1) { ?>
    <tr><td valign="top"><b><?php echo L_G_MULTITIERCOMMISSION?></b></td>
        <td><?php $this->a_this->drawMultiTierCommissionField($this->a_campdetails); ?></td></tr>
<?php } ?>
    <tr><td><b><?php echo L_G_BANNERS?></b></td>
        <td><?php echo $this->a_campdetails['bannercount']?></td></tr>
    <tr><td><b><?php echo L_G_SHORT_DESCRIPTION?></b></td>
        <td><?php echo $this->a_campdetails['shortdescription']?></td></tr>
    <tr><td><b><?php echo L_G_DESCRIPTION?></b></td>
        <td><?php echo $this->a_campdetails['description']?></td></tr>
    </table>
<?php  } ?>
