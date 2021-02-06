    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <?php QUnit_Templates::printFilter(2, L_G_ACTIONS); ?>
    <?php if($this->a_action_permission['create']) { ?>
      <tr>
        <td align=left nowrap>
            &nbsp;<img src="<?php echo $this->a_this->getImage('add.png')?>" border=0>
        </td>
        <td align=left nowrap>
           <b><a class=mainlink href="javascript:addTransaction();"><?php echo L_G_CREATETRANSACTION?></a></b>&nbsp;
        </td>
      </tr>
    <?php } ?>
    <?php if($this->a_action_permission['view']) { ?>
      <tr>
        <td align=left nowrap>
            &nbsp;<img src="<?php echo $this->a_this->getImage('export.png')?>" border=0>
        </td>
        <td align=left nowrap>
           <b><a class=mainlink href="javascript:FilterForm.action.value='exportcsv'; FilterForm.submit();"><?php echo L_G_EXPORTTOCSV?></a></b>&nbsp;
        </td>
      </tr>
    <?php } ?>
    </table>
