<?php if($_SESSION[SESSION_PREFIX.'installmethod'] == '') { ?>
    
<table border=0 width=100% cellspacing=2 cellpadding=2>
<tr>
  <td width=20% class="done">Start</td>
  <td width=20% class="waiting">...</td>
  <td width=20% class="waiting">...</td>
  <td width=20% class=waiting>...</td>
  <td width=20% class=waiting>...</td>
</tr>
</table>   
 
<?php } else if($_SESSION[SESSION_PREFIX.'installmethod'] == 'install') { ?>

<table border=0 width=100% cellspacing=2 cellpadding=2>
<tr>
  <td width=16% class="<?php echo (in_array($_REQUEST['action'], array('DbConfig', 'DbCreate', 'MerchantConfig', 'Settings', 'Finish')) ? 'done' : 'waiting')?>">Install</td>
  <td width=16% class="<?php echo (in_array($_REQUEST['action'], array('DbConfig', 'DbCreate', 'MerchantConfig', 'Settings', 'Finish')) ? 'done' : 'waiting')?>">Database configuration</td>
  <td width=16% class="<?php echo (in_array($_REQUEST['action'], array('DbCreate', 'MerchantConfig', 'Settings', 'Finish')) ? 'done' : 'waiting')?>">Database creation</td>
  <td width=16% class="<?php echo (in_array($_REQUEST['action'], array('MerchantConfig', 'Settings', 'Finish')) ? 'done' : 'waiting')?>">Merchant account</td>
  <td width=16% class="<?php echo (in_array($_REQUEST['action'], array('Settings', 'Finish')) ? 'done' : 'waiting')?>">Global settings</td>
  <td width=16% class="<?php echo (in_array($_REQUEST['action'], array('Finish')) ? 'done' : 'waiting')?>">Finish</td>
</tr>
</table>

<?php } else if($_REQUEST['installmethod'] == 'upgradefree') { ?>

<table border=0 width=100% cellspacing=2 cellpadding=2>
<tr>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('settingscheckoutfree', 'convertedfromfree', 'finish')) ? 'done' : 'waiting')?>">Upgrade from free version</td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('settingscheckoutfree', 'convertedfromfree', 'finish')) ? 'done' : 'waiting')?>">Databases configuration</td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('convertedfromfree', 'finish')) ? 'done' : 'waiting')?>">Database conversion</td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('finish')) ? 'done' : 'waiting')?>">Finish</td>
</tr>
</table>

<?php } else if($_REQUEST['installmethod'] == 'upgrade122') { ?>

<table border=0 width=100% cellspacing=2 cellpadding=2>
<tr>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('settingscheckout', 'startconvertfrom12x', 'convertedsettings12x', 'convertedfrom12x', 'finishconvert', 'finishconvert2')) ? 'done' : 'waiting')?>">Install</td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('settingscheckout', 'startconvertfrom12x', 'convertedsettings12x', 'convertedfrom12x', 'finishconvert', 'finishconvert2')) ? 'done' : 'waiting')?>"><?php echo L_G_SETTINGSCHECKOUT?></td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('convertedfrom12x', 'convertedsettings12x', 'finishconvert', 'finishconvert2')) ? 'done' : 'waiting')?>"><?php echo L_G_DBCONVERT?></td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('convertedsettings12x', 'finishconvert', 'finishconvert2')) ? 'done' : 'waiting')?>"><?php echo L_G_SETTINGSCONVERT?></td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('finishconvert2')) ? 'done' : 'waiting')?>">Finish</td>
</tr>
</table>

<?php } else if($_POST['installmethod'] == 'upgrade13') { ?>

<table border=0 width=100% cellspacing=2 cellpadding=2>
<tr>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('settingscheckout13', 'startconvertfrom13', 'convertedfrom13', 'finishconvert', 'finishconvert2')) ? 'done' : 'waiting')?>">Install</td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('settingscheckout13', 'startconvertfrom13', 'convertedfrom13', 'finishconvert', 'finishconvert2')) ? 'done' : 'waiting')?>"><?php echo L_G_SETTINGSCHECKOUT?></td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('convertedfrom13', 'finishconvert', 'finishconvert2')) ? 'done' : 'waiting')?>"><?php echo L_G_DBCONVERT?></td>
  <td width=16% class="<?php echo (in_array($_POST['action'], array('finishconvert2')) ? 'done' : 'waiting')?>">Finish</td>
</tr>
</table>

<?php } ?>
