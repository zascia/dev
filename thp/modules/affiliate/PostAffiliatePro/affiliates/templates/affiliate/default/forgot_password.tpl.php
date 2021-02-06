
<SCRIPT>
function validate(form)
{
  if (form.username.value == "")
  {
    alert("<?php echo L_G_YOUHAVETOENTEREMAIL?>");
    return false;
  }

  return true;
}
</SCRIPT>

<form action='forgot_password.php' method=post onsubmit="return validate(this)">
  <table border=0 align=center width="300px">
  <tr>
    <td colspan=2 align=center>
<!--Begin error message-->
<?php //QUnit_Global::includeTemplate('error_msg.tpl.php'); ?>
<!--End error message-->
    </td>
  </tr>
<?php if($this->a_passwordResetSuccess) { ?>
  <tr>
    <td colspan=2 align=center>
        <b><a href="index.php?lid=<?php echo $_REQUEST['lid']?>"><?php echo L_G_LOGIN?></a></b>
        <br><br>
    </td>
  </tr>
<?php } ?>
  <tr>
    <td colspan=2 align=center><b><?php echo L_G_STEP?> 1</b></td>
  </tr>
  <tr>
    <td colspan=2 align=center><?php echo L_G_ENTEREMAIL?></td>
  </tr>
  <tr>
    <td align=right width="100px"><?php echo L_G_USERNAME?>&nbsp;</td>
    <td><input class=logon type=text name=username size=23 value=''></td>
  </tr>
  <tr>
    <td colspan=2 align=center>
      <input type=hidden name=commited value='yes'>
      <input type=hidden name=md value='QCore_ForgotPassword'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=lid value=<?php echo $_REQUEST['lid']?>>
      <input type=hidden name=postaction value=step1>
      <input type=submit class=formbutton value='<?php echo L_G_SUBMIT?>'>
    </td>
  </tr>
  </table>
</form>
<form action='forgot_password.php' method=post onsubmit="return validate(this)">
  <table border=0 align=center width="300px">
  <tr>
    <td colspan=2 align=center><b><?php echo L_G_STEP?> 2</b></td>
  </tr>
  <tr>
    <td colspan=2 align=center><?php echo L_G_ENTERCODE?></td>
  </tr>
  <tr>
    <td align=right><?php echo L_G_CODE?>&nbsp;</td>
    <td><input type="text" name="code"></td>
  </tr>
  <tr>
    <td colspan=2 align=center>
      <input type=hidden name=commited value='yes'>
      <input type=hidden name=md value='QCore_ForgotPassword'>
      <input type=hidden name=action value=<?php echo $_POST['action']?>>
      <input type=hidden name=lid value=<?php echo $_REQUEST['lid']?>>
      <input type=hidden name=postaction value=step2>
      <input type=submit class=formbutton value='<?php echo L_G_SUBMIT?>'>
    </td>
  </tr>
  </table>
</center>
