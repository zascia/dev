<script>
<!--
    function setDefaultGraphicBannerFormat() {
        document.getElementById('bannerformat_graphicsformat').value='<?php echo DEFAULT_GRAPHICS_BANNER_FORMAT?>';
    }
    
    function setDefaultTextBannerFormat() {
        document.getElementById('bannerformat_textformat').value='<?php echo DEFAULT_BANNER_FORMAT?>';
    }
-->
</script>
<table width="100%" border=0 cellspacing=0 cellpadding=3>
<?php QUnit_Templates::printFilter2(L_G_BANNERFORMAT_TEXTFORMAT); ?> 
<tr>
<td>
<textarea name="bannerformat_textformat" id="bannerformat_textformat" cols="110" rows="6"><?php echo stripslashes($_POST['bannerformat_textformat'])?></textarea>
<br>
<input type="button" onclick="javascript: setDefaultTextBannerFormat();" value="<?php echo L_G_DEFAULTFORMAT?>">
<p><?php showHelp('L_G_BANNERFORMAT_HELP'); ?></p>
</td>
</tr>
<?php QUnit_Templates::printFilter2(L_G_BANNERFORMAT_GRAPHICSFORMAT); ?> 
<tr>
<td>
<textarea name="bannerformat_graphicsformat" id="bannerformat_graphicsformat" cols="110" rows="6"><?php echo stripslashes($_POST['bannerformat_graphicsformat'])?></textarea>
<br>
<input type="button" onclick="javascript: setDefaultGraphicBannerFormat();" value="<?php echo L_G_DEFAULTFORMAT?>">
<p><?php showHelp('L_G_GRAPHICSBANNERFORMAT_HELP'); ?></p>
</td>


</tr>
</table>