<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_AffiliateProfile extends QUnit_UI_TemplatePage
{
    var $blAffiliate;

    function Affiliate_Affiliates_Views_AffiliateProfile() {
        $this->blAffiliate =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Affiliate');
        $this->blPayoutOptions =& QUnit_Global::newObj('Affiliate_Merchants_Bl_PayoutOptions');
        
        $this->navigationAddURL(L_G_HOME,'index.php?md=home');
        $this->navigationAddURL(L_G_AFFPROFILE,'index.php?md=Affiliate_Affiliates_Views_AffiliateProfile');
    }

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'edituser':
                    if($this->processEditProfile())
                        return;
                    break;
            }
        }

        $this->drawFormEditProfile();    
    }

    //------------------------------------------------------------------------

    function processEditProfile()
    {
        $obj = QUnit_Global::newObj('Affiliate_Affiliates_Bl_AffiliateEditNew');
        if(!$obj->process(true)) {
            return false;                
        } 
        $this->addOkMessage(L_G_AFFILIATEEDITED);
    
        return false;
    }

    //------------------------------------------------------------------------

    function drawFormEditProfile()
    {
        $panel_settings = QUnit_Global::newObj('Affiliate_Affiliates_Views_AffPanelSettings');
        
        $this->assign('a_description', L_G_AFF_PROFILE_DESCRIPTION);
        
        $this->assign('a_panel_settings', $panel_settings->loadPanelSettings('affprofile'));
        
        $this->addContent('section_descriptions');

        if($_POST['commited'] != 'yes') {
            $this->blAffiliate->loadUserInfoToPost($GLOBALS['Auth']->userID);
        }
        
        // get info about parent affiliate
        $parentUserID = $this->blAffiliate->getParentUserId($GLOBALS['Auth']->getUserID());
        if($parentUserID != '')
        {
            $sql = 'select * from wd_g_users '.
                   'where deleted=0 '.
                   '  and userid='._q($_POST['parentuserid']).
                   '  and rtype='._q(USERTYPE_USER).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());

            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs)
            {
                $this->addErrorMessage(L_G_DBERROR);
                return false;
            }
            
            if (!$rs->EOF) {
                $_POST['parentuseridtext'] = $rs->fields['userid'].': '.$rs->fields['name'].' '.$rs->fields['surname'].' - '.$rs->fields['username'];
            }
        }

        $_POST['action'] = 'edit';
        $_POST['header'] = L_G_EDITPROFILE;
        $_POST['postaction'] = 'edituser';  

        $minPayouts = QCore_Settings::getMinPayoutsAsArray();

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($minPayouts);
        $this->assign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($GLOBALS['countries']);
        $this->assign('a_list_data2', $list_data2);

        $payout_methods = $this->blPayoutOptions->getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $list_data4 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data4->setTemplateRS($payout_methods);
        $this->assign('a_list_data4', $list_data4);

        $payout_fields = $this->blPayoutOptions->getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $this->assign('a_list_data5', $payout_fields);

        $settings = QCore_Settings::getAccountSettings(SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
        $settings = array_merge($settings, QCore_Settings::getGlobalSettings());
        $this->assign('settings', $settings);
        $this->addContent('aff_profile_new');

        return true;
    }

    //------------------------------------------------------------------------
}
?>
