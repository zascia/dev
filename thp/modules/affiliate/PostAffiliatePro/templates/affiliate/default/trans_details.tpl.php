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
    <tr><td><b><?php echo L_G_TRANSID?></b></td>
        <td><?php echo $this->a_transdetails['transid']?></td></tr>
    <tr><td><b><?php echo L_G_AFFILIATE?></b></td>
        <td><?php echo $this->a_transdetails['name'].' '.$this->a_transdetails['surname'].' ('.$this->a_transdetails['affiliateid'].')'?></td></tr>
    <tr><td><b><?php echo L_G_DATECREATED?></b></td>
        <td><?php echo $this->a_transdetails['dateinserted']?></td></tr>
    <tr><td><b><?php echo L_G_TRANSTYPE?></b></td>
        <td><?php  if($this->a_transdetails['transkind'] > TRANSKIND_SECONDTIER)
                    print ($this->a_transdetails['transkind'] - TRANSKIND_SECONDTIER).' - '.L_G_TIER.' ';
                print $GLOBALS['Auth']->getCommissionTypeString($this->a_transdetails['transtype']);
            ?></td></tr>
    <tr><td><b><?php echo L_G_STATUS?></b></td>
        <td><?php   if($this->a_transdetails['rstatus'] == AFFSTATUS_NOTAPPROVED) print '<img src="'.$this->a_this->getImage('sphore_pending.png').'" title="'.L_G_WAITINGAPPROVAL.'" alt="'.L_G_WAITINGAPPROVAL.'"> '.L_G_WAITINGAPPROVAL;
                 else if($this->a_transdetails['rstatus'] == AFFSTATUS_APPROVED) print '<img src="'.$this->a_this->getImage('sphore_active.png').'" title="'.L_G_APPROVED.'" alt="'.L_G_APPROVED.'"> '.L_G_APPROVED.' ('.($this->a_transdetails['dateapproved'] == '' ? L_G_UNKNOWN_DATE : $this->a_transdetails['dateapproved']).')';
                 else if($this->a_transdetails['rstatus'] == AFFSTATUS_SUPPRESSED) print '<img src="'.$this->a_this->getImage('sphore_declined.png').'" title="'.L_G_SUPPRESSED.'" alt="'.L_G_SUPPRESSED.'"> '.L_G_SUPPRESSED;
            ?></td></tr>
    <tr><td><b><?php echo L_G_PAYOUT_STATUS?></b></td>
        <td><?php   if($this->a_transdetails['payoutstatus'] == AFFSTATUS_NOTAPPROVED) print '<img src="'.$this->a_this->getImage('sphore_pending.png').'" title="'.L_G_WAITINGAPPROVAL.'" alt="'.L_G_WAITINGAPPROVAL.'"> '.L_G_WAITINGAPPROVAL;
                 else if($this->a_transdetails['payoutstatus'] == AFFSTATUS_APPROVED) print '<img src="'.$this->a_this->getImage('sphore_active.png').'" title="'.L_G_APPROVED.'" alt="'.L_G_APPROVED.'"> '.L_G_APPROVED.' ('.$this->a_transdetails['datepayout'].')';
                 else if($this->a_transdetails['payoutstatus'] == AFFSTATUS_SUPPRESSED) print '<img src="'.$this->a_this->getImage('sphore_declined.png').'" title="'.L_G_SUPPRESSED.'" alt="'.L_G_SUPPRESSED.'"> '.L_G_SUPPRESSED;
            ?>
        </td></tr>
    <tr><td><b><?php echo L_G_COMMISSION?></b></td>
        <td <?php echo $this->a_transdetails['commission'] < 0 ? 'class="minusCost"' : ''?>>
            <?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->a_transdetails['commission'])?></td></tr>
    <tr><td><b><?php echo L_G_TOTAL_COST?></b></td>
        <td <?php echo $this->a_transdetails['totalcost'] < 0 ? 'class="minusCost"' : ''?>>
            <?php echo Affiliate_Merchants_Bl_Settings::showCurrency($this->a_transdetails['totalcost'])?></td></tr>
    <tr><td valign="top"><b><?php echo L_G_REFERRER_URL?></b></td>
        <td><a href="<?php echo $this->a_transdetails['refererurl']?>" target="new"><?php echo wrapString($this->a_transdetails['refererurl'], 40)?></a></td></tr>
<?php  if ( ($this->a_transdetails['transtype'] == TRANSTYPE_LEAD) || ($this->a_transdetails['transtype'] == TRANSTYPE_SALE) ) { ?>
    <tr><td><b><?php echo L_G_ORIGINAL_REFERRER_URL?></b></td>
        <td><a href="<?php echo $this->a_transdetails['originalreferrer']?>" target="new"><?php echo wrapString($this->a_transdetails['originalreferrer'], 40)?></a></td></tr>
    <tr><td><b><?php echo L_G_ORIGINAL_REFERRER_TIME?></b></td>
        <td><?php  if ($this->a_transdetails['originalreferrertime'] == "" || $this->a_transdetails['originalreferrertime'] == "NULL" || !is_numeric($this->a_transdetails['originalreferrertime']))
                    print L_G_UNKNOWN;
                else
                    print date("Y-m-d G:i:s", $this->a_transdetails['originalreferrertime']);
            ?></td></tr>
    <tr><td><b><?php echo L_G_TRACKINGMETHOD?></b></td>
        <td><?php  switch($this->a_transdetails['trackingmethod']) {
                    case SALE_TRACKING_1STPARTY_COOKIE:   print L_G_SALE_TRACKING_1STPARTY_COOKIE; break;
                    case SALE_TRACKING_FLASH:       print L_G_SALE_TRACKING_FLASH; break;
                    case SALE_TRACKING_COOKIE:      print L_G_SALE_TRACKING_COOKIE; break;
                    case SALE_TRACKING_IP:          print L_G_SALE_TRACKING_IP; break;
                    case SALE_TRACKING_REFERRED:    print L_G_SALE_TRACKING_REFERRED; break;
                    case SALE_TRACKING_SESSION:     print L_G_SALE_TRACKING_SESSION; break;
                    case SALE_TRACKING_AFFILIATEID: print L_G_SALE_TRACKING_AFFILIATEID; break;
                    default:                     print L_G_UNKNOWN; break;
                }
            ?></td></tr>
    <tr><td><b><?php echo L_G_FIRSTCLICK?></b></td>
        <td><?php  if ($this->a_transdetails['firstclick'] == "" || strtoupper($this->a_transdetails['firstclick']) == "NULL")
                    print L_G_UNKNOWN;
                else
                    print date("Y-m-d G:i:s", $this->a_transdetails['firstclick']);
            ?>
            </td></tr>
    <tr><td><b><?php echo L_G_LASTCLICK?></b></td>
        <td><?php  if ($this->a_transdetails['lastclick'] == "" || strtoupper($this->a_transdetails['lastclick']) == "NULL")
                    print L_G_UNKNOWN;
                else
                    print date("Y-m-d G:i:s", $this->a_transdetails['lastclick']);
            ?>
            </td></tr>
   <tr><td><b><?php echo L_G_CLICKCOUNT?></b></td>
        <td><?php  if ($this->a_transdetails['clickcount'] == "" || strtoupper($this->a_transdetails['clickcount']) == "NULL")
                    print L_G_UNKNOWN;
                else
                    print $this->a_transdetails['clickcount'];
            ?>
            </td></tr>
<?php  } ?>
    <tr><td><b><?php echo L_G_ORDERID?></b></td>
        <td><?php echo $this->a_transdetails['orderid']?></td></tr>
    <tr><td><b><?php echo L_G_PRODUCTID?></b></td>
        <td><?php echo $this->a_transdetails['productid']?></td></tr>
    <tr><td><b><?php echo L_G_IP?></b></td>
        <td><?php echo $this->a_transdetails['ip']?>
            <?php if($GLOBALS['Auth']->getSetting('Glob_acct_geo_allowed') == '1') { ?>
              <?php echo ($this->a_transdetails['countryname'] != '') ? '('.$this->a_transdetails['countryname'].')' : ''?>
            <?php } ?>
        </td></tr>
    <tr><td><b><?php echo L_G_DATA1?></b></td>
        <td><?php echo $this->a_transdetails['data1']?></td></tr>
    <tr><td><b><?php echo L_G_DATA2?></b></td>
        <td><?php echo $this->a_transdetails['data2']?></td></tr>
    <tr><td><b><?php echo L_G_DATA3?></b></td>
        <td><?php echo $this->a_transdetails['data3']?></td></tr>
    </table>
<?php  } ?>
