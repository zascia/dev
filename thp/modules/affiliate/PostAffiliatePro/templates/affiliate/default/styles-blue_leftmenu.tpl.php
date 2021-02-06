A.aLeftMenuItem {
	COLOR: <?php echo $this->a_colors->getColor('menu_link2')?>;
    FONT-FAMILY: Tahoma, Arial,Helvetica,sans-serif;
    FONT-SIZE: 11px;
    FONT-WEIGHT: normal
}

TD.leftMenuMain
{
    width: 172px;
    height: 100%;
    text-align: left;
    vertical-align: top;
}

.leftMenu
{
    text-align: left;
    vertical-align: top;
    height: 100%;
    background-color: <?php echo $this->a_colors->getColor('background')?>;
}

.leftMenuContent
{
    width: 178px;
    height: 100%;
    text-align: left;
    vertical-align: top;
    background-color: <?php echo $this->a_colors->getColor('background')?>;
}

.leftMenuContentBorder
{
    width: 3px;
    height: 100%;
    background-color: <?php echo $this->a_colors->getColor('background')?>;
}

.topSmallNavigation
{
    height: 22px;
    background-color: <?php echo $this->a_colors->getColor('background')?>;
    border-bottom: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.leftMenuBorder
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_leftmenuborder.png') ?>");
    BACKGROUND-REPEAT: repeat-y;
    width: 6px;
    height: 100%;
    background-color: #FFFFFF;
}

.leftMenuLine
{
    width: 1px;
    height: 100%;
    background-color: <?php echo $this->a_colors->getColor('border')?>;
}

.leftMenuTableOpened
{
    width: 100%;
    border: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.leftMenuTableClosed
{
    width: 100%;
    border: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.leftMenuTableOpened .menuTree {
	DISPLAY: block
}
.leftMenuTableClosed .menuTree {
	DISPLAY: none
}

.leftMenuHeader
{
    background-color: <?php echo $this->a_colors->getColor('bacground_active')?>;
    color: <?php echo $this->a_colors->getColor('menu_link')?>;
    height: 20px;
    padding-left: 8px;
	font: 11px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: bold;
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('darrow.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    background-position: 152px;
}

.leftMenuItem
{
    background-image: url("<?php echo  $this->a_this->getImage('blue_leftmenuitem.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    background-position: 10px;
    color: #0056B6;
    height: 17px;
    padding-left: 25px;
	font: 11px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: normal;
}
.leftMenuTop
{
    height: 4px;
}
.leftMenuBottom
{
    height: 5px;
}
