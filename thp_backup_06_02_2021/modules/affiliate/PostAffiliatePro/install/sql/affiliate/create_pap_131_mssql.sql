

CREATE TABLE pa_merchants(
merchantid int NOT NULL CONSTRAINT PK_pa_merchants1 PRIMARY KEY,
username varchar(30) NOT NULL,
password varchar(60) NOT NULL,
email varchar(100) NULL,
dateinserted datetime NULL,
datedeleted datetime NULL,
deleted tinyint DEFAULT 0 NULL,
disabled tinyint DEFAULT 0 NOT NULL,
weburl text NULL,
contactname varchar(200) NULL,
payeename varchar(200) NULL,
paypal_email varchar(150) NULL,
tax_ssn varchar(100) NULL,
company_name varchar(100) NULL,
street varchar(150) NULL,
city varchar(150) NULL,
state varchar(150) NULL,
country varchar(100) NULL,
zipcode varchar(10) NULL,
phone varchar(50) NULL,
fax varchar(50) NULL)
;

CREATE INDEX IDX_Entity_1_1 ON pa_merchants (username,password,deleted)
;
CREATE UNIQUE INDEX IDX_unique_name ON pa_merchants (username,deleted)
;

CREATE TABLE pa_campaigns(
campaignid int NOT NULL CONSTRAINT PK_pa_campaigns1 PRIMARY KEY,
name varchar(100) NULL,
description text NULL,
dateinserted datetime NULL,
deleted tinyint DEFAULT 0 NOT NULL,
disabled tinyint DEFAULT 0 NOT NULL,
signupbanner varchar(250) NULL,
cookielifetime int NOT NULL,
clickapproval tinyint NULL,
saleapproval tinyint NULL,
policy tinyint NULL,
commtype tinyint NOT NULL,
products text NULL)
;


CREATE TABLE pa_affiliates(
affiliateid int NOT NULL CONSTRAINT PK_pa_affiliates1 PRIMARY KEY,
username varchar(60) NOT NULL,
password varchar(60) NOT NULL,
contactname varchar(100) NULL,
company_name varchar(100) NULL,
weburl varchar(250) NULL,
street varchar(100) NULL,
city varchar(100) NULL,
state varchar(100) NULL,
country varchar(100) NULL,
zipcode varchar(10) NULL,
phone varchar(50) NULL,
fax varchar(50) NULL,
tax_ssn varchar(100) NULL,
paypal_email varchar(100) NULL,
status tinyint DEFAULT 0 NOT NULL,
min_payout int NULL,
notes text NULL,
dateinserted datetime NULL,
dateapproved datetime NULL,
deleted tinyint DEFAULT 0 NOT NULL,
parentaffiliateid int NULL,
bank_accountname text NULL,
bank_name text NULL,
bank_account text NULL,
bank_swift text NULL,
bank_address text NULL,
bank_code text NULL,
payableto varchar(100) NULL,
payout_type tinyint NULL,
mb_email varchar(100) NULL)
;

CREATE INDEX IDX_pa_affiliates_1 ON pa_affiliates (deleted)
;
CREATE INDEX IDX_pa_affiliates_2 ON pa_affiliates (username,password)
;

CREATE TABLE pa_campaigncategories(
campcategoryid int NOT NULL CONSTRAINT PK_pa_campaigncategories1 PRIMARY KEY,
name varchar(100) NULL,
deleted tinyint DEFAULT 0 NOT NULL,
clickcommission FLOAT NULL,
salecommission FLOAT NULL,
recurringcommission FLOAT NULL,
recurringcommtype varchar(5) NULL,
recurringcommdate int NULL,
recurringdatetype tinyint NULL,
campaignid int NULL,
salecommtype varchar(5) NULL,
stsalecommtype varchar(5) NULL,
st2clickcommission FLOAT NULL,
st2salecommission FLOAT NULL,
st3clickcommission FLOAT NULL,
st3salecommission FLOAT NULL,
st4clickcommission FLOAT NULL,
st4salecommission FLOAT NULL,
st5clickcommission FLOAT NULL,
st5salecommission FLOAT NULL,
st6clickcommission FLOAT NULL,
st6salecommission FLOAT NULL,
st7clickcommission FLOAT NULL,
st7salecommission FLOAT NULL,
st8clickcommission FLOAT NULL,
st8salecommission FLOAT NULL,
st9clickcommission FLOAT NULL,
st9salecommission FLOAT NULL,
st10clickcommission FLOAT NULL,
st10salecommission FLOAT NULL,
strecurringcommtype varchar(5) NULL,
st2recurringcommission FLOAT NULL,
st3recurringcommission FLOAT NULL,
st4recurringcommission FLOAT NULL,
st5recurringcommission FLOAT NULL,
st6recurringcommission FLOAT NULL,
st7recurringcommission FLOAT NULL,
st8recurringcommission FLOAT NULL,
st9recurringcommission FLOAT NULL,
st10recurringcommission FLOAT NULL)
;

CREATE INDEX IDX_pa_affiliatecategories_1 ON pa_campaigncategories (campaignid)
;

CREATE TABLE pa_banners(
bannerid int NOT NULL CONSTRAINT PK_pa_banners1 PRIMARY KEY,
description text NULL,
destinationurl text NULL,
sourceurl text NULL,
flashsource text NULL,
bannertype tinyint NULL,
deleted tinyint DEFAULT 0 NULL,
campaignid int NULL)
;

CREATE INDEX IDX_pa_banners_1 ON pa_banners (campaignid)
;

CREATE TABLE pa_emailtemplates(
emailtempsid int NOT NULL CONSTRAINT PK_pa_emailtemplates1 PRIMARY KEY,
categorycode varchar(20) NOT NULL,
emailsubject varchar(250) NULL,
emailtext text NULL,
deleted tinyint DEFAULT 0 NULL,
lang varchar(10) NOT NULL)
;


CREATE TABLE pa_impressions(
impressionid int identity(1,1) NOT NULL CONSTRAINT PK_pa_impressions1 PRIMARY KEY,
dateimpression datetime NOT NULL,
bannerid int NULL,
affiliateid int NULL,
all_imps_count int DEFAULT 0 NULL,
unique_imps_count int DEFAULT 0 NULL)
;

CREATE INDEX IDX_pa_impressions_1 ON pa_impressions (dateimpression)
;
CREATE INDEX IDX_pa_impressions_2 ON pa_impressions (bannerid)
;
CREATE INDEX IDX_pa_impressions_3 ON pa_impressions (bannerid,affiliateid,dateimpression)
;
CREATE INDEX IDX_pa_impressions_4 ON pa_impressions (affiliateid)
;


CREATE TABLE pa_accounting(
accountingid int NOT NULL CONSTRAINT PK_pa_accounting1 PRIMARY KEY,
dateinserted datetime NOT NULL,
datefrom datetime NOT NULL,
dateto datetime NOT NULL,
note text NULL,
paypalfile varchar(100) NULL,
mbfile varchar(100) NULL,
wirefile varchar(100) NULL,
CONSTRAINT UC_pa_accounting1 UNIQUE(accountingid))
;


CREATE TABLE pa_affiliatescampaigns(
affcampid int NOT NULL CONSTRAINT PK_pa_affiliatescampaigns1 PRIMARY KEY,
campcategoryid int NULL,
affiliateid int NULL,
CONSTRAINT UC_pa_affiliatescampaigns1 UNIQUE(affcampid))
;


CREATE TABLE pa_history(
historyid int identity(1,1) NOT NULL CONSTRAINT PK_pa_history1 PRIMARY KEY,
type tinyint NOT NULL,
value text NOT NULL,
dateinserted datetime NOT NULL,
hfile text NULL,
line int NULL,
ip varchar(20) NULL,
CONSTRAINT UC_pa_history1 UNIQUE(historyid))
;


CREATE TABLE pa_settings(
settingsid int identity(1,1) NOT NULL CONSTRAINT PK_pa_settings1 PRIMARY KEY,
code varchar(50) NOT NULL,
value text NOT NULL,
affiliateid int NULL,
CONSTRAINT UC_pa_settings1 UNIQUE(settingsid))
;


CREATE TABLE pa_recurringcommissions(
recurringcommid int identity(1,1) NOT NULL CONSTRAINT PK_pa_recurringcommissions1 PRIMARY KEY,
commission FLOAT NOT NULL,
commtype varchar(5) NULL,
commdate tinyint NOT NULL,
datetype tinyint NOT NULL,
status tinyint DEFAULT 0 NOT NULL,
deleted tinyint DEFAULT 0 NULL,
campcategoryid int NULL,
affiliateid int NULL,
originaltransid int NULL,
dateinserted datetime NOT NULL,
stcommtype varchar(5) NULL,
st2affiliateid int NULL,
st2commission FLOAT NULL,
st3affiliateid int NULL,
st3commission FLOAT NULL,
st4affiliateid int NULL,
st4commission FLOAT NULL,
st5affiliateid int NULL,
st5commission FLOAT NULL,
st6affiliateid int NULL,
st6commission FLOAT NULL,
st7affiliateid int NULL,
st7commission FLOAT NULL,
st8affiliateid int NULL,
st8commission FLOAT NULL,
st9affiliateid int NULL,
st9commission FLOAT NULL,
st10affiliateid int NULL,
st10commission FLOAT NULL,
CONSTRAINT UC_pa_recurringcommissions1 UNIQUE(recurringcommid))
;


CREATE TABLE pa_transactions(
transid int identity(1,1) NOT NULL CONSTRAINT PK_pa_transactions1 PRIMARY KEY,
status tinyint DEFAULT 0 NOT NULL,
dateinserted datetime NULL,
dateapproved datetime NULL,
transtype tinyint DEFAULT 0 NULL,
payoutstatus tinyint DEFAULT 1 NULL,
datepayout datetime NULL,
cookiestatus tinyint NULL,
orderid varchar(200) NULL,
totalcost FLOAT NULL,
bannerid int NULL,
transkind tinyint DEFAULT 0 NULL,
refererurl varchar(250) NULL,
affiliateid int NULL,
campcategoryid int NULL,
parenttransid int NULL,
commission FLOAT DEFAULT 0 NULL,
ip varchar(20) NULL,
recurringcommid int NULL,
accountingid int NULL,
productid varchar(200) NULL)
;

CREATE INDEX IDX_pa_transactions_1 ON pa_transactions (affiliateid)
;
CREATE INDEX IDX_pa_transactions_2 ON pa_transactions (dateinserted)
;
CREATE INDEX IDX_pa_transactions_3 ON pa_transactions (transkind,transtype,status)
;
CREATE INDEX IDX_pa_transactions_4 ON pa_transactions (campcategoryid)
;
CREATE INDEX IDX_pa_transactions_5 ON pa_transactions (ip)
;





ALTER TABLE pa_affiliates
ADD CONSTRAINT FK_pa_affiliates_1 
FOREIGN KEY (parentaffiliateid) REFERENCES pa_affiliates (affiliateid)
;


ALTER TABLE pa_campaigncategories
ADD CONSTRAINT FK_pa_campaigncategories_1 
FOREIGN KEY (campaignid) REFERENCES pa_campaigns (campaignid)
;


ALTER TABLE pa_banners
ADD CONSTRAINT FK_pa_banners_1 
FOREIGN KEY (campaignid) REFERENCES pa_campaigns (campaignid)
;



ALTER TABLE pa_impressions
ADD CONSTRAINT FK_pa_impressions_1 
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid)
;

ALTER TABLE pa_impressions
ADD CONSTRAINT FK_pa_impressions_2 
FOREIGN KEY (bannerid) REFERENCES pa_banners (bannerid)
;



ALTER TABLE pa_affiliatescampaigns
ADD CONSTRAINT FK_pa_affiliatescampaigns_1 
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid)
;

ALTER TABLE pa_affiliatescampaigns
ADD CONSTRAINT FK_pa_affiliatescampaigns_2 
FOREIGN KEY (campcategoryid) REFERENCES pa_campaigncategories (campcategoryid)
;



ALTER TABLE pa_settings
ADD CONSTRAINT FK_pa_settings_1 
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid)
;


ALTER TABLE pa_recurringcommissions
ADD CONSTRAINT FK_pa_recurringcommissions_1 
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid)
;

ALTER TABLE pa_recurringcommissions
ADD CONSTRAINT FK_pa_recurringcommissions_2 
FOREIGN KEY (campcategoryid) REFERENCES pa_campaigncategories (campcategoryid)
;

ALTER TABLE pa_recurringcommissions
ADD CONSTRAINT FK_pa_recurringcommissions_3 
FOREIGN KEY (originaltransid) REFERENCES pa_transactions (transid)
;


ALTER TABLE pa_transactions
ADD CONSTRAINT FK_pa_transactions_1 
FOREIGN KEY (accountingid) REFERENCES pa_accounting (accountingid)
;

ALTER TABLE pa_transactions
ADD CONSTRAINT FK_pa_transactions_2 
FOREIGN KEY (campcategoryid) REFERENCES pa_campaigncategories (campcategoryid)
;

ALTER TABLE pa_transactions
ADD CONSTRAINT FK_pa_transactions_3 
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid)
;

ALTER TABLE pa_transactions
ADD CONSTRAINT FK_pa_transactions_4 
FOREIGN KEY (bannerid) REFERENCES pa_banners (bannerid)
;

ALTER TABLE pa_transactions
ADD CONSTRAINT FK_pa_transactions_5 
FOREIGN KEY (recurringcommid) REFERENCES pa_recurringcommissions (recurringcommid)
;

ALTER TABLE pa_transactions
ADD CONSTRAINT FK_pa_transactions_6 
FOREIGN KEY (parenttransid) REFERENCES pa_transactions (transid)
;

