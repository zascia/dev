<?php
QUnit_Global::includeClass('QUnit_Object');

class QUnit_UI_ColorScheme extends QUnit_Object
{

    //------------------------------------------------------------------------

    function QUnit_UI_ColorScheme()
    {
        $this->categories = array();
        $this->colors = array();
        $this->schemes = array();
        $this->name = '';
        $this->image = '';
        $this->title = '';

        $this->addCategory('links', L_G_LINKS);
        $this->addCategory('errormessages', L_G_COLORS_ERRORMESSAGES);
        $this->addCategory('okmessages', L_G_COLORS_OKMESSAGES);
        $this->addCategory('footer', L_G_COLORS_FOOTER);
        $this->addCategory('forms', L_G_COLORS_FORMS);
        $this->addCategory('tables', L_G_TABLES);
        $this->addCategory('menu', L_G_MENU);

        $this->addColor('links', 'normallink', L_G_LINK_NORMAL, '#FFFFFF');
        $this->addColor('links', 'helplink', L_G_LINK_HELP, '#FFFFFF');
        $this->addColor('links', 'textlink', L_G_LINK_TEXT, '#FFFFFF');
        $this->addColor('errormessages', 'error_border', L_G_COLOR_BORDER, '#FFFFFF');
        $this->addColor('errormessages', 'error_header', L_G_COLOR_HEADER, '#FFFFFF');
        $this->addColor('errormessages', 'error_message', L_G_COLOR_MESSAGE, '#FFFFFF');
        $this->addColor('okmessages', 'ok_border', L_G_COLOR_BORDER, '#FFFFFF');
        $this->addColor('okmessages', 'ok_header', L_G_COLOR_HEADER, '#FFFFFF');
        $this->addColor('okmessages', 'ok_message', L_G_COLOR_MESSAGE, '#FFFFFF');
        $this->addColor('footer', 'footer_text', L_G_COLOR_TEXT, '#FFFFFF');
        $this->addColor('footer', 'footer_background', L_G_COLOR_BACKGROUND, '#FFFFFF');
        $this->addColor('forms', 'form_button', L_G_COLOR_BUTTON, '#FFFFFF');
        $this->addColor('forms', 'frm_button_shadow', L_G_COLOR_FRMBTNSHADOW, '#FFFFFF');
        $this->addColor('forms', 'frm_button_light', L_G_COLOR_FRMBTNLIGHT, '#FFFFFF');

        $this->addColor('tables', 'border', L_G_TABLE_BORDER, '#FFFFFF');
        $this->addColor('tables', 'border2', L_G_TABLE_BORDER2, '#FFFFFF');
        $this->addColor('tables', 'actionheader', L_G_TABLE_ACTIONEHEADER, '#FFFFFF');
        $this->addColor('tables', 'tableheader', L_G_TABLE_HEADER, '#FFFFFF');
        $this->addColor('tables', 'tableheader2', L_G_TABLE_HEADER2, '#FFFFFF');
        $this->addColor('tables', 'listheader', L_G_TABLE_LISTHEADER, '#FFFFFF');
        $this->addColor('tables', 'listheader_sort', L_G_TABLE_LISTHEADERSORT, '#FFFFFF');
        $this->addColor('tables', 'listresult_row1', L_G_TABLE_LISTRESULT_ROW1, '#FFFFFF');
        $this->addColor('tables', 'listresult_row2', L_G_TABLE_LISTRESULT_ROW2, '#FFFFFF');
        $this->addColor('tables', 'datail_row1', L_G_TABLE_DETAIL_ROW1, '#FFFFFF');
        $this->addColor('tables', 'datail_row2', L_G_TABLE_DETAIL_ROW2, '#FFFFFF');

        $this->addColor('menu', 'background', L_G_MENU_BACKGROUND, '#FFFFFF');
        $this->addColor('menu', 'background_logo', L_G_MENU_BACKGROUND_LOGO, '#FFFFFF');
        $this->addColor('menu', 'bacground_active', L_G_MENU_BACKGROUND_ACTIVE, '#FFFFFF');
        $this->addColor('menu', 'menu_link', L_G_MENU_LINK, '#FFFFFF');
        $this->addColor('menu', 'menu_link2', L_G_MENU_LINK2, '#FFFFFF');
        $this->addColor('menu', 'menu_link_disbled', L_G_MENU_LINK_DISABLED, '#FFFFFF');

        $this->initSchemes();
    }

    function initSchemes() {
        $this->schemes['Blue'] = array();
        $this->schemes['Blue']['name'] = 'Blue';
        $this->schemes['Blue']['image'] = 'scheme_blue.jpg';
        $this->schemes['Blue']['title'] = L_G_COLORSCHEME_BLUE;
        $this->schemes['Blue']['colors']['normallink'] = '#FF0000';
        $this->schemes['Blue']['colors']['helplink'] = '#00AA00';
        $this->schemes['Blue']['colors']['textlink'] = '#0056B6';
        $this->schemes['Blue']['colors']['error_border'] = '#FF0000';
        $this->schemes['Blue']['colors']['error_header'] = '#FFA9A9';
        $this->schemes['Blue']['colors']['error_message'] = '#FF0000';
        $this->schemes['Blue']['colors']['ok_border'] = '#00AA00';
        $this->schemes['Blue']['colors']['ok_header'] = '#BAFCBA';
        $this->schemes['Blue']['colors']['ok_message'] = '#00AA00';
        $this->schemes['Blue']['colors']['footer_text'] = '#555555';
        $this->schemes['Blue']['colors']['footer_background'] = '#E8EDFA';
        $this->schemes['Blue']['colors']['frm_button_light'] = '#F5F5F5';
        $this->schemes['Blue']['colors']['border'] = '#5993AB';
        $this->schemes['Blue']['colors']['border2'] = '#D9E6EC';
        $this->schemes['Blue']['colors']['actionheader'] = '#FFFFFF';
        $this->schemes['Blue']['colors']['tableheader'] = '#B3CED9';
        $this->schemes['Blue']['colors']['tableheader2'] = '#D6DFF5';
        $this->schemes['Blue']['colors']['listheader'] = '#D9E6EC';
        $this->schemes['Blue']['colors']['listheader_sort'] = '#B3CED9';
        $this->schemes['Blue']['colors']['listresult_row1'] = '#FFFFFF';
        $this->schemes['Blue']['colors']['listresult_row2'] = '#E8EDFA';
        $this->schemes['Blue']['colors']['background'] = '#E8EDFA';
        $this->schemes['Blue']['colors']['background_logo'] = '#FFFFFF';
        $this->schemes['Blue']['colors']['bacground_active'] = '#B3CED9';
        $this->schemes['Blue']['colors']['menu_link'] = '#0056B6';
        $this->schemes['Blue']['colors']['menu_link2'] = '#0056B6';
        $this->schemes['Blue']['colors']['menu_link_disbled'] = '#666666';
        $this->schemes['Blue']['colors']['datail_row1'] = '#E8EBF2';
        $this->schemes['Blue']['colors']['datail_row2'] = '#F2F5FC';
        $this->schemes['Blue']['colors']['frm_button_shadow'] = '#B4B4B6';
        $this->schemes['Blue']['colors']['form_button'] = '#B3CED9';

        $this->schemes['Desert'] = array();
        $this->schemes['Desert']['name'] = 'Desert';
        $this->schemes['Desert']['image'] = 'scheme_desert.jpg';
        $this->schemes['Desert']['title'] = L_G_COLORSCHEME_DESERT;
        $this->schemes['Desert']['colors']['normallink'] = '#FF0000';
        $this->schemes['Desert']['colors']['helplink'] = '#00AA00';
        $this->schemes['Desert']['colors']['textlink'] = '#0056B6';
        $this->schemes['Desert']['colors']['error_border'] = '#FF0000';
        $this->schemes['Desert']['colors']['error_header'] = '#FFA9A9';
        $this->schemes['Desert']['colors']['error_message'] = '#FF0000';
        $this->schemes['Desert']['colors']['ok_border'] = '#00AA00';
        $this->schemes['Desert']['colors']['ok_header'] = '#BAFCBA';
        $this->schemes['Desert']['colors']['ok_message'] = '#00AA00';
        $this->schemes['Desert']['colors']['footer_text'] = '#555555';
        $this->schemes['Desert']['colors']['footer_background'] = '#FFFFCC';
        $this->schemes['Desert']['colors']['frm_button_light'] = '#F5F5F5';
        $this->schemes['Desert']['colors']['border'] = '#000000';
        $this->schemes['Desert']['colors']['border2'] = '#FFFFCC';
        $this->schemes['Desert']['colors']['actionheader'] = '#FFFFFF';
        $this->schemes['Desert']['colors']['tableheader'] = '#CC6600';
        $this->schemes['Desert']['colors']['tableheader2'] = '#FF9900';
        $this->schemes['Desert']['colors']['listheader'] = '#FFFFCC';
        $this->schemes['Desert']['colors']['listheader_sort'] = '#CC6600';
        $this->schemes['Desert']['colors']['listresult_row1'] = '#FFFFFF';
        $this->schemes['Desert']['colors']['listresult_row2'] = '#FFFFDD';
        $this->schemes['Desert']['colors']['background'] = '#FF9900';
        $this->schemes['Desert']['colors']['background_logo'] = '#FFFFCC';
        $this->schemes['Desert']['colors']['bacground_active'] = '#CC6600';
        $this->schemes['Desert']['colors']['menu_link'] = '#FFFFCC';
        $this->schemes['Desert']['colors']['menu_link2'] = '#CC6600';
        $this->schemes['Desert']['colors']['menu_link_disbled'] = '#666666';
        $this->schemes['Desert']['colors']['datail_row1'] = '#FFFFDD';
        $this->schemes['Desert']['colors']['datail_row2'] = '#FFFFFF';
        $this->schemes['Desert']['colors']['frm_button_shadow'] = '#B4B4B6';
        $this->schemes['Desert']['colors']['form_button'] = '#FF9900';
    }

    function getSchemes() {
        return $this->schemes;
    }

    function getScheme($name) {
        return $this->schemes[$name];
    }


    function addCategory($name, $title) {
        $this->categories[$name]['_name'] = $name;
        $this->categories[$name]['_title'] = $title;
    }

    function addColor($category, $colorName, $title, $value) {
        $this->categories[$category]['_colors'][$colorName] = $colorName;

        $this->colors[$colorName]['_name'] = $colorName;
        $this->colors[$colorName]['_value'] = $value;
        $this->colors[$colorName]['_title'] = $title;
    }

    function getCategories() {
        return $this->categories;
    }

    function getColors() {
        return $this->colors;
    }

    function getColor($name) {
        return $this->colors[$name]['_value'];
    }

    function setColor($name, $value) {
        $this->colors[$name]['_value'] = $value;
    }

    function getColorTitle($name) {
        return $this->colors[$name]['_title'];
    }

    function getName() {
        return $this->name;
    }

    function getImage() {
        return $this->image;
    }

    function getTitle() {
        return $this->title;
    }

    function getColorsCount() {
        return count($this->colors);
    }
}
?>
