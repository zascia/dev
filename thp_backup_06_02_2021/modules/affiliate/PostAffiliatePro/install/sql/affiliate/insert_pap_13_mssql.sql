
INSERT INTO pa_affiliates(affiliateid, username, password, weburl, contactname, street, city, country, zipcode, status, dateinserted, dateapproved)
VALUES (1,'test@test.test','test','www.test.com', 'Test', 'test street', 'test city', 'United States', '11111', 2, GETDATE(), GETDATE());

CREATE TABLE seq_pa_affiliates (
  id int NOT NULL default '0'
);

INSERT INTO seq_pa_affiliates VALUES (1);

INSERT INTO pa_campaigns(campaignid, name, dateinserted, cookielifetime, clickapproval, saleapproval, commtype)
                 VALUES (1,'First',GETDATE(), 0, 1, 1, 4);

CREATE TABLE seq_pa_campaigns (
  id int NOT NULL default '0'
);

INSERT INTO seq_pa_campaigns VALUES (1);

INSERT INTO pa_campaigncategories(campcategoryid, campaignid, name, clickcommission, salecommission, salecommtype)
                 VALUES (1, 1, 'Unassigned users', 0.25, 20.0, '$');

CREATE TABLE seq_pa_campaigncategories (
  id int NOT NULL default '0'
);

INSERT INTO seq_pa_campaigncategories VALUES (1);



INSERT INTO pa_banners VALUES (2,'Test banner'+CHAR(13)+'text text text','http://www.webradev.com','TestBanner',NULL,1,0,1);

CREATE TABLE seq_pa_banners (
  id int NOT NULL default '0'
);

INSERT INTO seq_pa_banners VALUES (2);

INSERT INTO pa_emailtemplates VALUES (1,'AFF_EMAIL_SIGNUP','Thank you for joining','Dear $Affiliate_name,'+CHAR(13)+CHAR(13)+'thank you for joining our affiliate program.'+CHAR(13)+CHAR(13)+'Your username is: $Affiliate_username'+CHAR(13)+'Your password is: $Affiliate_password'+CHAR(13)+'You can log in into your control panel in url: http://www.yoursite.com/affiliate/affiliates/'+CHAR(13)+CHAR(13)+'  sincerelly,'+CHAR(13)+CHAR(13)+'    Your site Team',0,'English');
INSERT INTO pa_emailtemplates VALUES (2,'AFF_EMAIL_NTF_SIGNUP','New affiliate signup','POST Affiliate Pro Email notification'+CHAR(13)+CHAR(13)+'New affiliate joined the affiliate program. Affiliate details:'+CHAR(13)+CHAR(13)+'Name: $Affiliate_name'+CHAR(13)+'Username/email: $Affiliate_username'+CHAR(13)+'Website: $Affiliate_website'+CHAR(13)+'Country: $Affiliate_country'+CHAR(13)+'Status: $Affiliate_status ',0,'English');
INSERT INTO pa_emailtemplates VALUES (3,'AFF_EMAIL_NTF_SALE','New sale','POST Affiliate Pro Email notification'+CHAR(13)+CHAR(13)+'New sale was registered by affiliate program. Sale details:'+CHAR(13)+CHAR(13)+'Transaction ID:  $Sale_id'+CHAR(13)+'Commission:  $Sale_commission'+CHAR(13)+'Total cost:  $Sale_totalcost'+CHAR(13)+'OrderID:  $Sale_orderid'+CHAR(13)+'ProductID:  $Sale_productid'+CHAR(13)+'Date&time:  $Sale_date'+CHAR(13)+'Affiliate:  $Sale_affiliate'+CHAR(13)+'Status:  $Sale_status'+CHAR(13)+'IP address:  $Sale_ip'+CHAR(13)+'Referrer:  $Sale_referrer'+CHAR(13)+'',0,'English');
INSERT INTO pa_emailtemplates VALUES (4,'AFF_EMAIL_DAILY_REP','Daily report for $Date','Daily report for $Date'+CHAR(13)+CHAR(13)+'Impressions:  $Impressions'+CHAR(13)+CHAR(13)+'Clicks:  $Clicks'+CHAR(13)+CHAR(13)+'Sales'+CHAR(13)+'-----------------------------------'+CHAR(13)+'Approved:  $Sales_approved'+CHAR(13)+'2nd tier approved: $Sales_approved_2ndtier'+CHAR(13)+CHAR(13)+'Waiting for approval: $Sales_waitingapproval'+CHAR(13)+'2nd tier waiting for approval: $Sales_waitingapproval_2ndtier'+CHAR(13)+CHAR(13)+'Declined:  $Sales_declined'+CHAR(13)+'2nd tier declined:  $Sales_declined_2ndtier'+CHAR(13)+CHAR(13)+''+CHAR(13)+'Commissions'+CHAR(13)+'-----------------------------------'+CHAR(13)+'Approved:  $Commissions_approved'+CHAR(13)+'2nd tier approved: $Commissions_approved_2ndtier'+CHAR(13)+CHAR(13)+'Waiting for approval: $Commissions_waitingapproval'+CHAR(13)+'2nd tier waiting for approval: $Commissions_waitingapproval_2ndtier'+CHAR(13)+'-----------------------------------'+CHAR(13)+CHAR(13)+'Declined:  $Commissions_declined'+CHAR(13)+'2nd tier declined:  $Commissions_declined_2ndtier'+CHAR(13)+CHAR(13)+'',0,'English');
INSERT INTO pa_emailtemplates VALUES (5,'AFF_EMAIL_AF_NTF_SGN','New affiliate signup','POST Affiliate Pro Email notification'+CHAR(13)+CHAR(13)+'New affiliate joined the affiliate program. Affiliate details:'+CHAR(13)+CHAR(13)+'Username/email: $Affiliate_username'+CHAR(13)+'Website: $Affiliate_website'+CHAR(13)+'Country: $Affiliate_country'+CHAR(13)+'Status: $Affiliate_status ',0,'English');
INSERT INTO pa_emailtemplates VALUES (6,'AFF_EMAIL_AF_NTF_SLE','New sale commission','POST Affiliate Pro Email notification'+CHAR(13)+CHAR(13)+'New sale was registered by affiliate program. Sale details:'+CHAR(13)+CHAR(13)+'Commission:  $Sale_commission'+CHAR(13)+'OrderID:  $Sale_orderid'+CHAR(13)+'ProductID:  $Sale_productid'+CHAR(13)+'Date&time:  $Sale_date'+CHAR(13)+'Status:  $Sale_status'+CHAR(13)+'IP address:  $Sale_ip'+CHAR(13)+'Referrer:  $Sale_referrer'+CHAR(13)+'',0,'English');
INSERT INTO pa_emailtemplates VALUES (7,'AFF_EMAIL_AF_DL_REP','Daily report','Daily report for $Date'+CHAR(13)+CHAR(13)+'Impressions:  $Impressions'+CHAR(13)+CHAR(13)+'Clicks:  $Clicks'+CHAR(13)+CHAR(13)+'Sales'+CHAR(13)+'-----------------------------------'+CHAR(13)+'Approved:  $Sales_approved'+CHAR(13)+'2nd tier approved: $Sales_approved_2ndtier'+CHAR(13)+CHAR(13)+'Waiting for approval: $Sales_waitingapproval'+CHAR(13)+'2nd tier waiting for approval: $Sales_waitingapproval_2ndtier'+CHAR(13)+CHAR(13)+'Declined:  $Sales_declined'+CHAR(13)+'2nd tier declined:  $Sales_declined_2ndtier'+CHAR(13)+CHAR(13)+''+CHAR(13)+'Commissions'+CHAR(13)+'-----------------------------------'+CHAR(13)+'Approved:  $Commissions_approved'+CHAR(13)+'2nd tier approved: $Commissions_approved_2ndtier'+CHAR(13)+CHAR(13)+'Waiting for approval: $Commissions_waitingapproval'+CHAR(13)+'2nd tier waiting for approval: $Commissions_waitingapproval_2ndtier'+CHAR(13)+'-----------------------------------'+CHAR(13)+CHAR(13)+'Declined:  $Commissions_declined'+CHAR(13)+'2nd tier declined:  $Commissions_declined_2ndtier'+CHAR(13)+'',0,'English');
INSERT INTO pa_emailtemplates VALUES (11,'AFF_EMAIL_FORGOTPASS','Forgot password','Dear $Affiliate_name,'+CHAR(13)+CHAR(13)+'check your password details below.'+CHAR(13)+CHAR(13)+'Your username is: $Affiliate_username'+CHAR(13)+'Your password is: $Affiliate_password'+CHAR(13)+'You can log in into your control panel in url: http://www.yoursite.com/affiliate/affiliates/'+CHAR(13)+CHAR(13)+'  sincerelly,'+CHAR(13)+CHAR(13)+'    Your site Team',0,'English');

CREATE TABLE seq_pa_emailtemps (
  id int NOT NULL default '0'
);

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

