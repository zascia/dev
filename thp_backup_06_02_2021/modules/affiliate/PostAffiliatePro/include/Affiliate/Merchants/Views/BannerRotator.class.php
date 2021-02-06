<?php
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Views_Banner');

class Affiliate_Merchants_Views_BannerRotator extends Affiliate_Merchants_Views_Banner
{
    //--------------------------------------------------------------------------

    function process()
    {
        if ($this->processRotator()) {
            return parent::process();
        }
        
        $this->showBanner();
    }
    
    //--------------------------------------------------------------------------
    
    function processRotator() {
        if(isset($_POST['submit_add'])) {
            $this->processAddSubBanner();
            return false;
        }
        if(isset($_POST['reset_rank'])) {
            $this->processResetRank();
            return false;
        }
        if(isset($_POST['reset_stats'])) {
            $this->processResetStats();
            return false;
        }
        if(isset($_POST['save_rank'])) {
            $_POST['desturl'] = $_POST['desturl'] | ROTATOR_RESET_STATS;
            $this->processEditRank();
            return false;
        }
        foreach ($_POST as $key => $value) {
            if (strstr($key, 'delete_') !== false) {
                $tmp = explode('_', $key);
                $_POST['desturl'] =  $_POST['desturl'] | ROTATOR_CONTENT_CHANGE | ROTATOR_RESET_RANK;
                $this->processDeleteSubBanner($tmp[1]);
                return false;
            }
            if (strstr($key, 'editrank_') !== false) {
                $tmp = explode('_', $key);
                $_POST['desturl'] =  $_POST['desturl'] | ROTATOR_RESET_RANK;
                $_POST['edit_rank_id'] = $tmp[1];
                return false;
            }
        }
        
        return true;
    }
    
    //------------------------------------------------------------------------

    function showBanner() {
        $this->assign('a_md', 'Affiliate_Merchants_Views_BannerRotator');
        
        if ($_POST['header'] == '') {
            $_POST['header'] = L_G_ADDBANNER;
        }
        
        $objCampaignManager =& QUnit_Global::newObj('Affiliate_Merchants_Views_CampaignManager');    
        $campaigns = $objCampaignManager->getCampaignsAsArray();
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($campaigns);
        $this->assign('a_list_campaigns', $list_data);
        
        $params = array(
                'AccountID' => $GLOBALS['Auth']->getAccountID(),
                'notIn' => array(BANNERTYPE_ROTATOR)
                );
        $banners = $this->blBanners->getBannersAsArray($params);    
        $list_data = QUnit_Global::newObj('QCore_RecordSet');
        $list_data->setTemplateRS($banners);
        $this->assign('a_list_data_banners', $list_data);
        
        $this->assign('a_selected_banners', $this->parseRotatorBannerDescription($_POST['desc']));

        $this->navigationAddURL(L_G_ROTATORBANNER,'index.php?md=Affiliate_Merchants_Views_BannerRotator');
        
        $categories = $this->blCategories->getRows();
        $this->assign('bannerCategories', $categories);

        $this->addContent('banner_edit_rotator');
    }
    
    //------------------------------------------------------------------------

    function loadBannerInfo() {
        $data = parent::loadBannerInfo();
    
        //$this->assign('a_selected_banners', $this->parseRotatorBannerDescription($data['description']));
    }

    //------------------------------------------------------------------------

    function checkCorrectness($pvars) {
        checkCorrectness($_POST['campaign'], $pvars['CampaignID'], L_G_PCNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['name'], $pvars['pname'], L_G_BANNERNAME, CHECK_ALLOWED);
        $pvars['ptype'] = BANNERTYPE_ROTATOR; 
        
        return $pvars;
    }    
    
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
    
    //------------------------------------------------------------------------
    
    function encodeRotatorBannerDescription($banners)
    {
        if (count($banners) == 0) {
            return '';
        }
        
        $desc = '';
        foreach ($banners as $bannerID => $bannerData) {
            $desc .= ($desc == '' ? '' : ',').$bannerID.';'.implode(';', $bannerData);
        }
        
        return $desc;
    }
    
    //------------------------------------------------------------------------
    
    function processAddSubBanner() {
        $pvars = array();
        $pvars['addbanner_id'] = preg_replace('/[\'\"]/', '', $_POST['addbanner_id']);
        $pvars['addbanner_rank'] = preg_replace('/[^0-9]/', '', $_POST['addbanner_rank']);
        
        checkCorrectness($_POST['addbanner_id'], $pvars['addbanner_id'], L_G_BANNERID, CHECK_ALLOWED);
        checkCorrectness($_POST['addbanner_rank'], $pvars['addbanner_rank'], L_G_RANK, CHECK_NUMBER);
        
        if ($pvars['addbanner_rank'] < 0 || $pvars['addbanner_rank'] > MAX_RANK) {
            QUnit_Messager::setErrorMessage(L_G_RANK.' '.L_G_MUSTBEININTERVAL.' 0 '.L_G_TO.' '.MAX_RANK);
        }
        
        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        
        $banners = $this->parseRotatorBannerDescription($_POST['desc']);
        
        if(count($banners) == 0) {
            $banners[$pvars['addbanner_id']] = array('all_imps'  => 0,
                                                     'uniq_imps' => 0,
                                                     'clicks'    => 0,
                                                     'rank'      => MAX_RANK);
            $_POST['desc'] = $this->encodeRotatorBannerDescription($banners);
        } else {
            if (key_exists($pvars['addbanner_id'], $banners)) {
                QUnit_Messager::setErrorMessage(L_G_BANNERISALREADYINROTATOR);
                return;
            }
            
            $rank_multiply = (MAX_RANK - $pvars['addbanner_rank']) / MAX_RANK;
            $total_rank = 0;
            foreach ($banners as $bannerID => $bannerData) {
                $total_rank += $banners[$bannerID]['rank'] = round($banners[$bannerID]['rank']*$rank_multiply, RANK_PRECISION);
            }
            
            $banners[$pvars['addbanner_id']] = array('all_imps'  => 0,
                                                     'uniq_imps' => 0,
                                                     'clicks'    => 0,
                                                     'rank'      => MAX_RANK - $total_rank);
                                                     
            $_POST['desc'] = $this->encodeRotatorBannerDescription($banners);
        }
    }
    
    //------------------------------------------------------------------------
    
    function processDeleteSubBanner($id) {
        $banners = $this->parseRotatorBannerDescription($_POST['desc']);
        $removed_rank = $banners[$id]['rank'];
        unset($banners[$id]);
        if(count($banners) != 0) {
            $rank_multiply = MAX_RANK/(MAX_RANK - $removed_rank);
            foreach ($banners as $bannerID => $bannerData) {
                $banners[$bannerID]['rank'] = round($banners[$bannerID]['rank']*$rank_multiply, RANK_PRECISION);
            }
        }
        $_POST['desc'] = $this->encodeRotatorBannerDescription($banners);
    }
    
    //------------------------------------------------------------------------
    
    function processResetRank() {
        $banners = $this->parseRotatorBannerDescription($_POST['desc']);
        if(($count = count($banners)) != 0) {
            foreach ($banners as $bannerID => $bannerData) {
                $banners[$bannerID]['rank'] = round(MAX_RANK/$count, RANK_PRECISION);
            }
        }
        $_POST['desc'] = $this->encodeRotatorBannerDescription($banners);
    }
    
    //------------------------------------------------------------------------
    
    function processResetStats() {
        $banners = $this->parseRotatorBannerDescription($_POST['desc']);
        if(count($banners) != 0) {
            foreach ($banners as $bannerID => $bannerData) {
                $banners[$bannerID]['all_imps'] = 0;
                $banners[$bannerID]['uniq_imps'] = 0;
                $banners[$bannerID]['clicks'] = 0;
            }
        }
        $_POST['desc'] = $this->encodeRotatorBannerDescription($banners);
    }
    
    //------------------------------------------------------------------------
    
    function processEditRank() {
        $newrankID = preg_replace('/[\'\"]/', '', $_POST['edit_rank_id']);
        $newrank = preg_replace('/[^0-9]/', '', $_POST['edit_rank_value']);
        checkCorrectness($_POST['edit_rank_value'], $newrank, L_G_RANK, CHECK_NUMBER);
        
        if ($newrank < 0 || $newrank > MAX_RANK) {
            QUnit_Messager::setErrorMessage(L_G_RANK.' '.L_G_MUSTBEININTERVAL.' 0 '.L_G_TO.' '.MAX_RANK);
        }
        
        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        
        $banners = $this->parseRotatorBannerDescription($_POST['desc']);
        if ($banners[$newrankID] == '') {
            return;
        }
        if (count($banners) == 1) {
            $_POST['edit_rank_id'] = '';
            return;
        }
        $banners[$newrankID]['rank'] = $newrank;
        
        $sum   = 0;
        $count = 0;
        foreach ($banners as $bannerID => $bannerData) {
            if ($bannerID == $newrankID)
                continue;
            $sum += $banners[$bannerID]['rank'];
            $count++;
        }
        $multiply = (MAX_RANK-$newrank)/$sum;
        foreach ($banners as $bannerID => $bannerData) {
            if ($bannerID == $newrankID)
                continue;
            $banners[$bannerID]['rank'] = round($banners[$bannerID]['rank'] * $multiply, RANK_PRECISION);
        }
        $_POST['edit_rank_id'] = '';
        
        $_POST['desc'] = $this->encodeRotatorBannerDescription($banners);
    }
}
?>
