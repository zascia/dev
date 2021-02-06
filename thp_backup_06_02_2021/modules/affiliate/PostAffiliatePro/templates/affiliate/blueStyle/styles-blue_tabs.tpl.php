.tabSpacer
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_topspacer.png') ?>");
    BACKGROUND-REPEAT: repeat-x;
    width: 5px;
}
.tabLeftTab
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_tablefttab.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    width: 3px;
    height: 40px;
}
.tabRightTab
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_tabrighttab.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    width: 3px;
}
.tabContent
{
    border-top: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    background-color: <?php echo $this->a_colors->getColor('tableheader')?>;
    min-width: 50px;
    text-align: center;
    vertical-align: middle;
    color: #333333;
    font: 11px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: bold;
}
.tabContentText {
    text-align: center;
    vertical-align: middle;
    color: #333333;
    font: 11px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: bold;
}
.tabLeftTabDisabled
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_tablefttab_dis.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    width: 3px;
}
.tabRightTabDisabled
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('blue_tabrighttab_dis.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
    width: 3px;
}
.tabContentDisabled
{
    border-top: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    background-color: <?php echo $this->a_colors->getColor('tableheader2')?>;
    min-width: 50px;
    text-align: center;
    vertical-align: middle;
    color: #666666;
    font: 11px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: bold;
}
.tabLine
{
    width: 100px;
    height: 5px;
    background-color: #B3CED9;
    BORDER-LEFT: #5993AB 1px solid;
    BORDER-RIGHT: #5993AB 1px solid;
}

.tabEdgeBorder1
{
    background-color: <?php echo $this->a_colors->getColor('border')?>;
    width: 1px;
    height: 1px;
}

.tabEdgeBorder2
{
    background-color: <?php echo $this->a_colors->getColor('border')?>;
    width: 2px;
    height: 1px;
}

.tabEdgeBorder3
{
    background-color: <?php echo $this->a_colors->getColor('border')?>;
    width: 1px;

}

.tabEdgeBorder4
{
    background-color: <?php echo $this->a_colors->getColor('border')?>;
    height: 1px;
}

.tabEdgeContent
{
    background-color: <?php echo $this->a_colors->getColor('tableheader')?>;
}

.tabEdgeContentDisabled
{
    background-color: <?php echo $this->a_colors->getColor('tableheader2')?>;
}
