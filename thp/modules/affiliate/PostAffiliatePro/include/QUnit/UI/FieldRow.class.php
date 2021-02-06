<?php
    class QUnit_UI_FieldRow {
        var $useRowParity = false;
        var $useEditBox = false;
        var $rowParity = 0;
        var $color = array(0 => ' class="formRowEven"', 1 => ' class="formRowOdd"');
        var $trParams = '';
        var $tdParams = '';
        var $settings;

        function FieldRow($useRowParity = false, $settings, $useEditBox = false, $trParams = '', $tdParams = '', $setOddColor = '', $setEvenColor = '') {
            $this->initialize($setOddColor, $setEvenColor, $useRowParity, $settings, $useEditBox, $trParams, $tdParams);
        }
        
        function initialize($useRowParity = false, $settings, $useEditBox = false, $trParams = '', $tdParams = '', $setOddColor = '', $setEvenColor = '') {
            $this->useEditBox = $useEditBox;
            $this->useRowParity = $useRowParity;
            $this->settings = $settings;
            $this->trParams = $trParams;
            $this->setTdParams($tdParams);
            if (!empty($setOddColor))
                $this->color[1] = $setOddColor;
            if (!empty($setEvenColor))
                $this->color[0] = $setEvenColor;
        }

        function trWithBgColor() {
            $this->rowParity = ($this->rowParity + 1) & 1;
            return '<tr '.$this->color[$this->rowParity].$this->trParams.'>';
        }

        function getFieldRow($code, $caption) {
            $result = '';
            if($this->settings['Aff_signup_'.$code] == "1") {
                if($this->settings['Aff_signup_'.$code.'_mandatory'] === "true") {
                    $caption = "<b>$caption</b>";
                    $mandatSign = "*";
                } else {
                    $mandatSign = "";
                }

                if ($this->useRowParity)
                    $result = $this->trWithBgColor();
                else
                    $result = '<tr '.$this->trParams.'>';

                $result .= "\n<td ".$this->tdParams[0].">&nbsp;$caption&nbsp;</td>\n";

                if ($this->useEditBox)
                    $result .= "<td ".$this->tdParams[1]."><input type=text name=$code size=44 value="._q($_POST[$code]).">$mandatSign&nbsp;</td></tr>";
                else
                    $result .= "<td width=10></td><td ".$this->tdParams[1].">&nbsp;$_POST[$code]&nbsp;</td></tr>";
            }
            return $result;
        }

        function setTdParams($tdParams) {
            if (!is_array($tdParams))
                $this->tdParams[0] = $tdParams;
            else
                $this->tdParams = $tdParams;
                
            if (!isset($this->tdParams[1]))
                $this->tdParams[1] = '';
        }

        function resetRowParity() {
            $this->rowParity = 0;
        }

    }
?>
