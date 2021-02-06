<?php
QUnit_Global::includeClass('QUnit_Object');
QUnit_Global::includeClass('QUnit_UI_TemplateEngine');

class QUnit_UI_TemplatePage extends QUnit_Object
{
    var $templateEngine;
    var $temporaryTemplateEngine;
    var $template = '';
    var $mainTemplate = '';
    var $templateSuffix = '';
    var $filePrefix = '';
    var $user_type = '';
    var $modulePermissions = array();
    var $navigation = array();
    
    //------------------------------------------------------------------------
    
    function init($template = 'blank') 
    {
        $this->template = $template;
        if($this->mainTemplate == '')
            $this->mainTemplate = 'main';
        $this->templateSuffix = '.tpl.php';
        $this->initTemplateEngine();
        $this->initPermissions();
    }
    
    //------------------------------------------------------------------------

    function initPermissions()
    {
    }
    
    //------------------------------------------------------------------------

    function checkPermissions($action = '')
    {
        if($action == '') $action = $this->getAction();

        if(!is_array($this->modulePermissions) || count($this->modulePermissions)<=0)
            return true;

        $necessaryPermission = $this->modulePermissions[$action];

        if($necessaryPermission == '' || $GLOBALS['Auth']->checkPermission($necessaryPermission))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //------------------------------------------------------------------------
    
    function getAction()
    {
        if($_REQUEST['postaction'] != '')
            return $_REQUEST['postaction'];
        if($_REQUEST['massaction'] != '')
            return $_REQUEST['massaction'];
        if($_REQUEST['action'] != '')
            return $_REQUEST['action'];
        if($_REQUEST['reporttype'] != '')
            return $_REQUEST['reporttype'];
        
        return 'view';
    }
    
    //------------------------------------------------------------------------

    /**
     * inits temporary Template Engine which can be used for rendering subsections 
     * of the page
     */
    function initTemplateEngine() 
    {
        $this->templateEngine =& QUnit_Global::newobj('QUnit_UI_TemplateEngine');
    }
    
    //------------------------------------------------------------------------

    function initTemporaryTE() 
    {
        $this->temporaryTemplateEngine =& QUnit_Global::newobj('QUnit_UI_TemplateEngine');
    }
    
    //------------------------------------------------------------------------
    
    function process() 
    {
        QUnit_Page::end_timer();
        
        $this->mainPageAssigns();
        $this->addErrorMessage(QUnit_Messager::getErrorMessages());
        $this->addOkMessage(QUnit_Messager::getOkMessages());
                
        $this->assign('okMessages', $this->getOkMessages());
        $this->assign('errorMessages', $this->getErrorMessages());
        return $this->fetch($this->template);
    }

    //------------------------------------------------------------------------

    function fetch($template) 
    {
        $finder =& QUnit_Global::newObj('QUnit_Io_PathFinder');

        $this->globalAssigns();
        
        $templateName = $template . $this->templateSuffix;
        $this->templateEngine->setPath('template', $finder->getTemplatePath($templateName));          
        $content = $this->templateEngine->fetch($templateName);

        if(is_object($content))
            return "$template ".$content->text;
        else
            return $content;
	    echo $this->template;
    }
    
    //------------------------------------------------------------------------
    
    function fetchTemplate($template) {
        return $this->fetch($template);
    }    
    
    //------------------------------------------------------------------------
    
    function getImage($img) {
        $finder =& QUnit_Global::newObj('QUnit_Io_PathFinder');

        if($path = $finder->getTemplatePath($img, 'image')) {
        	if ($GLOBALS['forum_active']) {
        		$path = str_replace('forumAdmin/', '', $path);
        		$path = str_replace('scripts/', '', $path);
        		return $path;
        	} else {
            	return $path;
        	}
        }
        return $img;
    }

    //------------------------------------------------------------------------

    function getCountriesAsOptions($country = 'United States') {
        $options = '';
        foreach($GLOBALS['countries'] as $item_country) {
            $options .= "<option value='".$item_country."'";
            if($item_country == $country)
                $options .= ' selected';
            $options .= ">".$item_country."</option>";
        }
        return $options;
    }

    //------------------------------------------------------------------------

    function temporaryFetch($template)
    {
        $finder =& QUnit_Global::newObj('QUnit_Io_PathFinder');
    
        $this->temporaryAssignRef('a_Auth', $GLOBALS['Auth']);
        $this->temporaryAssignRef('a_this', $this);

        $templateName = $template . $this->templateSuffix;
        $this->temporaryTemplateEngine->setPath('template', $finder->getTemplatePath($templateName));
        $content = $this->temporaryTemplateEngine->fetch($templateName);

        if(is_object($content))
            return $content->text;
        else
            return $content;
    }
    
    //------------------------------------------------------------------------

    function mainPageAssigns()
    {
        $this->assign('a_dbrequests', $GLOBALS['dbrequests']);
        $this->assign('a_timegenerated', QUnit_Page::getTimeGenerated());
    }

    //------------------------------------------------------------------------

    function globalAssigns()
    {
        $this->assignRef('a_Auth', $GLOBALS['Auth']);
        $this->assignRef('a_this', $this);
    }
    
    //------------------------------------------------------------------------

    function pageLimitsAssign()
    {
        $this->assign('a_list_page', $_REQUEST['list_page']);
        $this->assign('a_list_pages', $_REQUEST['list_pages']);
        $this->assign('a_allcount', $_REQUEST['allcount']);
    }

    //------------------------------------------------------------------------

    function redirect($request)
    {
        QUnit_UI_TemplatePage::timeRedirectNomsg($request);
        //header("Location: index.php?md=".$request);
        exit;
    }

    //------------------------------------------------------------------------    

    function timeRedirect($request, $time = 0)
    {
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time;URL=index.php?md=$request\">";
    
      echo "<br><center><span class=redirecttext>".L_G_WAITTRANSFER."</a><br><br><a class=redirectlink href=index.php?md=$request>".L_G_TRANSFERNOW."</a></center>";
    }

    //------------------------------------------------------------------------
    
    function timeRedirectNomsg($request, $time = 0)
    {
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time;URL=index.php?md=$request\">";
    }


    //------------------------------------------------------------------------

    function closeWindow($modul)
    {
        $this->assign('redirect_modul', $modul);
    }

    //------------------------------------------------------------------------

    function assign($var, $value)
    {
        $this->templateEngine->assign($var, $value);
    }
    
    //------------------------------------------------------------------------

    function assignRef($var, &$value)
    {
        $this->templateEngine->assignRef($var, $value);
    }

    //------------------------------------------------------------------------

    function temporaryAssign($var, $value)
    {
        $this->temporaryTemplateEngine->assign($var, $value);
    }
    
    //------------------------------------------------------------------------

    function temporaryAssignRef($var, &$value)
    {
        $this->temporaryTemplateEngine->assignRef($var, $value);
    }
    
    //------------------------------------------------------------------------

    function getFilePrefix()
    {
        return $this->filePrefix;
    }
    
    //------------------------------------------------------------------------

    function setFilePrefix($filePrefix)
    {
        $this->filePrefix = $filePrefix;
    }

    //------------------------------------------------------------------------

    function getMainTemplate()
    {
        return $this->mainTemplate;
    }
    
    //------------------------------------------------------------------------

    function setMainTemplate($mainTemplate)
    {
        $this->mainTemplate = $mainTemplate;
    }
    
    //------------------------------------------------------------------------
    
    function addContent($template, $main_tpl = '')
    {
//        if($main_tpl != '')
//            $this->setMainTemplate($main_tpl);
        
        $this->temp_content .= $this->fetch($template);
    }
    
    //------------------------------------------------------------------------
    
    function clearTempContent()
    {
        $this->temp_content = '';
    }

    //------------------------------------------------------------------------

    function getTemplateName($file)
    {
        return $file.$this->templateSuffix;
    }
    
    //------------------------------------------------------------------------

    function isLoginPage()
    {
        return false;
    }
    
    //------------------------------------------------------------------------
    
    function getContent()
    {
        return $this->temp_content;
    }
    
    //------------------------------------------------------------------------
    
    function setContent($content)
    {
        $this->temp_content = $content;
    }

    //------------------------------------------------------------------------
    
    function navigationClearAll() {
        
        $this->navigation = array();
        
        $GLOBALS['navigation'] = str_replace('"','\"',$this->navigationGetHTML());
    }
    
    //------------------------------------------------------------------------
    
    function navigationAddURL($name, $url, $target = '_self', $id = '') {
        
        $this->navigation[] = array('name' => $name, 'url' => $url, 'target' => $target, 'id' => $id);
        $GLOBALS['navigation'] = str_replace('"','\"',$this->navigationGetHTML());
    }

    //------------------------------------------------------------------------
    
    function navigationGetHTML() {
        
        $html = '&nbsp;&nbsp;';

        for ($i=0;$i<count($this->navigation)-1;$i++) {

            $html .= '<a class="navLink" href="'.$this->navigation[$i]['url'].'" target="'.$this->navigation[$i]['target'].'">'.$this->navigation[$i]['name'].'</a>&nbsp;&gt;&nbsp;';
        }
        
        if (is_array($this->navigation[$i])) {
            
            $html .= '<b>'.$this->navigation[$i]['name'].'</b>';
        }
        
        return $html;
    }
}
?>
