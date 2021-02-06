<script>
function forgot_password()
{
    document.location.href = "forgot_password.php";
}
</script>
  <center>

  <form action=index.php method=post>
  <table border=0 align=center>
  <tr>
    <td colspan=2 align=center><?php echo $this->a_caption?></td>
  </tr><tr>
    <td align=right><?php echo L_G_USERNAME2?>&nbsp;</td><td><input class=logon type=text name=username size=23 value='<?php echo $_REQUEST['username']?>'></td>
  </tr>
  <tr>
    <td align=right><?php echo L_G_PASSWORD?>&nbsp;</td><td><input class=logon type=password name=rpassword size=23 value=''></td>
  </tr>
<?php if($this->a_Auth->getSetting('Aff_allow_choose_lang') == 1)
   {
?>
  <tr>
    <td align=right><?php echo L_G_LANGUAGE?>&nbsp;</td>
    <td>
      <select name=lang>
<?php
      $selectedLang = $_POST['lang'];
      if($selectedLang == '')
        $selectedLang = $this->a_Auth->getSetting('Aff_default_lang');

      while($data=$this->a_list_data->getNextRecord()) { ?>
        <option value="<?php echo $data?>" <?php echo ($selectedLang == $data ? 'selected' : '')?>><?php echo $data?></option>
<?php    } ?>
      </select>
    </td>
  </tr>
<?php } else { ?>
    <input type=hidden name=lang value="<?php echo $this->a_Auth->getSetting('Aff_default_lang')?>">
<?php } ?>
  <tr>
    <td colspan=2 align=center>
    <?php
        $accountid = $_POST['accountid'];
        if($accountid == '') {
            $accountid = DEFAULT_ACCOUNT;
        }
    ?>
      <input type=hidden name=commited value='yes'>
      <input type=hidden name=md value='QCore_Login'>
      <input type=hidden name=query_string value='<?php echo ($_SERVER["QUERY_STRING"] != '') ? $_SERVER["QUERY_STRING"] : ''?>'>
      <input type=hidden name=accountid value='<?php echo $accountid?>'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=submit class=formbutton value="<?php echo L_G_LOGIN?>">
    </td>
  </tr>
  </table>
  </form>
  <br>
  <font size=-1>
  <?php echo L_G_FORGOTPASSWORD?> <a href='javascript:forgot_password();'><?php echo L_G_CLICKHERE?></a>
  </font>
  </center>
