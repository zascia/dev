<?php echo  $this->a_this->fetch('styles-blue_topmenu') ?>
<?php echo  $this->a_this->fetch('styles-blue_leftmenu') ?>
<?php echo  $this->a_this->fetch('styles-blue_tabs') ?>
H5
{
    font: 16px Arial, Tahoma, Verdana, Helvetica, sans-serif;
    font-weight: bold;
    margin-bottom: 3px;
    margin-top: 0px;
}
H6
{
    font: 14px Arial, Tahoma, Verdana, Helvetica, sans-serif;
    font-weight: bold;
    margin-bottom: 3px;
    margin-top: 0px;
}
FORM
{
    margin-top: 0px;
    margin-bottom: 0px;
}
INPUT
{
    font: 11px Arial, Verdana, Helvetica, sans-serif;
}
SELECT
{
    font: 11px Arial, Verdana, Helvetica, sans-serif;
}
IMG
{
    BORDER: 0;
}
.logo
{
    BACKGROUND-IMAGE: url("<?php echo  $this->a_this->getImage('wdlogo.png') ?>");
    BACKGROUND-REPEAT: no-repeat;
}
TEXTAREA
{
    font: 11px Arial, Verdana, Helvetica, sans-serif;
}

A.mainlink
{
    font-size: 11px;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    color: <?php echo $this->a_colors->getColor('normallink')?>;
    text-decoration: none;
    CURSOR: pointer;
}
.apFaq {
    vertical-align:top;
    text-align: left;
    color: #0000CC;
    font-family:Tahoma,arial ,verdana,sans-serif;
    font-size:12px;
    font-weight:bold; 
}
.apFaqAnswer {
    vertical-align:top;
    text-align: left;
    color: #0000CC;
    font-family:Tahoma,arial ,verdana,sans-serif;
    font-size:12px;
    font-weight:bold; 
    TEXT-DECORATION: underline
}
.helplink
{
    font-size: 10px;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    color: <?php echo $this->a_colors->getColor('helplink')?>;
    text-decoration: underline;
    CURSOR: pointer;
}

.simplelink
{
    font-size: 11px;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    color: <?php echo $this->a_colors->getColor('normallink')?>;
    text-decoration: underline;
    CURSOR: pointer;
    FONT-WEIGHT: normal;
}
.textlink
{
	COLOR: <?php echo $this->a_colors->getColor('textlink')?>;
    FONT-FAMILY: Tahoma, Arial,Helvetica,sans-serif;
    FONT-SIZE: 11px;
    FONT-WEIGHT: normal
}

.filterline
{
    height: 1px;
	color: <?php echo $this->a_colors->getColor('tableheader')?>;
}

.minusCost
{
	color: #ff0000;
}

TD
{
    font: 11px Tahoma, Arial, Verdana, Helvetica, sans-serif;
}

.advertisementTable
{
    border: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.advertisementCaption
{
    font-size: 9px;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    color: #ffffff;
    background-color: <?php echo $this->a_colors->getColor('border')?>;
}

.minihelp
{
    font: 11px Tahoma, Arial, Verdana, Helvetica, sans-serif;
	COLOR: #444444;
}
.contents
{
    background-color: #FFFFFF;
    text-align: left;
    vertical-align: top;
}

.footer
{
    color: <?php echo $this->a_colors->getColor('footer_text')?>;
    height: 15px;
    background-color: <?php echo $this->a_colors->getColor('footer_background')?>;
    border-top: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}
.formbutton
{
    font-size: 11px;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    border-left: 1px solid <?php echo $this->a_colors->getColor('frm_button_shadow')?>;
    border-bottom: 1px solid <?php echo $this->a_colors->getColor('frm_button_shadow')?>;
    border-right: 1px solid <?php echo $this->a_colors->getColor('frm_button_shadow')?>;
    border-top:  1px solid <?php echo $this->a_colors->getColor('frm_button_light')?>;
    cursor: pointer;
    background-color: <?php echo $this->a_colors->getColor('form_button')?>;
    padding: 2px 5px 2px 5px;
}
.forminput
{
    font-size: 11px;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    color: #000000;
    border-style: solid;
    border-width: 1;
    border-color: <?php echo $this->a_colors->getColor('border')?>;
    background-color: #FFFFFF;
}

.listing
{
    border: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listingBorderTopRight
{
    border-top: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    border-right: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}


.errorMsgTable
{
    border: <?php echo $this->a_colors->getColor('error_border')?> 1px solid;
    width: 450px;
}

.okMsgTable
{
    border: <?php echo $this->a_colors->getColor('ok_border')?> 1px solid;
    width: 450px;
}

.settings
{
    border-left: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    border-right: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    border-bottom: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.settingsLine
{
    border-top: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    height: 1px;
}

.listingClosed
{
    border: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listing .hidableHeader {
    DISPLAY: block
}
.listingClosed .hidableHeader {
    DISPLAY: none
}

.actionheader
{
    background-color: <?php echo $this->a_colors->getColor('actionheader')?>;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    height: 20px;
    padding-left: 2px;
}

.tableheader
{
    background-color: <?php echo $this->a_colors->getColor('tableheader')?>;
    TEXT-ALIGN: left;
    VERTICAL-ALIGN: middle;
    FONT-WEIGHT: normal;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('tableheader')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.errorMessageHeader
{
    background-color: <?php echo $this->a_colors->getColor('error_header')?>;
    TEXT-ALIGN: left;
    VERTICAL-ALIGN: middle;
    FONT-WEIGHT: bold;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('error_border')?> 1px solid;
}

.okMessageHeader
{
    background-color: <?php echo $this->a_colors->getColor('ok_header')?>;
    TEXT-ALIGN: left;
    VERTICAL-ALIGN: middle;
    FONT-WEIGHT: bold;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('ok_border')?> 1px solid;
}

.tableheader2
{
    TEXT-ALIGN: left;
    VERTICAL-ALIGN: middle;
    FONT-WEIGHT: normal;
    padding: 2px;
    background-color: <?php echo $this->a_colors->getColor('tableheader2')?>;
    BORDER-TOP: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.errorMessage
{
    color: <?php echo $this->a_colors->getColor('error_message')?>;
}

.okMessage
{
    color: <?php echo $this->a_colors->getColor('ok_message')?>;
}

.sideborders
{
    BORDER-LEFT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listheader
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: center;
    FONT-WEIGHT: bold;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listheaderLineTop
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: center;
    FONT-WEIGHT: bold;
    BORDER-TOP: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listheaderLineRight
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listheadersort
{
    background-color: <?php echo $this->a_colors->getColor('listheader_sort')?>;
    TEXT-ALIGN: center;
    FONT-WEIGHT: bold;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listheaderLeft
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: left;
    FONT-WEIGHT: bold;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listheaderNoRightLine
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: center;
    FONT-WEIGHT: bold;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listPaging
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: center;
    FONT-WEIGHT: bold;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listheaderNoLineNoBold
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: center;
}

.listheaderNoBold
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: center;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listheaderNoLine
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: center;
    FONT-WEIGHT: bold;
}

.listheaderNoLineLeft
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: left;
    FONT-WEIGHT: bold;
}

.listViewLine
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: left;
    height: 25px;
    VERTICAL-ALIGN: middle;
    BORDER-TOP: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listViewLineRight
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: right;
    height: 25px;
    VERTICAL-ALIGN: middle;
    BORDER-TOP: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.tablelistheader
{
    background-color: <?php echo $this->a_colors->getColor('listheader')?>;
    TEXT-ALIGN: center;
    FONT-WEIGHT: bold;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.header
{
    background-color: <?php echo $this->a_colors->getColor('tableheader')?>;
    TEXT-ALIGN: center;
    FONT-WEIGHT: bold;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listresult
{
    TEXT-ALIGN: center;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listresultBorderRight
{
    TEXT-ALIGN: center;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listresult2
{
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border2')?> 1px solid;
}

.listrow0
{
    background-color: <?php echo $this->a_colors->getColor('listresult_row1')?>;
}

.listrow1
{
    background-color: <?php echo $this->a_colors->getColor('listresult_row2')?>;
}

.detailrow0
{
    background-color: <?php echo $this->a_colors->getColor('datail_row2')?>;
}


.detailrow1
{
    background-color: <?php echo $this->a_colors->getColor('datail_row1')?>;
}

.settingtab
{
    TEXT-ALIGN: center;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-LEFT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listresultNoRightLine
{
    TEXT-ALIGN: center;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listresultnocenter
{
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listresultMouseOver
{
    background-color: <?php echo $this->a_colors->getColor('listresult_row2')?>;
    TEXT-ALIGN: center;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listresultSelected
{
    background-color: <?php echo $this->a_colors->getColor('listresult_row2')?>;
    TEXT-ALIGN: center;
    BORDER-RIGHT: <?php echo $this->a_colors->getColor('border')?> 1px solid;
    BORDER-BOTTOM: <?php echo $this->a_colors->getColor('border')?> 1px solid;
}

.listresultNoLine
{

}

UL.errorMessage
{
    margin-left: 20px;
    padding-left: 0px;
}

.okMessage2
{
    margin-left: 20px;
    padding-left: 0px;
}

LI.errorMessage
{
    padding-left: 0px;
}

.okMessage
{
    padding-left: 0px;
}

.formBText
{
    font: 11px Arial, Verdana, Helvetica, sans-serif;
    FONT-WEIGHT: bold;
}

.formText
{
    font: 11px Arial, Verdana, Helvetica, sans-serif;
}

.formRowOdd
{
    background-color: <?php echo $this->a_colors->getColor('listresult_row1')?>;
}

.formRowEven
{
    background-color: <?php echo $this->a_colors->getColor('listresult_row2')?>;
}

/* JS-Calendar */
.dynCalendarHeader{
	font-family: Arial, Verdana, Helvetica, Sans-Serif;
	font-size: 10pt;
	font-weight: bold;
}
.dynCalendarDayname {
	background-color: #eeeeee;
	border: 1px solid #c0c0c0;
	font-family: Arial, Verdana, Helvetica, Sans-Serif;
	font-size: 8pt;
	text-align: center;
}

.dynCalendarDay {
	background-color: #eeeeee;
	color: #000000;
	font-family: Arial, Verdana, Helvetica, Sans-Serif;
	font-size: 8pt;
}

.dynCalendarToday {
	background-color: #ffffff;
	border: 1px solid #c0c0c0;
	font-family: Arial, Verdana, Helvetica, Sans-Serif;
	font-size: 8pt;
}

.dynCalendar {
	background-color: #c0c0c0;
	border: 2px outset white;
	visibility: hidden;
	position: absolute;
	top: 1px;
	left: 1px;
	z-index: 100;
}

.ffldiro {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 8pt;
    color: #000000;
    background-color: #F5F5F5;
	font-weight: bold;
	font-style: italic;
	border: 1px dashed #333333;
}

.bannerCategories {
    border:1px solid #e0e0e0;
    background-color:#f0f0f0;
    padding: 10px;
    width: 750px;
}

.bannerCategories h5 {
    margin: 0px;
}
A.biggerRedLink {
    color: #ff0000;
	font-weight: bold;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px;
}

.campaignRow {
    padding:0;
    margin-bottom: 1em;
    border: 1px solid #5993AB;
    width: 780px;
}

.campaignRow .campaignName {
    font-size: larger;
    margin-bottom: 1px;
    padding: 0.2em;
    background-color: #B3CED9;
    border-bottom: 1px solid #5993AB;
}

.campaignRow .actions {
    float: right;
    padding: 0.5em;
}

.campaignRow .banner {
    margin-bottom: 1px;
    padding: 0.5em;
}

.campaignRow .panel {
    padding: 0.5em;
    margin: 1px;
}

.campaignRow .lpanel {
    float: left;
}

.campaignRow .rpanel {
    margin-left: 50%;
}

campaignRow .shortDescription {
    padding: 0.2em;
}

.campaignRow .description {
    padding: 0.5em;
    margin: 1px;
}

.tableOpened
{
    width: 700px;
}

.tableClosed
{
    width: 700px;
}

.tableOpened .firstStepsText {
	DISPLAY: block
}
.tableClosed .firstStepsText {
	DISPLAY: none
}

.firstStepsHeader
{
    background-color: #EAEFFC;
    color: <?php echo $this->a_colors->getColor('menu_link')?>;
    height: 20px;
    padding-left: 8px;
	font: 14px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: bold;
    border: #D6DFF5 1px solid;    
}
.firstStepsHeader2
{
    background-color: #F3F6FD;
    color: <?php echo $this->a_colors->getColor('menu_link')?>;
    height: 20px;
    padding-left: 8px;
	font: 12px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: bold;
    border: #D6DFF5 1px solid;
}
.fsSmall {
    color: #000000;
	font: 10px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: normal;
}
DIV.firstStepsText {
	font: 12px Tahoma, Arial, Verdana, Helvetica, sans-serif;
    font-weight: normal;
    padding-left: 22px;
}
