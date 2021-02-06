<?php
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class QUnit_UI_MainPage extends QUnit_UI_TemplatePage
{
    var $defaultView;

    //--------------------------------------------------------------------------

    function init()
    {
        parent::init();

        $this->template = $this->getMainTemplate();
    }

    //--------------------------------------------------------------------------

    function _getPageName($usesession = true)
    {
        if($_REQUEST['md'] == '')
        {
            $pageName = $this->getFilePrefix().$this->defaultView;
        }
        else
        {
            $pageName = $_REQUEST['md'];

            if ($pageName == 'home') {
                $pageName = $this->getFilePrefix().$this->defaultView;
            }

            if(isset($GLOBALS['mdClassMap'])) {
                if(isset($GLOBALS['mdClassMap'][AFF_PROGRAM_TYPE][$_REQUEST['md']])) {
                    $pageName =  $GLOBALS['mdClassMap'][AFF_PROGRAM_TYPE][$_REQUEST['md']];
                }
            }

        }

        $_SESSION[$this->getFilePrefix().'md'] = $pageName;

        if(strtolower($pageName) == $this->getFilePrefix().'Login')
        {
            $this->menu = 'blank';
        }

        return $pageName;
    }

    //--------------------------------------------------------------------------

    function _checkPage($pageName)
    {
        return QUnit_Global::existsClass($pageName);
    }

    //--------------------------------------------------------------------------

    function &_getPage($usesession = true)
    {
        $pageName = $this->_getPageName($usesession);

        if(!$this->_checkPage($pageName))
        {
            echo "class $pageName does not exist";
        }

        return QUnit_Global::newobj($pageName);
    }

    //--------------------------------------------------------------------------

    function &_getMenu()
    {
        //if ($GLOBALS['resourcesLeftMenu']) {
        //    $pageName = $this->getFilePrefix().'ResourcesMenu';
        //} else {
            $pageName = $this->getFilePrefix().'Menu';
        //}

        if(!$this->_checkPage($pageName)) {
            return false;
        }

        return QUnit_Global::newobj($pageName);
    }

    //--------------------------------------------------------------------------

    function process()
    {
        $this->init();

        check_security();

        $page =& $this->_getPage();
        $this->initPage($page);

        if($page->isLoginPage())
        {
            if($GLOBALS['Auth']->isLogged())
            {

                // proces new page to display content, not login form
                $page =& $this->_getPage(false);

                $this->initPage($page);
            } else {
            	$this->template = 'main_notlogged';
            }
        }

        return parent::process();
    }

    //--------------------------------------------------------------------------

    function processNoSecurityCheck()
    {
        $this->init();

        $page =& $this->_getPage();

        $this->initPage($page);
        if($GLOBALS['Auth'] != '' && is_object($GLOBALS['Auth'])) {
            if(!$GLOBALS['Auth']->isLogged()) {
                $this->template = 'main_notlogged';
            }
        }
        
        return parent::process();
    }

    //--------------------------------------------------------------------------

    function processWizard($fromPage, $to_call, $params)
    {
        $this->init();

        $page =& $this->_getPage();

        $page->init(); //???

        $page->setFromPage('AffEnt_SuperAdmins_Views_Accounts');
        $page->$to_call($params['AccountID'],$params['UserProfileID']);//$params['AccountID'], $this->createParams($params)

        $this->assign('content', $page->temp_content);
        $this->assign('leftMenu', $GLOBALS['leftMenu']);
        $this->assign('menu_left', $this->getTemplateName('menu_left'));
        $this->assign('my_message', $this->getTemplateName('errorMsg'));

        return parent::process();
    }

    //--------------------------------------------------------------------------

    function initPage($page)
    {
        $page->init();

        $page->user_type = $this->user_type;

        if($page->checkPermissions())
        {
            $page->process();

            $this->assign('content', $page->temp_content);
        }
        else
        {
            $this->assign('content', L_G_YOU_DONT_HAVE_RIGHTS);
        }

        $this->assign('a_logged_field_url', $GLOBALS['a_logged_field_url'] = $this->getLoggedFieldURL());

        if(isset($GLOBALS['Auth']) && $GLOBALS['Auth']->isLogged()) {
            if($menu =& $this->_getMenu()) {
                $this->assign('menu_left', $menu->getContent());
                $this->assign('leftMenu', $menu->menu);
            }
        }
        $this->assign('menu_top', $this->getTemplateName('menu_top'));
        $this->assign('my_message', $this->getTemplateName('errorMsg'));
        $this->assign('user_type', $this->user_type);

        //$this->assign('a_logged_field_url', $this->getLoggedFieldURL());

        $this->addErrorMessage($page->getErrorMessages());
        $this->addOkMessage($page->getOkMessages());
    }


    //--------------------------------------------------------------------------

    function createParams($params)
    {
        if(is_array($params))
        {
            $param_str = '';

            foreach($params as $k => $v)
            {
                $param_str .= $v.',';
            }

            $param_str = substr($param_str,0,-1);

            return $param_str;
        }
        else
            return '';
    }

    //--------------------------------------------------------------------------

    function setDefaultView($view)
    {
        $this->defaultView = $view;
    }

    //--------------------------------------------------------------------------

    function getLoggedFieldURL()
    {
        $logged_field_url = '';
        if(!is_object($GLOBALS['Auth'])) {
        	return $logged_field_url;
        }

        if($GLOBALS['Auth']->getUserType() == USERTYPE_SUPERADMIN)
        {
            $logged_field_url = 'index.php?md=AffEnt_SuperAdmins_Views_SuperAdminsManager&action=edit&said='.$GLOBALS['Auth']->getUserID().'&show_no_popup=1';
        }
        else if($GLOBALS['Auth']->getUserType() == USERTYPE_ADMIN)
        {
            $logged_field_url = 'index.php?md=Affiliate_Merchants_Views_AdminsManager&action=edit&aid='.$GLOBALS['Auth']->getUserID().'&show_no_popup=1';
        }
        else if($GLOBALS['Auth']->getUserType() == USERTYPE_USER)
        {
            $logged_field_url = 'index.php?md=Affiliate_Affiliates_Views_AffiliateProfile';
        }

        return $logged_field_url;
    }
}
?>
