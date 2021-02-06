

CREATE TABLE pa_merchants(
merchantid INT UNSIGNED NOT NULL,
username VARCHAR(30) NOT NULL,
password VARCHAR(60) NOT NULL,
email VARCHAR(100),
dateinserted DATETIME,
datedeleted DATETIME,
deleted TINYINT DEFAULT 0,
disabled TINYINT DEFAULT 0 NOT NULL,
weburl TEXT,
contactname VARCHAR(200),
payeename VARCHAR(200),
paypal_email VARCHAR(150),
tax_ssn VARCHAR(100),
company_name VARCHAR(100),
street VARCHAR(150),
city VARCHAR(150),
state VARCHAR(150),
country VARCHAR(100),
zipcode VARCHAR(10),
phone VARCHAR(50),
fax VARCHAR(50),
PRIMARY KEY (merchantid),
INDEX IDX_Entity_1_1 (username,password,deleted),
UNIQUE IDX_unique_name (username,deleted));


CREATE TABLE pa_campaigns(
campaignid INT UNSIGNED NOT NULL,
name VARCHAR(100),
description TEXT,
dateinserted DATETIME,
deleted TINYINT DEFAULT 0 NOT NULL,
disabled TINYINT DEFAULT 0 NOT NULL,
signupbanner VARCHAR(250),
cookielifetime INT NOT NULL,
clickapproval TINYINT,
saleapproval TINYINT,
policy TINYINT,
commtype TINYINT NOT NULL,
products TEXT,
PRIMARY KEY (campaignid));


CREATE TABLE pa_affiliates(
affiliateid INT UNSIGNED NOT NULL,
username VARCHAR(60) NOT NULL,
password VARCHAR(60) NOT NULL,
contactname VARCHAR(100),
company_name VARCHAR(100),
weburl VARCHAR(250),
street VARCHAR(100),
city VARCHAR(100),
state VARCHAR(100),
country VARCHAR(100),
zipcode VARCHAR(10),
phone VARCHAR(50),
fax VARCHAR(50),
tax_ssn VARCHAR(100),
paypal_email VARCHAR(100),
status TINYINT DEFAULT 0 NOT NULL,
min_payout INT,
notes TEXT,
dateinserted DATETIME,
dateapproved DATETIME,
deleted TINYINT DEFAULT 0 NOT NULL,
parentaffiliateid INT UNSIGNED,
bank_accountname TEXT,
bank_name TEXT,
bank_account TEXT,
bank_swift TEXT,
bank_address TEXT,
bank_code TEXT,
payableto VARCHAR(100),
payout_type TINYINT,
mb_email VARCHAR(100),
FOREIGN KEY (parentaffiliateid) REFERENCES pa_affiliates (affiliateid),
PRIMARY KEY (affiliateid),
INDEX IDX_pa_affiliates_1 (deleted),
INDEX IDX_pa_affiliates_2 (username,password));


CREATE TABLE pa_campaigncategories(
campcategoryid INT UNSIGNED NOT NULL,
name VARCHAR(100),
deleted TINYINT DEFAULT 0 NOT NULL,
clickcommission FLOAT,
salecommission FLOAT,
recurringcommission FLOAT,
recurringcommtype VARCHAR(5),
recurringcommdate INT,
recurringdatetype TINYINT,
campaignid INT UNSIGNED,
salecommtype VARCHAR(5),
stsalecommtype VARCHAR(5),
st2clickcommission FLOAT,
st2salecommission FLOAT,
st3clickcommission FLOAT,
st3salecommission FLOAT,
st4clickcommission FLOAT,
st4salecommission FLOAT,
st5clickcommission FLOAT,
st5salecommission FLOAT,
st6clickcommission FLOAT,
st6salecommission FLOAT,
st7clickcommission FLOAT,
st7salecommission FLOAT,
st8clickcommission FLOAT,
st8salecommission FLOAT,
st9clickcommission FLOAT,
st9salecommission FLOAT,
st10clickcommission FLOAT,
st10salecommission FLOAT,
strecurringcommtype VARCHAR(5),
st2recurringcommission FLOAT,
st3recurringcommission FLOAT,
st4recurringcommission FLOAT,
st5recurringcommission FLOAT,
st6recurringcommission FLOAT,
st7recurringcommission FLOAT,
st8recurringcommission FLOAT,
st9recurringcommission FLOAT,
st10recurringcommission FLOAT,
FOREIGN KEY (campaignid) REFERENCES pa_campaigns (campaignid),
PRIMARY KEY (campcategoryid),
INDEX IDX_pa_affiliatecategories_1 (campaignid));


CREATE TABLE pa_banners(
bannerid INT UNSIGNED NOT NULL,
description TEXT,
destinationurl TEXT,
sourceurl TEXT,
flashsource TEXT,
bannertype TINYINT,
deleted TINYINT DEFAULT 0,
campaignid INT UNSIGNED,
FOREIGN KEY (campaignid) REFERENCES pa_campaigns (campaignid),
PRIMARY KEY (bannerid),
INDEX IDX_pa_banners_1 (campaignid));


CREATE TABLE pa_emailtemplates(
emailtempsid INT UNSIGNED NOT NULL,
categorycode VARCHAR(20) NOT NULL,
emailsubject VARCHAR(250),
emailtext TEXT,
deleted TINYINT DEFAULT 0,
lang VARCHAR(10) NOT NULL,
PRIMARY KEY (emailtempsid));


CREATE TABLE pa_impressions(
impressionid INT NOT NULL AUTO_INCREMENT,
dateimpression DATETIME NOT NULL,
bannerid INT UNSIGNED,
affiliateid INT UNSIGNED,
all_imps_count INT DEFAULT 0,
unique_imps_count INT DEFAULT 0,
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid),
FOREIGN KEY (bannerid) REFERENCES pa_banners (bannerid),
PRIMARY KEY (impressionid),
INDEX IDX_pa_impressions_1 (dateimpression),
INDEX IDX_pa_impressions_2 (bannerid),
INDEX IDX_pa_impressions_3 (bannerid,affiliateid,dateimpression),
INDEX IDX_pa_impressions_4 (affiliateid));


CREATE TABLE pa_accounting(
accountingid INT UNSIGNED NOT NULL,
dateinserted DATETIME NOT NULL,
datefrom DATETIME NOT NULL,
dateto DATETIME NOT NULL,
note TEXT,
paypalfile VARCHAR(100),
mbfile VARCHAR(100),
wirefile VARCHAR(100),
PRIMARY KEY (accountingid),
UNIQUE UC_accountingid (accountingid));


CREATE TABLE pa_affiliatescampaigns(
affcampid INT UNSIGNED NOT NULL,
campcategoryid INT UNSIGNED,
affiliateid INT UNSIGNED,
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid),
FOREIGN KEY (campcategoryid) REFERENCES pa_campaigncategories (campcategoryid),
PRIMARY KEY (affcampid),
UNIQUE UC_affcampid (affcampid));


CREATE TABLE pa_history(
historyid INT NOT NULL AUTO_INCREMENT,
type TINYINT NOT NULL,
value TEXT NOT NULL,
dateinserted DATETIME NOT NULL,
hfile TEXT,
line INT,
ip VARCHAR(20),
PRIMARY KEY (historyid),
UNIQUE UC_historyid (historyid));


CREATE TABLE pa_settings(
settingsid INT NOT NULL AUTO_INCREMENT,
code VARCHAR(50) NOT NULL,
value TEXT NOT NULL,
affiliateid INT UNSIGNED,
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid),
PRIMARY KEY (settingsid),
UNIQUE UC_settingsid (settingsid));


CREATE TABLE pa_recurringcommissions(
recurringcommid INT NOT NULL AUTO_INCREMENT,
commission FLOAT NOT NULL,
commtype VARCHAR(5),
commdate TINYINT NOT NULL,
datetype TINYINT NOT NULL,
status TINYINT DEFAULT 0 NOT NULL,
deleted TINYINT DEFAULT 0,
campcategoryid INT UNSIGNED,
affiliateid INT UNSIGNED,
originaltransid INT UNSIGNED,
dateinserted DATETIME NOT NULL,
stcommtype VARCHAR(5),
st2affiliateid INT UNSIGNED,
st2commission FLOAT,
st3affiliateid INT UNSIGNED,
st3commission FLOAT,
st4affiliateid INT UNSIGNED,
st4commission FLOAT,
st5affiliateid INT UNSIGNED,
st5commission FLOAT,
st6affiliateid INT UNSIGNED,
st6commission FLOAT,
st7affiliateid INT UNSIGNED,
st7commission FLOAT,
st8affiliateid INT UNSIGNED,
st8commission FLOAT,
st9affiliateid INT UNSIGNED,
st9commission FLOAT,
st10affiliateid INT UNSIGNED,
st10commission FLOAT,
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid),
FOREIGN KEY (campcategoryid) REFERENCES pa_campaigncategories (campcategoryid),
FOREIGN KEY (originaltransid) REFERENCES pa_transactions (transid),
PRIMARY KEY (recurringcommid),
UNIQUE UC_recurringcommid (recurringcommid));


CREATE TABLE pa_transactions(
transid INT UNSIGNED NOT NULL AUTO_INCREMENT,
status TINYINT DEFAULT 0 NOT NULL,
dateinserted DATETIME,
dateapproved DATETIME,
transtype TINYINT DEFAULT 0,
payoutstatus TINYINT DEFAULT 1,
datepayout DATETIME,
cookiestatus TINYINT,
orderid VARCHAR(200),
totalcost FLOAT,
bannerid INT UNSIGNED,
transkind TINYINT DEFAULT 0,
refererurl VARCHAR(250),
affiliateid INT UNSIGNED,
campcategoryid INT UNSIGNED,
parenttransid INT UNSIGNED,
commission FLOAT DEFAULT 0,
ip VARCHAR(20),
recurringcommid INT,
accountingid INT UNSIGNED,
productid VARCHAR(200),
FOREIGN KEY (accountingid) REFERENCES pa_accounting (accountingid),
FOREIGN KEY (campcategoryid) REFERENCES pa_campaigncategories (campcategoryid),
FOREIGN KEY (affiliateid) REFERENCES pa_affiliates (affiliateid),
FOREIGN KEY (bannerid) REFERENCES pa_banners (bannerid),
FOREIGN KEY (recurringcommid) REFERENCES pa_recurringcommissions (recurringcommid),
FOREIGN KEY (parenttransid) REFERENCES pa_transactions (transid),
PRIMARY KEY (transid),
INDEX IDX_pa_transactions_1 (affiliateid),
INDEX IDX_pa_transactions_2 (dateinserted),
INDEX IDX_pa_transactions_3 (transkind,transtype,status),
INDEX IDX_pa_transactions_4 (campcategoryid),
INDEX IDX_pa_transactions_5 (ip));

