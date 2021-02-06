    <table cellpadding="0" cellspacing="0" border="0" width="780">
    <tr>
        <td valign=top><?php echo $_POST['description']?><br><br>
        </td>
    </table>
    <br>

    <form action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=0>
    <?php QUnit_Templates::printFilter(1, $_POST['header']); ?>
    <tr><td>
    <table border=0 cellspacing=0 cellpadding=2>
    <tr>
      <td class=dir_form>&nbsp;<b><?php echo L_G_NAME2;?></b>&nbsp;</td>
      <td><input type=text name=name size=44 value="<?php echo $_POST['name']?>">*&nbsp;</td>
    </tr>
    </table>

    </td></tr>
    <?php QUnit_Templates::printFilter(2, L_G_USER_RIGHTS); ?>
    <tr><td>
    <?php $i=0; ?>
    <table border=0 cellspacing=0 cellpadding=2 width="100%">
    <?php if(is_array($this->a_rts)) { ?>
      <?php $maxRightTypes = 0;
         foreach($this->a_rts as $category) {
           if(is_array($category['rights'])) {
             foreach($category['rights'] as $code => $right) {
                 if (count($right['types']) > $maxRightTypes)
                    $maxRightTypes = count($right['types']);
             }
           }
         }
      ?>
      <?php foreach($this->a_rts as $category) { ?>
        <tr class="listrow<?php echo ($i++)%2?>">
          <td valign=top colspan="<?php echo 1+$maxRightTypes?>" nowrap>&nbsp;<b><?php echo (defined($category['category']) ? constant($category['category']) : $category['category'])?></b>&nbsp;</td>
        </tr>
        <?php if(is_array($category['rights'])) { ?>
          <?php foreach($category['rights'] as $code => $right) { ?>
            <tr class="listrow<?php echo ($i++)%2?>">
              <td valign=top nowrap>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (defined($right['right']) ? constant($right['right']) : $right['right'])?>&nbsp;</td>
              <?php $j = 0;
                 foreach($right['types'] as $type) {
                   $j++; ?>
                   <td valign=top nowrap>
                    <input type=checkbox name=userrighttype[] value='<?php echo $type['righttypeid']?>'
                            <?php echo (in_array($type['righttypeid'], $_POST['userrighttype']) ? 'checked' : '')?>
                            >&nbsp;<?php echo (defined($type['langid']) ? constant($type['langid']) : $type['langid'])?>&nbsp;
                   </td>
              <?php } ?>
              <?php if ($j < $maxRightTypes) { ?>
                    <td colspan="<?php echo $maxRightTypes-$j?>">&nbsp;</td>
              <?php } ?>
            </tr>
          <?php } ?>
        <?php } ?>
      <?php } ?>
    <?php } ?>
<!--
<?php //while($data=$this->a_list_data->getNextRecord()) { ?>
    <tr>
      <td valign=top colspan=2><input type=checkbox name=userrighttype[] value=<?php //=$data['code']?>
             <?php //=(in_array($data['code'], $_POST['userrighttype']) ? 'checked' : '')?>><?php //eval("echo ".$data['langid'].";");?></td>
    </tr>
<?php //} ?>
-->
    </td></tr>
    </table>
    <tr>
      <td class=dir_form align=center><br>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_UserProfiles'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=upid value=<?php echo $_POST['upid']?>>
      <input type=hidden name=postaction value=<?php echo $_POST['postaction']?>>
      <input type=submit class=formbutton value='<?php echo L_G_SUBMIT; ?>'>
      <br><br>
      </td>
    </tr>
    </table>
    </form>
    <br><br>