<?php

QUnit_Global::includeClass('QUnit_Graphics_HtmlGraph');

class QUnit_Graphics_Graph {
    
    var $params = array();
    
    //------------------------------------------------------------------------
    
    function QUnit_Graphics_Graph() {
    }
    
    //------------------------------------------------------------------------

    function create($params) {
        if($params['type'] == '' || $params['library'] == '') {
            echo 'GRAPH PARAMETERS NOT CORRECT';
            return false;
        }
        
        switch ($params['library']) {
            case 'xmlswf':
                return $this->xmlswfGraph($params);
                
            case 'html':
                return $this->htmlGraph($params);
        }
    }
    
    //------------------------------------------------------------------------
    
    /** XML/SWF flash graph */
    function xmlswfGraph($params) {
        QUnit_Global::includeClass('QUnit_Graphics_XmlCharts');
        $graphObj = QUnit_Global::newobj('QUnit_Graphics_XmlCharts');

        // set default params
        if($params['width'] == '') $params['width'] = 600;
        if($params['height'] == '') $params['height'] = 350;
        if($params['background_color'] == '') $params['background_color'] = 'F3F3F3';
        if(!isset($params['use_caching'])) $params['use_caching'] = 1;
        
        // checks if graph contains parallel columns
        $needsLegend = (!is_array($params['values'][0]) ? false : true); 
        
        if(!is_array($params['type'])) {
            $params['type'] = array($params['type']);
        }
        $graphVariations = $params['type'];
        $uniq = md5(uniqid(rand(), true));
        $first = true;
        $cacheWrote = false;
        
        foreach($graphVariations as $graphType) {
            $params['type'] = $graphType;
            $graphName = $uniq.str_replace(' ', '_', $graphType);
            
            $chart = array();
            $chart = $graphObj->InitParameters($params, $needsLegend, $uniq, $graphVariations);
            
            // convert graph data to PHP/SWF format
            $chart = $graphObj->FillData($chart, $params);

            $data = $graphObj->GetChartData($chart);
            
            if(defined('USE_GRAPH_CACHING') && USE_GRAPH_CACHING == 1 && $params['use_caching'] != false) {
                $cacheWrote = $this->writeToCacheFile($graphName.".xml", $data);
            }
            
            if(!$cacheWrote) {
                $_SESSION['graphData'][$graphName] = $data;
            }
            
            if($first) {
                $dataToReturn = $this->xmlswfGetGraphCode($graphObj, $params, $graphName, $cacheWrote);
                $first = false;
            }
                
        }
        
        return $dataToReturn;
    }

    //------------------------------------------------------------------------

    function xmlswfGetGraphCode($graphObj, $params, $graphName, $cacheWrote) {
        if(defined('USE_GRAPH_CACHING') && USE_GRAPH_CACHING == 1 && $cacheWrote) {
            return $graphObj->InsertChart ( 
                        "../include/xmlcharts/charts.swf", 
                        "../include/xmlcharts/charts_library",
                        "../cache/".$graphName.".xml",
                        $params['width'], $params['height'], 
                        $params['background_color'],
                        true, 
                        "D1XR-QMEW9L.HSK5T4Q79KLYCK07EK" );
        } else {
            return $graphObj->InsertChart ( 
                        "../include/xmlcharts/charts.swf", 
                        "../include/xmlcharts/charts_library",
                        "../include/xmlcharts/gdata.php?uniq=$graphName&".SID, 
                        $params['width'], $params['height'], 
                        $params['background_color'], 
                        true, 
                        "D1XR-QMEW9L.HSK5T4Q79KLYCK07EK" );
        }
    }
    
    //------------------------------------------------------------------------

    function htmlGraph($params) {
        
        /*
            params: labels,
                    values,
                    attributes
        */
        
        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');

        $labels = implode(',', $this->params['labels']);
        $values = implode(',', $this->params['values']);
        
        $graph->labels = $labels;
        $graph->values = $values;
        
        foreach ($this->params['attributes'] as $attribute => $value) {
            
            if ($attribute == 'barColor' && is_array($value)) {
                $value = implode(',',$value);
            }
            
            $graph->{$attribute} = $value;
        }
        
        return $graph->create();
    }
    
    //------------------------------------------------------------------------
    /** fusioncharts flash graph, not finished */
    function flash2Dbar($params) {
        
        $graph = "<graph caption=' ' xaxisname='' yaxismaxvalue='10' shownames='1' showvalues='0' decimalPrecision='0' numberPrefix=''>";
        
        foreach ($this->params['values'] as $key => $value) {
            $graph .= "<set name='".$this->params['labels'][$key]."' value='$value' color='".$this->params['attributes']['barColor'][0]."'/>";
        }
                
        $graph .= '</graph>';
        
        $output = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="100%" id="FusionCharts" ALIGN="">
                    <PARAM NAME="FlashVars" value="&dataXML='.$graph.'">
                    <PARAM NAME=movie VALUE="../include/Charts/FC_2_3_Column3D.swf">
                    <PARAM NAME=quality VALUE=high>
                    <PARAM NAME=bgcolor VALUE=#FFFFFF>
                    <EMBED src="../include/Charts/FC_2_3_Column3D.swf?chartWidth=600&chartHeight=300" FlashVars="&dataXML='.$graph.'" quality=high bgcolor=#FFFFFF WIDTH="600" HEIGHT="300" NAME="FusionCharts" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
                   </OBJECT>';
        
        return $output;
    }
    
    //------------------------------------------------------------------------

    function writeToCacheFile($fileName, $contents) {
        if(!defined('USE_GRAPH_CACHING') || USE_GRAPH_CACHING != 1) {
            return false;
        }
        
        if (!$handle = fopen(CACHE_PATH.$fileName, 'w')) {
            return false;
        }

        if (fwrite($handle, $contents) === FALSE) {
            return false;
        }
        
        fclose($handle);
        
        return true;
    }
}

?>