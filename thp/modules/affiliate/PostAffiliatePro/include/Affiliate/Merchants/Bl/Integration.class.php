<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Merchants_Bl_Integration
{

    //--------------------------------------------------------------------------

    function Affiliate_Merchants_Bl_Integration() {
    
    }

    //--------------------------------------------------------------------------
    
    function getFirstIntegrationId() {
        $sql = 'select * from wd_pa_integration '.
               'where deleted=0 '.
               'order by rorder';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return $rs->fields['integrationid'];
    }
    
    //--------------------------------------------------------------------------

    function getIntegrationMethodsAsRs()
    {
        $sql = 'select * from wd_pa_integration '.
               'where deleted=0 '.
               'order by rorder';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return $rs;
    }
    
    //--------------------------------------------------------------------------
    
    function getIntegrationStepsAsRs($integrationId) {
        $sql = 'select * from wd_pa_integrationsteps '.
               'where integrationid='._q($integrationId).' '.
               'order by rorder';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return $rs;
    }
}
?>
