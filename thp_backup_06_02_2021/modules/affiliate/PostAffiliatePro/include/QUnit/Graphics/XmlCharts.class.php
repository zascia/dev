<?php
// charts.php v4.5
// ------------------------------------------------------------------------
// Copyright (c) 2003-2005, maani.us
// ------------------------------------------------------------------------
// This file is part of "PHP/SWF Charts"
//
// PHP/SWF Charts is a shareware. See http://www.maani.us/charts/ for
// more information.
// ------------------------------------------------------------------------

class QUnit_Graphics_XmlCharts {

    var $seriesColors = array("A5C3E1", "DAC0DE", "C0DED3", "ABCA94", "FFC258");
    
    //------------------------------------------------------------------------
    
    function InsertChart( $flash_file, $library_path, $php_source, $width=400, $height=250, $bg_color="666666", $transparent, $license, $data = null ){
        
        $php_source=urlencode($php_source);
        $library_path=urlencode($library_path);
        
        $protocol = ($_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
        
        $html="<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='".$protocol."download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' ";
        $html.="WIDTH=".$width." HEIGHT=".$height." id='charts' ALIGN=''>";
        $u=(strpos ($flash_file,"?")===false)? "?" : ((substr($flash_file, -1)==="&")? "":"&");
        $html.="<PARAM NAME=movie VALUE='".$flash_file.$u."library_path=".$library_path;
        if($data == null) {$html.="&php_source=".$php_source;}
        if($license!=null){$html.="&license=".$license;}
        $html.="'> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#".$bg_color."> ";
        if($transparent){$html.="<PARAM NAME=wmode VALUE=transparent> ";}
        if($data!=null) {$html.="<PARAM NAME=FlashVars VALUE=\"source_data=$data>\"";}
        $html.="<EMBED src='".$flash_file.$u."library_path=".$library_path."&php_source=".$php_source;
        if($license!=null){$html.="&license=".$license;}
        $html.="' quality=high bgcolor=#".$bg_color." WIDTH=".$width." HEIGHT=".$height." NAME='charts' ALIGN='' swLiveConnect='true' ";
        if($transparent){$html.="wmode=transparent ";}
        $html.="TYPE='application/x-shockwave-flash' PLUGINSPAGE='".$protocol."www.macromedia.com/go/getflashplayer'></EMBED></OBJECT>";
        return $html;
        
    }

    //------------------------------------------------------------------------

    function GetChartData( $chart=array() ){
        $xml="<chart>\r\n";
        $Keys1= array_keys((array) $chart);
        for ($i1=0;$i1<count($Keys1);$i1++){
            if(is_array($chart[$Keys1[$i1]])){
                $Keys2=array_keys($chart[$Keys1[$i1]]);
                if(is_array($chart[$Keys1[$i1]][$Keys2[0]])){
                    $xml.="\t<".$Keys1[$i1].">\r\n";
                    for($i2=0;$i2<count($Keys2);$i2++){
                        $Keys3=array_keys((array) $chart[$Keys1[$i1]][$Keys2[$i2]]);
                        switch($Keys1[$i1]){
                            case "chart_data":
                            $xml.="\t\t<row>\r\n";
                            for($i3=0;$i3<count($Keys3);$i3++){
                                switch(true){
                                    case ($chart[$Keys1[$i1]][$Keys2[$i2]][$Keys3[$i3]]===null):
                                    $xml.="\t\t\t<null/>\r\n";
                                    break;
                                    
                                    case ($Keys2[$i2]>0 and $Keys3[$i3]>0):
                                    $xml.="\t\t\t<number>".$chart[$Keys1[$i1]][$Keys2[$i2]][$Keys3[$i3]]."</number>\r\n";
                                    break;
                                    
                                    default:
                                    $xml.="\t\t\t<string>".$chart[$Keys1[$i1]][$Keys2[$i2]][$Keys3[$i3]]."</string>\r\n";
                                    break;
                                }
                            }
                            $xml.="\t\t</row>\r\n";
                            break;
                            
                            case "chart_value_text":
                            $xml.="\t\t<row>\r\n";
                            $count=0;
                            for($i3=0;$i3<count($Keys3);$i3++){
                                if($chart[$Keys1[$i1]][$Keys2[$i2]][$Keys3[$i3]]===null){$xml.="\t\t\t<null/>\r\n";}
                                else{$xml.="\t\t\t<string>".$chart[$Keys1[$i1]][$Keys2[$i2]][$Keys3[$i3]]."</string>\r\n";}
                            }
                            $xml.="\t\t</row>\r\n";
                            break;
                            
                            case "draw":
                            $text="";
                            $xml.="\t\t<".$chart[$Keys1[$i1]][$Keys2[$i2]]['type'];
                            for($i3=0;$i3<count($Keys3);$i3++){
                                if($Keys3[$i3]!="type"){
                                    if($Keys3[$i3]=="text"){$text=$chart[$Keys1[$i1]][$Keys2[$i2]][$Keys3[$i3]];}
                                    else{$xml.=" ".$Keys3[$i3]."='".$chart[$Keys1[$i1]][$Keys2[$i2]][$Keys3[$i3]]."'";}
                                }
                            }
                            if($text!=""){$xml.=">".$text."</text>\r\n";}
                            else{$xml.=" />\r\n";}
                            break;
                            
                            
                            default://link, etc.
                            $xml.="\t\t<value";
                            for($i3=0;$i3<count($Keys3);$i3++){
                                $xml.=" ".$Keys3[$i3]."='".$chart[$Keys1[$i1]][$Keys2[$i2]][$Keys3[$i3]]."'";
                            }
                            $xml.=" />\r\n";
                            break;
                        }
                    }
                    $xml.="\t</".$Keys1[$i1].">\r\n";
                }else{
                    if($Keys1[$i1]=="chart_type" or $Keys1[$i1]=="series_color" or $Keys1[$i1]=="series_image" or $Keys1[$i1]=="series_explode" or $Keys1[$i1]=="axis_value_text"){							
                        $xml.="\t<".$Keys1[$i1].">\r\n";
                        for($i2=0;$i2<count($Keys2);$i2++){
                            if($chart[$Keys1[$i1]][$Keys2[$i2]]===null){$xml.="\t\t<null/>\r\n";}
                            else{$xml.="\t\t<value>".$chart[$Keys1[$i1]][$Keys2[$i2]]."</value>\r\n";}
                        }
                        $xml.="\t</".$Keys1[$i1].">\r\n";
                    }else{//axis_category, etc.
                        $xml.="\t<".$Keys1[$i1];
                        for($i2=0;$i2<count($Keys2);$i2++){
                            $xml.=" ".$Keys2[$i2]."='".$chart[$Keys1[$i1]][$Keys2[$i2]]."'";
                        }
                        $xml.=" />\r\n";
                    }
                }
            }else{//chart type, etc.
                $xml.="\t<".$Keys1[$i1].">".$chart[$Keys1[$i1]]."</".$Keys1[$i1].">\r\n";
            }
        }
        $xml.="</chart>\r\n";
        return $xml;
    }
    
    //------------------------------------------------------------------------
    
    function InitParameters($params, $legend, $uniq, $graphVariations) {
        $type = $params['type'];
        $width = $params['width'];
        $height = $params['height'];
        $maxValueDigits = ceil(log10(max($params['values'])));
        $maxValueDigits = ($maxValueDigits > 1) ? $maxValueDigits : 1;
        $chart = array();
        $legendWidth = 500;
        $variationWidth = 32;
        
        $variations = (is_array($graphVariations) && count($graphVariations)>1 && defined('USE_GRAPH_CACHING') && USE_GRAPH_CACHING == 1 ? true : false);
        
        if(strpos($type, 'column') !== false || strpos($type, 'line') !== false) {
            $chart['axis_category' ] = array ( 'font'=>"arial", 'size'=>11, 'color'=>"000000", 'alpha'=>85, 'skip'=>0 );            
            $chart['axis_value' ] = array ( 'font'=>"arial", 'size'=>11, 'color'=>"000000", 'alpha'=>100, 'skip'=>0 );
            $chart[ 'chart_border' ] = array ( 'top_thickness'=>0, 'bottom_thickness'=>1, 'left_thickness'=>0, 'right_thickness'=>0, 'color' => '999999' );
            $chart[ 'chart_grid_h' ] = array ( 'color'=>"AAAAAA", 'thickness'=>1, 'alpha'=>100, 'type' => 'dotted' );
            $chart[ 'chart_grid_v' ] = array ( 'color'=>"AAAAAA", 'thickness'=>0, 'alpha'=>100 );
            $chart[ 'chart_pref' ] = array('rotation_x' => 10, 'rotation_y' => 10);
            
            $posX = 50 + $maxValueDigits * 5;
            $posY = 20;
            $posY += ($legend ? 30 : 0);
            $posY += ($variations && !$legend ? 10 : 0);
            $gWidth = $width - $posX - 20;
            $gHeight = $height - $posY - 30;
            
            $chart[ 'chart_rect' ] = array ( 'x'=>$posX, 'y'=>$posY, 'width'=> $gWidth , 'height'=>$gHeight, 'positive_color'=>"E9E9E9", 'positive_alpha'=>50 );
            $chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"000000", 'alpha'=>0, 'font'=>"arial", 'bold'=>false, 'size'=>10, 'position'=>"top", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );    
            
            if($legend) {
                $legendPosX = $width - $legendWidth - ($variations ? count($graphVariations)*40 + 40 : 20);
                
                $chart[ 'legend_rect' ] = array ( 'x'=>$legendPosX, 'y'=>10, 'width'=>$legendWidth, 'height'=>30, 'fill_color' => 'E0E0E0' ); 
                $chart['legend_label' ] = array ( 'font'=>"arial", 'bold'=>false, 'size'=>13, 'color'=>"000000", 'alpha'=>85 );
                $chart['legend_transition' ] = array ( 'type'=>"slide_down" );
            } else {
                $chart[ 'legend_rect' ] = array ( 'x'=>0, 'y'=>-10000, 'width'=>0, 'height'=>0, 'fill_color' => 'E0E0E0' ); 
            }
            
            if($variations) {
                // draw variations links
                $startPos = $width - count($graphVariations)*32;
                foreach($graphVariations as $variation) {
                    $graphName = $uniq.str_replace(' ', '_', $variation);
                    
                    $chart['link'][] = array(
                                            'x' => $startPos,
                                            'y' => 0,
                                            'width' => $variationWidth,
                                            'height' => 17,
                                            'target' => 'live_update',
                                            'url' => "../cache/".$graphName.".xml"
                                        );
                                        
                    $chart['draw'][] = array(
                                            'type' => 'image',
                                            'x' => $startPos,
                                            'y' => 0,
                                            'url' => '../templates/affiliate/default/images/chart_'.$variation.'.jpg',
                                            'transition' => 'slide_down',
                                        );
                                        
                    $startPos += $variationWidth;
                }
            }
            
            $chart[ 'chart_type' ] = str_replace('_', ' ', $type);
            $chart['chart_transition'] = array('type' => 'scale', 'delay' => 0, 'duration' => 1);
        } else if(strpos($type, 'bar') !== false) {
            $chart['axis_value' ] = array ( 'font'=>"arial", 'bold'=>false, 'size'=>0, 'color'=>"ffffff", 'alpha'=>100, 'skip'=>0 );

            $chart[ 'chart_border' ] = array ( 'top_thickness'=>0, 'bottom_thickness'=>0, 'left_thickness'=>0, 'right_thickness'=>0, 'color' => '999999' );
            $chart[ 'chart_grid_h' ] = array ( 'color'=>"ff0000", 'thickness'=>0, 'alpha'=>100 );
            $chart[ 'chart_grid_v' ] = array ( 'color'=>"AAAAAA", 'thickness'=>0, 'alpha'=>100 );
            $chart['series_switch'] = true;
            
            $posX = 90;
            $posY = ($legend ? 50 : 20);
            $gWidth = $width - $posX - 20;
            $gHeight = $height - $posY - 30;
            
            $chart[ 'chart_rect' ] = array ( 'x'=>$posX, 'y'=>$posY, 'width'=> $gWidth , 'height'=>$gHeight, 'positive_color'=>"E9E9E9", 'positive_alpha'=>0 );
            $chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"000000", 'alpha'=>0, 'font'=>"arial", 'bold'=>false, 'size'=>12, 'position'=>"right", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );    
            
            if($legend) {
                $chart[ 'legend_rect' ] = array ( 'x'=>$width - 500 - 20, 'y'=>10, 'width'=>500, 'height'=>30, 'fill_color' => 'E0E0E0' ); 
                $chart['legend_label' ] = array ( 'font'=>"arial", 'bold'=>false, 'size'=>13, 'color'=>"000000", 'alpha'=>85 );
                $chart['legend_transition' ] = array ( 'type'=>"slide_down" );
            } else {
                $chart[ 'legend_rect' ] = array ( 'x'=>0, 'y'=>-10000, 'width'=>0, 'height'=>0, 'fill_color' => 'E0E0E0' ); 
            }
            
            $chart[ 'chart_type' ] = $type ;
            $chart['chart_transition'] = array('type' => 'scale', 'delay' => 0, 'duration' => 1);
        } else if(strpos($type, 'traffic') !== false) {
            $chart['axis_value' ] = array ( 'font'=>"arial", 'bold'=>false, 'size'=>0, 'color'=>"ffffff", 'alpha'=>100, 'skip'=>0, 'min' => 0 );
            if($params['max'] != '' ) $chart['axis_value' ]['max'] = $params['max'];
            
            $chart[ 'chart_border' ] = array ( 'top_thickness'=>0, 'bottom_thickness'=>0, 'left_thickness'=>0, 'right_thickness'=>0, 'color' => '999999' );
            $chart[ 'chart_grid_h' ] = array ( 'color'=>"ff0000", 'thickness'=>0, 'alpha'=>100 );
            $chart[ 'chart_grid_v' ] = array ( 'color'=>"AAAAAA", 'thickness'=>0, 'alpha'=>100 );
            $chart[ 'chart_rect' ] = array ( 'x'=>10, 'y'=>2, 'width'=>530, 'height'=>15, 'positive_color'=>"E9E9E9", 'positive_alpha'=>0, 'negative_alpha'=>0 );
            $chart[ 'chart_type' ] = "stacked bar" ;
            $chart['chart_transition'] = array('type' => 'none');
            $chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"000000", 'alpha'=>0, 'font'=>"arial", 'bold'=>false, 'size'=>12, 'position'=>"right", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );    
            
            $chart[ 'legend_rect' ] = array ( 'x'=>0, 'y'=>-300, 'width'=>30, 'height'=>30, 'fill_color' => 'ffffff', 'fill_alpha'=>0  ); 
            
            $chart[ 'series_color' ] = array ("A5C3E1", "DAC0DE", "ABCA94", "FFC258", "FFC258" ); 
//            $chart[ 'series_color' ] = array ("ff0000", "00ff00", "0000ff", "550000" ); 
            $chart[ 'series_gap' ] = array ("set_gap" => 10);
            
            if($params['link'] != '') {
                $chart['link'][] = array(
                                    'x' => 0,
                                    'y' => 0,
                                    'width' => 1000,
                                    'height' => 1000,
                                    'target' => '_self',
                                    'url' => $params['link']
                                  );
            }
            
            $chart[ 'chart_type' ] = 'stacked bar' ;
        } else if(strpos($type, 'pie') !== false) {
            $chart['axis_value' ] = array ( 'font'=>"arial", 'bold'=>false, 'size'=>0, 'color'=>"ffffff", 'alpha'=>100, 'skip'=>0 );

            $chart[ 'chart_border' ] = array ( 'top_thickness'=>0, 'bottom_thickness'=>0, 'left_thickness'=>0, 'right_thickness'=>0, 'color' => '999999' );
            $chart[ 'chart_grid_h' ] = array ( 'color'=>"ff0000", 'thickness'=>0, 'alpha'=>100 );
            $chart[ 'chart_grid_v' ] = array ( 'color'=>"AAAAAA", 'thickness'=>0, 'alpha'=>100 );
            $chart['series_switch'] = true;
            
            $posX = 0;
            $posY = 0;
            $gWidth = $width;
            $gHeight = $height - $posY - 45;
            $positionTip = $params['positionTip'];
            
            $chart[ 'chart_rect' ] = array ( 'x'=>$posX, 'y'=>$posY, 'width'=> $gWidth , 'height'=>$gHeight, 'positive_color'=>"E9E9E9", 'positive_alpha'=>0 );
            $chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"000000", 'alpha'=>0, 'font'=>"arial", 'bold'=>false, 'size'=>12, 'as_percentage' => false, 'position'=>$positionTip, 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );    

            $chart[ 'legend_rect' ] = array ( 'x'=>0, 'y'=>-10000, 'width'=>0, 'height'=>0, 'fill_color' => 'E0E0E0' ); 
            
            $chart[ 'chart_type' ] = $type;
            
        }
        
        // common settings
        if(!isset($chart['axis_category'])) {
            $chart['axis_category' ] = array ( 'font'=>"arial", 'bold'=>false, 'size'=>11, 'color'=>"000000", 'alpha'=>85, 'skip'=>0 );
        }
        $chart['axis_ticks'] = array('category_ticks' => 'false', 'value_ticks' => 'false');
        
        if(!isset($chart[ 'series_color' ])) {
            if(isset($params[ 'series_color' ])) {
                $chart[ 'series_color' ] = $params[ 'series_color' ];
            } else {
                $chart[ 'series_color' ] = $this->seriesColors;
            }
        }
        return $chart;
    }

    //------------------------------------------------------------------------

    function FillData($chart, $params) {
        $valuesOrientation = $params['values_orientation'];
        $labels = $params['labels'];
        $values = $params['values'];
        $legend = $params['legend'];
        
        $arrLabels = $this->ConvertArray("labels", $valuesOrientation, $labels);
        $chart['chart_data'][] = $arrLabels;
        
        if(!is_array($values[0])) {
            $arrValues = $this->ConvertArray("Values", $valuesOrientation, $values);
            $chart['chart_data'][] = $arrValues;
        } else {
            for($i=0; $i<count($values); $i++) {
                $av = $values[$i];
                $l = ($legend[$i] != '' ? $legend[$i] : '');
                $arrValues = $this->ConvertArray($l, $valuesOrientation, $av);
                
                $chart['chart_data'][] = $arrValues;
            }
            
            if($chart['chart_type'] == 'column') {
                $chart['chart_type'] = "parallel column";
            }
        }
        
        if(strpos($chart[ 'chart_type' ], 'pie') !== false) {
            $textValues = array();
            for($i=0; $i<count($labels); $i++) {
                $textValues[$i] = $labels[$i].' ('.$params['prefix'].$values[$i].$params['suffix'].')';
            }
            $chart['chart_value_text'][] = $arrLabels;
            $chart['chart_value_text'][] = $this->ConvertArray("Values", $valuesOrientation, $textValues);
        }
        return $chart;
    }
    
    //------------------------------------------------------------------------

    function ConvertArray($firstElem, $dir, $arr) {
        $newArr = array();
        $newArr[] = $firstElem;
        
        if($dir == 'opposite') {
            for($i=count($arr)-1; $i>=0; $i--) {
                $newArr[] = $arr[$i];
            }
        } else {
            foreach($arr as $val) {
                $newArr[] = $val;
            }
        }        
        return $newArr;
    }
        
}
?>
