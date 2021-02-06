<?php
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Merchants_Bl_AdminInfo
{
    var $infoList;
    var $templatePage;

    //------------------------------------------------------------------------

    function Affiliate_Merchants_Bl_AdminInfo() {
        $this->infoList = array(
            'username' => L_G_EMAIL,
            'name'     => L_G_NAME,
            'surname'  => L_G_SURNAME,
            'icq'      => L_G_ICQ,
            'msn'      => L_G_MSN,
            'skype'    => L_G_SKYPE,
            'yahoomessenger' => L_G_YAHOOMESSENGER,
            'googletalk' => L_G_GOOGLETALK,
            'other_name' => L_G_OTHER_CONTACT_NAME,
            'other_contact' => L_G_OTHER_CONTACT_CONTACT,
            'photo_url' => L_G_PHOTO,
            'welcome_msg' => L_G_WELCOMEMESSAGE,
            'custom_html' => L_G_CUSTOMHTML);

        $this->templatePage = QUnit_Global::newObj('QUnit_UI_TemplatePage');
    }

    //------------------------------------------------------------------------

    function getInfoList() {
        return $this->infoList;
    }

    //------------------------------------------------------------------------

    function getFirstAdminId() {
        $sql = 'select userid from wd_g_users '.
               'where accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and rtype='._q(USERTYPE_ADMIN).
               ' order by userid';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF) {
            return false;
        }
        return $rs->fields['userid'];
    }

    //------------------------------------------------------------------------

    function getAdminInfo($userID) {
        $sql = 'select a.*, ac.name as account_name from wd_g_users a, wd_g_accounts ac '.
               'where userid='._q($userID).
               '  and a.accountid = ac.accountid'.
               '  and ac.accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }

        $info = array();

        $info['aid'] = $rs->fields['userid'];
        $info['username'] = $rs->fields['username'];
        $info['pwd1'] = '';
        $info['pwd2'] = '';
        $info['name'] = $rs->fields['name'];
        $info['surname'] = $rs->fields['surname'];
        $info['rstatus'] = $rs->fields['rstatus'];
        $info['accountid'] = $rs->fields['accountid'];
        $info['account_name'] = $rs->fields['account_name'];
        $info['userprofile'] = $rs->fields['userprofileid'];

        $settings = QCore_Settings::getAdminSettings(SETTINGTYPE_ADMIN, $GLOBALS['Auth']->getAccountID(), $userID);
        $info['icq']            = $settings['Aff_user_icq'];
        $info['msn']            = $settings['Aff_user_msn'];
        $info['skype']          = $settings['Aff_user_skype'];
        $info['yahoomessenger'] = $settings['Aff_user_yahoomessenger'];
        $info['googletalk']     = $settings['Aff_user_googletalk'];
        $info['other_name']     = $settings['Aff_user_other_name'];
        $info['other_contact']  = $settings['Aff_user_other_contact'];
        $info['photo_url']      = $settings['Aff_user_photo_url'];
        $info['welcome_msg']    = $settings['Aff_user_welcome_msg'];
        $info['custom_html']    = $settings['Aff_user_custom_html'];
        $info['selected_info']  = $settings['Aff_user_selected_info'];
        $info['info_list']      = $this->infoList;

        return $info;
    }

    //------------------------------------------------------------------------

    function getAdminInfoCode($userID) {
        $code = '';
        $info = $this->getAdminInfo($userID);

        $fields = explode(',', $info['selected_info']);
        if (count($fields) > 0) {
            foreach ($fields as $key) {
                switch ($key) {
                    case 'photo_url':
                        $code .= '<tr><td colspan="2"><b>'.$info['info_list'][$key].'</b><br><div align="center"><img src="'.$info[$key].'"></div></td></tr>';
                        break;
                    case 'custom_html':
                        $code .= '<tr><td colspan="2">'.$info[$key].'</td></tr>';
                        break;
                    case 'welcome_msg':
                        $code .= '<tr><td colspan="2">'.$info[$key].'</td></tr>';
                        break;
                    case 'icq':
                        $code .= '<tr><td width="40%"><b>'.$info['info_list'][$key].'</b></td>';
                        $code .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$info[$key].'&nbsp; <img src="'.$this->templatePage->getImage('icqunknown.gif').'" align="absmiddle"></td></tr>';
                        break;
                    case 'yahoomessenger':
                        $code .= '<tr><td width="40%"><b>'.$info['info_list'][$key].'</b></td>';
                        $code .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$info[$key].'&nbsp; <img src="'.$this->templatePage->getImage('yahoounknown.gif').'" align="absmiddle"></td></tr>';
                        break;
                    case 'skype':
                        $code .= '<tr><td width="40%"><b>'.$info['info_list'][$key].'</b></td>';
                        $code .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$info[$key].'&nbsp; <img src="'.$this->templatePage->getImage('skypeunknown.gif').'" align="absmiddle"></td></tr>';
                        break;
                    case 'msn':
                        $code .= '<tr><td width="40%"><b>'.$info['info_list'][$key].'</b></td>';
                        $code .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$info[$key].'&nbsp; <img src="'.$this->templatePage->getImage('msnunknown.gif').'" align="absmiddle"></td></tr>';
                        break;
                    case 'googletalk':
                        $code .= '<tr><td width="40%"><b>'.$info['info_list'][$key].'</b></td>';
                        $code .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$info[$key].'&nbsp;</td></tr>';
                        break;
                    default:
                        $code .= '<tr><td width="40%"><b>'.$info['info_list'][$key].'</b></td>';
                        $code .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$info[$key].'</td></tr>';
                        reak;
                }
            }
        }

        return $code;
    }
}
?>
