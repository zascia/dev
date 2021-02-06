
INSERT INTO pa_affiliates(affiliateid, username, password, weburl, contactname, street, city, country, zipcode, status, dateinserted, dateapproved)
VALUES (1,'test@test.test','test','www.test.com', 'Test', 'test street', 'test city', 'United States', '11111', 2, NOW(), NOW());

CREATE TABLE seq_pa_affiliates (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

INSERT INTO seq_pa_affiliates VALUES (1);

INSERT INTO pa_campaigns(campaignid, name, dateinserted, cookielifetime, clickapproval, saleapproval, commtype)
                 VALUES (1,'First',NOW(), 0, 1, 1, 4);

CREATE TABLE seq_pa_campaigns (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

INSERT INTO seq_pa_campaigns VALUES (1);

INSERT INTO pa_campaigncategories(campcategoryid, campaignid, name, clickcommission, salecommission, salecommtype)
                 VALUES (1, 1, 'Unassigned users', 0.25, 20.0, '$');

CREATE TABLE seq_pa_campaigncategories (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

INSERT INTO seq_pa_campaigncategories VALUES (1);



INSERT INTO pa_banners VALUES (2,'Test banner\r\ntext text text','http://www.webradev.com','TestBanner',NULL,1,0,1);

CREATE TABLE seq_pa_banners (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

INSERT INTO seq_pa_banners VALUES (2);

INSERT INTO pa_emailtemplates VALUES (1,'AFF_EMAIL_SIGNUP','Thank you for joining','Dear $Affiliate_name,\r\n\r\nthank you for joining our affiliate program.\r\n\r\nYour username is: $Affiliate_username\r\nYour password is: $Affiliate_password\r\nYou can log in into your control panel in url: http://www.yoursite.com/affiliate/affiliates/\r\n\r\n  sincerelly,\r\n\r\n    Your site Team',0,'english');
INSERT INTO pa_emailtemplates VALUES (2,'AFF_EMAIL_NTF_SIGNUP','New affiliate signup','POST Affiliate Pro Email notification\r\n\r\nNew affiliate joined the affiliate program. Affiliate details:\r\n\r\nName: $Affiliate_name\r\nUsername/email: $Affiliate_username\r\nWebsite: $Affiliate_website\r\nCountry: $Affiliate_country\r\nStatus: $Affiliate_status ',0,'english');
INSERT INTO pa_emailtemplates VALUES (3,'AFF_EMAIL_NTF_SALE','New sale','POST Affiliate Pro Email notification\r\n\r\nNew sale was registered by affiliate program. Sale details:\r\n\r\nTransaction ID:  $Sale_id\r\nCommission:  $Sale_commission\r\nTotal cost:  $Sale_totalcost\r\nOrderID:  $Sale_orderid\r\nProductID:  $Sale_productid\r\nDate&time:  $Sale_date\r\nAffiliate:  $Sale_affiliate\r\nStatus:  $Sale_status\r\nIP address:  $Sale_ip\r\nReferrer:  $Sale_referrer\r\n',0,'english');
INSERT INTO pa_emailtemplates VALUES (4,'AFF_EMAIL_DAILY_REP','Daily report for $Date','Daily report for $Date\r\n\r\nImpressions:  $Impressions\r\n\r\nClicks:  $Clicks\r\n\r\nSales\r\n-----------------------------------\r\nApproved:  $Sales_approved\r\n2nd tier approved: $Sales_approved_2ndtier\r\n\r\nWaiting for approval: $Sales_waitingapproval\r\n2nd tier waiting for approval: $Sales_waitingapproval_2ndtier\r\n\r\nDeclined:  $Sales_declined\r\n2nd tier declined:  $Sales_declined_2ndtier\r\n\r\n\r\nCommissions\r\n-----------------------------------\r\nApproved:  $Commissions_approved\r\n2nd tier approved: $Commissions_approved_2ndtier\r\n\r\nWaiting for approval: $Commissions_waitingapproval\r\n2nd tier waiting for approval: $Commissions_waitingapproval_2ndtier\r\n-----------------------------------\r\n\r\nDeclined:  $Commissions_declined\r\n2nd tier declined:  $Commissions_declined_2ndtier\r\n\r\n',0,'english');
INSERT INTO pa_emailtemplates VALUES (5,'AFF_EMAIL_AF_NTF_SGN','New affiliate signup','POST Affiliate Pro Email notification\r\n\r\nNew affiliate joined the affiliate program. Affiliate details:\r\n\r\nUsername/email: $Affiliate_username\r\nWebsite: $Affiliate_website\r\nCountry: $Affiliate_country\r\nStatus: $Affiliate_status ',0,'english');
INSERT INTO pa_emailtemplates VALUES (6,'AFF_EMAIL_AF_NTF_SLE','New sale commission','POST Affiliate Pro Email notification\r\n\r\nNew sale was registered by affiliate program. Sale details:\r\n\r\nCommission:  $Sale_commission\r\nOrderID:  $Sale_orderid\r\nProductID:  $Sale_productid\r\nDate&time:  $Sale_date\r\nStatus:  $Sale_status\r\nIP address:  $Sale_ip\r\nReferrer:  $Sale_referrer\r\n',0,'english');
INSERT INTO pa_emailtemplates VALUES (7,'AFF_EMAIL_AF_DL_REP','Daily report','Daily report for $Date\r\n\r\nImpressions:  $Impressions\r\n\r\nClicks:  $Clicks\r\n\r\nSales\r\n-----------------------------------\r\nApproved:  $Sales_approved\r\n2nd tier approved: $Sales_approved_2ndtier\r\n\r\nWaiting for approval: $Sales_waitingapproval\r\n2nd tier waiting for approval: $Sales_waitingapproval_2ndtier\r\n\r\nDeclined:  $Sales_declined\r\n2nd tier declined:  $Sales_declined_2ndtier\r\n\r\n\r\nCommissions\r\n-----------------------------------\r\nApproved:  $Commissions_approved\r\n2nd tier approved: $Commissions_approved_2ndtier\r\n\r\nWaiting for approval: $Commissions_waitingapproval\r\n2nd tier waiting for approval: $Commissions_waitingapproval_2ndtier\r\n-----------------------------------\r\n\r\nDeclined:  $Commissions_declined\r\n2nd tier declined:  $Commissions_declined_2ndtier\r\n',0,'english');
INSERT INTO pa_emailtemplates VALUES (11,'AFF_EMAIL_FORGOTPASS','Forgot password','Dear $Affiliate_name,\r\n\r\ncheck your password details below.\r\n\r\nYour username is: $Affiliate_username\r\nYour password is: $Affiliate_password\r\nYou can log in into your control panel in url: http://www.yoursite.com/affiliate/affiliates/\r\n\r\n  sincerelly,\r\n\r\n    Your site Team',0,'english');

CREATE TABLE seq_pa_emailtemps (
  id int(11) NOT NULL default '0'
) TYPE=MyISAM;

INSERT INTO seq_pa_emailtemps VALUES (11);

insert into pa_settings(code, value) values('showbankinfo', '1');
insert into pa_settings(code, value) values('showpaypalinfo', '1');
insert into pa_settings(code, value) values('showcheckinfo', '1');
insert into pa_settings(code, value) values('showmoneybookersinfo', '1');
insert into pa_settings(code, value) values('moneybookerscurrency', '$');
insert into pa_settings(code, value) values('system_currency', '$');
insert into pa_settings(code, value) values('show_minihelp', '1');
insert into pa_settings(code, value) values('login_protection_retries', '3');
insert into pa_settings(code, value) values('login_protection_delay', '900');
insert into pa_settings(code, value) values('support_recurring_commissions', '1');
insert into pa_settings(code, value) values('affiliateapproval', '1');
insert into pa_settings(code, value) values('affpostsignupurl', 'postsignup.php');
insert into pa_settings(code, value) values('version', '1.3');
insert into pa_settings(code, value) values('default_lang', 'english');
insert into pa_settings(code, value) values('allow_choose_lang', '1');
insert into pa_settings(code, value) values('min_payout_options', '100;200;300;400;500');
insert into pa_settings(code, value) values('initial_min_payout', '300');
insert into pa_settings(code, value) values('declinefrequentclicks', '');
insert into pa_settings(code, value) values('clickfrequency', '');
insert into pa_settings(code, value) values('declinefrequentsales', '');
insert into pa_settings(code, value) values('salefrequency', '');
insert into pa_settings(code, value) values('declinesameorderid', '');
insert into pa_settings(code, value) values('paging', '10');
insert into pa_settings(code, value) values('link_style', '1');
insert into pa_settings(code, value) values('email_onaffsignup', '1');
insert into pa_settings(code, value) values('email_onsale', '0');
insert into pa_settings(code, value) values('email_dailyreport', '0');
insert into pa_settings(code, value) values('email_recurringtrangenerated', '0');
insert into pa_settings(code, value) values('email_supportdailyreports', '0');
insert into pa_settings(code, value) values('forcecommfromproductid', 'no');
insert into pa_settings(code, value) values('maxcommissionlevels', '10');
insert into pa_settings(code, value) values('debug_trans', '0');

