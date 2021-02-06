<?php  if(count($this->a_actions) == 0) { ?>
        <?php echo L_G_NOACTIONS?>
<?php  } else { 
        $tableWidth = 100 + $this->a_action_count*16;
    ?>
        <table cellpadding="0" cellspacing="0" border="0" width="<?php echo $tableWidth?>">
        <tr>
    <?php  $id = uniqid('a_');
        for ($i=0; $i<$this->a_action_count; $i++) {
            $action = $this->a_actions[$i]; 
            if ($action != '') { ?>
                <td width="16">
                    <a href="javascript:document.getElementById('<?php echo $id?>').innerHTML='____________';<?php echo $action['action']?>"><img src="<?php echo $this->a_this->getImage($action['img'])?>" alt="<?php echo $action['desc']?>" title="<?php echo $action['desc']?>"
                        onmouseover="javascript:document.getElementById('<?php echo $id?>').innerHTML='<?php echo $action['desc']?>';"
                        onmouseout="javascript:document.getElementById('<?php echo $id?>').innerHTML='____________';"></a>
                </td>
        <?php  } else { ?>
                <td width="16"><img src="<?php echo $this->a_this->getImage('blank.gif')?>" width="16" height="16"></td>
        <?php  } ?>
    <?php  } ?>
        <td width="100%">
            &nbsp;<b id="<?php echo $id?>">____________</b>
        </td>
        </tr>
        </table>
<?php  } ?>