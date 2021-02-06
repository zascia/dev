.headerTopMenuActiveColor
{
    background-color: #ffffff;
}
TD.headerLogo
{
    BACKGROUND-COLOR: #ffffff;
    width: 180px;
    height: 57px;
    font-weight: bold;
}
.topHeader
{
    BACKGROUND-COLOR: #ffffff;
    width: 100%;
    height: 25px;
}
.topUserInfo
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('topmenuuserinfo.gif') ?>");
    BACKGROUND-REPEAT: repeat-x;
    BACKGROUND-COLOR: #ffffff;
}
.headerTopMenuLeft
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('topmenuleft.gif') ?>");
    BACKGROUND-color: #F0F0F0;
    width: 6px;
    height: 50px;
}
.headerTopMenuLeftActive
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('topmenuleftactive.gif') ?>");
    BACKGROUND-color: #F0F0F0;
    width: 6px;
    height: 50px;
}
.headerTopMenuRight
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('topmenuright.gif') ?>");
    BACKGROUND-color: #F0F0F0;
    width: 9px;
    height: 50px;
}
.headerTopMenuRightActive
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('topmenurightactive.gif') ?>");
    BACKGROUND-color: #F0F0F0;
    width: 9px;
    height: 50px;
}
.headerTopMenu
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('topmenu.gif') ?>");
    BACKGROUND-REPEAT: repeat-x;
    BACKGROUND-color: #F0F0F0;
    height: 50px;
    width: 66px;
    text-align: center;
    vertical-align: top;
}
.headerTopMenuActive
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('topmenuactive.gif') ?>");
    BACKGROUND-REPEAT: repeat-x;
    BACKGROUND-color: #ffffff;
    height: 50px;
    width: 66px;
    text-align: center;
    vertical-align: top;
}
.headerTopMenuTopSpacer
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('topmenuuserinfo.gif') ?>");
    BACKGROUND-REPEAT: repeat-x;
    BACKGROUND-color: #ffffff;
    height: 6px;
    width: 6px;
}
.headerTopMenuUpperSpacer
{
    BACKGROUND-color: #ffffff;
    text-align: right;
    height: 14px;
}
.headerTopMenuSpacer
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_topmenuspacer.png') ?>");
    BACKGROUND-REPEAT: repeat-x;
    width: 5px;
    height: 24px;
}
.headerLogo
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('topmenuuserinfo.gif') ?>");
    BACKGROUND-REPEAT: repeat-x;
    BACKGROUND-POSITION: bottom left;
    -vertical-align: bottom;
    height: 50px
}
.topSmallMenu
{
    BACKGROUND-color: #E0E4E5;
    height: 24px;
}
.topSmallNavigation
{
    BACKGROUND-color: #E0E4E5;
    height: 20px;
}
.topMenuLeftTab
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_topmenulefttab.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    width: 3px;
    height: 22px;
}
.topMenuRightTab
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_topmenurighttab.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    width: 3px;
    height: 22px;
}
.topMenuContent
{
    border-top: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    background-color: #ffffff;
    width: 110px;
    height: 22px;
    text-align: center;
    vertical-align: middle;
    color: #333333;
    font: 11px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: bold;
}
.topMenuLeftTabDisabled
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_topmenulefttab_dis.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    width: 3px;
    height: 22px;
}
.topMenuRightTabDisabled
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_topmenurighttab_dis.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    width: 3px;
    height: 22px;
}
.topMenuContentDisabled
{
    border-top: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    background-color: #D6DFF5;
    width: 110px;
    height: 22px;
    text-align: center;
    vertical-align: middle;
    color: #666666;
    font: 11px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: bold;
}
.topMenuLine
{
    width: 100px;
    height: 5px;
    background-color: <?php echo $this->a_colors->getColor('background')?>;
}
.topMenuLineAboveMenu
{
    width: 175px;
    height: 1px;
    background-color: <?php echo $this->a_colors->getColor('background_logo')?>;
}

.topMenuLineAboveContent
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blank.gif') ?>");
    BACKGROUND-REPEAT: no-repeat;
    height: 5px;
    background-color: #FFFFFF;
    border-top: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}
.topCorner
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_topcorner.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    width: 7px;
    height: 5px;
    background-color: <?php echo $this->a_colors->getColor('background_logo')?>;
}



A.pa_menuLink {
    color: #333333;
    text-decoration: none;
    font-size: 11px;
    font-weight: bold;
}

A.papTopMenuLink
{
    font-size: 10px;
    font-family: Tahoma, Arial, Verdana, Helvetica, sans-serif;
    color: <?php echo $this->a_colors->getColor('menu_link')?>;
    text-decoration: none;
    CURSOR: pointer;
}
.papTopMenuLinkDisabled
{
    font-size: 11px;
    font-family: Tahoma, Arial, Verdana, Helvetica, sans-serif;
    color: <?php echo $this->a_colors->getColor('menu_link_disabled')?>;
    text-decoration: none;
    CURSOR: pointer;
}
