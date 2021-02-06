******************************************************************
*                           MOD INFO
****************************************************************
* Target     : CubeCart version 3.0.x
*              --------------------------------------------------
*
* File info  : ePay gateway v1.0
*              Milos Homola aka convict (c)2007
**
* Author     : Milos Homola aka conVict
* Contact    : milos@cc3.biz
* Downloaded from : http://cc3.biz
* Last update: Sepetember 4 2007
* Estimeret tid: 2-4 Minutter
*
* Special notes: Tag altid backup af dine filer!
* Forfatter tager ingen ansvar for nogle skader (virkelige eller forstillede)
* Som skulle opstå ved at bruge dette modul
*
* Distribuer ikke denne kode uden skriftlig godkendelse
* af forfatteren! Det er illegalt at redistribuere denne code gratis eller ved gensalg
* uden godkendelse.
****************************************************************/
Nye filer:
admin/modules/gateway/ePay/index.php
admin/modules/gateway/ePay/logo.gif
language/en/epay_lang.inc.php
modules/gateway/ePay/callback.php
modules/gateway/ePay/common.inc.php
modules/gateway/ePay/dankort.gif
modules/gateway/ePay/danske.gif
modules/gateway/ePay/daners.gif
modules/gateway/ePay/edk.gif
modules/gateway/ePay/electron.gif
modules/gateway/ePay/ewire.gif
modules/gateway/ePay/forb.gif
modules/gateway/ePay/form.tpl
modules/gateway/ePay/form.inc.php
modules/gateway/ePay/jcb.gif
modules/gateway/ePay/master.gif
modules/gateway/ePay/nordea.gif
modules/gateway/ePay/transfer.inc.php
modules/gateway/ePay/visa.gif

FILER som skal redigeres:
language/dk/config.inc.php (og/eææer et hvilket som helst andet sprog du vil bruge)

**********************************
BEGYND INSTALLATIONS INSTRUKTIONER
**********************************

############################
Skridt 1 UPLOAD NYE FILER
############################

Opload venligst alle filer med mappestrykturen fra pakken (mapperne admin, modules og 
language) til din CubeCart rodmappe. Butikkens rodmappe er den der indeholder mapper
med navnene admin, classes, docs, extra, images, includes, js,language, modules, pear og skins.

Kopier simpelthen admin-mappen og module-mappen fra denne pakke til din butiks rodmappe.
Dette vil ikke overskrive filer i butikken, det vil bare tillægge nye filer.

##################################
SKRIDT 2 REDIGER EKSISTERENDE FIL
##################################

Åben language/en/config.inc.php

FIND ved slutningen af filen
-------------------

?>


Tilføj denne linje lige over det
---------------------------------

include("epay_lang.inc.php"); # lang file by convict #


OBS: Hvis du bruge Cubecart på andre sprog en dansk, gør da dette skridt for hver 
sprog og oversæt alt mellem "" i den nye fil, epay_lang.inc.php

#############################
Gem, Luk og Opload din fil language/dk/config.inc.php
#############################

#############################
SKRIDT 3 KONFIGURER & AKTIVER MODULET
#############################

Kør CC Admin Control Panel->Modules->Gateways->ePay configure

Set dine værdier og aktiver Betalingsmodulet.

#############################
#  SLUT
############################

*** KUNDESERVICE ***

Please sign-in to your account and open a HelpDesk ticket at CC3.biz for service issues and bug reports.
Thank you for purchasing this product!
