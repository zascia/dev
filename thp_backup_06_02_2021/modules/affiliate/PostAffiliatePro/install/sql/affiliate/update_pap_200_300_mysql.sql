CREATE TABLE wd_g_categories (
  catid varchar(8) NOT NULL default '',
  parentcatid varchar(8) default NULL,
  name varchar(100) NOT NULL default '',
  rstatus tinyint(4) NOT NULL default '0',
  product varchar(10) NOT NULL default '',
  description text,
  dateinserted datetime NOT NULL default '0000-00-00 00:00:00',
  deleted tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (catid),
  UNIQUE KEY IDX_wd_g_categories2 (catid),
  KEY IDX_wd_g_categories1 (parentcatid)
) TYPE=MyISAM;


CREATE TABLE wd_g_domains (
  domainid varchar(8) NOT NULL default '',
  accountid varchar(8) default NULL,
  userid varchar(8) default NULL,
  rtype tinyint(4) NOT NULL default '0',
  url varchar(255) NOT NULL default '',
  dateinserted datetime NOT NULL default '0000-00-00 00:00:00',
  rstatus tinyint(4) NOT NULL default '0',
  declinereason text,
  PRIMARY KEY  (domainid),
  KEY IDX_wd_g_domains1 (accountid),
  KEY IDX_wd_g_domains2 (userid)
) TYPE=MyISAM;

CREATE TABLE wd_pa_bannercategories (
  bannercategoryid varchar(8) NOT NULL default '',
  name varchar(255) NOT NULL default '',
  PRIMARY KEY  (bannercategoryid)
) TYPE=MyISAM;

INSERT INTO wd_pa_bannercategories VALUES ('79bf2443','Text links');
INSERT INTO wd_pa_bannercategories VALUES ('fe50b29a','Graphic banners');
INSERT INTO wd_pa_bannercategories VALUES ('2ed1e0ca','Articles & Reviews');

CREATE TABLE wd_g_jobs (
    jobid CHAR(8) NOT NULL,
    rtype SMALLINT UNSIGNED,
    rstatus TINYINT UNSIGNED,
    progress BIGINT,
    datecreated DATETIME,
    datefinished DATETIME,
    PRIMARY KEY (jobid)
);


CREATE TABLE wd_pa_integration (
  integrationid varchar(8) NOT NULL default '',
  integrationname varchar(40) default NULL,
  integrationlangconst varchar(40) default NULL,
  textbefore text,
  textafter text,
  deleted tinyint(4) default NULL,
  rorder tinyint(3) unsigned default NULL,
  PRIMARY KEY  (integrationid),
  UNIQUE KEY IDX_wd_pa_integration1 (integrationid)
) TYPE=MyISAM;


CREATE TABLE wd_pa_integrationsteps (
  intstepid varchar(8) NOT NULL default '',
  integrationid varchar(8) NOT NULL default '',
  rorder tinyint(3) unsigned default NULL,
  textbefore text,
  textarea text,
  textafter text,
  lang varchar(10) default NULL,
  PRIMARY KEY  (intstepid),
  KEY IDX_wd_pa_integrationsteps1 (integrationid)
) TYPE=MyISAM;

CREATE TABLE wd_pa_impressions_tmp (
    impressionid CHAR(8) NOT NULL,
    accountid CHAR(8),
    dateimpression DATETIME NOT NULL,
    bannerid CHAR(8),
    rotatorid CHAR(8),
    affiliateid CHAR(8),
    all_imps_count INTEGER DEFAULT 0,
    unique_imps_count INTEGER DEFAULT 0,
    commissiongiven TINYINT NOT NULL DEFAULT 0,
    data1 VARCHAR(80),
    country CHAR(2) DEFAULT '__',
    CONSTRAINT PK_wd_pa_impressions PRIMARY KEY (impressionid)
);

CREATE TABLE wd_pa_transactions_tmp (
    transid CHAR(8) NOT NULL,
    accountid CHAR(8),
    rstatus TINYINT NOT NULL DEFAULT 0,
    dateinserted DATETIME,
    dateapproved DATETIME,
    transtype SMALLINT DEFAULT 0,
    payoutstatus TINYINT DEFAULT 1,
    datepayout DATETIME,
    cookiestatus TINYINT,
    orderid VARCHAR(200),
    totalcost FLOAT,
    bannerid CHAR(8),
    rotatorid CHAR(8),
    transkind TINYINT DEFAULT 0,
    refererurl VARCHAR(250),
    affiliateid CHAR(8),
    campcategoryid CHAR(8),
    parenttransid CHAR(8),
    commission FLOAT DEFAULT 0,
    ip VARCHAR(20),
    countrycode CHAR(2),
    recurringcommid CHAR(8),
    accountingid CHAR(8),
    productid VARCHAR(200),
    data1 VARCHAR(80),
    data2 VARCHAR(80),
    data3 VARCHAR(80),
    browser VARCHAR(6),
    count int(11) DEFAULT 1,
    CONSTRAINT PK_wd_pa_transactions PRIMARY KEY (transid)
);

ALTER TABLE wd_g_emailtemplates ADD accountid varchar(8) default NULL;

UPDATE wd_g_emailtemplates set accountid = 'default1';

INSERT INTO wd_g_emailtemplates VALUES ('5f6e0260','AFF_EMAIL_ONSIGN','Thank you for signing up','Dear $Affiliate_name,\r\n\r\nthank you for signing up to our affiliate program. Your application will be reviewed and you will receive email with access information after approval.\r\n\r\nIf you have any requests regarding the affiliate program, don\'t hesitate to contact me on the email address\r\nname@yoursite.com.\r\n\r\nsincerelly,\r\n\r\nYour Affiliate manager',0,'english','default1');
INSERT INTO wd_g_emailtemplates VALUES ('091ab586','AFF_EMAIL_MONTH_REP','Monthly report $Date-$Month','Impressions: $Impressions\r\nClicks: $Clicks\r\nSales: $Sales_approved\r\nLeads: $Leads_approved\r\nCommissions: $Commissions_approved\r\n\r\n-----------------------------------\r\n$Sales_list\r\n\r\n\r\n-----------------------------------\r\n$Leads_list',0,'english','default1');
INSERT INTO wd_g_emailtemplates VALUES ('70aedbf5','AFF_EMAIL_WE_REP','Weekly Report','Impressions: $Impressions\r\nClicks: $Clicks\r\nSales: $Sales_approved\r\nLeads: $Leads_approved\r\nCommissions: $Commissions_approved\r\n\r\n-----------------------------------\r\n$Sales_list\r\n\r\n\r\n-----------------------------------\r\n$Leads_list',0,'english','default1');
INSERT INTO wd_g_emailtemplates VALUES ('574e3282','AFF_EMAIL_AF_ML_REP','Monthly report','Impressions: $Impressions\r\nClicks: $Clicks\r\nSales: $Sales_approved\r\nLeads: $Leads_approved\r\nCommissions: $Commissions_approved\r\n\r\n-----------------------------------\r\n$Sales_list\r\n\r\n\r\n-----------------------------------\r\n$Leads_list',0,'english','default1');
INSERT INTO wd_g_emailtemplates VALUES ('5b108965','AFF_EMAIL_AFF_WE_REP','Weekly report','Impressions: $Impressions\r\nClicks: $Clicks\r\nSales: $Sales_approved\r\nLeads: $Leads_approved\r\nCommissions: $Commissions_approved\r\n\r\n-----------------------------------\r\n$Sales_list\r\n\r\n\r\n-----------------------------------\r\n$Leads_list',0,'english','default1');

INSERT INTO wd_g_emailtemplates VALUES ('f595c543','AFF_EMAIL_AF_DL_REP','Daily report $Date','Impressions: $Impressions\r\nClicks: $Clicks\r\nSales: $Sales_approved\r\nLeads: $Leads_approved\r\nCommissions: $Commissions_approved\r\n\r\n-----------------------------------\r\n$Sales_list\r\n\r\n\r\n-----------------------------------\r\n$Leads_list',0,'english','default1');
INSERT INTO wd_g_emailtemplates VALUES ('3cd5c8e5','AFF_EMAIL_AF_WE_REP','Weekly Report $Date','Impressions: $Impressions\r\nClicks: $Clicks\r\nSales: $Sales_approved\r\nLeads: $Leads_approved\r\nCommissions: $Commissions_approved\r\n\r\n-----------------------------------\r\n$Sales_list\r\n\r\n\r\n-----------------------------------\r\n$Leads_list',0,'english','default1');
INSERT INTO wd_g_emailtemplates VALUES ('ed25972d','AFF_EMAIL_AFF_CAMP_A','You have been approved','Dear $Affiliate_name,\r\n\r\nyou have been approved for campaign $camp_name.\r\n\r\nBest regards,\r\n\r\nYour affiliate manager',0,'english','default1');



ALTER TABLE wd_g_messages ADD datevalidfrom datetime default NULL;
ALTER TABLE wd_g_messages ADD datevalidto datetime default NULL;
ALTER TABLE wd_g_messages ADD active tinyint(3) unsigned default '0';
ALTER TABLE wd_g_messages ADD showtoall tinyint(3) unsigned default '0';

ALTER TABLE wd_g_userprofiles DROP KEY name;


ALTER TABLE wd_pa_accounting ADD mbfile varchar(100) default NULL;
ALTER TABLE wd_pa_accounting ADD wirefile varchar(100) default NULL;


ALTER TABLE wd_pa_banners ADD name varchar(100) default NULL;
ALTER TABLE wd_pa_banners ADD hidden tinyint(4) default '0';
ALTER TABLE wd_pa_banners ADD size varchar(11) default NULL;
ALTER TABLE wd_pa_banners ADD dateinserted datetime default NULL;
ALTER TABLE wd_pa_banners ADD bannercategory varchar(8) NOT NULL default '';

ALTER TABLE wd_pa_impressions ADD rotatorid varchar(8) default NULL;
ALTER TABLE wd_pa_impressions ADD country char(2) default '__';

ALTER TABLE wd_pa_recurringcommissions CHANGE st2affiliateid st2affiliateid varchar(8) default NULL;
ALTER TABLE wd_pa_recurringcommissions CHANGE st3affiliateid st3affiliateid varchar(8) default NULL;
ALTER TABLE wd_pa_recurringcommissions CHANGE st4affiliateid st4affiliateid varchar(8) default NULL;
ALTER TABLE wd_pa_recurringcommissions CHANGE st5affiliateid st5affiliateid varchar(8) default NULL;
ALTER TABLE wd_pa_recurringcommissions CHANGE st6affiliateid st6affiliateid varchar(8) default NULL;
ALTER TABLE wd_pa_recurringcommissions CHANGE st7affiliateid st7affiliateid varchar(8) default NULL;
ALTER TABLE wd_pa_recurringcommissions CHANGE st8affiliateid st8affiliateid varchar(8) default NULL;
ALTER TABLE wd_pa_recurringcommissions CHANGE st9affiliateid st9affiliateid varchar(8) default NULL;
ALTER TABLE wd_pa_recurringcommissions CHANGE st10affiliateid st10affiliateid varchar(8) default NULL;



ALTER TABLE wd_pa_transactions CHANGE transtype transtype smallint(6) default '0';
ALTER TABLE wd_pa_transactions ADD rotatorid varchar(8) default NULL;
ALTER TABLE wd_pa_transactions ADD countrycode char(2) default NULL;
ALTER TABLE wd_pa_transactions ADD browser varchar(6) default NULL;
ALTER TABLE wd_pa_transactions ADD count int(11) default 1;
UPDATE wd_pa_transactions set count=1;

INSERT INTO wd_g_settings VALUES ('2739f548',3,'Aff_style_c_normallink','#FF0000','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('8fcdde81',3,'Aff_style_c_helplink','#00AA00','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('ce0b9f15',3,'Aff_style_c_textlink','#0056B6','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('a2fb0e68',3,'Aff_style_c_error_border','#FF0000','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('c9ca2889',3,'Aff_style_c_error_header','#FFA9A9','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('908e3967',3,'Aff_style_c_error_message','#FF0000','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('8c7db251',3,'Aff_style_c_ok_border','#00AA00','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('46f2762d',3,'Aff_style_c_ok_header','#BAFCBA','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('dd234c81',3,'Aff_style_c_ok_message','#00AA00','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('5cdd8ff1',3,'Aff_style_c_footer_text','#555555','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('2a630357',3,'Aff_style_c_footer_background','#E8EDFA','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('5505c066',3,'Aff_style_c_form_button','#B3CED9','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('d6fab855',3,'Aff_style_c_frm_button_shadow','#B4B4B6','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('b855227b',3,'Aff_style_c_frm_button_light','#F5F5F5','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('c1507b66',3,'Aff_style_c_border','#5993AB','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('6e6ce0c8',3,'Aff_style_c_border2','#D9E6EC','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('be76e83b',3,'Aff_style_c_actionheader','#FFFFFF','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('557b55cb',3,'Aff_style_c_tableheader','#B3CED9','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('449bf520',3,'Aff_style_c_tableheader2','#D6DFF5','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('1c82ff7c',3,'Aff_style_c_listheader','#D9E6EC','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('ebac34ee',3,'Aff_style_c_listheader_sort','#B3CED9','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('67830a89',3,'Aff_style_c_listresult_row1','#FFFFFF','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('7675f9d7',3,'Aff_style_c_listresult_row2','#E8EDFA','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('a233bc2a',3,'Aff_style_c_datail_row1','#EBEEF5','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('f878eda6',3,'Aff_style_c_datail_row2','#F2F5FC','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('874c1f46',3,'Aff_style_c_background','#E8EDFA','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('9385969d',3,'Aff_style_c_background_logo','#FFFFFF','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('5a55b7fd',3,'Aff_style_c_bacground_active','#B3CED9','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('1da2a4a8',3,'Aff_style_c_menu_link','#0056B6','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('f7869da1',3,'Aff_style_c_menu_link2','#0056B6','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('0c1c8958',3,'Aff_style_c_menu_link_disbled','#666666','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('bc17a4e9',4,'Aff_user_icq','','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('08c6b3c4',4,'Aff_user_msn','','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('37a45385',4,'Aff_user_skype','','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('b719fd51',4,'Aff_user_yahoomessenger','','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('5648e1a3',4,'Aff_user_googletalk','','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('706f8417',4,'Aff_user_other_name','','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('efd4dd7e',4,'Aff_user_other_contact','','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('cbbae032',4,'Aff_user_photo_url','../affiliate-manager.gif','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('7aa3fad5',4,'Aff_user_welcome_msg','Hello and welcome to our affiliate program.\r\n      <br/>\r\n      I\'m your affiliate manager, and I\'m here for you if you have ANY questions or problems related to our affiliate program.\r\n      <br/><br/>\r\n      I wish you all success in promoting our products, and profitable partnership for both you and us.\r\n','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('3aff3269',4,'Aff_user_custom_html','','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('6cc87d6b',4,'Aff_user_selected_info','photo_url,welcome_msg','default1','1',NULL,NULL);
INSERT INTO wd_g_settings VALUES ('8678a468', 3,'Aff_debug_emails','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('e6c1cf39', 3,'Aff_debug_impressions','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('d74f71be', 3,'Aff_debug_clicks','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('b4ca2aef', 3,'Aff_debug_sales','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316039', 3, 'Aff_style_merchant_skin', 'default', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('4v8xc9v9', 3, 'Aff_style_affiliate_skin', 'default', 'default1', NULL, NULL, NULL);

INSERT INTO wd_g_righttypes VALUES("39", NULL, "", "reports", "aff_rep_top_campaigns", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_TOPCAMPAIGNS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("41", NULL, "", "reports", "aff_rep_non_perform_affiliates", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_NONPERFORMAFFILIATES", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("42", NULL, "", "reports", "aff_rep_rotator", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_ROTATORSTATS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("51", NULL, "", "tools", "aff_tool_db_maintenance", "repair", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_MAINTENANCE", "L_G_RT_REPAIROPTIMIZE", "3");
INSERT INTO wd_g_righttypes VALUES("52", NULL, "", "tools", "aff_tool_integration", "modify", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_INTEGRATIONCODE", "L_G_RT_MODIFY", "1");
INSERT INTO wd_g_righttypes VALUES("53", NULL, "", "tools", "aff_tool_signupsettings", "modify", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_AFFSIGNUPSETTINGS", "L_G_RT_MODIFY", "1");
INSERT INTO wd_g_righttypes VALUES("55", NULL, "", "tools", "aff_tool_signupsettings", "view", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_AFFSIGNUPSETTINGS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("56", NULL, "", "tools", "aff_tool_afflayoutsettings", "view", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_LAYOUTSETTINGS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("57", NULL, "", "affiliates", "aff_aff_accountingsettings", "view", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_ACCOUNTINGSETTINGS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("58", NULL, "", "affiliates", "aff_aff_accountingsettings", "modify", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_ACCOUNTINGSETTINGS", "L_G_RT_MODIFY", "0");
INSERT INTO wd_g_righttypes VALUES("59", NULL, "", "affiliates", "aff_aff_appliedaffiliates", "view", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_APPLIEDAFFILIATES", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("60", NULL, "", "affiliates", "aff_aff_appliedaffiliates", "modify", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_APPLIEDAFFILIATES", "L_G_RT_MODIFY", "0");
INSERT INTO wd_g_righttypes VALUES("61", NULL, "", "affiliates", "aff_aff_appliedaffiliates", "approvedecline", "0000-00-00 00:00:00", "L_G_AFFILIATES", "L_G_APPLIEDAFFILIATES", "L_G_RT_APPROVE_DECLINE", "0");
INSERT INTO wd_g_righttypes VALUES("62", NULL, "", "tools", "aff_tool_affpanelsettings", "view", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_PANELSETTINGS", "L_G_RT_VIEW", "0");
INSERT INTO wd_g_righttypes VALUES("63", NULL, "", "tools", "aff_tool_db_maintenance", "archive", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_MAINTENANCE", "L_G_RT_ARCHIVE", "4");
INSERT INTO wd_g_righttypes VALUES("64", NULL, "", "tools", "aff_tool_affpanelsettings", "modify", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_PANELSETTINGS", "L_G_RT_MODIFY", "1");
INSERT INTO wd_g_righttypes VALUES("65", NULL, "", "tools", "aff_tool_afflayoutsettings", "modify", "0000-00-00 00:00:00", "L_G_TOOLS", "L_G_LAYOUTSETTINGS", "L_G_RT_MODIFY", "1");
INSERT INTO wd_g_righttypes VALUES("66", NULL, "", "reports", "aff_rep_impclicks", "view", "0000-00-00 00:00:00", "L_G_REPORTS", "L_G_IMPRESSIONCLICKS", "L_G_RT_VIEW", "1");

INSERT INTO wd_g_userrights VALUES("c285fdsg", "userpro1", "39");
INSERT INTO wd_g_userrights VALUES("g45h4g41", "userpro1", "41");
INSERT INTO wd_g_userrights VALUES("grte4g41", "userpro1", "42");
INSERT INTO wd_g_userrights VALUES("g45h4g51", "userpro1", "51");
INSERT INTO wd_g_userrights VALUES("g45h4g52", "userpro1", "52");
INSERT INTO wd_g_userrights VALUES("g45h4g53", "userpro1", "53");
INSERT INTO wd_g_userrights VALUES("g45h4g55", "userpro1", "55");
INSERT INTO wd_g_userrights VALUES("g45h4g56", "userpro1", "56");
INSERT INTO wd_g_userrights VALUES("g45h4g57", "userpro1", "57");
INSERT INTO wd_g_userrights VALUES("g45h4g58", "userpro1", "58");
INSERT INTO wd_g_userrights VALUES("g45h4g59", "userpro1", "59");
INSERT INTO wd_g_userrights VALUES("g45h4g60", "userpro1", "60");
INSERT INTO wd_g_userrights VALUES("g45h4g61", "userpro1", "61");
INSERT INTO wd_g_userrights VALUES("g45h4g62", "userpro1", "62");
INSERT INTO wd_g_userrights VALUES("g45h4g63", "userpro1", "63");
INSERT INTO wd_g_userrights VALUES("g45h4g64", "userpro1", "64");
INSERT INTO wd_g_userrights VALUES("g45h4g65", "userpro1", "65");
INSERT INTO wd_g_userrights VALUES("g45h4g66", "userpro1", "66");

INSERT INTO wd_g_settings VALUES ('60316345',3,'Aff_signup_refid','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316657',3,'Aff_signup_refid_mandatory','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316029',3,'Aff_signup_username','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316030',3,'Aff_signup_username_mandatory','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316031',3,'Aff_signup_name','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316032',3,'Aff_signup_name_mandatory','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316033',3,'Aff_signup_surname','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316034',3,'Aff_signup_surname_mandatory','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316035',3,'Aff_signup_country','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('60316036',3,'Aff_signup_country_mandatory','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996001',3,'Aff_signup_street','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996002',3,'Aff_signup_street_mandatory','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996003',3,'Aff_signup_city','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996004',3,'Aff_signup_city_mandatory','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996005',3,'Aff_signup_state','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996006',3,'Aff_signup_state_mandatory','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996007',3,'Aff_signup_zipcode','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996008',3,'Aff_signup_zipcode_mandatory','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996009',3,'Aff_signup_weburl','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996010',3,'Aff_signup_weburl_mandatory','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996011',3,'Aff_signup_company_name','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996012',3,'Aff_signup_company_name_mandatory','false','default1',NULL,NULL,NULL);

INSERT INTO wd_g_settings VALUES ('6f76ac90',3,'Aff_signup_terms_conditions','To be an authorized affiliate of www.yoursite.com, you agree to abide by the terms and conditions contained in this agreement.\r\n\r\nEnter Your Terms & Conditions Here','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('1cf7c642',3,'Aff_signup_display_terms','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('1967072e',3,'Aff_signup_force_acceptance','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('87378f58',3,'Aff_signup_affect_editing','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('de243cc7',3,'Aff_signup_phone','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('ea21e59e',3,'Aff_signup_phone_mandatory','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('c5ac8f03',3,'Aff_signup_fax','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('1c43ee8f',3,'Aff_signup_fax_mandatory','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('f8542885',3,'Aff_signup_tax_ssn','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('da426588',3,'Aff_signup_tax_ssn_mandatory','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('aed560ea',3,'Aff_signup_data1','0','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('d5f3a27e',3,'Aff_signup_data1_mandatory','hide','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('0620dca6',3,'Aff_signup_data1_name','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('bea3f852',3,'Aff_signup_data2','0','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('a32a2d49',3,'Aff_signup_data2_mandatory','hide','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('5cbd13b3',3,'Aff_signup_data2_name','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('eca39e30',3,'Aff_signup_data3','0','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('67f77e5c',3,'Aff_signup_data3_mandatory','hide','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('cee8a009',3,'Aff_signup_data3_name','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('3b0529b9',3,'Aff_signup_data4','0','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('caddaeeb',3,'Aff_signup_data4_mandatory','hide','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('f3e2e9f6',3,'Aff_signup_data4_name','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('dfde94a8',3,'Aff_signup_data5','0','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('8c340688',3,'Aff_signup_data5_mandatory','hide','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('b94d0339',3,'Aff_signup_data5_name','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('b30d0924',3,'Aff_signup_refid','0','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('3f711726',3,'Aff_signup_refid_mandatory','hide','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('aa22566b',3,'Aff_signup_description','<b>Welcome To The Post Affilaite Pro Demo Affiliate Program!</b>\r\n\r\n<p>\r\nOur program is free to join, it\'s easy to sign-up and requires no technical knowledge.<br>\r\n</p>\r\n\r\n<p>\r\n<b>How does it work</b><br>\r\nWhen you join our program you will get an access to your own control panel. There you can get banners and text links to promote our site. \r\n<br>\r\nWhen you refer some customer to us, you will receive a percentage of his purchase as a reward.\r\n</p>\r\n\r\n<p>\r\n<b>Real-Time Statistics And Reporting</b><br/>\r\nCheck your statistic, sales, traffic, account balance and see how your banners are performing anytime inyour affiliate panel.\r\n</p>\r\n\r\n<p>\r\n<b>Affiliate Program Details</b><br/>\r\nCommission: <font color=#ff0000><b>pay per sale 10%</b></font>\r\n</p>','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('d8d02be9',3,'Aff_signup_display_description','1','default1',NULL,NULL,NULL);


INSERT INTO wd_g_settings VALUES ('43425301', 3, 'Aff_menu_item_affprofile_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425302', 3, 'Aff_menu_item_subaffsignup_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425303', 3, 'Aff_menu_item_quick_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425304', 3, 'Aff_menu_item_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425305', 3, 'Aff_menu_item_traffic_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425306', 3, 'Aff_menu_item_subaffiliates_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425307', 3, 'Aff_menu_item_subid_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425308', 3, 'Aff_menu_item_afftopurls_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425309', 3, 'Aff_menu_item_contactus_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425310', 3, 'Aff_menu_item_banners_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('43425311', 3, 'Aff_menu_item_settings_show', 'true', 'default1', NULL, NULL, NULL);
INSERT INTO wd_g_settings VALUES ('8584a42a',3,'Aff_menu_item_profile_show','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('fdc43348',3,'Aff_menu_item_trans_show','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('75a76106',3,'Aff_menu_item_subaff_show','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('137a8997',3,'Aff_menu_item_topurls_show','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('91c56715',3,'Aff_menu_item_notif_show','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('cc22b9eb',3,'Aff_menu_item_faq_show','true','default1',NULL,NULL,NULL);

INSERT INTO wd_g_settings VALUES ('067c22e8',3,'Aff_settings_mainpage_show_description','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('8b9c6e9d',3,'Aff_settings_mainpage_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('151af7db',3,'Aff_settings_affprofile_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('daf4aa18',3,'Aff_settings_banners_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('344054da',3,'Aff_settings_banners_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('5c266818',3,'Aff_settings_banners_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('ae177764',3,'Aff_settings_subaffsignup_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('abdf0ba1',3,'Aff_settings_subaffsignup_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('dcce7fe3',3,'Aff_settings_subaffsignup_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('e1ecb26f',3,'Aff_settings_quick_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('fe7515f7',3,'Aff_settings_quick_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('c942a1e7',3,'Aff_settings_quick_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('b1a4b176',3,'Aff_settings_transactions_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('ff582f2d',3,'Aff_settings_transactions_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('0b7b84d4',3,'Aff_settings_transactions_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('a4cb28ef',3,'Aff_settings_traffic_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('7cd71174',3,'Aff_settings_traffic_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('0ec7aefd',3,'Aff_settings_traffic_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('b48c3cf0',3,'Aff_settings_subaffiliates_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('76ead01b',3,'Aff_settings_subaffiliates_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('628ca545',3,'Aff_settings_subaffiliates_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('527051e5',3,'Aff_settings_subid_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('63690dd4',3,'Aff_settings_subid_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('7bde5a09',3,'Aff_settings_subid_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('f3622c39',3,'Aff_settings_afftopurls_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('1000432d',3,'Aff_settings_afftopurls_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('2f1ffb04',3,'Aff_settings_afftopurls_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('abf6cfd9',3,'Aff_settings_settings_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('1de2ae56',3,'Aff_settings_settings_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('4a41a274',3,'Aff_settings_settings_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('f800843e',3,'Aff_settings_contactus_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('141b9c7e',3,'Aff_settings_contactus_show_customdescription','false','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('140e0dad',3,'Aff_settings_contactus_customdescription','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('e7c4ecce',3,'Aff_settings_faq_show_description','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('52872995',3,'Aff_settings_faq_show_customdescription','true','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('c92117b5',3,'Aff_settings_faq_customdescription','<table style=\"padding: 0px\"  border=0 cellspacing=0 cellpadding=2>\r\n    <tr><td align=left>  <a class=contents href=\"#whatineed\">1. How to start promoting your products?</a></td></tr>\r\n    <tr><td align=left>  <a class=contents href=\"#howpaid\">2. How do I know I will be paid for my referral?</a></td></tr>\r\n    <tr><td align=left>  <a class=contents href=\"#payment\">3. How is the payment handled?</a></td></tr>\r\n    <tr><td align=left>  <a class=contents href=\"#setup\">4. How do I set up an account?</a></td></tr>\r\n    <tr><td align=left>  <a class=contents href=\"#afflink\">5. What is the affiliate link?</a></td></tr>\r\n    <tr><td align=left>  <a class=contents href=\"#ppc\">6. Can I promote you through pay-per-click search engines?</a></td></tr>\r\n    <tr><td align=left>  <a class=contents href=\"#training\">7. Do you have any training program for affiliates?</a></td></tr>\r\n    <tr><td align=left>  <a class=contents href=\"#whatnow\">8. What must I do NOW?</a></td></tr>\r\n</table>\r\n</p>\r\n\r\nggggggg\r\n<p>\r\n<a name=\"whatineed\"></a>\r\n<span class=\"top_feat\">1. How to start promoting your products?</span><br/>\r\nYou can see the Getting Started section on the main page after you log-in. \r\n</p>\r\n\r\n<p>\r\n<a name=\"howpaid\"></a>\r\n<span class=\"top_feat\">2. How do I know I will be paid for my referral?</span><br/>\r\nThe program is powered by Post Affiliate Pro, the leading affiliate tracking software.\r\nPost Affiliate Pro uses combination of cookies and IP address to track referrals for best possible reliability. \r\nWhen the visitor follows your affiliate link to our site, our affiliate system registers this referral and places cookie on his or her computer. \r\nWhen the visitor pays for the product, affiliate system checks for cookie (if not found, checks for IP address of referral) and credits \r\nyour account with commission. \r\n<br/>\r\nThis process is absolutely automatic. All your referrals will be properly tracked.\r\n</p>\r\n<p>\r\nPost Affiliate Pro is used by thousands of Internet merchants and affiliates world-wide. \r\n</p>\r\n<p>\r\n<a name=\"payment\"></a>\r\n<span class=\"top_feat\">3. How is the payment handled?</span><br/>\r\nYou can choose if you want to be paid by PayPal or by wire transfer, as well as minimum payout value ($100 minimum). \r\nWe do not support regular checks at the moment.\r\n<br/>\r\nPayments are issues in US dollars, and are paid <b>once a month</b>, always on 15th. \r\n</p>\r\n<p>\r\n<a name=\"afflink\"></a>\r\n<span class=\"top_feat\">5. What is the affiliate link?</span><br/>\r\nAffiliate link is a special URL where you should be sending the visitors. You will get the URL\'s for different banners\r\nin your affiliate panel after log in.\r\n</p>\r\n\r\n<p>\r\n<a name=\"ppc\"></a>\r\n<span class=\"top_feat\">6. Can I promote you through pay-per-click search engines?</span><br/>\r\nYES! You can promote us through pay-per-click search engines. In fact, this type of promotion becomes \r\nincreasingly popular and we are aware of several affiliates promoting our products in this way and making a very good profit. \r\n(Well, they keep promoting us month after month, which tells you something, doesn\'t it?)\r\n\r\nIf you are not familiar with with type of promotion, we recommend <a href=\"http://netquality.wingcube.hop.clickbank.net/\" target=_blank>this excellent ebook</a>. \r\nSome people are making MILLIONS promoting other people\'s products - why not you?\r\n</p>\r\n\r\n<p>\r\n<a name=\"whatnow\"></a>\r\n<span class=\"top_feat\">7. Do you have any training program for affiliates?</span><br/>\r\nYes, basics of affiliate marketing and most useful tips are described in your affiliate panel. \r\nYou can find new tips and techniques also in our affiliate newsletter.\r\n<br/>\r\nIf you are serious with earning your income as an affiliate, we recommend \r\nexcellent <a href=\"http://www.superaffiliatehandbook.com/cbae/?a=Zkjh06wHjL\" target=_blank>SuperAffiliate Handbook</a>.\r\n</p>\r\n\r\n<p>\r\n<a name=\"whatnow\"></a>\r\n<span class=\"top_feat\">8. What must I do NOW?</span><br/>\r\nFew simple steps:<br/>\r\n1. Go to the <a href=#signup>Signup Form</a><br/>\r\n2. Fill out the form <br/>\r\n3. Receive your password and other info by email<br/> \r\n4. Log in to your own affiliate panel and choose from various banners, text links, reviiews and other promotional materials<br/>\r\n5. Place some of these banners/links onto the Home page of your website and as many pages as you want, to increase your sales<br/>\r\n6. Receive 50% commissions from every sale!\r\n</p>\r\n\r\n','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('b589cf76',3,'Aff_integration_version','1000006','default1',NULL,NULL,NULL);

INSERT INTO wd_g_settings VALUES ('939ace0e',3,'Aff_login_display_text_in_the_middle','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('916b412d',3,'Aff_login_text_in_the_middle_msg','<p>\r\n    <span style=\"color: #3333cc; font-size: 14px; font-weight: bold; font-family: Tahoma;\">Getting Started As Affiliate</span>\r\n    </p>\r\n    <p>\r\n    Welcome to our affiliate program. On the left side you can see the menu that will help you orient in the system.\r\n    <br/>\r\n    In the <b>Banners</b> section you can get banners, text links, articles or reviews that you can use to promote our products.\r\n    <br/> \r\n    In <b>Reports</b> you can run various reports showing you trends of your promotion efforts over time <b>Traffic & Sales</b>, list of all <b>Transactions</b>, and so on.\r\n    </p>\r\n    \r\n    <br/>\r\n    <p>\r\n    <span style=\"color: #3333cc; font-size: 14px; font-weight: bold; font-family: Tahoma;\">A few ways to make money with our affiliate program</span>\r\n    </p>\r\n    \r\n    <p>\r\n    <ol>\r\n    <li><strong>Write a review of some of our products</strong>, letting people know how good it is. \r\n    Include your affiliate link at the end of the review. Post your review to free sites such \r\n    as <a href=\"http://www.GoArticles.com\" target=_blank>GoArticles.com</a> & <a href=\"http://www.EzineArticles.com\" target=_blank>EzineArticles.com</a>. \r\n    </li>\r\n    <li><strong>Create a free blog</strong> (web log) at sites such as Blogger.com, and post your review of our products, \r\n    including your affiliate link. Then \"ping\" your blog at a site such as Pingomatic.com, so it gets picked up quickly by search engines.\r\n    </li>\r\n    \r\n    <li><strong>Join popular marketing forums</strong> such as WarriorForum.com, and make frequent contributions to popular threads there. \r\n    Be sure to go into your forum profile and edit your \"signature\". Make a signature that includes your  affiliate link, \r\n    or a link to your own \"review\" website of our product. That way, every time you make a post, anyone who sees it will see your \r\n    signature and potentially click on your affiliate link.\r\n    </li>\r\n    \r\n    <li>Once every few weeks <strong>post a press release</strong> at PRweb.com, in which you include your favorable review of our product, \r\n    along with your affiliate link. If you pay them $80, they will guarantee that your press release is picked up by all major search \r\n    engines, potentially sending you thousands of visitors.\r\n    </li>\r\n    \r\n    <li>If you own an email list of <strong>newsletter</strong> subscribers or other people who have opted in to receive email offers from you, \r\n    send them an email telling them about our website, and feel free to use some text from our homepage in your email. Include \r\n    your affiliate link at the end of the email. You can even use our email sample above. \r\n    <br/>\r\n    *NOTE - We do not tolerate spamming in \r\n    any way. \r\n    </li>\r\n    \r\n    <li><strong>Pay-Per-Click</strong> (PPC):\r\n    Using a PPC account from Google Adwords, Overture, or many others, you can easily generate income with the our affiliate program. \r\n    You can either send people directly to us using your affiliate link in your PPC ads, or you can create your own website in which you have \r\n    a review of our product, followed by your affiliate tracking link. \r\n    </li>\r\n    \r\n    <li><strong>Upgrade yourself</strong><br/>\r\n    Being affiliate is not exceptionally difficult, but there are many tricks and techniques that can improve your results.\r\n    Learn from the best - <a style=\"color: #ff0000\" href=\"http://www.superaffiliatehandbook.com/cbae/?a=Zkjh06wHjL\" target=_blank><b>SuperAffiliate Handbook</b></a> is \r\n    highly recommended reading for every affiliate.\r\n    </li>\r\n    </ol>\r\n    </p>\r\n\r\n    <br/>\r\n    <p>\r\n    <span style=\"color: #3333cc; font-size: 14px; font-weight: bold; font-family: Tahoma;\">Tips and tricks to earn more as an affiliate</span>\r\n    </p>\r\n    \r\n    <p>\r\n    <ul>\r\n    <li>From our experience, you will get the best results from writing your own product reviews, even if it\'s short. \r\n        You don\'t have to be a good writer. Just write what you really think about the product. \r\n        When you publish your product review, use your general affiliate link (on the top) to send user to our website.\r\n    </li>\r\n    <br/>\r\n    <li>You will have much better conversion if you\'ll put your visitors into pre-sold mood before sending them to our site. \r\n        <br/>\r\n        Pre-sold mood means that you build interest in product and visitor has decided to potentially buy it after he reads your product review.\r\n        <br/>\r\n        Choose from various types of product descriptions, download and adjust them to fit in your site. \r\n        Experiment with short or long, try to find perfect combination with banners.\r\n    </li>\r\n    <br/>\r\n    <li>Try to think like a visitor, when he comes to your page with review or affiliate link, you should draw his attention, build curiosity\r\n        or feeling that he might need this kind of solution.\r\n    </li>\r\n    <br/>\r\n    <li>Experiment with different banners, text links, or reviews. Keep these that bring good results, and change the others.\r\n        Sometimes only change of few words or color of link can mean difference.\r\n    </li>\r\n    </ul>\r\n    </p>','default1',NULL,NULL,NULL);

INSERT INTO wd_g_settings VALUES ('78996014',3,'Aff_login_display_welcome','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996015',3,'Aff_login_display_statistics','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996016',3,'Aff_login_display_trendgraph','','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996017',3,'Aff_login_display_manager','1','default1',NULL,NULL,NULL);
INSERT INTO wd_g_settings VALUES ('78996018',3,'Aff_login_welcome_msg','','default1',NULL,NULL,NULL);


insert into wd_pa_integration
values('general1',
'General solution', '',
'AffPlanet is compatible with nearly ALL merchant accounts, payment gateways, shopping carts and membership systems.<br/><br/><b>What integration means</b><br>
Integration is a way to connect the affiliate system to your current website, shopping cart or payment gateway in a way that affiliate system will
be notified about purchases. When notified, affiliate system registers the sale, finds referring affiliate (if any) and creates appropriate commission for him.
<br/><br/>
The general method of integration is putting an invisible image anywhere in the "thank you for order" or order confirmation page that is displayed to the customer
after the payment is processed.',
'This is all that is required. Now whenever there\'s sale, the sale tracking script sale.php is called, and it will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('general1', 'general1', 1,
'<b>Open your order confirmation or "thank you for order" page template, and put the following code somewhere onto the page</b>',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n<script type=\"text/javascript\"><!--\r\nvar TotalCost="XXXXXX.XX";\r\nvar OrderID="XXXXXX";\r\nvar ProductID="XXXXXX";\r\npapSale();\r\n--></script>',
'where the values XXXXXX should be replaced with correct values for:<br/>
<b>TotalCost</b> (mandatory for % commissions) - price of the product <br/>
<b>OrderID</b> (optional) - can be your unique generated order ID to cross-check the sale. <br/>
<b>ProductID</b> (optional) - the ID of the product bought.
<br/><br/>
All fields are optional, but without TotalCost system will be not able to compute percentage commissions.
<br/>
Also, ProductID is required if you plan to use <b>Force choosing commission by product ID</b> - this is available only in Pro version.
<br/><br/>
If you need to set total sale cost and order id, but you don\'t have access to their values in your "Thank you" page, the situation is more complicated.
There is no general solution for this. If you know that you can register sale in some other place, where those values (total cost and order id) are available, you can put the tracking code there.
Otherwise, consult us for advice and finding possible solution. ',
'english');


insert into wd_pa_integration
values('oscom01',
'osCommerce', '',
'Integration with osCommerce is made by placing sale tracking script into the confirmation page. To obtain the values of OrderID and TotalSale, snippet connects to osCommerce database and retrieves the values from there.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('oscom01', 'oscom01', 1,
'Find and open file <b>checkout_success.php</b>',
'',
'',
'english');


insert into wd_pa_integrationsteps
values('oscom02', 'oscom01', 2,
'Inside the file find this line <br>
<b><i>if ($global[\'global_product_notifications\'] != \'1\') {<br>
...
</i></b>',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('oscom03', 'oscom01', 3,
'insert the following code just above that line',
'  //--------------------------------------------------------------------------\n
  // integration code\n
  //--------------------------------------------------------------------------\n
  // get order id\n
  $sql = "select orders_id from ".TABLE_ORDERS.\n
         " where customers_id=\'".(int)$customer_id.\n
         "\' order by date_purchased desc limit 1";\n
  $pap_orders_query = tep_db_query($sql);\n
  $pap_orders = tep_db_fetch_array($pap_orders_query);\n
  $pap_order_id = $pap_orders[\'orders_id\'];\n
\n
  // get total amount of order\n
  $sql = "select value from ".TABLE_ORDERS_TOTAL.\n
         " where orders_id=\'".(int)$pap_order_id.\n
         "\' and class=\'ot_subtotal\'";\n
  $pap_orders_total_query = tep_db_query($sql);\n
  $pap_orders_total = tep_db_fetch_array($pap_orders_total_query);\n
  $pap_total_value = $pap_orders_total[\'value\'];\n
\n
  // draw invisible image to register sale\n
  if($pap_total_value != "" && $pap_order_id != "")\n
  {\n
    $img = \'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n<script type=\"text/javascript\"><!--\r\nvar TotalCost="\'.$pap_total_value.\'";\r\nvar OrderID="\'.$pap_order_id.\'";\r\nvar ProductID="";\r\npapSale();\r\n--></script>\';\n
    print $img;\n
  }\n
  //--------------------------------------------------------------------------\n
  // END of integration code\n
  //--------------------------------------------------------------------------\n
',
'',
'english');


insert into wd_pa_integrationsteps
values('oscom04', 'oscom01', 4,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');



insert into wd_pa_integration
values('2check01',
'2Checkout', '',
'2Checkout system has two versions (1 and 2). affiliate software can be easily integrated with both of them. They way of integration is the same, the versions differ only in structure of menu in 2checkout control panel.
2Checkout directly supports putting the hidden image tag on the sales confirmation page.',
'This is all that is required. Now whenever there\'s sale, 2checkout will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('2check01', '2check01', 1,
'Log-in to 2checkout vendor panel, go to <b>Look and Feel</b> and put the following URL to the <b>Affiliate URL</b> &lt;img src = field:',
'$SCRIPTDIRsale.php?TotalCost=$a_total&OrderID=$a_order',
'',
'english');


insert into wd_pa_integration
values('paypal01',
'PayPal', '',
'PayPal integrates using IPN callback.<br/>
Note! This is description of integration with PayPal if you use PayPal buttons on your web pages. If you use PayPal as a processing system in your shopping cart,
use the method for integrating with shopping cart, not these steps.
<br/>
Also, make sure you don\'t already use PayPal IPN for another purpose, such as some kind of digital delivery or membership registration.',
'This is all that is required. Now whenever there\'s sale, PayPal will use its IPN function to call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('paypal01', 'paypal01', 1,
'Now add the following code into EVERY PayPal button form',
'<input type="hidden" name="notify_url" value="$SCRIPTDIRpaypal.php">\n
<input type="hidden" name="custom" value="" id="pap_dx8vc2s5">\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\n
<script type="text/javascript"><!--\n
paypalSale();\n
--></script>\n',
'This will tell PayPal that it should silently
call <b>$SCRIPTDIRpaypal.php</b> script upon every sale, and it will pass
all sale variables including the custom field to this script.', 'english');

insert into wd_pa_integrationsteps
values('paypal02', 'paypal01', 2,
'Example of updated PayPal form:<br/><br/>
<code>
&lt;!-- Begin PayPal Button --&gt;<br/>
&lt;form action="https://www.paypal.com/cgi-bin/webscr" method="post"&gt;<br/>
&lt;input type="hidden" name="cmd" value="_xclick"&gt;<br/>
&lt;input type="hidden" name="business" value="paypalemail@yoursite.com"&gt;<br/>
&lt;input type="hidden" name="undefined_quantity" value="1"&gt;<br/>
&lt;input type="hidden" name="item_name" value="Product Name"&gt;<br/>
&lt;input type="hidden" name="amount" value="19.95"&gt;<br/>
&lt;input type="hidden" name="image_url" value="https://yoursite.com/images/paypaltitle.gif"&gt;<br/>
&lt;input type="hidden" name="no_shipping" value="1"&gt;<br/>
&lt;input type="hidden" name="return" value="http://www.yoursite.com/paypalthanks.html"&gt;<br/>
&lt;input type="hidden" name="cancel_return" value="http://www.yoursite.com"&gt;<br/>
<b>&lt;input type="hidden" name="notify_url" value="$SCRIPTDIRpaypal.php"&gt;<br/>
&lt;input type="hidden" name="custom" value="" id="pap_dx8vc2s5"&gt;<br/>
&lt;script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"&gt;&lt;/script&gt;<br/>
&lt;script type="text/javascript"&gt;&lt;!--<br/>
paypalSale();<br/>
--&gt;&lt;/script&gt;<br/></b>
&lt;input type="image" src="http://images.paypal.com/images/x-click-but5.gif" border="0" name="submit"&gt;<br/>
&lt;/form&gt;<br/>
&lt;!-- End PayPal Button --&gt;</code>',
'',
'', 'english');



insert into wd_pa_integration
values('stormp01',
'StormPay', '',
'StormPay integration is similar to PayPal, it also uses StormPay\'s IPN callback.<br/>
Note! This is description of integration with StormPay if you use StormPay buttons on your web pages. If you use StormPay as a processing system in your shopping cart,
use the method for integrating with shopping cart, not these steps.
<br/>
Also, make sure you don\'t already use StormPay IPN for another purpose, such as some kind of digital delivery or membership registration.',
'This is all that is required. Now whenever there\'s sale, StormPay will use its IPN function to call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('stormp01', 'stormp01', 1,
'Now add the following code into EVERY StormPay button form',
'<input type="hidden" name="user1" value="" id="pap_dx8vc2s5">\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\n
<script type="text/javascript"><!--\n
paypalSale();\n
--></script>\n',
'This will tell StormPay that it should silently
call <b>$SCRIPTDIRstormpay.php</b> script upon every sale, and it will pass
all sale variables including the custom field to this script.', 'english');


insert into wd_pa_integrationsteps
values('stormp02', 'stormp01', 2,
'Example of updated StormPay form:<br/><br/>
<code>
&lt;form action="http://www.stormpay.com....&gt;<br/>
... <br/>
&lt;input type="hidden" name="user1" value="" id="pap_dx8vc2s5"&gt;<br/>
&lt;script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"&gt;&lt;/script&gt;<br/>
&lt;script type="text/javascript"&gt;&lt;!--<br/>
paypalSale();<br/>
--&gt;&lt;/script&gt;<br/>
...<br/>
&lt;/form&gt;<br/>',
'',
'', 'english');

insert into wd_pa_integrationsteps
values('stormp04', 'stormp01', 3,
'Next step is to configure StormPay to use IPN callback to our
stormpay script.
There is an <b>IPN Cofiguration</b> section of your <b>Profile / Setup</b> page.
You should specify there full url to the stormpay script: ',
'$SCRIPTDIRstormpay.php',
'', 'english');



insert into wd_pa_integration
values('worldp01',
'WorldPay', '',
'WorldPay integration is similar to PayPal, it also uses WorldPay callback.<br/>
Note! This is description of integration with WorldPay if you use WorldPay buttons on your web pages. If you use WorldPay as a processing system in your shopping cart,
use the method for integrating with shopping cart, not these steps.
<br/>
Also, make sure you don\'t already use WorldPay callback for another purpose, such as some kind of digital delivery or membership registration.',
'This is all that is required. Now whenever there\'s sale, WorldPay will use its callback function to call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('worldp01', 'worldp01', 1,
'Now add the following code into EVERY WorldPay button form',
'<input type="hidden" name="M_aid" value="" id="pap_dx8vc2s5">\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\n
<script type="text/javascript"><!--\n
paypalSale();\n
--></script>\n',

'This will tell WorldPay that it should silently
call <b>$SCRIPTDIRworldp.php</b> script upon every sale, and it will pass
all sale variables including the custom field to this script.', 'english');


insert into wd_pa_integrationsteps
values('worldp02', 'worldp01', 2,
'Example of updated WorldPay form:<br/><br/>
<code>
&lt;form action="http://www.worldpay.com....&gt;<br/>
... <br/>
&lt;input type="hidden" name="M_aid" value="" id="pap_dx8vc2s5"&gt;<br/>
&lt;script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"&gt;&lt;/script&gt;<br/>
&lt;script type="text/javascript"&gt;&lt;!--<br/>
paypalSale();<br/>
--&gt;&lt;/script&gt;<br/>
...<br/>
&lt;/form&gt;<br/>',
'',
'', 'english');

insert into wd_pa_integrationsteps
values('worldp03', 'worldp01', 3,
'Next step is to configure WorldPay to use callback to our
worldpay script.
You should specify there full url to the worldpay script: ',
'$SCRIPTDIRworldpay.php',
'', 'english');



insert into wd_pa_integration
values('amembe01',
'aMember', '',
'aMember uses a variation of General solution, it tracks sales by invoking hidden script from "thank you" page.',
'This is all that is required. Now whenever there\'s sale, aMember will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('amembe01', 'amembe01', 1,
'Put the following code to the aMember thanks.html page',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n
<script type=\"text/javascript\"><!--\r\n
var TotalCost="{$payment.amount}";\r\n
var OrderID="{$payment.payment_id}";\r\n
var ProductID="{$payment.product_id}";\r\n
papSale();\r\n
--></script>',
'',
'english');


insert into wd_pa_integration
values('snscar01',
'SecureNetShop (snscart)', '',
'To integrate with SecureNetShop you have to display affiliate-tracking code in the "receipt page" of the shopping cart.',
'This is all that is required. Now whenever there\'s sale, aMember will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);

insert into wd_pa_integrationsteps
values('snscar01', 'snscar01', 1,
'Click on the <b>Settings</b> menu in your shopping cart administration area',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('snscar02', 'snscar01', 1,
'Click on <b>Order tracking</b> that will be displayed under "Marketing". ',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('snscar03', 'snscar01', 1,
'Click on the <b>Add new</b> button.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('snscar04', 'snscar01', 1,
'Choose your affiliate tracking provider from the list of options or else enter the tracking codes in the text box <b>Tracking code</b>. You can also choose the substitution codes for the affiliate tracking.<br/>
The tracking code is:',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n<script type=\"text/javascript\"><!--\r\nvar TotalCost="XXXXXXXX";\r\nvar OrderID="XXXXXX";\r\nvar ProductID="XXXXXX";\r\npapSale();\r\n--></script>',
'where the values XXXXXX should be replaced with correct values for:<br/>
<b>TotalCost</b> (mandatory for % commissions) - price of the product <br/>
<b>OrderID</b> (optional) - can be your unique generated order ID to cross-check the sale. <br/>
<b>ProductID</b> (optional) - the ID of the product bought.
<br/><br/>',
'english');

insert into wd_pa_integrationsteps
values('snscar05', 'snscar01', 1,
'Choose the placement conditions and than click on the save button.',
'',
'',
'english');



insert into wd_pa_integration
values('ccbill01',
'ccBill', '',
'Integration with ccBill can be made using the Approval URL supported by them.',
'This is all that is required. Now whenever there\'s sale, ccBill will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('ccbill01', 'ccbill01', 1,
'Login to your ccBill <b>Admin Center</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('ccbill02', 'ccbill01', 1,
'Go to <b>Account Maintenance -> Account Admin</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('ccbill03', 'ccbill01', 1,
'Click on the sub/account (if applicable),then on advanced (left side menu) and place the following code into the <b>Approval Post URL</b> section:.',
'$SCRIPTDIRsale.php?TotalCost=initialPrice&OrderID=subscription_id',
'',
'english');


insert into wd_pa_integration
values('psigat01',
'PSiGate', '',
'PSiGate uses a variation of General solution, it tracks sales by invoking hidden script from "thank you" page.',
'This is all that is required. Now whenever there\'s sale, PSiGate will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('psigat01', 'psigat01', 1,
'Specify your own thank you page for PsiGate and put there the following code',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n
<script type=\"text/javascript\"><!--\r\n
var TotalCost="SubTotal";\r\n
var OrderID="OrdNo";\r\n
var ProductID="";\r\n
papSale();\r\n
--></script>',
'',
'english');



insert into wd_pa_integration
values('clicar01',
'ClickCartPro', '',
'Integration with ccBill can be made using the Approval URL supported by them.
 Go to Account Maintenance -> Account Admin. ',
'This is all that is required. Now whenever there\'s sale, ClickCartPro will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('clicar01', 'clicar01', 1,
'Login to your ClickCartPro <b>Admin Center</b> and go to the <b>Main Menu</b>. ',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('clicar02', 'clicar01', 1,
'go to <b>HTML Pages and Elements - > Manage Site Elements</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('clicar03', 'clicar01', 1,
'Open and update this template: <b>Order Confirmation - Third Party Affiliate Program Placeholder</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('clicar04', 'clicar01', 1,
'Place the following code anywhere in the box (all in one line) and click submit:',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\"><!--
var TotalCost="(CGIVAR)tracking_subtotal(/CGIVAR)";var OrderID="(CGIVAR)tracking_id(/CGIVAR)";var ProductID="";papSale();--></script>',
'',
'english');

insert into wd_pa_integration
values('hspher01',
'H-Sphere', '',
'Integration with any affiliate system is directly supported by H-Sphere.',
'This is all that is required. Now whenever there\'s sale, H-Sphere will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('hspher01', 'hspher01', 1,
'Log-in to your <b>H-Sphere Admin Center</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('hspher02', 'hspher01', 1,
'Go to <b>Settings - Affiliate Program</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('hspher03', 'hspher01', 1,
'Leave AutoInsert set to amount and place the following code into the area for Link 1:',
'$SCRIPTDIRsale.php?TotalCost=${amount}',
'',
'english');


insert into wd_pa_integration
values('mambop01',
'mambo-phpShop', '',
'Integration with mambo-phpShop is made by placing sale tracking script into the order confirmation page.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('mambop01', 'mambop01', 1,
'open and edit the temlate file that displays order confirmation page. It is the file
<b>/mambo/administrator/components/com_phpshop/classes/ps_checkout.php</b>',
'',
'',
'english');


insert into wd_pa_integrationsteps
values('mambop02', 'mambop01', 2,
'Find the following code which should already exist in the file.  <br>
<code>if (AFFILIATE_ENABLE == \'1\') { $ps_affiliate->register_sale($order_id); }</code>',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('mambop03', 'mambop01', 3,
'Cut/Paste the following code into the file, under the code found above:',
'print \'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\"><!--var TotalCost=\"\'.$order_subtotal.\'\";var OrderID=\"\'.$order_id.\'\";var ProductID=\"\";papSale();--></script>\';',
'',
'english');


insert into wd_pa_integrationsteps
values('mambop04', 'mambop01', 4,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');


insert into wd_pa_integration
values('shopsi01',
'ShopSite', '',
'Integration with ShopSite is made by placing sale tracking script into the order confirmation page.',
'This is all that is required. Now whenever there\'s sale, ShopSite will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('shopsi01', 'shopsi01', 1,
'Log-in to your <b>ShopSite Admin Center</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('shopsi02', 'shopsi01', 1,
'Click on <b>Commerce Setup -> Order System -> Thank You</b>.',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('shopsi03', 'shopsi01', 1,
'Cut/Paste the following code into the top box labeled <b>Information on the Thank You screen to return to storefront</b>:',
'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>\r\n
<script type=\"text/javascript\"><!--\r\n
var TotalCost=ss_subtotal;\r\n
var OrderID=ss_ordernum;\r\n
var ProductID="";\r\n
papSale();\r\n
--></script>',
'',
'english');


insert into wd_pa_integration
values('yahoos01',
'Yahoo Stores', '',
'Integration with Yahoo Stores is made by placing sale tracking script into the order confirmation page.',
'This is all that is required. Now whenever there\'s sale, Yahoo Stores will call our sale tracking script, and system will generate commission for the affiliate.',
0, 1);


insert into wd_pa_integrationsteps
values('yahoos01', 'yahoos01', 1,
'Login to your <b>Yahoo Store Manager and click Order Settings -> Order Form</b>',
'',
'',
'english');

insert into wd_pa_integrationsteps
values('yahoos02', 'yahoos01', 1,
'Find the box labeled: <b>Order Confirmation : Message</b>, place the following code into the box and click done.',
'<script>
<!--\r\n
function getSaleInfo(){\r\n
var totalCost;\r\n
var orderId;\r\n
bs = bs2 = document.getElementsByTagName("b");\r\n
for(i=0;i<bs.length;i++) {\r\n
if(prz = bs[i].innerHTML.match(/(\d+\.\d{2})/)) { totalCost = prz[1];}\r\n
}\r\n
for(var i=0;i<bs2.length;i++) {\r\n
if(bs2[i].innerHTML.indexOf("Order Number:")!=-1) {\r\n
orderId = bs2[i].nextSibling.nodeValue;\r\n
}\r\n
}\r\n
document.getElementById(\'st_code\').innerHTML=\'<img src="$SCRIPTDIRsale.php?TotalCost=\' + totalCost + \'&OrderID=\' + orderId + \'" alt="" width=1 height=1>\';\r\n
}\r\n
window.onload = getSaleInfo;\r\n
// -->\r\n
</script> \r\n
<div id="st_code"></div>',
'',
'english');

insert into wd_pa_integrationsteps
values('yahoos03', 'yahoos01', 1,
'After inserting the code below you should click <b>Order Settings -> Publish Order Settings</b> to make the changes live.',
'',
'',
'english');


insert into wd_pa_integration
values('zencar01',
'ZenCart', '',
'Integration with ZenCart is made by placing sale tracking script into the order confirmation page.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('zencar01', 'zencar01', 1,
'To integrate ZenCart you should edit the order confirmation template. Open the file
<b>/zencart/tpl_checkout_success_default.php</b>',
'',
'',
'english');


insert into wd_pa_integrationsteps
values('zencar02', 'zencar01', 2,
'Find the line with following code which should already exist in the file.  <br>
<code>fields[\'orders_id\']; ?></code>',
'',
'',
'english');


insert into wd_pa_integrationsteps
values('zencar03', 'zencar01', 3,
'Cut/Paste the following code into the file, under the line found above:',
'<?php\r\n
$dbreq = $db->Execute("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = \'".(int)$orders->fields[\'orders_id\']."\' AND class = \'ot_subtotal\'");\r\n
$totalCost = (number_format($dbreq->fields[\'value\'],2));\r\n
$orderId = $dbreq->fields[\'orders_id\'];\r\n
print \'<script id=\"pap_x2s6df8d\" src=\"$SCRIPTDIRsale.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\"><!--var TotalCost=\"\'.$totalCost.\'\";var OrderID=\"\'.$orderId.\'\";var ProductID=\"\";papSale();--></script>\';\r\n
?>',
'',
'english');


insert into wd_pa_integration
values('vtmart01',
'Virtue Mart', '',
'Integration with Virtue Mart is made by placing sale tracking script into the confirmation page.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('vtmart01', 'vtmart01', 1,
'Find and open file <b>checkout.thankyou.php</b>',
'','', 'english');


insert into wd_pa_integrationsteps
values('vtmart02', 'vtmart01', 2,
'Replace last ?> with following code',
'$q = "SELECT * FROM #__{vm}_orders WHERE order_id=\'$order_id\'";\r\n
$db->query( $q );\r\n
$pap_order_total = $db->f(\'order_subtotal\' );\r\n
\r\n
$q = "SELECT * FROM #__{vm}_order_item WHERE order_id=\'$order_id\'";\r\n
$db->query( $q );\r\n
$pap_product_id = $db->f(\'product_id\');\r\n
?>\r\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
var TotalCost="<?php echo  $pap_order_total ?>";\r\n
var OrderID="<?php echo  $order_id ?>";\r\n
var ProductID="<?php echo  $pap_product_id ?>";\r\n
papSale();\r\n
</script>',
'',
'english');


insert into wd_pa_integrationsteps
values('vtmart03', 'vtmart01', 3,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');


insert into wd_pa_integration
values('cartm01',
'Cart Manager', '',
'Integration with Cart Manager can be made using the Approval URL supported by them.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('cartm01', 'cartm01', 1,
'Login to your CartManager admin center and click <b>Advanced Settings</b>.',
'','', 'english');

insert into wd_pa_integrationsteps
values('cartm02', 'cartm01', 2,
'Find the box labeled: <b>HTML For Bottom of Receipt</b>.',
'','', 'english');

insert into wd_pa_integrationsteps
values('cartm03', 'cartm01', 3,
'Place the following code into the box.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
var TotalCost=PRINTSUBTOTAL;\r\n
var OrderID=PRINTORDERNUMBER;\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('cartm04', 'cartm01', 4,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');


insert into wd_pa_integration
values('ecomt01',
'eCommerce Templates', '',
'Integration with eCommerce Templates is made by placing sale tracking script into the confirmation page.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('ecomt01', 'ecomt01', 1,
'Find and open file <b>thanks.php</b>.',
'','', 'english');

insert into wd_pa_integrationsteps
values('ecomt02', 'ecomt01', 2,
'Find the following line which already exists in the file: <b>&lt;?php include "vsadmin/inc/incthanks.php" ?&gt;</b>',
'','', 'english');

insert into wd_pa_integrationsteps
values('ecomt03', 'ecomt01', 3,
'Put following code right after this line.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
var TotalCost="<?php echo  $ordGrandTotal ?>";\r\n
var OrderID="<?php echo  $ordID ?>";\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('ecomt04', 'ecomt01', 4,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');



insert into wd_pa_integration
values('mamchp01',
'Mambo-ChargePlus', '',
'Integration with Mambo-ChargePlus is made by placing sale tracking script into the confirmation page.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('mamchp01', 'mamchp01', 1,
'Find and open file <b>/components/com_mambocharge_plus/mambocharge_plus_thankyou.php</b>.',
'','', 'english');

insert into wd_pa_integrationsteps
values('mamchp02', 'mamchp01', 2,
'Put the following code into the very bottom of this file.',
'<?php\r\n
$aff_subtotal = $_POST[\'amount3\'];\r\n
$aff_orderid = $_POST[\'invoice\'];\r\n
?>\r\n
<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
var TotalCost="<?php echo  $aff_subtotal ?>";\r\n
var OrderID="<?php echo  $aff_orderid ?>";\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('mamchp04', 'mamchp01', 3,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');


insert into wd_pa_integration
values('swreg01',
'SWREG', '',
'Integration with SWREG is very simple - you only need to place sale tracking script into the template of order confirmation page.<br>
If you use Advanced ordering method, then you probably don\'t need to follow the steps below. Use the General Solution tracking code and put it to your own custom order confirmation page.
<br/>If you use standard ordering, follow the steps below.',
'',
0, 1);


insert into wd_pa_integrationsteps
values('swreg01', 'swreg01', 1,
'Log in to SWREG admin panel and click to <b>edit your look and feel templates</b><br/>If your templates are disabled, you should enable them by clicking on the top link <b>enable templates</b>.',
'',
'',
'english');


insert into wd_pa_integrationsteps
values('swreg02', 'swreg01', 2,
'Open <b>Credit Card Confirmation Template</b> and edit it\'s code. If you don\'t have this template customized yet, you should download the system template and make the changes there.
<br/>Put the following code anywhere inside the &lt;body&gt; &lt;/body&gt; tags of the template.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>
<script type="text/javascript"><!--\r\n
var TotalCost="###BASECURRENCYTOTAL###";\r\n
var OrderID="###ORDERNO###";\r\n
var ProductID="";\r\n
papSale();\r\n
--></script>',
'If you want to use secure images, only replace http:// with https:// in script src.<br/>When you added the code to template file, upload it back to server, then Activate it and make it Default. This will tell system to use your customized template with tracking code when displaying order confirmation page.',
'english');

insert into wd_pa_integrationsteps
values('swreg03', 'swreg01', 3,
'This way you added tracking code to <b>Credit Card Confirmation Template</b>. You should do the same for other ordering methods, like <b>PayPal Template</b>, <b>Wire Transfer Ordering Template</b> and <b>Check/Cheque Ordering Template</b>',
'',
'',
'english');

insert into wd_pa_integration
values('xcart01',
'X-Cart', '',
'Integration with X-Cart is made by placing sale tracking script into the order confirmation page.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('xcart01', 'xcart01', 1,
'Find and open file <b>/xcart/skin1/customer/main/order_message.tpl</b>.<br/>
If you use other skin, your skin directory could be different.',
'','', 'english');

insert into wd_pa_integrationsteps
values('xcart02', 'xcart01', 2,
'Put the following code right after the &lt;BR&gt;&lt;BR&gt;&lt;BR&gt;&lt;BR&gt; line.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
var TotalCost="{$orders[oi].order.subtotal}";\r\n
var OrderID="{$orders[oi].order.orderid}";\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('xcart03', 'xcart01', 3,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');

insert into wd_pa_integration
values('1shop01',
'1ShoppingCart', '',
'Integration with 1ShoppingCart is made by placing sale tracking script into the than you page.',
'',
0, 1);

insert into wd_pa_integrationsteps
values('1shop01', '1shop01', 1,
'1ShoppingCart allows you to have custom template of <b>thank you</b> page. They even provide sample custom thank you page.<br>
Find and open this custom thank you template file.',
'','', 'english');

insert into wd_pa_integrationsteps
values('1shop02', '1shop01', 2,
'Put the following code right after last presence of ?&gt mark.',
'<script id="pap_x2s6df8d" src="$SCRIPTDIRsale.js" type="text/javascript"></script>\r\n
<script type="text/javascript">\r\n
var TotalCost="<?php echo  $_POST[\'Total\']; ?>";\r\n
var OrderID="<?php echo  $_POST[\'orderID\']; ?>";\r\n
var ProductID="";\r\n
papSale();\r\n
</script>','', 'english');

insert into wd_pa_integrationsteps
values('1shop03', '1shop01', 3,
'It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.',
'',
'',
'english');

