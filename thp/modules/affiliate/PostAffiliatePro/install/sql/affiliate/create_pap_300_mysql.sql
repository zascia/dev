
CREATE TABLE wd_g_history (
    historyid CHAR(8) NOT NULL,
    accountid CHAR(8),
    rtype TINYINT NOT NULL,
    value TEXT NOT NULL,
    dateinserted DATETIME NOT NULL,
    hfile TEXT,
    line INTEGER,
    ip VARCHAR(20),
    module VARCHAR(20) NOT NULL DEFAULT '',
    CONSTRAINT PK_wd_g_history PRIMARY KEY (historyid),
    KEY IDX_wd_g_history1(accountid)
);

CREATE TABLE wd_g_accounts (
    accountid CHAR(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    dateinserted DATETIME NOT NULL,
    rstatus TINYINT NOT NULL DEFAULT 0,
    CONSTRAINT PK_wd_g_accounts PRIMARY KEY (accountid),
    UNIQUE (name),
    UNIQUE KEY IDX_wd_g_accounts1(accountid)
);

CREATE TABLE wd_g_righttypes (
    righttypeid CHAR(8) NOT NULL,
    parentrighttypeid CHAR(8),
    module VARCHAR(20) NOT NULL DEFAULT '',
    category VARCHAR(40) NOT NULL,
    code VARCHAR(40) NOT NULL,
    righttype VARCHAR(20),
    dateinserted DATETIME NOT NULL,
    categorylangid VARCHAR(80) NOT NULL,
    rightlangid VARCHAR(80) NOT NULL,
    typelangid VARCHAR(80) NOT NULL,
    rorder INTEGER,
    CONSTRAINT PK_wd_g_righttypes PRIMARY KEY (righttypeid),
    UNIQUE KEY IDX_wd_g_righttypes1(righttypeid),
    KEY IDX_wd_g_righttypes2(parentrighttypeid)
);

CREATE TABLE wd_g_userprofiles (
    userprofileid CHAR(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    rtype VARCHAR(20) NOT NULL,
    accountid CHAR(8),
    CONSTRAINT PK_wd_g_userprofiles PRIMARY KEY (userprofileid),
    UNIQUE KEY IDX_wd_g_userprofiles1(userprofileid),
    KEY IDX_wd_g_userprofiles2(accountid)
);

CREATE TABLE wd_g_userrights (
    userrightid CHAR(8) NOT NULL,
    userprofileid CHAR(8) NOT NULL,
    righttypeid CHAR(8),
    CONSTRAINT PK_wd_g_userrights PRIMARY KEY (userrightid),
    KEY IDX_wd_g_userrights1(userprofileid),
    KEY IDX_wd_g_userrights2(righttypeid)
);

CREATE TABLE wd_g_settings (
    settingsid CHAR(8) NOT NULL,
    rtype TINYINT UNSIGNED NOT NULL,
    code VARCHAR(50) NOT NULL,
    value TEXT,
    accountid CHAR(8),
    userid CHAR(8),
    id1 CHAR(8),
    id2 CHAR(8),
    CONSTRAINT PK_wd_g_settings PRIMARY KEY (settingsid),
    KEY IDX_wd_g_settings1(accountid),
    KEY IDX_wd_g_settings2(userid)
);

CREATE TABLE wd_g_jobs (
    jobid CHAR(8) NOT NULL,
    rtype SMALLINT UNSIGNED,
    rstatus TINYINT UNSIGNED,
    progress BIGINT,
    datecreated DATETIME,
    datefinished DATETIME,
    PRIMARY KEY (jobid)
);

CREATE TABLE wd_pa_campaigns (
    campaignid CHAR(8) NOT NULL,
    accountid CHAR(8),
    name VARCHAR(100),
    description TEXT,
    shortdescription VARCHAR(200),
    dateinserted DATETIME,
    deleted TINYINT NOT NULL DEFAULT 0,
    disabled TINYINT NOT NULL DEFAULT 0,
    commtype TINYINT NOT NULL,
    products TEXT,
    CONSTRAINT PK_wd_pa_campaigns PRIMARY KEY (campaignid),
    UNIQUE KEY IDX_wd_pa_campaigns1(campaignid),
    KEY IDX_wd_pa_campaigns2(accountid)
);

CREATE TABLE wd_g_users (
    userid CHAR(8) NOT NULL,
    accountid CHAR(8) NOT NULL,
    refid VARCHAR(20),
    username VARCHAR(60) NOT NULL,
    rpassword VARCHAR(60) NOT NULL,
    name VARCHAR(100),
    surname VARCHAR(100),
    rstatus TINYINT NOT NULL DEFAULT 0,
    product VARCHAR(10) NOT NULL DEFAULT '',
    dateinserted DATETIME,
    dateapproved DATETIME,
    deleted TINYINT NOT NULL DEFAULT 0,
    userprofileid CHAR(8),
    rtype TINYINT NOT NULL,
    parentuserid CHAR(8),
    leftnumber INTEGER,
    rightnumber INTEGER,
    company_name VARCHAR(150),
    weburl VARCHAR(250),
    street VARCHAR(250),
    city VARCHAR(250),
    state VARCHAR(250),
    country VARCHAR(150),
    zipcode VARCHAR(40),
    phone VARCHAR(100),
    fax VARCHAR(100),
    tax_ssn VARCHAR(100),
    data1 VARCHAR(250),
    data2 VARCHAR(250),
    data3 VARCHAR(250),
    data4 VARCHAR(250),
    data5 VARCHAR(250),
    payoptid CHAR(8),
    originalparentid CHAR(8),
    flags TINYINT,
    CONSTRAINT PK_wd_g_users PRIMARY KEY (userid),
    KEY IDX_pa_affiliates_1(deleted),
    KEY IDX_pa_affiliates_2(username, rpassword),
    UNIQUE KEY IDX_wd_g_users3(userid),
    KEY IDX_wd_g_users4(accountid),
    KEY IDX_wd_g_users5(userprofileid),
    KEY IDX_wd_g_users6(parentuserid),
    KEY IDX_wd_g_users7(payoptid),
    KEY IDX_wd_g_users8(originalparentid)
);

CREATE TABLE wd_pa_campaigncategories (
    campcategoryid CHAR(8) NOT NULL,
    name VARCHAR(100),
    deleted TINYINT NOT NULL DEFAULT 0,
    cpmcommission FLOAT,
    clickcommission FLOAT,
    salecommission FLOAT,
    recurringcommission FLOAT,
    recurringcommtype VARCHAR(5),
    recurringcommdate INTEGER,
    recurringdatetype TINYINT,
    campaignid CHAR(8),
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
    CONSTRAINT PK_wd_pa_campaigncategories PRIMARY KEY (campcategoryid),
    KEY IDX_pa_affiliatecategories_1(campaignid),
    UNIQUE KEY IDX_wd_pa_campaigncategories2(campcategoryid)
);

CREATE TABLE wd_pa_banners (
    bannerid CHAR(8) NOT NULL,
    name VARCHAR(100),
    description TEXT,
    destinationurl TEXT,
    sourceurl TEXT,
    bannertype TINYINT,
    deleted TINYINT DEFAULT 0,
    campaignid CHAR(8),
    hidden TINYINT DEFAULT 0,
    size VARCHAR(11),
    dateinserted DATETIME,
    bannercategory char(8) NOT NULL,
    CONSTRAINT PK_wd_pa_banners PRIMARY KEY (bannerid),
    KEY IDX_pa_banners_1(campaignid),
    UNIQUE KEY IDX_wd_pa_banners2(bannerid)
);

CREATE TABLE wd_pa_bannercategories (
  bannercategoryid char(8) NOT NULL,
  name varchar(255) NOT NULL,
  PRIMARY KEY  (bannercategoryid)
);

CREATE TABLE wd_g_emailtemplates (
    emailtempsid CHAR(8) NOT NULL,
    categorycode VARCHAR(20) NOT NULL,
    emailsubject VARCHAR(250),
    emailtext TEXT,
    deleted TINYINT DEFAULT 0,
    lang VARCHAR(10) NOT NULL,
    accountid CHAR(8),
    CONSTRAINT PK_wd_g_emailtemplates PRIMARY KEY (emailtempsid),
    KEY IDX_wd_g_emailtemplates1(accountid)
);

CREATE TABLE wd_pa_impressions (
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
    CONSTRAINT PK_wd_pa_impressions PRIMARY KEY (impressionid),
    KEY IDX_pa_impressions_3(bannerid, affiliateid, dateimpression),
    KEY IDX_wd_pa_impressions2(bannerid),
    KEY IDX_wd_pa_impressions3(affiliateid),
    KEY IDX_wd_pa_impressions4(accountid)
);

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

CREATE TABLE wd_pa_transactions (
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
    CONSTRAINT PK_wd_pa_transactions PRIMARY KEY (transid),
    KEY IDX_pa_transactions_2(dateinserted),
    KEY IDX_pa_transactions_3(transkind, transtype, rstatus),
    KEY IDX_pa_transactions_4(campcategoryid),
    KEY IDX_wd_pa_transactions4(bannerid),
    KEY IDX_wd_pa_transactions5(affiliateid),
    KEY IDX_wd_pa_transactions6(parenttransid),
    UNIQUE KEY IDX_wd_pa_transactions7(transid),
    KEY IDX_wd_pa_transactions8(recurringcommid),
    KEY IDX_wd_pa_transactions9(accountingid),
    KEY IDX_wd_pa_transactions10(accountid)
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

CREATE TABLE wd_pa_affiliatescampaigns (
    affcampid CHAR(8) NOT NULL,
    campcategoryid CHAR(8),
    affiliateid CHAR(8),
    campaignid CHAR(8) NOT NULL,
    rstatus TINYINT NOT NULL,
    declinereason VARCHAR(250),
    CONSTRAINT PK_wd_pa_affiliatescampaigns PRIMARY KEY (affcampid),
    KEY IDX_wd_pa_affiliatescampaigns1(campcategoryid),
    KEY IDX_wd_pa_affiliatescampaigns2(affiliateid),
    KEY IDX_wd_pa_affiliatescampaigns3(campaignid)
);

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

CREATE TABLE wd_pa_recurringcommissions (
    recurringcommid CHAR(8) NOT NULL,
    commission FLOAT NOT NULL,
    commtype VARCHAR(5),
    commdate TINYINT NOT NULL,
    datetype TINYINT NOT NULL,
    rstatus TINYINT NOT NULL DEFAULT 0,
    deleted TINYINT DEFAULT 0,
    campcategoryid CHAR(8),
    affiliateid CHAR(8),
    originaltransid CHAR(8),
    dateinserted DATETIME NOT NULL,
    stcommtype VARCHAR(5),
    st2affiliateid CHAR(8),
    st2commission FLOAT,
    st3affiliateid CHAR(8),
    st3commission FLOAT,
    st4affiliateid CHAR(8),
    st4commission FLOAT,
    st5affiliateid CHAR(8),
    st5commission FLOAT,
    st6affiliateid CHAR(8),
    st6commission FLOAT,
    st7affiliateid CHAR(8),
    st7commission FLOAT,
    st8affiliateid CHAR(8),
    st8commission FLOAT,
    st9affiliateid CHAR(8),
    st9commission FLOAT,
    st10affiliateid CHAR(8),
    st10commission FLOAT,
    CONSTRAINT PK_wd_pa_recurringcommissions PRIMARY KEY (recurringcommid),
    KEY IDX_wd_pa_recurringcommissions1(campcategoryid),
    KEY IDX_wd_pa_recurringcommissions2(affiliateid),
    KEY IDX_wd_pa_recurringcommissions3(originaltransid),
    UNIQUE KEY IDX_wd_pa_recurringcommissions4(recurringcommid)
);

CREATE TABLE wd_pa_accounting (
    accountingid CHAR(8) NOT NULL,
    dateinserted DATETIME NOT NULL,
    datefrom DATETIME NOT NULL,
    dateto DATETIME NOT NULL,
    note TEXT,
    rfile VARCHAR(200),
    mbfile VARCHAR(100),
    wirefile VARCHAR(100),
    CONSTRAINT PK_wd_pa_accounting PRIMARY KEY (accountingid),
    UNIQUE KEY IDX_wd_pa_accounting1(accountingid)
);

CREATE TABLE wd_g_groups (
    groupid CHAR(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    rstatus TINYINT NOT NULL,
    product VARCHAR(10) NOT NULL DEFAULT '',
    dateinserted DATETIME,
    deleted TINYINT NOT NULL DEFAULT 0,
    parentgroupid CHAR(8),
    leftnumber INTEGER,
    rightnumber INTEGER,
    CONSTRAINT PK_wd_g_groups PRIMARY KEY (groupid),
    UNIQUE KEY IDX_wd_g_groups1(groupid),
    KEY IDX_wd_g_groups2(parentgroupid)
);

CREATE TABLE wd_g_usergroups (
    usergroupid CHAR(8) NOT NULL,
    userid CHAR(8) NOT NULL,
    groupid CHAR(8) NOT NULL,
    CONSTRAINT PK_wd_g_usergroups PRIMARY KEY (usergroupid),
    KEY IDX_wd_g_usergroups1(userid),
    KEY IDX_wd_g_usergroups2(groupid)
);

CREATE TABLE wd_pa_payoutoptions (
    payoptid CHAR(8) NOT NULL,
    accountid CHAR(8) NOT NULL,
    name VARCHAR(100) NOT NULL,
    exporttype TINYINT NOT NULL,
    exportformat TEXT,
    disabled TINYINT NOT NULL DEFAULT 0,
    langid VARCHAR(80) NOT NULL,
    rorder TINYINT NOT NULL,
    paybuttonformat TEXT,
    PRIMARY KEY (payoptid),
    UNIQUE KEY IDX_wd_pa_payoutoptions1(payoptid),
    KEY IDX_wd_pa_payoutoptions2(accountid)
);

CREATE TABLE wd_pa_payoutfields (
    payfieldid CHAR(8) NOT NULL,
    payoptid CHAR(8) NOT NULL,
    code VARCHAR(20) NOT NULL,
    name VARCHAR(40) NOT NULL,
    langid VARCHAR(80) NOT NULL,
    rtype TINYINT NOT NULL,
    mandatory TINYINT NOT NULL DEFAULT 0,
    visible TINYINT NOT NULL,
    availablevalues TEXT,
    rorder TINYINT UNSIGNED NOT NULL,
    value TEXT,
    PRIMARY KEY (payfieldid),
    KEY IDX_wd_pa_payoutfields1(payoptid)
);

CREATE TABLE wd_g_listviews (
    viewid CHAR(8) NOT NULL,
    accountid CHAR(8) NOT NULL,
    userid CHAR(8) NOT NULL,
    name VARCHAR(30) NOT NULL,
    rcolumns TEXT NOT NULL,
    listname VARCHAR(60) NOT NULL,
    PRIMARY KEY (viewid, accountid, userid),
    KEY IDX_wd_g_listviews1(accountid),
    KEY IDX_wd_g_listviews2(userid)
);

CREATE TABLE wd_g_messages (
    messageid CHAR(8) NOT NULL,
    rtype TINYINT NOT NULL,
    dateinserted DATETIME NOT NULL,
    title VARCHAR(100) NOT NULL,
    rtext TEXT NOT NULL,
    deleted TINYINT NOT NULL DEFAULT 0,
    accountid CHAR(8),
    datevalidfrom DATETIME,
    datevalidto DATETIME,
    active TINYINT UNSIGNED DEFAULT 0,
    showtoall TINYINT UNSIGNED DEFAULT 0,
    PRIMARY KEY (messageid),
    KEY IDX_wd_g_messages1(accountid),
    UNIQUE KEY IDX_wd_g_messages2(messageid)
);

CREATE TABLE wd_g_messagestousers (
    messagetouserid CHAR(8) NOT NULL,
    messageid CHAR(8),
    userid CHAR(8),
    email VARCHAR(80),
    rstatus TINYINT NOT NULL,
    PRIMARY KEY (messagetouserid),
    KEY IDX_wd_g_messagestousers1(messageid),
    KEY IDX_wd_g_messagestousers2(userid)
);

CREATE TABLE wd_pa_rules (
    ruleid CHAR(8) NOT NULL,
    name VARCHAR(100),
    cond_when VARCHAR(20),
    cond_in VARCHAR(20),
    cond_is VARCHAR(20),
    cond_value1 VARCHAR(40),
    cond_value2 VARCHAR(40),
    cond_action VARCHAR(40),
    cond_action_value VARCHAR(100),
    accountid CHAR(8) NOT NULL,
    campaignid CHAR(8) NOT NULL,
    PRIMARY KEY (ruleid, accountid, campaignid),
    KEY IDX_wd_pa_rules1(accountid),
    KEY IDX_wd_pa_rules2(campaignid)
);

CREATE TABLE wd_g_categories (
    catid CHAR(8) NOT NULL,
    parentcatid CHAR(8),
    name VARCHAR(100) NOT NULL,
    rstatus TINYINT NOT NULL,
    product VARCHAR(10) NOT NULL,
    description TEXT,
    dateinserted DATETIME NOT NULL,
    deleted TINYINT NOT NULL,
    PRIMARY KEY (catid),
    KEY IDX_wd_g_categories1(parentcatid),
    UNIQUE KEY IDX_wd_g_categories2(catid)
);

CREATE TABLE wd_pa_integration (
    integrationid CHAR(8) NOT NULL,
    integrationname VARCHAR(40),
    integrationlangconst VARCHAR(40),
    textbefore TEXT,
    textafter TEXT,
    deleted TINYINT,
    rorder TINYINT UNSIGNED,
    PRIMARY KEY (integrationid),
    UNIQUE KEY IDX_wd_pa_integration1(integrationid)
);

CREATE TABLE wd_pa_integrationsteps (
    intstepid CHAR(8) NOT NULL,
    integrationid CHAR(8) NOT NULL,
    rorder TINYINT UNSIGNED,
    textbefore TEXT,
    textarea TEXT,
    textafter TEXT,
    lang VARCHAR(10),
    PRIMARY KEY (intstepid),
    KEY IDX_wd_pa_integrationsteps1(integrationid)
);


