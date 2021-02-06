INSERT INTO `wd_g_accounts` VALUES ('default1', 'Default account', 'Do not delete', '2005-02-22 07:14:08', 0);

INSERT INTO wd_g_emailtemplates VALUES("491603db", "AFF_EMAIL_FORGOTPAS1", "Forgot password - step1", "Hello,\r\n\r\nplease use the verification code below in the step 2:\r\n$Affiliate_verification_code\r\n\r\n\r\n", "0", "english");
INSERT INTO wd_g_emailtemplates VALUES("a8a1013a", "AFF_EMAIL_FORGOTPAS2", "Forgot password", "Hello,\r\n\r\nyour password was set to: $Affiliate_password\r\nYour username is: $Affiliate_username", "0", "english");
INSERT INTO wd_g_emailtemplates VALUES("a8a1243a", "AFF_EMAIL_MONTH_REP", "Merchant Monthly Report", "Monthly report for $Month\r\n\r\nImpressions:  $Impressions\r\n\r\nClicks:  $Clicks\r\n\r\nSales\r\n-----------------------------------\r\nApproved:  $Sales_approved\r\n2nd tier approved: $Sales_approved_2ndtier\r\n\r\nWaiting for approval: $Sales_waitingapproval\r\n2nd tier waiting for approval: $Sales_waitingapproval_2ndtier\r\n\r\nDeclined:  $Sales_declined\r\n2nd tier declined:  $Sales_declined_2ndtier\r\n\r\n\r\nCommissions\r\n-----------------------------------\r\nApproved:  $Commissions_approved\r\n2nd tier approved: $Commissions_approved_2ndtier\r\n\r\nWaiting for approval: $Commissions_waitingapproval\r\n2nd tier waiting for approval: $Commissions_waitingapproval_2ndtier\r\n-----------------------------------\r\n\r\nDeclined:  $Commissions_declined\r\n2nd tier declined:  $Commissions_declined_2ndtier\r\n\r\nTransactions\r\n-----------------------------------\r\nSales list:\r\n$Sales_list\r\n\r\nLeads list:\r\n$Leads_list\r\n", "0", "English");INSERT INTO wd_g_emailtemplates VALUES("1916de1b", "AFF_EMAIL_CONTACT_US", "Message from affiliate", "$Date $Time\r\n\r\nAffiliate: $Affiliate_id - $Affiliate_name\r\n\r\nSubject: $Affiliate_emailsubject\r\n\r\nText:\r\n$Affiliate_emailtext", "0", "english");
INSERT INTO wd_g_emailtemplates VALUES("h8t7843a", "AFF_EMAIL_AF_ML_REP", "Monthly report", "Monthly report for $Month\r\n\r\nImpressions:  $Impressions\r\n\r\nClicks:  $Clicks\r\n\r\nSales\r\n-----------------------------------\r\nApproved:  $Sales_approved\r\n2nd tier approved: $Sales_approved_2ndtier\r\n\r\nWaiting for approval: $Sales_waitingapproval\r\n2nd tier waiting for approval: $Sales_waitingapproval_2ndtier\r\n\r\nDeclined:  $Sales_declined\r\n2nd tier declined:  $Sales_declined_2ndtier\r\n\r\n\r\nCommissions\r\n-----------------------------------\r\nApproved:  $Commissions_approved\r\n2nd tier approved: $Commissions_approved_2ndtier\r\n\r\nWaiting for approval: $Commissions_waitingapproval\r\n2nd tier waiting for approval: $Commissions_waitingapproval_2ndtier\r\n-----------------------------------\r\n\r\nDeclined:  $Commissions_declined\r\n2nd tier declined:  $Commissions_declined_2ndtier\r\n\r\nTransactions\r\n-----------------------------------\r\nSales list:\r\n$Sales_list\r\n\r\nLeads list:\r\n$Leads_list\r\n", "0", "English");


INSERT INTO `wd_g_settings` VALUES ('60316fdc', 3, 'Aff_support_click_commissions', '1', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316fd3', 3, 'Aff_support_sale_commissions', '1', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316001', 3, 'Aff_fixed_cost', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316002', 3, 'Aff_join_campaign', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316003', 3, 'Aff_display_news', '1', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316004', 3, 'Aff_display_resources', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316005', 3, 'Aff_display_banner_stats_all', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316006', 3, 'Aff_use_forced_matrix', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316007', 3, 'Aff_round_numbers', '2', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316008', 3, 'Aff_currency_left_position', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316009', 3, 'Aff_program_signup_bonus', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316010', 3, 'Aff_program_referral_commission', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316011', 3, 'Aff_overwrite_cookie', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316012', 3, 'Aff_delete_cookie', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316013', 3, 'Aff_referred_affiliate_allow', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316014', 3, 'Aff_permanent_redirect', '0', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316015', 3, 'Aff_mail_send_type', '1', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316016', 3, 'Aff_log_level', '15', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('afdcffa5', 3, 'Aff_system_currency', '$', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('afdcffa6', 3, 'Aff_show_minihelp', '1', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316029', 3, 'Aff_signup_username', '1', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316030', 3, 'Aff_signup_username_mandatory', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316031', 3, 'Aff_signup_name', '1', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316032', 3, 'Aff_signup_name_mandatory', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316033', 3, 'Aff_signup_surname', '1', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316034', 3, 'Aff_signup_surname_mandatory', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316035', 3, 'Aff_signup_country', '1', 'default1', NULL, NULL, NULL);
INSERT INTO `wd_g_settings` VALUES ('60316036', 3, 'Aff_signup_country_mandatory', 'true', 'default1', NULL, NULL, NULL);

INSERT INTO wd_g_righttypes VALUES("02", NULL, "", "campaigns", "aff_camp_product_categories", "modify", "0000-00-00 00:00:00", "L_G_RT_CAMPAIGNS", "L_G_CAMPAIGNS", "L_G_RT_MODIFY", "2");
INSERT INTO wd_g_righttypes VALUES("01", "02", "", "campaigns", "aff_camp_product_categories", "view", "0000-00-00 00:00:00", "L_G_RT_CAMPAIGNS", "L_G_CAMPAIGNS", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("03", "04", "", "affiliates", "aff_aff_affiliates", "view", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_AFFILIATES", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("05", "06", "", "affiliates", "aff_aff_pay_affiliates", "view", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_PAYOUT", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("07", "08", "", "affiliates", "aff_aff_accounting", "view", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_ACCOUNTING", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("09", "10", "", "transactions", "aff_trans_transactions", "view", "0000-00-00 00:00:00", "L_G_TRANSACTIONS", "L_G_TRANSACTIONS", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("12", NULL, "", "reports", "aff_rep_quick_report", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_QUICK", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("13", NULL, "", "reports", "aff_rep_transactions", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_TRANSACTIONS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("14", NULL, "", "reports", "aff_rep_traffic_and_sales", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_TRAFFIC", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("15", NULL, "", "reports", "aff_rep_top_20_affiliates", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_TOP20AFFILIATES", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("39", NULL, "", "reports", "aff_rep_top_campaigns", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_TOPCAMPAIGNS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("16", NULL, "", "reports", "aff_rep_number_of_affiliates", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_AFFILIATECOUNTS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("38", NULL, "", "reports", "aff_rep_top_urls", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_TOPREFERRINGURLS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("17", "18", "", "communication", "aff_comm_email_templates", "view", "0000-00-00 00:00:00", "L_G_COMMUNICATION", "L_G_EMAILTEMPLATES", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("19", NULL, "", "communication", "aff_comm_broadcast_email", "use", "0000-00-00 00:00:00", "L_G_COMMUNICATION", "L_G_BROADCAST_MESSAGE", "L_G_RT_USE", "0");
INSERT INTO wd_g_righttypes VALUES("20", "21", "", "tools", "aff_tool_admins", "view", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_ADMINS", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("22", "23", "", "tools", "aff_tool_user_profiles", "view", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_USER_PROFILES_MANAGER", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("24", "25", "", "tools", "aff_tool_settings", "view", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_SETTINGS", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("26", NULL, "", "tools", "aff_tool_integration", "view", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_INTEGRATIONCODE", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("27", "28", "", "tools", "aff_tool_history", "view", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_HISTORY", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("29", NULL, "", "tools", "aff_tool_db_maintenance", "backup", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_MAINTENANCE", "L_G_RT_BACKUP", "1");
INSERT INTO wd_g_righttypes VALUES("04", NULL, "", "affiliates", "aff_aff_affiliates", "modify", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_AFFILIATES", "L_G_RT_MODIFY", "2");
INSERT INTO wd_g_righttypes VALUES("06", NULL, "", "affiliates", "aff_aff_pay_affiliates", "modify", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_PAYOUT", "L_G_RT_MODIFY", "2");
INSERT INTO wd_g_righttypes VALUES("08", NULL, "", "affiliates", "aff_aff_accounting", "modify", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_ACCOUNTING", "L_G_RT_MODIFY", "2");
INSERT INTO wd_g_righttypes VALUES("10", "11", "", "transactions", "aff_trans_transactions", "approvedecline", "0000-00-00 00:00:00", "L_G_TRANSACTIONS", "L_G_TRANSACTIONS", "L_G_RT_APPROVE_DECLINE", "2");
INSERT INTO wd_g_righttypes VALUES("11", NULL, "", "transactions", "aff_trans_transactions", "modify", "0000-00-00 00:00:00", "L_G_TRANSACTIONS", "L_G_TRANSACTIONS", "L_G_RT_MODIFY", "3");
INSERT INTO wd_g_righttypes VALUES("18", NULL, "", "communication", "aff_comm_email_templates", "modify", "0000-00-00 00:00:00", "L_G_COMMUNICATION", "L_G_EMAILTEMPLATES", "L_G_RT_MODIFY", "2");
INSERT INTO wd_g_righttypes VALUES("21", NULL, "", "tools", "aff_tool_admins", "modify", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_ADMINS", "L_G_RT_MODIFY", "2");
INSERT INTO wd_g_righttypes VALUES("23", NULL, "", "tools", "aff_tool_user_profiles", "modify", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_USER_PROFILES_MANAGER", "L_G_RT_MODIFY", "2");
INSERT INTO wd_g_righttypes VALUES("25", NULL, "", "tools", "aff_tool_settings", "modify", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_SETTINGS", "L_G_RT_MODIFY", "2");
INSERT INTO wd_g_righttypes VALUES("28", NULL, "", "tools", "aff_tool_history", "purge", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_HISTORY", "L_G_RT_PURGE", "2");
INSERT INTO wd_g_righttypes VALUES("30", NULL, "", "tools", "aff_tool_db_maintenance", "restore", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_MAINTENANCE", "L_G_RT_RESTORE", "2");
INSERT INTO wd_g_righttypes VALUES("31", "32", "", "transactions", "aff_trans_recurr_transactions", "view", "0000-00-00 00:00:00", "L_G_TRANSACTIONS", "L_G_RECURRINGCOMMS", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("32", "33", "", "transactions", "aff_trans_recurr_transactions", "approvedecline", "0000-00-00 00:00:00", "L_G_TRANSACTIONS", "L_G_RECURRINGCOMMS", "L_G_RT_APPROVE_DECLINE", "2");
INSERT INTO wd_g_righttypes VALUES("33", NULL, "", "transactions", "aff_trans_recurr_transactions", "modify", "0000-00-00 00:00:00", "L_G_TRANSACTIONS", "L_G_RECURRINGCOMMS", "L_G_RT_MODIFY", "3");
INSERT INTO wd_g_righttypes VALUES("35", NULL, "", "campaigns", "aff_camp_banner_links", "modify", "0000-00-00 00:00:00", "L_G_RT_CAMPAIGNS", "L_G_BANNERS", "L_G_RT_MODIFY", "2");
INSERT INTO wd_g_righttypes VALUES("34", "35", "", "campaigns", "aff_camp_banner_links", "view", "0000-00-00 00:00:00", "L_G_RT_CAMPAIGNS", "L_G_BANNERS", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("36", "37", "", "communication", "aff_comm_communications", "view", "0000-00-00 00:00:00", "L_G_COMMUNICATION", "L_G_COMMUNICATION", "L_G_RT_VIEW", "1");
INSERT INTO wd_g_righttypes VALUES("37", NULL, "", "communication", "aff_comm_communications", "modify", "0000-00-00 00:00:00", "L_G_COMMUNICATION", "L_G_COMMUNICATION", "L_G_RT_MODIFY", "2");


INSERT INTO `wd_g_userprofiles` VALUES ('userpro1', 'Default admin profile', '3', 'default1');

INSERT INTO wd_g_userrights VALUES("303322f3", "userpro1", "01");
INSERT INTO wd_g_userrights VALUES("98edf3f2", "userpro1", "02");
INSERT INTO wd_g_userrights VALUES("6d0469b2", "userpro1", "03");
INSERT INTO wd_g_userrights VALUES("8a264905", "userpro1", "04");
INSERT INTO wd_g_userrights VALUES("3591ac15", "userpro1", "05");
INSERT INTO wd_g_userrights VALUES("fe7c978a", "userpro1", "06");
INSERT INTO wd_g_userrights VALUES("9eaa424f", "userpro1", "07");
INSERT INTO wd_g_userrights VALUES("de631656", "userpro1", "08");
INSERT INTO wd_g_userrights VALUES("62670421", "userpro1", "09");
INSERT INTO wd_g_userrights VALUES("8a721021", "userpro1", "10");
INSERT INTO wd_g_userrights VALUES("6bfdc423", "userpro1", "11");
INSERT INTO wd_g_userrights VALUES("55bae64f", "userpro1", "12");
INSERT INTO wd_g_userrights VALUES("0acf1810", "userpro1", "13");
INSERT INTO wd_g_userrights VALUES("7a209eb2", "userpro1", "14");
INSERT INTO wd_g_userrights VALUES("75d8c0f7", "userpro1", "15");
INSERT INTO wd_g_userrights VALUES("c2c671fe", "userpro1", "16");
INSERT INTO wd_g_userrights VALUES("0f2295a4", "userpro1", "17");
INSERT INTO wd_g_userrights VALUES("f5f6a7f6", "userpro1", "18");
INSERT INTO wd_g_userrights VALUES("e4025111", "userpro1", "19");
INSERT INTO wd_g_userrights VALUES("d6f68d7a", "userpro1", "20");
INSERT INTO wd_g_userrights VALUES("c677b9d0", "userpro1", "21");
INSERT INTO wd_g_userrights VALUES("39d51858", "userpro1", "22");
INSERT INTO wd_g_userrights VALUES("df484242", "userpro1", "23");
INSERT INTO wd_g_userrights VALUES("18f2a81a", "userpro1", "24");
INSERT INTO wd_g_userrights VALUES("c702dc78", "userpro1", "25");
INSERT INTO wd_g_userrights VALUES("46cb70c0", "userpro1", "26");
INSERT INTO wd_g_userrights VALUES("fd95d2e5", "userpro1", "27");
INSERT INTO wd_g_userrights VALUES("44d46fef", "userpro1", "28");
INSERT INTO wd_g_userrights VALUES("0723cf68", "userpro1", "29");
INSERT INTO wd_g_userrights VALUES("0e8581e8", "userpro1", "30");
INSERT INTO wd_g_userrights VALUES("a0c939d5", "userpro1", "31");
INSERT INTO wd_g_userrights VALUES("c5bcad90", "userpro1", "32");
INSERT INTO wd_g_userrights VALUES("715114df", "userpro1", "33");
INSERT INTO wd_g_userrights VALUES("e5597917", "userpro1", "34");
INSERT INTO wd_g_userrights VALUES("79cc1788", "userpro1", "35");
INSERT INTO wd_g_userrights VALUES("eede7703", "userpro1", "36");
INSERT INTO wd_g_userrights VALUES("cdc30ab1", "userpro1", "37");
INSERT INTO wd_g_userrights VALUES("cdc59g1u", "userpro1", "38");
INSERT INTO wd_g_userrights VALUES("c285fdsg", "userpro1", "39");

INSERT INTO wd_pa_payoutoptions VALUES("paypal01", "default1", "PayPal", "0", "PPEMAIL\\t$Affiliate_amount\\tUSD\\t$Affiliate_name\\r\\n", "0", "L_G_METHODPAYPAL", "2", "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=_blank>\r\n<input type=\"hidden\" name=\"currency_code\" value=\"USD\">\r\n<input type=\"hidden\" name=\"no_note\" value=\"1\">\r\n<input type=\"hidden\" name=\"amount\" value=\"$Affiliate_amount\">\r\n<input type=\"hidden\" name=\"item_number\" value=\"Affiliate_Payment_$Date\">\r\n<input type=\"hidden\" name=\"item_name\" value=\"Affiliate Program Payment\">\r\n<input type=\"hidden\" name=\"business\" value=\"$Affiliate_username\">\r\n<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\r\n<input type=\"submit\" name=\"submit\" value=\"Pay by PayPal\">\r\n</form>\r\n");
INSERT INTO wd_pa_payoutoptions VALUES ('moneyboo','default1','MoneyBookers',0,'',0,'L_G_PAYOUTMB', 3, '');
INSERT INTO wd_pa_payoutoptions VALUES ('check001','default1','Check',0,'',0,'L_G_PAYOUTCHECK', 1, '');
INSERT INTO wd_pa_payoutoptions VALUES ('wiretran','default1','Bank/Wire transfer',0,'',0,'L_G_PAYOUTWIRE', 4, '');


INSERT INTO wd_pa_payoutfields VALUES ('paypal01','paypal01','PPEMAIL','PayPal Email','L_G_METHODFIELDPAYPALEMAIL',1,0,1,'',1,'');
INSERT INTO wd_pa_payoutfields VALUES ('moneybo1','moneyboo','MBEMAIL','MoneyBookers email','L_G_PAYOUTFIELDMBEMAIL',1,0,1,'',1,'');
INSERT INTO wd_pa_payoutfields VALUES ('check001','check001','CHPAYABLETO','Payable to','L_G_PAYOUTFIELDPAYABLETO',1,0,1,'',1,'');
INSERT INTO wd_pa_payoutfields VALUES ('wiretra1','wiretran','BANKACCNAME','Bank account name','L_G_PAYOUTFIELDBANKACCNAME',1,0,1,'',1,'');
INSERT INTO wd_pa_payoutfields VALUES ('wiretra2','wiretran','BANKNAME','Bank name','L_G_PAYOUTFIELDBANKNAME',1,0,1,'',2,'');
INSERT INTO wd_pa_payoutfields VALUES ('wiretra3','wiretran','BANKACCNUMBER','Account number','L_G_PAYOUTFIELDACCNUMBER',1,0,1,'',3,'');
INSERT INTO wd_pa_payoutfields VALUES ('wiretra4','wiretran','BANKCODE','Bank code','L_G_PAYOUTFIELDBANKCODE',1,0,1,'',4,'');
INSERT INTO wd_pa_payoutfields VALUES ('wiretra5','wiretran','BANKADDRESS','Bank address','L_G_PAYOUTFIELDBANKADDRESS',1,0,1,'',5,'');
INSERT INTO wd_pa_payoutfields VALUES ('wiretra6','wiretran','BANKSWIFT','S.W.I.F.T code','L_G_PAYOUTFIELDSWIFT',1,0,1,'',6,'');


INSERT INTO `wd_g_settings` VALUES ('76ba76f1', 3, 'Aff_scripts_url', 'http://127.0.0.1/webra/dev/version_2/www2/PostAffiliate/Scripts', 'default1', NULL, NULL, NULL);

insert into wd_g_users(userid, username, rpassword, dateinserted, weburl,
name, surname,
tax_ssn, company_name,
street, city, state, country, zipcode, phone, fax, accountid, rtype, userprofileid)
select 'merch001', username, password, dateinserted, weburl,
LEFT(contactname, LOCATE(' ', contactname)), SUBSTRING(contactname, LOCATE(' ', contactname)+1),
tax_ssn, company_name,
street, city, state, country, zipcode, phone, fax, 'default1', 3, 'userpro1'
from pa_merchants where merchantid=1;

insert into wd_g_users(userid, refid, username, rpassword, 
name, surname, 
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn,
dateinserted, dateapproved, parentuserid, 
accountid, rtype, payoptid, rstatus, deleted)
select affiliateid, affiliateid, username, password, 
LEFT(contactname, LOCATE(' ', contactname)), SUBSTRING(contactname, LOCATE(' ', contactname)+1),
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn, 
dateinserted, dateapproved, parentaffiliateid, 
'default1', 4, '', status, deleted
from pa_affiliates
where payout_type Is Null or payout_type='';

insert into wd_g_users(userid, refid, username, rpassword, 
name, surname, 
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn,
dateinserted, dateapproved, parentuserid, 
accountid, rtype, payoptid, rstatus, deleted)
select affiliateid, affiliateid, username, password, 
LEFT(contactname, LOCATE(' ', contactname)), SUBSTRING(contactname, LOCATE(' ', contactname)+1),
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn, 
dateinserted, dateapproved, parentaffiliateid, 
'default1', 4, 'wiretran', status, deleted
from pa_affiliates
where payout_type=1;

insert into wd_g_users(userid, refid, username, rpassword, 
name, surname, 
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn,
dateinserted, dateapproved, parentuserid, 
accountid, rtype, payoptid, rstatus, deleted)
select affiliateid, affiliateid, username, password, 
LEFT(contactname, LOCATE(' ', contactname)), SUBSTRING(contactname, LOCATE(' ', contactname)+1),
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn, 
dateinserted, dateapproved, parentaffiliateid, 
'default1', 4, 'paypal01', status, deleted
from pa_affiliates
where payout_type=2;


insert into wd_g_users(userid, refid, username, rpassword, 
name, surname, 
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn,
dateinserted, dateapproved, parentuserid, 
accountid, rtype, payoptid, rstatus, deleted)
select affiliateid, affiliateid, username, password, 
LEFT(contactname, LOCATE(' ', contactname)), SUBSTRING(contactname, LOCATE(' ', contactname)+1),
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn, 
dateinserted, dateapproved, parentaffiliateid, 
'default1', 4, 'moneyboo', status, deleted
from pa_affiliates
where payout_type=3;


insert into wd_g_users(userid, refid, username, rpassword, 
name, surname, 
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn,
dateinserted, dateapproved, parentuserid, 
accountid, rtype, payoptid, rstatus, deleted)
select affiliateid, affiliateid, username, password, 
LEFT(contactname, LOCATE(' ', contactname)), SUBSTRING(contactname, LOCATE(' ', contactname)+1),
company_name, weburl, street, city, state, country, zipcode, phone, fax, tax_ssn, 
dateinserted, dateapproved, parentaffiliateid, 
'default1', 4, 'check001', status, deleted
from pa_affiliates
where payout_type=4;


insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_payoptionfield_wiretra1', bank_accountname, 'default1', affiliateid, 'wiretra1' 
from pa_affiliates where payout_type=1;

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_payoptionfield_wiretra2', bank_name, 'default1', affiliateid, 'wiretra2' 
from pa_affiliates where payout_type=1;

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_payoptionfield_wiretra3', bank_account, 'default1', affiliateid, 'wiretra3' 
from pa_affiliates where payout_type=1;

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_payoptionfield_wiretra4', bank_code, 'default1', affiliateid, 'wiretra4' 
from pa_affiliates where payout_type=1;

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_payoptionfield_wiretra5', bank_address, 'default1', affiliateid, 'wiretra5' 
from pa_affiliates where payout_type=1;

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_payoptionfield_wiretra6', bank_swift, 'default1', affiliateid, 'wiretra6' 
from pa_affiliates where payout_type=1;


insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_payoptionfield_paypal01', paypal_email, 'default1', affiliateid, 'paypal01' 
from pa_affiliates where payout_type=2;


insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_payoptionfield_moneybo1', mb_email, 'default1', affiliateid, 'moneybo1' 
from pa_affiliates where payout_type=3;


insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_payoptionfield_check001', payableto, 'default1', affiliateid, 'check001' 
from pa_affiliates where payout_type=4;

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, 'Aff_min_payout', min_payout, 'default1', affiliateid
from pa_affiliates;



insert into wd_pa_campaigns(campaignid, accountid, name, description, dateinserted, deleted, disabled, commtype, products)
select campaignid, 'default1', name, description, dateinserted, deleted, disabled, 1, products from pa_campaigns
where commtype=1;

insert into wd_pa_campaigns(campaignid, accountid, name, description, dateinserted, deleted, disabled, commtype, products)
select campaignid, 'default1', name, description, dateinserted, deleted, disabled, 4, products from pa_campaigns
where commtype=3;

insert into wd_pa_campaigns(campaignid, accountid, name, description, dateinserted, deleted, disabled, commtype, products)
select campaignid, 'default1', name, description, dateinserted, deleted, disabled, 5, products from pa_campaigns
where commtype=4;

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
6, 'Aff_camp_cookielifetime', cookielifetime, 'default1', 'merch001', campaignid 
from pa_campaigns;

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
6, 'Aff_camp_clickapproval', clickapproval, 'default1', 'merch001', campaignid 
from pa_campaigns;

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid, id1)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
6, 'Aff_camp_saleapproval', saleapproval, 'default1', 'merch001', campaignid 
from pa_campaigns;


insert into wd_pa_campaigncategories(
  campcategoryid          , name                    , deleted                 , clickcommission         
, salecommission          , recurringcommission     , recurringcommtype       , recurringcommdate       
, recurringdatetype       , campaignid              , salecommtype            , stsalecommtype          
, st2clickcommission      , st2salecommission       , st3clickcommission      , st3salecommission       
, st4clickcommission      , st4salecommission       , st5clickcommission      , st5salecommission       
, st6clickcommission      , st6salecommission       , st7clickcommission      , st7salecommission       
, st8clickcommission      , st8salecommission       , st9clickcommission      , st9salecommission       
, st10clickcommission     , st10salecommission      , strecurringcommtype     , st2recurringcommission  
, st3recurringcommission  , st4recurringcommission  , st5recurringcommission  , st6recurringcommission  
, st7recurringcommission  , st8recurringcommission  , st9recurringcommission  , st10recurringcommission 

)
 select 
  campcategoryid          , name                    , deleted                 , clickcommission         
, salecommission          , recurringcommission     , recurringcommtype       , recurringcommdate       
, recurringdatetype       , campaignid              , salecommtype            , stsalecommtype          
, st2clickcommission      , st2salecommission       , st3clickcommission      , st3salecommission       
, st4clickcommission      , st4salecommission       , st5clickcommission      , st5salecommission       
, st6clickcommission      , st6salecommission       , st7clickcommission      , st7salecommission       
, st8clickcommission      , st8salecommission       , st9clickcommission      , st9salecommission       
, st10clickcommission     , st10salecommission      , strecurringcommtype     , st2recurringcommission  
, st3recurringcommission  , st4recurringcommission  , st5recurringcommission  , st6recurringcommission  
, st7recurringcommission  , st8recurringcommission  , st9recurringcommission  , st10recurringcommission 

from pa_campaigncategories where name<>'Unassigned users';

insert into wd_pa_campaigncategories(
  campcategoryid          , name                    , deleted                 , clickcommission         
, salecommission          , recurringcommission     , recurringcommtype       , recurringcommdate       
, recurringdatetype       , campaignid              , salecommtype            , stsalecommtype          
, st2clickcommission      , st2salecommission       , st3clickcommission      , st3salecommission       
, st4clickcommission      , st4salecommission       , st5clickcommission      , st5salecommission       
, st6clickcommission      , st6salecommission       , st7clickcommission      , st7salecommission       
, st8clickcommission      , st8salecommission       , st9clickcommission      , st9salecommission       
, st10clickcommission     , st10salecommission      , strecurringcommtype     , st2recurringcommission  
, st3recurringcommission  , st4recurringcommission  , st5recurringcommission  , st6recurringcommission  
, st7recurringcommission  , st8recurringcommission  , st9recurringcommission  , st10recurringcommission 

)
 select 
  campcategoryid          , 'L_G_UNASSIGNED_USERS'  , deleted                 , clickcommission         
, salecommission          , recurringcommission     , recurringcommtype       , recurringcommdate       
, recurringdatetype       , campaignid              , salecommtype            , stsalecommtype          
, st2clickcommission      , st2salecommission       , st3clickcommission      , st3salecommission       
, st4clickcommission      , st4salecommission       , st5clickcommission      , st5salecommission       
, st6clickcommission      , st6salecommission       , st7clickcommission      , st7salecommission       
, st8clickcommission      , st8salecommission       , st9clickcommission      , st9salecommission       
, st10clickcommission     , st10salecommission      , strecurringcommtype     , st2recurringcommission  
, st3recurringcommission  , st4recurringcommission  , st5recurringcommission  , st6recurringcommission  
, st7recurringcommission  , st8recurringcommission  , st9recurringcommission  , st10recurringcommission 

from pa_campaigncategories where name='Unassigned users';



insert into wd_pa_banners(bannerid, description, destinationurl, sourceurl, bannertype, deleted, campaignid)
select bannerid, description, destinationurl, sourceurl, bannertype, deleted, campaignid from pa_banners;


insert into wd_g_emailtemplates(emailtempsid, categorycode, emailsubject, emailtext, deleted, lang)
select emailtempsid, categorycode, emailsubject, emailtext, deleted, lang from pa_emailtemplates;


insert into wd_pa_impressions(impressionid, accountid, dateimpression, bannerid, affiliateid, all_imps_count, unique_imps_count, commissiongiven, data1)
select impressionid, 'default1', dateimpression, bannerid, affiliateid, all_imps_count, unique_imps_count, 1, '' from pa_impressions;


insert into wd_pa_transactions(
transid, accountid, rstatus, dateinserted, dateapproved, transtype, payoutstatus, datepayout, 
cookiestatus, orderid, totalcost, bannerid, transkind, refererurl, affiliateid, campcategoryid, 
parenttransid, commission, ip, recurringcommid, accountingid, productid, data1, data2, data3)
select 
transid, 'default1', status, dateinserted, dateapproved, transtype, payoutstatus, datepayout, 
cookiestatus, orderid, totalcost, bannerid, transkind, refererurl, affiliateid, campcategoryid, 
parenttransid, commission, ip, recurringcommid, accountingid, productid, '', '', ''
from pa_transactions where transtype=1;

insert into wd_pa_transactions(
transid, accountid, rstatus, dateinserted, dateapproved, transtype, payoutstatus, datepayout, 
cookiestatus, orderid, totalcost, bannerid, transkind, refererurl, affiliateid, campcategoryid, 
parenttransid, commission, ip, recurringcommid, accountingid, productid, data1, data2, data3)
select 
transid, 'default1', status, dateinserted, dateapproved, 4, payoutstatus, datepayout, 
cookiestatus, orderid, totalcost, bannerid, transkind, refererurl, affiliateid, campcategoryid, 
parenttransid, commission, ip, recurringcommid, accountingid, productid, '', '', ''
from pa_transactions where transtype=3;


insert into wd_pa_affiliatescampaigns(
affcampid, campcategoryid, affiliateid, campaignid, rstatus, declinereason)
select 
ac.affcampid, ac.campcategoryid, ac.affiliateid, cc.campaignid, 2, ''
from pa_affiliatescampaigns ac, pa_campaigncategories cc
where ac.campcategoryid=cc.campcategoryid;


insert into wd_pa_accounting(
accountingid, dateinserted, datefrom, dateto, note, rfile)
select 
accountingid, dateinserted, datefrom, dateto, note, CONCAT_WS("", paypalfile, mbfile, wirefile)
from pa_accounting;


insert into wd_g_history(
historyid, accountid, rtype, value, dateinserted, hfile, line, ip, module)
select 
historyid, 'default1', 8, value, dateinserted, hfile, line, ip, ''
from pa_history
where type=1;

insert into wd_g_history(
historyid, accountid, rtype, value, dateinserted, hfile, line, ip, module)
select 
historyid, 'default1', 2, value, dateinserted, hfile, line, ip, ''
from pa_history
where type=5;


insert into wd_pa_recurringcommissions(
  recurringcommid , commission      , commtype        , commdate        
, datetype        , rstatus          , deleted         , campcategoryid  
, affiliateid     , originaltransid , dateinserted    , stcommtype      
, st2affiliateid  , st2commission   , st3affiliateid  , st3commission   
, st4affiliateid  , st4commission   , st5affiliateid  , st5commission   
, st6affiliateid  , st6commission   , st7affiliateid  , st7commission   
, st8affiliateid  , st8commission   , st9affiliateid  , st9commission   
, st10affiliateid , st10commission 
)
select
  recurringcommid , commission      , commtype        , commdate        
, datetype        , status          , deleted         , campcategoryid  
, affiliateid     , originaltransid , dateinserted    , stcommtype      
, st2affiliateid  , st2commission   , st3affiliateid  , st3commission   
, st4affiliateid  , st4commission   , st5affiliateid  , st5commission   
, st6affiliateid  , st6commission   , st7affiliateid  , st7commission   
, st8affiliateid  , st8commission   , st9affiliateid  , st9commission   
, st10affiliateid , st10commission 
from pa_recurringcommissions;


insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
3, CONCAT('Aff_', code), value, 'default1', NULL
from pa_settings
where code in('declinefrequentclicks', 'declinefrequentsales', 'declinesameorderid', 
'clickfrequency', 'salefrequency', 'scripts_url', 'system_email', 'signup_url', 
'system_currency', 'export_dir', 'export_url', 'show_minihelp', 'login_protection_retries',
'login_protection_delay', 'support_recurring_commissions', 'banners_dir', 'banners_url', 
'default_lang', 'allow_choose_lang', 'min_payout_options', 'initial_min_payout', 'link_style',
'forcecommfromproductid', 'maxcommissionlevels', 'notifications_email', 'affiliateapproval',
'afflogouturl', 'affpostsignupurl', 'p3p_xml', 'p3p_compact', 'track_by_ip', 'ip_validity',
'ip_validity_type', 'track_by_session', 'apply_from_banner', 'recurringrealcommissions');


insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
5, CONCAT('Aff_', code), value, 'default1', affiliateid
from pa_settings
where code in('email_affonaffsignup', 'email_affonsale', 'email_affdailyreport', 
'aff_notificationlang');

insert into wd_g_settings(settingsid, rtype, code, value, accountid, userid)
select SUBSTRING(CONV(RAND()*1000000*1000000, 10, 24), 1, 8), 
3, CONCAT('Aff_', code), value, 'default1', NULL
from pa_settings
where code in('email_onaffsignup', 'email_onsale', 'email_dailyreport', 'email_recurringtrangenerated');

