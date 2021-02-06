<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================


define('L_G_POSTAFFPRO','Post Affiliate Pro');
define('L_G_START','Start');
define('L_G_FINISH','Finish');
define('L_G_FINISHCONVERT','Finish convert');
define('L_G_EMPTY','cannot be blank');
define('L_G_UNALLOWED','contains unallowed characters');
define('L_G_NOTNUMBER','must be positive number');
define('L_G_NOTALLOWED','has unallowed value');
define('L_G_ERROR', 'Error');
define('L_G_SUCCESS', 'Success');
define('L_G_INSTALLATION','Installation');
define('L_G_INSTALLATIONPROGRESSBAR','Installation progressbar');
define('L_G_DBCONFIG','Specify database');
define('L_G_INSTALLLANGUAGE','Language of installation');
define('L_G_DBHOSTNAME','Database Server Hostname / DSN');
define('L_G_DBTYPE','Your Database Type');
define('L_G_DBNAME','Your Database Name');
define('L_G_DBUSERNAME','Database Username');
define('L_G_DBPWD','Database Password');
define('L_G_INSTALLATIONMETHOD','Choose your installation method');
define('L_G_IMINSTALL','clean install');
define('L_G_IMUPGRADEFREE','upgrade from free version of Post Affiliate');
define('L_G_UPGRADE122','upgrade from Post Affiliate Pro 1.2.x');
define('L_G_STEP1HELP',"Thank you for choosing Post Affiliate Pro. This wizard will lead you step by step through the installation of Post Affiliate Pro.");
define('L_G_DBCONFIGHELP',"<b>Please fill out the database configuration details requested below.</b><br>Note ".
                         "that the database you install into should already exist.<br><br>".
                         "Requirements to complete this step:".
                         "<li><b>the database must exist</b><br>".
                         "You can create the database and user by starting MySql prompt and executing the commands:");
define('L_G_DBCONFIGHELP2', "</li><li><b>this script must have write enabled access to /settings/settings.php file</b><br>".
                         "You can change the permissions with command CHMOD 777. When the installation is finished, you can change the settings file permissions back to read-only permissions.");
define('L_G_NEXT','Next >>');
define('L_G_CHOOSEINSTALLMETHOD','You have to choose the installation method');
define('L_G_CANNOTCONNECTTODATABASE','Cannot connect to database, check your database configuration. Database returned: ');
define('L_G_CANNOTOPENSQLSCRIPT','Fatal error: Cannot open script with SQL commands for creating database. Check your configuration!');
define('L_G_DBCREATIONSUCCESS','Database was succesfully created and initialized with startup data.<br> The database connection settings were'.
                                 ' saved to the settings file.<br><br>'.
                                 'Please click Next button to continue with setup.');
define('L_G_DBININCONSISTENTSTATE','Because some of the SQL commands failed, the database can be in inconsistent state.'.
                                     'It is recomended to delete all database tables that might be created before trying installing database again!');
define('L_G_DBERROR','Database SQL Error: ');
define('L_G_NOTAVAILABLE','The selected method is not yet available');
define('L_G_NOTAVAILABLE2','This method is being implemented. Please check our web site in a few days.');
define('L_G_BACK','<< Back');
define('L_G_EMPTY','cannot be empty');
define('L_G_UNALLOWED','contains unallowed characters');
define('L_G_SETTINGSDIRNOTWRITABLE',"'/settings' directory is not writable");
define('L_G_SETTINGSFILENOTWRITABLE',"'/settings/settings.php' file is not writable");
define('L_G_DBCREATEDHELP','Now the database is being created and populated with initial records. It can take few seconds...');
define('L_G_DBCREATION','Database creation');
define('L_G_MERCHANTCONFIGHELP',"<b>Merchant access configuration.</b><br>Specify your admin username and password below.");
define('L_G_MERCHANTCONFIG','Setting up merchant account');
define('L_G_MERCHANTCONFIGURATION','Merchant account');
define('L_G_MUSERNAME','Merchant username');
define('L_G_MPWD','Merchant password');
define('L_G_VERIFYMPWD','Verify merchant password');
define('L_G_MEMAIL','Merchant email');
define('L_G_PASSWORDSDONTMATCH',"Passwords don't match");
define('L_G_SETTINGSHELP',"Now in the installation program you'll set only the most important system settings.<br>".
                            "All settings will be available for you in the <b>Tools -> Settings</b> section after you log on into your control panel.".
                             "<br><br>Requirements to complete this step:".
                             "<li><b>export and banners directory must be enabled for writing by PHP</b><br>".
                             "You can change the permissions of these directories by CHMOD to 775 or 777".
                             "</li><br><li><b>The complete URLs should be given to both directories</b><br>If the URLs are not correct, ".
                             "uploading of banners and exporting files will not work.");

define('L_G_EXPORTDIR', 'Export directory');
define('L_G_HLPEXPORTDIR', "Directory for export of CSV (Excel) files. Default is '../exports', it ".
                             " should be relative path from '/affiliate/merchants' directory");
define('L_G_BANNERSURL', 'Complete URL to banners directory');
define('L_G_BANNERSDIR', 'Directory for banners upload');
define('L_G_HLPBANNERSDIR', "Directory where the banners will be uploaded, it has to be ".
                              " relative path from '/affiliate/merchants' directory.");
define('L_G_EXPORTURL', 'Complete URL to export directory');
define('L_G_SETTINGS','System settings');
define('L_G_CHECKIT','Click here to test the url');
define('L_G_URLTOSCRIPTSDIR', "Complete URL to '/scripts' directory");
define('L_G_HLPURLTOSCRIPTSDIR', "Complete URL to '/affiliate/scripts' directory.<br>".
                                   "If URL is set to wrong path, program will be not able to register ".
                                   "impressions, clicks and sales");
define('L_G_SYSTEMEMAIL', 'System email');
define('L_G_MAINSITEURL', 'Main site URL');
define('L_G_SIGNUPURL', 'Complete URL to signup page');
define('L_G_HLPSIGNUPURL', 'Complete URL to signup page.<br>'.
                             'If URL is set to wrong path, affiliates will see incorrect link, and cannot advertise your affiliate program.');

define('L_G_DIRNOTWRITABLE','- directory is not writable, change its permissions');
define('L_G_VERSION','version');
define('L_G_GENERATEDIN','generated in');
define('L_G_INSTALLSTITLE','Post Affiliate Pro Installation');
define('L_G_INSTALLATIONFINISHED','Installation finished');
define('L_G_INSTFINISHED', "Congratulations, you succesfully finished installation of Post Affiliate Pro.<br>".
                             "Now you can log into your merchant panel and review your other settings, set commissions, email templates and notifications, etc.");
define('L_G_NEXTSTEPS',    "Now you can log in to your merchant panel. There you can find <b>Start with your affiliate program</b> section that will help you starting your program.");
define('L_G_HLPSYSTEMEMAIL','System email is the email that is displayed as a Sender whenever you send email from affiliate system. This applies also for email notifications.');
define('L_G_MYSQL','MySql (default)');
define('L_G_MSSQL','MS SQL');
define('L_G_SETTINGSCHECKOUTHELP', "Your old <b>/settings/settings.php</b> file is examined.<br> The database from the older version of Post Affiliate Pro has to be converted to a new database format.".
                                " Also note that all settings except database access will be extracted from settings file and saved into the database. <br>".
                                "Your old <b>/settings/settings.php</b> will remain unchanged, but all the non-database settings there will be ignored.");
define('L_G_ALLOK','Everything is OK');
define('L_G_SETTINGSCHECKOUT','Checking settings');
define('L_G_DBCONVERT','Converting database');
define('L_G_DBCONNECTIONDOESNTEXIST',"Database connection doesn't exist");
define('L_G_DBUPGRADEDTO122','Database was upgraded to version 1.2.2');
define('L_G_BACKUPTABLES','Making backup of old tables');
define('L_G_CREATINGNEWSTRUCTURE','Creating new structure');
define('L_G_CONVERTINGMERCHANTS','Converting merchants');
define('L_G_CONVERTINGAFFILIATES','Converting affiliates');
define('L_G_CONVERTINGCAMPAIGNS','Converting product categories');
define('L_G_CONVERTINGCAMPAIGNCATEGORIES','Converting commission categories');
define('L_G_BANNERS','Converting banners');
define('L_G_OK','OK');
define('L_G_EMAILTEMPLATES','Converting email templates');
define('L_G_IMPRESSIONS','Converting impressions');
define('L_G_TRANSACTIONS','Converting transactions');
define('L_G_AFFILIATESCAMPAIGNS','Converting affiliate commission categories');
define('L_G_RECURRINGCOMMISSIONS','Converting recurring commissions');
define('L_G_DROPPINGBACKUPTABLES','Dropping backup table');
define('L_G_DBCONVERTHELP','Database is going to be converted from previous version to new version.<br>'.
                             ' This process can take some time.');
define('L_G_SETTINGSCONVERTHELP','Settings are loaded from settings file, and placed into the database. <br>'.
                                'Note that in version 1.3 all settings except database configuration are stored in the database and you are able to edit them '.
                                ' in Merchant Control Panel');
define('L_G_SETTINGSCONVERT','Converting settings');
define('L_G_SETTINGSCONVERSIONSUCCESS','Settings are succesfully converted');
define('L_G_UPGRADEFINISHED','Upgrade finished');
define('L_G_UPGFINISHED', "Congratulations, you succesfully finished upgrade of Post Affiliate Pro.<br>".
                             "Now you can log into your merchant panel and check your settings.");
define('L_G_UPGNEXTSTEPS', "Now you can log in to your merchant panel. There you can find <b>Start with your affiliate program</b> section that will help you starting your program.");

// version 1.3.1
define('L_G_UPGRADE13','upgrade from Post Affiliate Pro 1.3');
define('L_G_UPGRADE14','upgrade from Post Affiliate Pro 1.4');
define('L_G_UPGRADE20','upgrade from Post Affiliate Pro 2.0.x');
define('L_G_DBCONVERSIONSUCCESS','Database was suffesfully converted from previous version.<br><br>'.
                                 'Please click Next button to continue with setup.');


// upgrade from PostAff free addon

define('L_G_POSTAFFPRODB','Post Affiliate Pro database settings');
define('L_G_POSTAFFFREEDB','Post Affiliate (free version) database settings');
define('L_G_SAMEDBFREEPRO','check this if free version uses the same database as Pro version');
define('L_G_CANNOTCONNECTTOPRODATABASE','Cannot connect to Pro version database, check your /settings/settings.php file!');
define('L_G_CANNOTCONNECTTOFREEDATABASE','Cannot conect to free version database, check your configuration');
define('L_G_CONVERTINGSALES','Converting sales');
define('L_G_CONVERTINGCLICKS','Converting clicks');
define('L_G_CONVERSIONFINISHED','Conversion finished');

define('L_G_SETTINGSCHECKOUTFREEUPGRADEHELP', "Your <b>/settings/settings.php</b> file is examined.<br> The database from the free version of Post Affiliate has to be converted to a new database format.");
define('L_G_UPGRADEFROMFREE','Upgrade from free version');
define('L_G_UPGRADEFROMFREEHLP',"To upgrade from free version you have to perform normal installation of Post Affiliate Pro using the 'install' option".
                  " in the previous step.<br> You can use the same database where free verison is installed, because there is no table name conflict between free an dPro version.".
                  "<p>After you succesfuly installed Post Affiliate Pro, return to this step to convert data from free Post Affiliate to Post Affiliate Pro database.</p>".
                  "Once it is done, the upgrade is completed.");
define('L_G_UPGRADEWASSUCCESFUL','Upgrade was succesful');
define('L_G_DBCREATIONFAILED','Database creation failed');
define('L_G_AUTHORIZATION','Product code');
define('L_G_AUTHINSERTCODE','Product ID: ');
define('L_G_AUTHCODENOTINSERTED','You need to insert authorization code');
define('L_G_AUTHBADHOST','Wrong hostname (bad http server configuration ?)');
define('L_G_AUTHCONNECTIONFAILED','Connection to authorization server failed');
define('L_G_AUTHWRONGCODE','Authorization failed, wrong code.');
define('L_G_SESSIONNOTWORKING','Session not working: installation is not possible');
define('L_G_DBREQUESTS', 'DB Requests');
define('L_G_LICENSEHELP','<b>Enter your license (Product ID) here.</b><br>You can get your Product ID from our members area - Purchased Products section (see image bellow).');
define('L_G_CHOOSEDESIGN','Choose skin (design of control panels)');
define('L_G_SKINHELP','You will be always able to change your skin and system colors in your control panel.');
define('L_G_YOUHAVETOCHOOSESKIN','You have to choose one of the skins');
define('L_G_CONVERTFAILED','Conversion of database failed');
define('L_G_CACHEDIR', 'Cache directory');
define('L_G_CACHEURL', 'Complete URL to cache directory');
define('L_G_HLPCACHEDIR', '');
define('L_G_BACKUPBEFOREUPDATE', 'It is recommended to backup your database before doing upgrade!');
define('L_G_CRONJOB','<b>Set up cron job</b><br>Set up cron to execute command below every hour. This command will run job that is '.
                    ' necessary when you generate recurring commmissions, or send automatic daily,weekly or monthly reports.');
define('L_G_TODO','There is one more action to finish the installation:');
define('L_G_SAMPLECRONINCPANEL','Example setting cron job in CPanel');
define('L_G_SETTINGSFILEISEMPTY', 'Your settings file <b>/settings/settings.php</b> is empty. Please copy settings file from your older version of Post Affiliate Pro.');

define('L_G_DIRECTORYFORREPLICATION', 'Directory for page replication');
define('L_G_HLPDIRECTORYFORREPLICATION', "Directory for replicated pages. Default is '../page', it should be relative path from '/affiliate/merchants' directory. It must be write enabled.");
define('L_G_URLTODIRECTORYFORREPLICATION', 'Complete URL to page replication dir');

?>
