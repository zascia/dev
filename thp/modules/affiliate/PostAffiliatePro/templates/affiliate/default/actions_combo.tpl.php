<?php  if(count($this->a_actions) == 0) { ?>
        <?php echo L_G_NOACTIONS?>
<?php  } else { ?>
    <select name=action_select OnChange="performAction(this);">
            <option value="-" selected>------------------------</option>
    <?php  
        foreach ($this->a_actions as $id => $action) { ?>
            <option value="javascript:<?php echo $action['action']?>;"><?php echo $action['desc']?></a>
    <?php  } ?>
    </select>
<?php  } ?>