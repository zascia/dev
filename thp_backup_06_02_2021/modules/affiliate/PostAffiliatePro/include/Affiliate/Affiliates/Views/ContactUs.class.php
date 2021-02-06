<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================


QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_ContactUs extends QUnit_UI_TemplatePage
{
	var $blAffiliate;

    function Affiliate_Affiliates_Views_ContactUs() {
        $this->blCommunications =& QUnit_Global::newObj('QCore_Bl_Communications');
        $this->blEmailTemplates =& QUnit_Global::newObj('QCore_EmailTemplates');    
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');    
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_CONTACTUS,'index.php?md=Affiliate_Affiliates_Views_ContactUs');
    }
    
    
    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['action'])
            {
                case 'send':
                    if($this->processSendMail())
                        return;
                    break;
            }
        }
        $this->drawFormContactUs();    
    }

    //------------------------------------------------------------------------

    function processSendMail()
    {
        if(get_magic_quotes_gpc())
        {
            $_POST['emailsubject'] = stripslashes($_POST['emailsubject']);
            $_POST['emailtext'] = stripslashes($_POST['emailtext']);
        }

        $system_email = $GLOBALS['Auth']->getSetting('Aff_system_email');

        $params = array('UserID' => $GLOBALS['Auth']->getUserID(),
                        'title' => $_POST['emailsubject'],
                        'body' => $_POST['emailtext']);

        $emaildata = $this->blEmailTemplates->getFilledEmailMessage('', $GLOBALS['Auth']->getAccountID(), 'AFF_EMAIL_CONTACT_US', $GLOBALS['Auth']->getSetting('Aff_default_lang'), $params);
        if($emaildata != false)
        {
            $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $GLOBALS['Auth']->getUserID(),
                            'email' => $system_email,
                            'settings' => $GLOBALS['Auth']->getSettings(),
                            'returnpath' => $GLOBALS['Auth']->getUsernameForUser($GLOBALS['Auth']->getUserID())
                           );
                           
            if(!$this->blCommunications->sendEmail($params))
            {
                $this->addErrorMessage(L_G_EMAILSENDFAILED);
                QCore_History::DebugMsg(WLOG_DEBUG, L_G_EMAILSENDFAILED.' ('.L_G_TO.': '.$system_email.')', __FILE__, __LINE__);
            }
            else
            {
                $this->addOkMessage(L_G_EMAILSENDOK);
                QCore_History::DebugMsg(WLOG_ACTION, L_G_EMAILSENDOK.' ('.L_G_TO.': '.$system_email.')', __FILE__, __LINE__);
                return false;
            }
        }
        else
        {
            $this->addErrorMessage(L_G_EMAILSENDFAILED);
            QCore_History::DebugMsg(WLOG_DBERROR, L_G_EMAILSENDFAILED.' ('.L_G_TO.': '.$system_email.')', __FILE__, __LINE__);
        }

        return false;
    }

    //------------------------------------------------------------------------

    function drawFormContactUs()
    {
        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        $this->assign('a_description', L_G_AFF_CONTACTUS_DESCRIPTION);
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('contactus'));
        $this->addContent('section_descriptions');
        
        $this->assign('a_user', $this->blAffiliate->loadUserInfoAsArray($GLOBALS['Auth']->getUserID()));

        $_POST['header'] = L_G_CONTACTUS;
        $_POST['action'] = 'send';

        $this->addContent('contact_us');

        return true;
    }

    //------------------------------------------------------------------------
}
?>
