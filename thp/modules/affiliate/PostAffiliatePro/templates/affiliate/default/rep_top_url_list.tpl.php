<table class=listing border=0 cellspacing=0 cellpadding=2 width="780">
    <tr>
        <td bgcolor="#F3F3F3" colspan=3 height=150 valign=bottom>
        <?php echo $this->a_topurls_graph?>
        </td>
    </tr>    
    <tr>
      <td class=settingsLine colspan=3 align=center>
        <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
      </td>
    </tr>
    <tr>
        <td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>        
    </tr>
        <td class="listresult2">&nbsp;</td>
        <td class="listresult2"><?php echo L_G_REFERERURL?></td>
        <td class="listresult2" width="80"><?php echo L_G_COUNT?></td>
    </tr>
    <tr><td class=settingsLine colspan=3><img border=0 src="<?php echo  $this->a_this->getImage('blank.gif') ?>"></td></tr>
    
    <?php
    //dbg($_REQUEST);
    $i = 1;
    if ($this->a_allcount == 0) {
    ?>
    <tr><td class=listresult1 colspan=2 align=center><?php echo L_G_NORESULTS?></td></tr>
    <?php
    } else {
		while($data=$this->a_list_data->getNextRecord())
        	{
    	?>
    		<tr class="listrow<?php echo ($i++)%2?>">
                <td class=listresult2 align=center valign=middle>
                    <?php if ($_REQUEST['list_page']*$_REQUEST['numrows'] + $i - 1 <= 20) { ?>
                    <table border=0 cellspacing=0 cellpadding=0><tr><td width=10 height=10 bgcolor="#<?php echo ($i>=$this->a_count_data ? $this->a_seriesColor[0] : $this->a_seriesColor[$this->a_count_data-$i])?>"><img src="<?php echo  $this->a_this->getImage('blank.gif') ?>" border="0" width="1px"></td></tr></table>
                    <?php } ?>
                </td>
        		<td class=listresult2 align=left>
        			<?php
					if ($data['refererurl'] == '') {
						echo "&nbsp;".L_G_NOURL;
					} else {
					?>
        			<a href="<?php echo $data['refererurl']?>" target="new">
        			<?php 
        				define('maxLength', 120);
        				$str = $data['refererurl'];
        				while (strlen($str) > maxLength) {
        					echo "&nbsp;".substr($str, 0, maxLength)."<br>";
        					$str = substr($str, maxLength);
        				}
        				echo "&nbsp;".$str;
					}
        		?></a>
        	</td>
        	<td class=listresult2 align=right><?php echo $data['count']?>&nbsp;</td>
        </tr>
    <?php
		}
    }
	?>
    </table>
    
  </center>

  </td>
</tr>
</table>
<br>
</form>