<script>
function showCode(show) {
    if (show==<?php echo LINK_STYLE_NEW?>) {
        document.getElementById('code_div_old').style.display = "none";
        document.getElementById('code_div_new').style.display = "block";
    }
    else {
        document.getElementById('code_div_new').style.display = "none";
        document.getElementById('code_div_old').style.display = "block";
    }
}
</script>

    <table width="100%" border=0 cellspacing=0 cellpadding=0>
    <?php QUnit_Templates::printFilter(3, L_G_CLICKSTRACKING); ?>
    <tr class="detailrow0">
      <td class=dir_form valign=top nowrap width="140" style="padding: 5px"><b><?php echo L_G_LINKSTYLE?></b></td>
      <td colspan=2>
        <input type="radio" name="link_style" value="<?php echo LINK_STYLE_NEW?>" <?php echo ($_POST['link_style'] == LINK_STYLE_NEW ? 'checked' : '')?>
            onclick="javascript: showCode(<?php echo LINK_STYLE_NEW?>);">&nbsp;<b><?php echo L_G_LINKSTYLE_NEW?> (<?php echo L_G_DEFAULT?> & <?php echo L_G_RECOMMENDED?>)</b>
            
        <br>
        <b><font color="#ff0000"><?php echo L_G_LINKSTYLE_NEW_EXAMPLE?></font></b>            
      </td>
    </tr>
    <tr class="detailrow0">
      <td></td>
      <td colspan=2>
        <?php echo L_G_HLP_LINKSTYLE_NEW?>
      </td>
    </tr>
    <tr class="detailrow0">
      <td colspan=3>&nbsp;</td>
    </tr>
    <tr class="detailrow0">
      <td></td>
      <td colspan=2 align="left">
        <input type="radio" name="link_style" value="<?php echo LINK_STYLE_OLD?>" <?php echo ($_POST['link_style'] == LINK_STYLE_OLD ? 'checked' : '')?>
            onclick="javascript: showCode(<?php echo LINK_STYLE_OLD?>);">&nbsp;<b><?php echo L_G_LINKSTYLE_OLD?></b>
            
        <br>
        <b><font color="#ff0000"><?php echo L_G_LINKSTYLE_OLD_EXAMPLE?></font></b>
      </td>
    </tr>
    <tr class="detailrow0">
      <td></td>
      <td colspan=2>
        <?php echo L_G_HLP_LINKSTYLE_OLD?>
      </td>
    </tr>
    
    <tr class="detailrow0">
      <td colspan=3><br><br><br><br><br></td>
    </tr>
    
    <tr>
      <td colspan="3">
      
<!-- NEW STYLE DIV -->
      <div id='code_div_new' <?php echo ($_POST['link_style'] == LINK_STYLE_OLD) ? 'style="display: none;"' : ''?>>
      <table width="100%" border=0 cellspacing=0 cellpadding=5>
      <tr class="detailrow1">
        <td class=formBText valign=top nowrap><?php echo L_G_URL_TO_MAIN_SITE;?></td>
        <td valign=top><input type=text size=70 name=main_site_url value="<?php echo $_POST['main_site_url']?>"> *
            <?php showQuickHelp(L_G_HLPURL_TO_MAIN_SITE); ?></td>
      </tr>
      <tr class="detailrow0">
        <td align=left colspan=2>
        <?php echo L_G_CLICKTRACKINGHLP?>
        </td>
      </tr>
      <tr class="detailrow0">
        <td align=center colspan=2>
        <textarea rows=11 cols=100><script id="pap_x2s6df8d" src="<?php echo $this->a_Auth->getSetting('Aff_scripts_url')?>track.js" type="text/javascript">
</script>

<script type="text/javascript">
<!--
papTrack();
//-->
</script></textarea>
        </td>
      </tr>
    </table>
    </div>

<!-- OLD STYLE DIV -->
    <div id='code_div_old' <?php echo ($_POST['link_style'] == LINK_STYLE_NEW) ? 'style="display: none;"' : ''?>>
    <table width="100%" border=0 cellspacing=0 cellpadding=5>
      <tr class="detailrow1">
        <td align=left>
          <b><?php echo L_G_ORIGINALREFERRERTRACKINGHLP?></b><br>
          <?php echo L_G_ORIGINALREFERRERTRACKING_DESCRIPTION?>
        </td>
      </tr>
      <tr class="detailrow0">
        <td align=left>
        <?php echo L_G_ORIGREFHLP?>
        </td>
      </tr>
      <tr class="detailrow0">
        <td align=center>
        <textarea rows=11 cols=100><script>
<!--
    if(document.referrer != '')
        document.write('<script src="<?php echo $this->a_Auth->getSetting('Aff_scripts_url')?>sr.php?ref='+escape(document.referrer)+'"></script>');
//-->
</script></textarea>
        </td>
      </tr>
    </table>
    </div>

      </td>
    </tr>
    </table>
