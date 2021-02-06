<?php
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class QUnit_UI_ResourcesPage extends QUnit_UI_TemplatePage
{
    //------------------------------------------------------------------------

    function findPage($page)
    {
        $page = preg_replace('/[^\w\-]/','',substr($page,0,128));

        $completePath = $this->getResourcesDir().'/'.$page.'.html';

        if(file_exists($completePath))
        {
            // load its contents
            ob_start();

            // include the requested template filename in the local scope
            // (this will execute the view logic).
            include($completePath);

            $contents = ob_get_contents();
            ob_end_clean();

            return $contents;
        }
        else
            return "Page $page.html not found.";
    }

    //--------------------------------------------------------------------------

    function getAccountDir() {
        $settings = QCore_Settings::getGlobalSettings();
        if(!isset($settings['Glob_accounts_dir']) || $settings['Glob_accounts_dir'] == '') {
            QUnit_Messager::setErrorMessage(L_G_ACCOUNTSDIRNOTCONFIGURED);
            return false;
        }
        return $settings['Glob_accounts_dir'].'/'.$GLOBALS['Auth']->getAccountID();
    }

    //--------------------------------------------------------------------------

    function getResourcesDir() {
    	if (AFF_PROGRAM_TYPE == PROG_TYPE_PRO) {
        	return $GLOBALS['PROJECT_ROOT_PATH'].'/affiliates/'.ltrim($GLOBALS['Auth']->getSetting('Aff_resources_dir'), '/').'/'.$_SESSION[SESSION_PREFIX.'lang'];
    	} else {
    		return $GLOBALS['PROJECT_ROOT_PATH'].'/'.$this->getAccountDir().'/resources/'.$_SESSION[SESSION_PREFIX.'lang'];
    	}
    }
}
?>
