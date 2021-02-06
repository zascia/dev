<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Messager');

class Affiliate_Merchants_Bl_Banners
{
    function Affiliate_Merchants_Bl_Banners()
    {
    }

    //--------------------------------------------------------------------------

    function getBannersAsArray($params)
    {
        if($params['AccountID'] == '') return false;

        $sql = 'select b.bannerid, b.destinationurl, b.bannertype, b.description, b.name, b.hidden, b.size '.
               'from wd_pa_banners b, wd_pa_campaigns c '.
               'where b.deleted = 0'.
               '  and b.campaignid=c.campaignid'.
               '  and c.accountid='._q($params['AccountID']);

        if(isset($params['in'])) {
            if ($params['in'] != 'all') {
                $sql .= '  and b.bannertype in ('.implode(',', $params['in']).')';
            }
        } else {
            if(isset($params['notIn'])) {
                $sql .= '  and b.bannertype not in ('.implode(',', $params['notIn']).')';
            } else {
                $sql .= '  and b.bannertype not in (\''.BANNERTYPE_POPUP.'\',\''.BANNERTYPE_POPUNDER.'\')';
            }
        }
        $sql .= ' order by b.bannerid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $banners = array();

        while(!$rs->EOF)
        {
            $banners[$rs->fields['bannerid']]['bannerid'] = $rs->fields['bannerid'];
            $banners[$rs->fields['bannerid']]['name'] = $rs->fields['name'];
        	$banners[$rs->fields['bannerid']]['destinationurl'] = $rs->fields['destinationurl'];
            $banners[$rs->fields['bannerid']]['bannertype'] = $rs->fields['bannertype'];
            $banners[$rs->fields['bannerid']]['description'] = $rs->fields['description'];
            $banners[$rs->fields['bannerid']]['hidden'] = $rs->fields['hidden'];
            $banners[$rs->fields['bannerid']]['size'] = $rs->fields['size'];

            switch($rs->fields['bannertype'])
            {
                case BANNERTYPE_TEXT : $banners[$rs->fields['bannerid']]['type_text'] = L_G_TEXT_; break;
                case BANNERTYPE_IMAGE : $banners[$rs->fields['bannerid']]['type_text'] = L_G_GRAPHICS; break;
                case BANNERTYPE_HTML : $banners[$rs->fields['bannerid']]['type_text'] = L_G_HTML_FLASH; break;
                case BANNERTYPE_POPUP : $banners[$rs->fields['bannerid']]['type_text'] = L_G_POPUP; break;
                case BANNERTYPE_POPUNDER : $banners[$rs->fields['bannerid']]['type_text'] = L_G_POPUNDER; break;
                case BANNERTYPE_ROTATOR : $banners[$rs->fields['bannerid']]['type_text'] = L_G_ROTATOR; break;
            }

            $rs->MoveNext();
        }

        return $banners;
    }

    //--------------------------------------------------------------------------

    function insert($pvars)
    {
        $BannerID = QCore_Sql_DBUnit::createUniqueID('wd_pa_banners', 'bannerid');
        $sql = 'insert into wd_pa_banners '.
               '(bannerid, name, campaignid, destinationurl, sourceurl, description, bannercategory, bannertype, hidden, size, dateinserted)'.
               'values('._q($BannerID).','._q($pvars['pname']).','._q($pvars['CampaignID']).
               ','._q($pvars['pdesturl']).','._q($pvars['psourceurl']).','._q($pvars['pdesc']).','._q($pvars['BannerCategoryID']).
               ','._q($pvars['ptype']).','._q($pvars['phidden']).','._q($pvars['psize']).','.sqlNow().')';

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        QUnit_Messager::setOkMessage(L_G_BANNERADDED);

        if (QUICK_IMPRESSION_ENABLED == 1) {
            $this->createBannerCacheFile();
        }

        return $BannerID;
    }

    //--------------------------------------------------------------------------

    function update($pvars)
    {
        $sql = 'update wd_pa_banners '.
               'set destinationurl='._q($pvars['pdesturl']).
               '   ,sourceurl='._q($pvars['psourceurl']).
               '   ,name='._q($pvars['pname']).
               '   ,description='._q($pvars['pdesc']).
               '   ,campaignid='._q($pvars['CampaignID']).
               '   ,hidden='._q($pvars['phidden']).
               '   ,size='._q($pvars['psize']).
               '   ,bannertype='._q($pvars['ptype']).
               '   ,bannercategory='._q($pvars['BannerCategoryID']).
               ' where bannerid='._q($pvars['BannerID']);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        QUnit_Messager::setOkMessage(L_G_BANNEREDITED);

        if (QUICK_IMPRESSION_ENABLED == 1) {
            $this->createBannerCacheFile();
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function getBannerInfo($params)
    {
        $IDs = $params['bannerid'];
        $sql = 'select * from wd_pa_banners '.
               'where deleted='._q('0');
        if(is_array($IDs) && count($IDs) > 0)
        {
            $sql .= ' and bannerid in ('.implode(',', $IDs).')';
        }
        $sql .= ' order by destinationurl';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $bannerData = array();

        while(!$rs->EOF)
        {
            $bannerData[$rs->fields['bannerid']]['bannerid'] = $rs->fields['bannerid'];
            $bannerData[$rs->fields['bannerid']]['name'] = $rs->fields['name'];
            $bannerData[$rs->fields['bannerid']]['description'] = $rs->fields['description'];
            $bannerData[$rs->fields['bannerid']]['destinationurl'] = $rs->fields['destinationurl'];
            $bannerData[$rs->fields['bannerid']]['sourceurl'] = $rs->fields['sourceurl'];
            $bannerData[$rs->fields['bannerid']]['bannertype'] = $rs->fields['bannertype'];
            $bannerData[$rs->fields['bannerid']]['campaignid'] = $rs->fields['campaignid'];
            $bannerData[$rs->fields['bannerid']]['hidden'] = $rs->fields['hidden'];
            $bannerData[$rs->fields['bannerid']]['size'] = $rs->fields['size'];

            $rs->MoveNext();
        }

        return $bannerData;
    }

    //--------------------------------------------------------------------------

    function parseRotatorBannerDescription($desc)
    {
        if($desc == '') {
            return array();
        }

        $descArray = explode(',', $desc);
        $parsed = array();

        foreach($descArray as $descItem) {
            $banner = explode(';', $descItem);
            $parsed[$banner[0]] = array('all_imps'  => $banner[1],
                                        'uniq_imps' => $banner[2],
                                        'clicks'    => $banner[3],
                                        'rank'      => $banner[4]);
        }
        return $parsed;
    }

    //--------------------------------------------------------------------------

    function createBannerCacheFile() {
        $sql = 'select b.bannerid, b.destinationurl, b.bannertype, b.description, b.sourceurl '.
              'from wd_pa_banners b, wd_pa_campaigns c '.
              'where b.deleted = 0'.
              '  and b.campaignid=c.campaignid'.
              '  and c.accountid='._q($GLOBALS['Auth']->getAccountID()).
              ' order by b.bannerid';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        require_once($GLOBALS['PROJECT_ROOT_PATH'].'/scripts/SimpleCache.class.php');

        $cache =& new SimpleCache(CACHE_PATH.$GLOBALS['Auth']->getLiteAccountID().'_'.BANNERS_CACHE_FILENAME);
        $cache->openWrite();

        while(!$rs->EOF)
        {
            switch($rs->fields['bannertype'])
            {
//                case BANNERTYPE_IMAGE:
//                    $data = $rs->fields['sourceurl'];
//                    break;
                case BANNERTYPE_ROTATOR:
                    $subbanners = $this->parseRotatorBannerDescription($rs->fields['description']);
                    $data = '';
                    if (count($subbanners) > 0) {
                        foreach ($subbanners as $bannerID => $bannerDesc) {
                            $data .= $bannerID.';'.$bannerDesc['rank'].'_';
                        }
                    }
                    $data = rtrim($data, '_');
                    break;
                default:
                    $data = '';

                    $params = array();
                    $params['Affiliate_id'] = '$$AFF_ID$$';
                    $params['Affiliate_refid'] = '$$AFF_REFID$$';
                    $params['Affiliate_name'] = '';
                    $params['Affiliate_username'] = '';
                    
                    $clickUrlOnly = $this->getClickUrl($rs->fields['destinationurl'], $params);
                    
                    $specialDestUrl == '$$SPECIAL_DEST_URL$$';

                    $code = $this->getBannerCode($clickUrlOnly, $rs->fields['bannertype'], $rs->fields['bannerid'], $rs->fields['sourceurl'], $rs->fields['description'], $params, $specialDestUrl);
                    if ($rs->fields['bannertype'] == BANNERTYPE_POPUNDER || $rs->fields['bannertype'] == BANNERTYPE_POPUP) {
                        $data = $code;
                    } else {
	                   $data = "document.write('".str_replace("'", '"', $code)."');";
                    }

                    break;
            }

            $cache->replace($rs->fields['bannerid'], $rs->fields['bannertype'].','.$data);

            $rs->MoveNext();

        }

        $cache->close();
    }

    //--------------------------------------------------------------------------

    function getClickUrl($destinationUrl, $params)
    {
        if($GLOBALS['Auth']->getSetting('Aff_link_style') == LINK_STYLE_NEW)
        {
            $destUrl = $destinationUrl;
            if(strpos($destUrl, '?') === false)
                $char = '?';
            else
                $char = '&';

            $destUrl = str_replace('$Affiliate_id', $params['Affiliate_id'], $destUrl);
            $destUrl = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $destUrl);
            $destUrl = str_replace('$Affiliate_name', $params['Affiliate_name'], $destUrl);
            $destUrl = str_replace('$Affiliate_username', $params['Affiliate_username'], $destUrl);

            if (GLOBAL_DB_ENABLED == 1) {
                $clickUrlOnly = $destUrl.$char."lid=".$_SESSION[LID_PREFFIX.'lite_accountid']."&".PARAM_A_AID."=".$params['Affiliate_refid'];
            } else {
                $clickUrlOnly = $destUrl.$char.PARAM_A_AID."=".$params['Affiliate_refid'];
            }
        }
        else
        {
            if (GLOBAL_DB_ENABLED == 1) {
                $clickUrlOnly = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."t.php?lid=".$_SESSION[LID_PREFFIX.'lite_accountid']."&".PARAM_A_AID."=".$params['Affiliate_refid'];
            } else {
                $clickUrlOnly = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."t.php?".PARAM_A_AID."=".$params['Affiliate_refid'];
            }
        }

        return $clickUrlOnly;
    }

    //--------------------------------------------------------------------------

	function getBannerCode($clickUrlOnly, $bannerType, $bannerID, $sourceUrl, $description, $params, $specialDestUrl = '') {
	    if($bannerType == BANNERTYPE_TEXT)
        {
            $title = $sourceUrl;
            $title = str_replace('$Affiliate_id', $params['Affiliate_id'], $title);
            $title = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $title);
            $title = str_replace('$Affiliate_name', $params['Affiliate_name'], $title);
            $title = str_replace('$Affiliate_username', $params['Affiliate_username'], $title);

            $description = str_replace('$Affiliate_id', $params['Affiliate_id'], $description);
            $description = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $description);
            $description = str_replace('$Affiliate_name', $params['Affiliate_name'], $description);
            $description = str_replace('$Affiliate_username', $params['Affiliate_username'], $description);

            if(isset($GLOBALS['Auth']->getSetting['Aff_bannerformat_textformat']) && trim($GLOBALS['Auth']->getSetting['Aff_bannerformat_textformat']) != '')
            {
                $code = $GLOBALS['Auth']->getSetting['Aff_bannerformat_textformat'];
                $code = str_replace('$TITLE', $title, $code);
                $code = str_replace('$DESCRIPTION', $description, $code);
                $code = str_replace('$DESTINATION', "'".$clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : '')."'", $code);
                $code = str_replace('$IMPRESSION_TRACK', "", $code);

                $banner['titleDescription'] = $code;

            }
            else
            {
                $banner['titleDescription'] = "<b>".$title."</b><br>".$description;

                $code = "<A HREF=\"".$clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : '')."\">";
                $code .= "<center><b>".$title."</b><br>".$description."</center>";
                $code .= "</A>";
            }

            return $code;
        }
        else if($bannerType == BANNERTYPE_HTML)
        {
            $description = str_replace('$Affiliate_id', $params['Affiliate_id'], $description);
            $description = str_replace('$Affiliate_name', $params['Affiliate_name'], $description);
            $description = str_replace('$Affiliate_username', $params['Affiliate_username'], $description);

            $code = str_replace('$CLICKURL', $clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.$specialDestUrl : ''), $description);

            return $code;
        }
        else if($bannerType == BANNERTYPE_IMAGE)
        {
            $banner['titleDescription'] = "<img src='".$sourceUrl."' border=0 alt='".$description."'><br>";

            $code = "<A HREF=\"".$clickUrlOnly.'&'.PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : '')."\">";
            $code .= "<img src='".$sourceUrl."' border=0 alt='".$description."'><br>";
            $code .= "</A>";

            return $code;
        }
        else if($bannerType == BANNERTYPE_POPUP || $bannerType == BANNERTYPE_POPUNDER)
        {
            $viewMerchBannerManager = QUnit_Global::newObj('Affiliate_Merchants_Views_BannerManager');
            $banner_details = $viewMerchBannerManager->parseBannerDescription($description, false);

            $banner_content = '';
            if($banner_details['display'] == URL_EXIST)
            {
                $blBanners =& QUnit_Global::newObj('Affiliate_Merchants_Bl_Banners');
                $original_banner = $blBanners->getBannerInfo(array('bannerid' => $sourceUrl));

                $bannerData = $original_banner[$sourceUrl];

                if($bannerData['bannertype'] == BANNERTYPE_TEXT)
                {
                    $title = $bannerData['sourceurl'];
                    $title = str_replace('$Affiliate_id', $params['Affiliate_id'], $title);
                    $title = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $title);
                    $title = str_replace('$Affiliate_name', $params['Affiliate_name'], $title);
                    $title = str_replace('$Affiliate_username', $params['Affiliate_username'], $title);

                    $bannerData['description'] = str_replace('$Affiliate_id', $params['Affiliate_id'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_refid', $params['Affiliate_refid'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_name', $params['Affiliate_name'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_username', $params['Affiliate_username'], $bannerData['description']);

                    if($GLOBALS['Auth']->getSetting('Aff_bannerformat_textformat') != '') {
                        $banner_content = $GLOBALS['Auth']->getSetting('Aff_bannerformat_textformat');
                        $banner_content = str_replace('$TITLE', $title, $banner_content);
                        $banner_content = str_replace('$DESCRIPTION', $bannerData['description'], $banner_content);
                        $banner_content = str_replace('$DESTINATION', $clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : ''), $banner_content);
                        $banner_content = str_replace('$IMPRESSION_TRACK', "", $banner_content);
                    }
                    else
                    {
                        $banner_content = "<A HREF=".$clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : '').">";
                        $banner_content .= "<center><b>".$title."</b><br>".$bannerData['description']."</center>";
                        $banner_content .= "</A>";
                    }
                }
                else if($bannerData['bannertype'] == BANNERTYPE_HTML)
                {
                    $bannerData['description'] = str_replace('$Affiliate_id', $params['Affiliate_id'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_name', $params['Affiliate_name'], $bannerData['description']);
                    $bannerData['description'] = str_replace('$Affiliate_username', $params['Affiliate_username'], $bannerData['description']);

                    $banner_content = str_replace('$CLICKURL', $clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.$specialDestUrl : ''), $bannerData['description']);
                }
                else if($bannerData['bannertype'] == BANNERTYPE_IMAGE)
                {
                    $banner_content = "<A HREF=".$clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : '').">";
                    $banner_content .= "<br><img src=".$bannerData['sourceurl']." border=0 alt=".$bannerData['description']."><br>";
                    $banner_content .= "</A>";
                }
            }
            else
            {
                $banner_content = $sourceUrl;
                $clickurl_link = '&clickurl='.urlencode($clickUrlOnly."&".PARAM_A_BID."=".$bannerID.($specialDestUrl != '' ? '&desturl='.urlencode($specialDestUrl) : '')).'&special=1';
            }

            $banner['titleDescription'] = '<input class=formbutton type="button" VALUE="'.L_G_TEST.' '.
                            ($bannerType == BANNERTYPE_POPUNDER ? L_G_POPUNDER : L_G_POPUP).
                            '" onClick="showPopupPopunder(\''.urlencode($banner_content).'\',\''.$bannerType.'\',\''.$banner_details['rwidth'].'\',\''.$banner_details['rheight'].'\')">';

            if (GLOBAL_DB_ENABLED == 1) {
                $impression_content = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?lid=".$_SESSION[LID_PREFFIX.'lite_accountid']."&".PARAM_A_AID."=".$params['Affiliate_refid']."&".PARAM_A_BID."=".$bannerID;
            } else {
                $impression_content = $GLOBALS['Auth']->getSetting('Aff_scripts_url')."sb.php?".PARAM_A_AID."=".$params['Affiliate_refid']."&".PARAM_A_BID."=".$bannerID;
            }

            $code = 'var TheNewWindow = window.open("'.$GLOBALS['Auth']->getSetting('Aff_scripts_url').'showPop.php?banner_content='.urlencode($banner_content).'&impression_content='.urlencode($impression_content).$clickurl_link.'",\'ThePop\',';
            $code .= '\'top=0,left=0,width='.$banner_details['rwidth'].',height='.$banner_details['rheight'].',toolbar='.$banner_details['window_toolbar'].',location='.$banner_details['window_location'];
            $code .= ',directories='.$banner_details['window_directories'].',status='.$banner_details['window_status'].',menubar='.$banner_details['window_menubar'].',scrollbars='.$banner_details['window_scrollbars'].',resizable='.$banner_details['window_resizable'].'\');';
            if($bannerType == BANNERTYPE_POPUNDER) $code .= ' TheNewWindow.blur();';
            else $code .= ' TheNewWindow.focus();';

            return $code;
        }

        return false;
	}


}
?>
