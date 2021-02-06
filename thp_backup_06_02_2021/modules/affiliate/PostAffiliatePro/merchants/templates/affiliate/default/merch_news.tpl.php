<?php $data=$this->a_news_data; ?>

  <form action=index.php method=post>
  <table class=listing width="500" cellspacing=0 cellpadding=3 border=0>
    <?php QUnit_Templates::printFilter(1, $data['title']); ?>
    <tr>
      <td align=left nowrap><i><?php echo $data['dateinserted']?></i></td>
    </tr>
    <tr>
      <td align=left><?php echo nl2br($data['rtext'])?>&nbsp;</td>
    </tr>
    <tr>
      <td align=center>
        <input type=hidden name=commited value=yes>
        <input type=hidden name=md value='Affiliate_Merchants_Views_News'>
        <input type=hidden name=action value=<?php echo $_POST['action']?>>
        <input type=hidden name=nid value='<?php echo $_POST['nid']?>'>
        <input type=hidden name=view_old value='<?php echo $_REQUEST['view_old']?>'>
        <?php if($data['status'] != MESSAGESTATUS_NOT_SHOW) { ?>
          <input type=submit class=formbutton value='<?php echo L_G_DO_NOT_SHOW_THIS_NEWS_AGAIN?>'>&nbsp;&nbsp;
        <?php } ?>
        <input class=formbutton type=button value='<?php echo L_G_BACK?>' onClick='javascript:history.go(-1);'>
      </td>
    </tr>
  </table>
  </form>

  <br>
