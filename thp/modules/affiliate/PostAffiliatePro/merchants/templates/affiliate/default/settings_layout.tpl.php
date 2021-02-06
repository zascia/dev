    <?php echo L_G_LAYOUT_DESCRIPTION?>
    <br/><br/>
<?php
function getColorInput($id, $name, $default) {
    $code = '<td>'.$name.'</td>'.
            '<td><input class="forminput" type="text" size="8" id="c_'.$id.'" name="c_'.$id.'" value="'.$_POST['c_'.$id].'" onkeyup="javascript:setColor(\'cp_'.$id.'\',this.value)"></td>'.
            '<td id="cp_'.$id.'" width="10" style="background-color: '.$_POST['c_'.$id].'; cursor: pointer;\"'.
                " onClick=\"javascript: field = '".$id."'; hideToolTip=false; toolTip(event, cp, '3', WIDTH,'315')\"".
                " onmouseout=\"javascript:hideToolTip=true; setTimeout('toolTip()', 1500);\"></td>".
            '<td><a class="simplelink" href="javascript:setDefault(\''.$id.'\');">'.L_G_SETDEFAULTCOLOR.'</a></td>';
    return $code;
}
?>
<script language="javascript">

//----------------------------------------------------------------------------
// RGB color parser
//----------------------------------------------------------------------------
function RGBColor(color_string)
{
    this.ok = false;

    // strip any leading #
    if (color_string.charAt(0) == '#') { // remove # if any
        color_string = color_string.substr(1,6);
    }

    color_string = color_string.replace(/ /g,'');
    color_string = color_string.toLowerCase();

    // before getting into regexps, try simple matches
    // and overwrite the input
    var simple_colors = {
        aliceblue: 'f0f8ff',
        antiquewhite: 'faebd7',
        aqua: '00ffff',
        aquamarine: '7fffd4',
        azure: 'f0ffff',
        beige: 'f5f5dc',
        bisque: 'ffe4c4',
        black: '000000',
        blanchedalmond: 'ffebcd',
        blue: '0000ff',
        blueviolet: '8a2be2',
        brown: 'a52a2a',
        burlywood: 'deb887',
        cadetblue: '5f9ea0',
        chartreuse: '7fff00',
        chocolate: 'd2691e',
        coral: 'ff7f50',
        cornflowerblue: '6495ed',
        cornsilk: 'fff8dc',
        crimson: 'dc143c',
        cyan: '00ffff',
        darkblue: '00008b',
        darkcyan: '008b8b',
        darkgoldenrod: 'b8860b',
        darkgray: 'a9a9a9',
        darkgreen: '006400',
        darkkhaki: 'bdb76b',
        darkmagenta: '8b008b',
        darkolivegreen: '556b2f',
        darkorange: 'ff8c00',
        darkorchid: '9932cc',
        darkred: '8b0000',
        darksalmon: 'e9967a',
        darkseagreen: '8fbc8f',
        darkslateblue: '483d8b',
        darkslategray: '2f4f4f',
        darkturquoise: '00ced1',
        darkviolet: '9400d3',
        deeppink: 'ff1493',
        deepskyblue: '00bfff',
        dimgray: '696969',
        dodgerblue: '1e90ff',
        feldspar: 'd19275',
        firebrick: 'b22222',
        floralwhite: 'fffaf0',
        forestgreen: '228b22',
        fuchsia: 'ff00ff',
        gainsboro: 'dcdcdc',
        ghostwhite: 'f8f8ff',
        gold: 'ffd700',
        goldenrod: 'daa520',
        gray: '808080',
        green: '008000',
        greenyellow: 'adff2f',
        honeydew: 'f0fff0',
        hotpink: 'ff69b4',
        indianred : 'cd5c5c',
        indigo : '4b0082',
        ivory: 'fffff0',
        khaki: 'f0e68c',
        lavender: 'e6e6fa',
        lavenderblush: 'fff0f5',
        lawngreen: '7cfc00',
        lemonchiffon: 'fffacd',
        lightblue: 'add8e6',
        lightcoral: 'f08080',
        lightcyan: 'e0ffff',
        lightgoldenrodyellow: 'fafad2',
        lightgrey: 'd3d3d3',
        lightgreen: '90ee90',
        lightpink: 'ffb6c1',
        lightsalmon: 'ffa07a',
        lightseagreen: '20b2aa',
        lightskyblue: '87cefa',
        lightslateblue: '8470ff',
        lightslategray: '778899',
        lightsteelblue: 'b0c4de',
        lightyellow: 'ffffe0',
        lime: '00ff00',
        limegreen: '32cd32',
        linen: 'faf0e6',
        magenta: 'ff00ff',
        maroon: '800000',
        mediumaquamarine: '66cdaa',
        mediumblue: '0000cd',
        mediumorchid: 'ba55d3',
        mediumpurple: '9370d8',
        mediumseagreen: '3cb371',
        mediumslateblue: '7b68ee',
        mediumspringgreen: '00fa9a',
        mediumturquoise: '48d1cc',
        mediumvioletred: 'c71585',
        midnightblue: '191970',
        mintcream: 'f5fffa',
        mistyrose: 'ffe4e1',
        moccasin: 'ffe4b5',
        navajowhite: 'ffdead',
        navy: '000080',
        oldlace: 'fdf5e6',
        olive: '808000',
        olivedrab: '6b8e23',
        orange: 'ffa500',
        orangered: 'ff4500',
        orchid: 'da70d6',
        palegoldenrod: 'eee8aa',
        palegreen: '98fb98',
        paleturquoise: 'afeeee',
        palevioletred: 'd87093',
        papayawhip: 'ffefd5',
        peachpuff: 'ffdab9',
        peru: 'cd853f',
        pink: 'ffc0cb',
        plum: 'dda0dd',
        powderblue: 'b0e0e6',
        purple: '800080',
        red: 'ff0000',
        rosybrown: 'bc8f8f',
        royalblue: '4169e1',
        saddlebrown: '8b4513',
        salmon: 'fa8072',
        sandybrown: 'f4a460',
        seagreen: '2e8b57',
        seashell: 'fff5ee',
        sienna: 'a0522d',
        silver: 'c0c0c0',
        skyblue: '87ceeb',
        slateblue: '6a5acd',
        slategray: '708090',
        snow: 'fffafa',
        springgreen: '00ff7f',
        steelblue: '4682b4',
        tan: 'd2b48c',
        teal: '008080',
        thistle: 'd8bfd8',
        tomato: 'ff6347',
        turquoise: '40e0d0',
        violet: 'ee82ee',
        violetred: 'd02090',
        wheat: 'f5deb3',
        white: 'ffffff',
        whitesmoke: 'f5f5f5',
        yellow: 'ffff00',
        yellowgreen: '9acd32'
    };
    for (var key in simple_colors) {
        if (color_string == key) {
            color_string = simple_colors[key];
        }
    }
    // emd of simple type-in colors

    // array of color definition objects
    var color_defs = [
        {
            re: /^(\w{2})(\w{2})(\w{2})$/,
            example: ['#00ff00', '336699'],
            process: function (bits){
                return [
                    parseInt(bits[1], 16),
                    parseInt(bits[2], 16),
                    parseInt(bits[3], 16)
                ];
            }
        },
        {
            re: /^(\w{1})(\w{1})(\w{1})$/,
            example: ['#fb0', 'f0f'],
            process: function (bits){
                return [
                    parseInt(bits[1] + bits[1], 16),
                    parseInt(bits[2] + bits[2], 16),
                    parseInt(bits[3] + bits[3], 16)
                ];
            }
        }
    ];

    // search through the definitions to find a match
    for (var i = 0; i < color_defs.length; i++) {
        var re = color_defs[i].re;
        var processor = color_defs[i].process;
        var bits = re.exec(color_string);
        if (bits) {
            channels = processor(bits);
            this.r = channels[0];
            this.g = channels[1];
            this.b = channels[2];
            this.ok = true;
        }

    }

    // validate/cleanup values
    this.r = (this.r < 0 || isNaN(this.r)) ? 0 : ((this.r > 255) ? 255 : this.r);
    this.g = (this.g < 0 || isNaN(this.g)) ? 0 : ((this.g > 255) ? 255 : this.g);
    this.b = (this.b < 0 || isNaN(this.b)) ? 0 : ((this.b > 255) ? 255 : this.b);

    // some getters
    this.toHex = function () {
        var r = this.r.toString(16);
        var g = this.g.toString(16);
        var b = this.b.toString(16);
        if (r.length == 1) r = '0' + r;
        if (g.length == 1) g = '0' + g;
        if (b.length == 1) b = '0' + b;
        return '#' + r + g + b;
    }
}

function setColor(id, value) {
    var color = new RGBColor(value);
    if (color.ok) {
        document.getElementById(id).style.backgroundColor = color.toHex();
    }
}

function setValue(id, value) {
    document.getElementById(id).value = value;
}

function setDefault(id) {
    setColor('cp_' + id, currentScheme[id]);
    setValue('c_'  + id, currentScheme[id]);
}

function loadScheme(scheme) {
    for(i in scheme) {
        if(i != '_name') {
            setColor('cp_' + i, scheme[i]);
            setValue('c_'  + i, scheme[i]);
        }
    }
    document.getElementById('scheme-' + currentScheme['_name']).style.fontWeight = 'normal';
    document.getElementById('scheme-' + scheme['_name']).style.fontWeight = 'bold';
    currentScheme = scheme;
    document.getElementById('current_color_scheme').value = scheme['_name'];
}
</script>

<?php
    $basiccolors = array("000000", "333333", "666666", "999999", "CCCCCC", "FFFFFF",
                         "FF0000", "00FF00", "0000FF", "FFFF00", "00FFFF", "FF00FF");
    $colors = array();
    for ($y = 0; $y < 12; $y++) {
        $colors[] = $basiccolors[$y];
        for ($x = 0; $x < 18; $x++) {
            $colors[] = dechex(floor($y/6)*9  + floor($x/6)*3).dechex(floor($y/6)*9  + floor($x/6)*3).
                        dechex(($x % 6)*3).dechex(($x % 6)*3).
                        dechex(($y % 6)*3).dechex(($y % 6)*3);
        }
    }

    $columns = 19;
    $c = 0;
    $code = '<table cellpadding=0 cellspacing=0 border=1 style="cursor: pointer;"><tr>';
    foreach ($colors as $color) {
        if ($c++ == $columns) {
            $c = 1;
            $code .= '</tr><tr>';
        }
        $code .= "<td style=\"border: #000000 1px solid; background-color: #".$color."; color: #".$color.";\"".
                    " onclick=\"javascript: setValue('c_'+field, '#".$color."'); setColor('cp_'+field, '#".$color."');\"".
                    " width=15 height=10>_</td>";
    }
    $code .=  '</tr></table>';

    $code = str_replace('"', '{SLASH}', $code);
?>

<script language="javascript">
    var field;
    var cp = "<?php echo $code?>";
    <?php foreach($this->a_colors->getSchemes() as $name => $scheme) { ?>

            var scheme<?php echo $name?> = new Array()
            <?php foreach($scheme['colors'] as $colorName => $dummy) { ?>
                scheme<?php echo $name?>['<?php echo $colorName?>'] =  '<?php echo $scheme['colors'][$colorName]?>'
            <?php } ?>
            scheme<?php echo $name?>['_name'] = '<?php echo $name?>'
    <?php } ?>
    var currentScheme = scheme<?php echo $this->a_current_scheme?>
//    document.getElementById('scheme-' + currentScheme['_name']).style.fontWeight = 'bold';

</script>


    <form action="index.php" method="POST" enctype="multipart/form-data">
    <table class="listing" width="780" border=0 cellspacing=0 cellpadding=0>
    <?php QUnit_Templates::printFilter(1, L_G_LAYOUTSETTINGS); ?>
    <tr><td>
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tr class="detailrow0"><td width="15%"><b><?php echo L_G_LOGO_IMAGE?></b></td>
                <td><?php echo L_G_URL?></td>
                <td><input class="forminput" id="logo_url_id" type="text" size="100" name="logo_url" value="<?php echo $_POST["logo_url"]?>">
                    <a class="simplelink" href="javascript:setValue('logo_url_id', '')"><?php echo L_G_SETDEFAULTLOGO?></a></td></tr>
            <tr class="detailrow1"><td></td>
                <td><?php echo L_G_UPLOADFILE?></td>
                <td><input  class="forminput" type="file" size="90" name="logo_file"></td></tr>
            <tr class="detailrow0"><td nowrap><b><?php echo L_G_MERCHANT_SKIN?></b></td>
                <td colspan="2">
                    <select class="forminput" name="merchant_skin">
                        <option value="default" <?php echo ($_POST['merchant_skin'] == 'default') ? 'selected' : ''?>><?php echo L_G_DEFAULT?></option>
                        <option value="blueStyle" <?php echo ($_POST['merchant_skin'] == 'blueStyle') ? 'selected' : ''?>><?php echo L_G_NEWSTYLE?></option>
                    </select>
                </td></tr>
            <tr class="detailrow1"><td><b><?php echo L_G_AFFILIATE_SKIN?></b></td>
                <td colspan="2">
                    <select class="forminput" name="affiliate_skin">
                        <option value="default" <?php echo ($_POST['affiliate_skin'] == 'default') ? 'selected' : ''?>><?php echo L_G_DEFAULT?></option>
                        <option value="blueStyle" <?php echo ($_POST['affiliate_skin'] == 'blueStyle') ? 'selected' : ''?>><?php echo L_G_NEWSTYLE?></option>
                    </select>
                </td></tr>
            <tr class="detailrow0"><td><b><?php echo L_G_PAGE_POSITION?></b></td>
                <td colspan="2">
                    <select class="forminput" name="page_position">
                        <option value="left" <?php echo ($_POST['page_position'] == 'left') ? 'selected' : ''?>><?php echo L_G_LEFT?></option>
                        <option value="center" <?php echo ($_POST['page_position'] == 'center') ? 'selected' : ''?>><?php echo L_G_CENTERED?></option>
                    </select>
                </td></tr>
        </table>
        </td></tr>
    <?php QUnit_Templates::printFilter2(1, L_G_COLORS); ?>
    <tr><td>
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
        <tr><td valign="top"">
                <table cellpadding="2" cellspacing="0" border="0">
                <?php foreach($this->a_colors->getCategories() as $catName => $catArray) { ?>
                    <?php if($catArray['_name'] == 'tables') { ?>
                        </table>
                        </td>
                        <td valign="top"">
                        <table cellpadding="2" cellspacing="0" border="0">
                    <?php } ?>
                <tr><td><b><?php echo $catArray['_title']?></b></td><td></td></tr>
                    <?php  if(isset($catArray['_colors'])) {
                        foreach($catArray['_colors'] as $colorName) { ?>
                             <tr><td></td><?php echo getColorInput($colorName, $this->a_colors->getColorTitle($colorName), $this->a_colors->getColor($colorName))?></tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                </table>
            </td>
            <td valign="top">
                <table cellpadding="2" cellspacing="0" border="0">
                <?php foreach($this->a_colors->getSchemes() as $name => $scheme) { ?>
                <tr><td><a href="javascript: loadScheme(scheme<?php echo $name?>);">
                        <img src="<?php echo $this->a_this->getImage($scheme['image'])?>" border="1"><br>
                        <span id="scheme-<?php echo $name?>" style="font-weight:<?php echo  $name == $this->a_current_scheme ? 'bold' : 'normal'?>"><?php echo $scheme['title']?></span> <span id="scheme-<?php echo $name?>-default"><?php echo  $name == $this->a_current_scheme ? '(Default)' : ''?></span></a><br><br></td></tr>
                <?php } ?>
                </table>
            </td>
        </tr>
        </table>
        </td>
    </tr>
    <tr><td align="center"><br>
            <input type=hidden name=commited value=yes>
            <input type=hidden id=current_color_scheme name=current_color_scheme value="<?php echo  $this->a_current_scheme?>">
            <input type=hidden name=md value='Affiliate_Merchants_Views_LayoutSettings'>
            <?php if ($this->a_this->checkPermissions('edit')) { ?>
                <input type="submit" class="formbutton" value="<?php echo L_G_SAVECHANGES?>">
            <?php } else { ?>
                <input class=formbutton type=button value="<?php echo L_G_YOU_DONT_HAVE_RIGHTS_TO_EDIT?>">
            <?php } ?>
            <br><br>
         </td>
    </tr>
    </table>
    </form>
