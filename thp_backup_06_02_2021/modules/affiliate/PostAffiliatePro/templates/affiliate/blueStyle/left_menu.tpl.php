<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="leftMenuContent" valign="top">
  
<?php
$permissions = $this->a_Auth->getPermissions();
if($this->a_Auth->isLogged()) 
{ 
    if(!isset($this->leftMenu) || !is_array($this->leftMenu))
        print 'NO MENU ARRAY FOUND';
    else
    {
        // draw menu
        foreach($this->leftMenu as $menuTable)
        {
            $uniq = md5(uniqid(""));

            // draw table
            print '<table class="leftMenuTableOpened" id='.$uniq.' cellspacing="0" cellpadding="0">';
            
            $headerDrawn = false;
            $itemDrawn = false;
            $menuPart = '';
            
            // draw table content
            foreach($menuTable as $menuItem)
            {
                if($menuItem[0] == 'header')
                {
                    // draw header
                    $menuPart .= '<tr><td class="leftMenuHeader" onclick="openMenuItems(\''.$uniq.'\');">'.$menuItem[1].'</td></tr><tr><td class="leftMenuTop"></td></tr>';
                    $headerDrawn = true;
                }
                else // it is item
                {
                    if(count($menuItem) == 2)
                    {
                        // no permission part
                        $link = $menuItem[1];
                    }
                    else
                    {
                        $permission = $menuItem[1];
                        $link = $menuItem[2];
                    }
                    
                    if($permission != '' && !in_array($permission, $permissions))
                        continue;
                        
                    $menuPart .= '<tr><td valign="top" align="left"><DIV class=menuTree>';

                    if(!$itemDrawn)
                    {
                        $menuPart .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
                        $itemDrawn = true;
                    }
                    
                    if(!$headerDrawn)
                        $menuPart .= '<tr><td class="leftMenuTop"></td></tr>';
                        
                    // draw item
                    $menuPart .= '<tr><td class="leftMenuItem">'.$link.'</div></td></tr>';
                }
            }
            
            if($itemDrawn)
            {
                print $menuPart;
                print '<tr><td class="leftMenuBottom"></td></tr></table>';
                print '</div></td></tr></table>';
                
            }
            
            // spacer between menu tables
            print '<table width="100%" height="3" border="0" cellspacing="0" cellpadding="0"><tr><td></td></tr></table>';  
        }
    }
}
?>    

  </td>

</tr>
</table>
