<?php

$GLOBALS['emailcategories'] = Array (
    'AFF_EMAIL_ONSIGN',
    'AFF_EMAIL_SIGNUP',
    'AFF_EMAIL_FORGOTPAS1',
    'AFF_EMAIL_FORGOTPAS2',
    'AFF_EMAIL_NTF_SIGNUP',
    'AFF_EMAIL_NTF_SALE',
    'AFF_EMAIL_NOTIFY_RC',
    'AFF_EMAIL_DAILY_REP',
    'AFF_EMAIL_MONTH_REP',
    'AFF_EMAIL_WE_REP',
    'AFF_EMAIL_AF_NTF_SGN',
    'AFF_EMAIL_AF_NTF_SLE',
    'AFF_EMAIL_AF_PAR_SLE',
    'AFF_EMAIL_AF_ML_REP',
    'AFF_EMAIL_AF_DL_REP',
    'AFF_EMAIL_AF_WE_REP',
    'AFF_EMAIL_CONTACT_US',
    'AFF_EMAIL_AFF_CAMP_A',
    'AFF_EMAIL_AFF_NL_SGN'
    
);

$GLOBALS['emailcategoriesEComMagnet'] = Array (
    'CUST_SIGNUP',
    'CUST_ACC_CREATED',
    'CUST_ADMIN_NTF_SIGNUP',
    'CUST_ADMIN_NTF_PAID',
    'CUST_ADMIN_NTF_ACC_CREATED',
);

// Allowed constants in email messages
define('ALLOWEDCONST_DATETIME', '$Date<br>$Time');

define('ALLOWEDCONST_AFFILIATE',
'$Affiliate_id<br>'.
'$Affiliate_refid<br>'. 
'$Affiliate_name<br>'.
'$Affiliate_firstname<br>'.
'$Affiliate_lastname<br>'.
'$Affiliate_username<br>'.
'$Affiliate_status<br>'.
'$Affiliate_company<br>'.
'$Affiliate_website<br>'.
'$Affiliate_street<br>'.
'$Affiliate_city<br>'.
'$Affiliate_state<br>'.
'$Affiliate_country<br>'.
'$Affiliate_zipcode<br>'.
'$Affiliate_phone<br>'.
'$Affiliate_fax<br>'.
'$Affiliate_tax_ssn<br>'.
'$Affiliate_data1<br>'.
'$Affiliate_data2<br>'.
'$Affiliate_data3<br>'.
'$Affiliate_data4<br>'.
'$Affiliate_data5');

define('ALLOWEDCONST_PARENT',
'$Parent_id<br>'.
'$Parent_refid<br>'. 
'$Parent_name<br>'.
'$Parent_firstname<br>'.
'$Parent_lastname<br>'.
'$Parent_username<br>'.
'$Parent_status<br>'.
'$Parent_company<br>'.
'$Parent_website<br>'.
'$Parent_street<br>'.
'$Parent_city<br>'.
'$Parent_state<br>'.
'$Parent_country<br>'.
'$Parent_zipcode<br>'.
'$Parent_phone<br>'.
'$Parent_fax<br>'.
'$Parent_tax_ssn<br>'.
'$Parent_data1<br>'.
'$Parent_data2<br>'.
'$Parent_data3<br>'.
'$Parent_data4<br>'.
'$Parent_data5');

define('ALLOWEDCONST_AFF_EMAIL_ONSIGN',
	ALLOWEDCONST_DATETIME.'<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_SIGNUP', 
    ALLOWEDCONST_DATETIME.'<br>$Affiliate_password<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_FORGOTPAS1', 
    ALLOWEDCONST_DATETIME.'<br>$Affiliate_verification_code<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_FORGOTPAS2', 
	ALLOWEDCONST_DATETIME.'<br>$Affiliate_password<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_NTF_SIGNUP', ALLOWEDCONST_DATETIME.'<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_NTF_SALE', ALLOWEDCONST_DATETIME.'<br>$Sale_id<br>$Sale_commission<br>$Sale_totalcost<br>$Sale_orderid<br>$Sale_productid<br>$Sale_date<br>$Sale_affiliate<br>$Sale_status<br>$Sale_ip<br>$Sale_referrer<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_NOTIFY_RC', ALLOWEDCONST_DATETIME.'<br>$Rc_id<br>$Rc_commission<br>$Rc_orderid<br>$Rc_affiliate<br>$Rc_status<br>$Rc_recurringcommissionid<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_DAILY_REP', ALLOWEDCONST_DATETIME.'<br>$Impressions<br>$Clicks<br>'.
                                        '$Sales_approved<br>$Sales_approved_multitier<br>$Sales_waitingapproval<br>'.
                                        '$Sales_waitingapproval_multitier<br>$Sales_declined<br>$Sales_declined_multitier<br>'.
                                        '$Leads_approved<br>$Leads_approved_multitier<br>$Leads_waitingapproval<br>'.
                                        '$Leads_waitingapproval_multitier<br>$Leads_declined<br>$Leads_declined_multitier<br>'.
                                        '$Commissions_approved<br>$Commissions_approved_multitier<br>$Commissions_waitingapproval<br>'.
                                        '$Commissions_waitingapproval_multitier<br>$Commissions_declined<br>$Commissions_declined_multitier<br>'.
                                        '$Sales_list<br>$Leads_list');

define('ALLOWEDCONST_AFF_EMAIL_MONTH_REP', ALLOWEDCONST_DATETIME.'<br>$Year<br>$Time<br>$Impressions<br>$Clicks<br>'.
                                        '$Sales_approved<br>$Sales_approved_multitier<br>$Sales_waitingapproval<br>'.
                                        '$Sales_waitingapproval_multitier<br>$Sales_declined<br>$Sales_declined_multitier<br>'.
                                        '$Leads_approved<br>$Leads_approved_multitier<br>$Leads_waitingapproval<br>'.
                                        '$Leads_waitingapproval_multitier<br>$Leads_declined<br>$Leads_declined_multitier<br>'.
                                        '$Commissions_approved<br>$Commissions_approved_multitier<br>$Commissions_waitingapproval<br>'.
                                        '$Commissions_waitingapproval_multitier<br>$Commissions_declined<br>$Commissions_declined_multitier<br>'.
                                        '$Sales_list<br>$Leads_list');

define('ALLOWEDCONST_AFF_EMAIL_WE_REP', ALLOWEDCONST_DATETIME.'<br>$Week_start<br>$Week_end<br>$Impressions<br>$Clicks<br>$Sales_approved<br>$Sales_approved_multitier<br>$Sales_waitingapproval<br>$Sales_waitingapproval_multitier<br>$Sales_declined<br>$Sales_declined_multitier<br>$Leads_approved<br>$Leads_approved_multitier<br>$Leads_waitingapproval<br>$Leads_waitingapproval_multitier<br>$Leads_declined<br>$Leads_declined_multitier<br>$Commissions_approved<br>$Commissions_approved_multitier<br>$Commissions_waitingapproval<br>$Commissions_waitingapproval_multitier<br>$Commissions_declined<br>$Commissions_declined_multitier<br>$Sales_list<br>$Leads_list');

define('ALLOWEDCONST_AFF_EMAIL_AF_NTF_SGN', ALLOWEDCONST_DATETIME.'<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_AF_NTF_SLE', ALLOWEDCONST_DATETIME.'<br>$Sale_id<br>$Sale_commission<br>$Sale_totalcost<br>$Sale_orderid<br>$Sale_productid<br>$Sale_date<br>$Sale_affiliate<br>$Sale_status<br>$Sale_ip<br>$Sale_referrer<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_AF_PAR_SLE', ALLOWEDCONST_DATETIME.'<br>$Sale_id<br>$Sale_commission<br>$Sale_totalcost<br>$Sale_orderid<br>$Sale_productid<br>$Sale_date<br>$Sale_affiliate<br>$Sale_status<br>$Sale_ip<br>$Sale_referrer<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_AF_ML_REP', '$Date<br>$Month<br>$Year<br>$Time<br>$Impressions<br>$Clicks<br>'.
                                        '$Sales_approved<br>$Sales_approved_multitier<br>$Sales_waitingapproval<br>'.
                                        '$Sales_waitingapproval_multitier<br>$Sales_declined<br>$Sales_declined_multitier<br>'.
                                        '$Leads_approved<br>$Leads_approved_multitier<br>$Leads_waitingapproval<br>'.
                                        '$Leads_waitingapproval_multitier<br>$Leads_declined<br>$Leads_declined_multitier<br>'.
                                        '$Commissions_approved<br>$Commissions_approved_multitier<br>$Commissions_waitingapproval<br>'.
                                        '$Commissions_waitingapproval_multitier<br>$Commissions_declined<br>$Commissions_declined_multitier<br>'.
                                        '$Sales_list<br>$Leads_list<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_AF_DL_REP', '$Date<br>$Time<br>$Impressions<br>$Clicks<br>'.
                                        '$Sales_approved<br>$Sales_approved_multitier<br>$Sales_waitingapproval<br>'.
                                        '$Sales_waitingapproval_multitier<br>$Sales_declined<br>$Sales_declined_multitier<br>'.
                                        '$Leads_approved<br>$Leads_approved_multitier<br>$Leads_waitingapproval<br>'.
                                        '$Leads_waitingapproval_multitier<br>$Leads_declined<br>$Leads_declined_multitier<br>'.
                                        '$Commissions_approved<br>$Commissions_approved_multitier<br>$Commissions_waitingapproval<br>'.
                                        '$Commissions_waitingapproval_multitier<br>$Commissions_declined<br>$Commissions_declined_multitier<br>'.
                                        '$Sales_list<br>$Leads_list<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_AF_WE_REP', ALLOWEDCONST_DATETIME.'<br>$Week_start<br>$Week_end<br>$Impressions<br>$Clicks<br>$Sales_approved<br>$Sales_approved_multitier<br>$Sales_waitingapproval<br>$Sales_waitingapproval_multitier<br>$Sales_declined<br>$Sales_declined_multitier<br>$Leads_approved<br>$Leads_approved_multitier<br>$Leads_waitingapproval<br>$Leads_waitingapproval_multitier<br>$Leads_declined<br>$Leads_declined_multitier<br>$Commissions_approved<br>$Commissions_approved_multitier<br>$Commissions_waitingapproval<br>$Commissions_waitingapproval_multitier<br>$Commissions_declined<br>$Commissions_declined_multitier<br>$Sales_list<br>$Leads_list<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_CONTACT_US', ALLOWEDCONST_DATETIME.'<br>$Affiliate_emailsubject<br>$Affiliate_emailtext<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_AFF_CAMP_A', ALLOWEDCONST_DATETIME.'<br>$camp_name<br>'.ALLOWEDCONST_AFFILIATE.'<br>'.ALLOWEDCONST_PARENT);

define('ALLOWEDCONST_AFF_EMAIL_AFF_NL_SGN', ALLOWEDCONST_DATETIME.'<br>'.ALLOWEDCONST_AFFILIATE);
?>
