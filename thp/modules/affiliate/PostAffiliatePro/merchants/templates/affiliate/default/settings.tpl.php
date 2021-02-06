
    <center>
    <form action=index.php method=post>
    <table class=tableresult border=0 cellspacing=0 cellpadding=2>
    <tr>
      <td class=header align=center colspan=3><?php echo L_G_PAYOUTMETHODS?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SHOWBANKINFO;?></b></td>
      <td valign=top><input type=checkbox name=showbankinfo value=1 <?php echo ($_POST['showbankinfo'] == 1 ? 'checked' : '')?>></td>
      <td><?php showHelp('L_G_HLPSHOWBANKINFO'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SHOWPAYPALINFO;?></b></td>
      <td valign=top><input type=checkbox name=showpaypalinfo value=1 <?php echo ($_POST['showpaypalinfo'] == 1 ? 'checked' : '')?>><br><br></td>
      <td rowspan=2 valign=top><?php showHelp('L_G_HLPSHOWPAYPALINFO'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_PAYPALCURRENCY?></b></td>
      <td valign=top>
      <select name=paypalcurrency>
        <option value="USD" <?php echo ($_POST['paypalcurrency'] == 'USD' ? 'selected' : '')?>>USD</option>
        <option value="EUR" <?php echo ($_POST['paypalcurrency'] == 'EUR' ? 'selected' : '')?>>EUR</option>
        <option value="GBP" <?php echo ($_POST['paypalcurrency'] == 'GBP' ? 'selected' : '')?>>GBP</option>
        <option value="CAD" <?php echo ($_POST['paypalcurrency'] == 'CAD' ? 'selected' : '')?>>CAD</option>
        <option value="JPY" <?php echo ($_POST['paypalcurrency'] == 'JPY' ? 'selected' : '')?>>JPY</option>
      </select>    
      </td>
    </tr>    
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SHOWMONEYBOOKERSINFO;?></b></td>
      <td valign=top><input type=checkbox name=showmoneybookersinfo value=1 <?php echo ($_POST['showmoneybookersinfo'] == 1 ? 'checked' : '')?>></td>
      <td rowspan=2 valign=top ><?php showHelp('L_G_HLPSHOWMONEYBOOKERSINFO'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_MONEYBOOKERSCURRENCY;?></b></td>
      <td valign=top><input type=text size=3 name=moneybookerscurrency value="<?php echo $_POST['moneybookerscurrency']?>"></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SHOWCHECKINFO;?></b></td>
      <td valign=top><input type=checkbox name=showcheckinfo value=1 <?php echo ($_POST['showcheckinfo'] == 1 ? 'checked' : '')?>></td>
      <td><?php showHelp('L_G_HLPSHOWCHECKINFO'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_MINPAYOUTOPTIONS;?></b></td>
      <td colspan=2><input type=text size=70 name=min_payout_options value="<?php echo $_POST['min_payout_options']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><?php showHelp('L_G_HLPMINPAYOUTOPTIONS'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_INITIALMINPAYOUT?></b></td>
      <td colspan=2><input type=text size=20 name=initial_min_payout value="<?php echo $_POST['initial_min_payout']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><?php showHelp('L_G_HLPINITIALMINPAYOUT'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    
    <tr>
      <td class=header align=center colspan=3><?php echo L_G_SYSTEMSETTINGS?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SUPPORTRECURRINGCOMMISSIONS;?></b></td>
      <td valign=top><input type=checkbox name=support_recurring_commissions value=1 <?php echo ($_POST['support_recurring_commissions'] == 1 ? 'checked' : '')?>></td>
      <td valign=top><?php showHelp('L_G_HLPSUPPORTRECURRINGCOMMISSIONS'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>    
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_RECURRINGREALCOMMISSIONS;?></b></td>
      <td valign=top><input type=checkbox name=recurringrealcommissions value=1 <?php echo ($_POST['recurringrealcommissions'] == 1 ? 'checked' : '')?>></td>
      <td valign=top><?php showHelp('L_G_HLPRECURRINGREALCOMMISSIONS'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_MAXCOMMISSIONLEVELS?></b></td>
      <td valign=top colspan=2>
      <select name=maxcommissionlevels>
        <option value="1" <?php echo ($_POST['maxcommissionlevels'] == 1 ? 'selected' : '')?>>1 - <?php echo L_G_NOMULTITIERCOMMISSIONS?></option>
<?php      for($i=2; $i<=10; $i++) { ?>
        <option value="<?php echo $i?>" <?php echo ($_POST['maxcommissionlevels'] == $i ? 'selected' : '')?>><?php echo $i.' - '.L_G_TIER?></option>
<?php      } ?>        
      </select>      
      </td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td valign=top><b><?php echo L_G_FORCEPRODUCTIDCHOOSING?></b></td>
      <td valign=top colspan=2>
      <select name=forcecommfromproductid>
        <option value="no" <?php echo ($_POST['forcecommfromproductid'] == 'no' ? 'selected' : '')?>><?php echo L_G_NO?></option>
        <option value="yes" <?php echo ($_POST['forcecommfromproductid'] == 'yes' ? 'selected' : '')?>><?php echo L_G_YES?></option>
      </select>      
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td class=dir_form colspan=2><?php showHelp('L_G_HLPFORCEPRODUCTIDCHOOSING'); ?></td>
    </tr>    
    <tr>
      <td valign=top><b><?php echo L_G_APPLYCATFROMBANNER?></b></td>
      <td valign=top colspan=2>
      <input type=checkbox name=apply_from_banner value=1 <?php echo ($_POST['apply_from_banner'] == 1 ? 'checked' : '')?>>
    </tr>
    <tr>
      <td class=listresult2 valign=top nowrap>&nbsp;</td>
      <td class=listresult2 colspan=2><?php showHelp('L_G_HLPAPPLYCATFROMBANNER'); ?></td>
    </tr>    

    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_EXPORTDIR;?></b></td>
      <td colspan=2 valign=top><input type=text size=70 name=export_dir value="<?php echo $_POST['export_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2 valign=top><?php showHelp('L_G_HLPEXPORTDIR'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_EXPORTURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=export_url value="<?php echo $_POST['export_url']?>"></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_LINKSTYLE;?></b></td>
      <td colspan=2>
      <select name=link_style>
        <option value="<?php echo LINK_STYLE_OLD?>" <?php echo ($_POST['link_style'] == LINK_STYLE_OLD ? 'selected' : '')?>><?php echo L_G_LINKSTYLE_OLD?></option>
        <option value="<?php echo LINK_STYLE_NEW?>" <?php echo ($_POST['link_style'] == LINK_STYLE_NEW ? 'selected' : '')?>><?php echo L_G_LINKSTYLE_NEW?></option>
      </select>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><?php showHelp('L_G_HLPLINKSTYLE'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=dir_form valign=top><b><?php echo L_G_BANNERSDIR;?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_dir value="<?php echo $_POST['banners_dir']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPBANNERSDIR'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_BANNERSURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=banners_url value="<?php echo $_POST['banners_url']?>"></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_URLTOSCRIPTSDIR?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=scripts_url value="<?php echo $_POST['scripts_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPURLTOSCRIPTSDIR'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SIGNUPURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=signup_url value="<?php echo $_POST['signup_url']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPSIGNUPURL'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_TRACKREFSBYSESSION?></b></td>
      <td valign=top>
      <input type=checkbox name=track_by_session value=1 <?php echo ($_POST['track_by_session'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top>
      <?php showHelp('L_G_HLPTRACKREFSBYSESSION'); ?>
      </td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_TRACKREFSBYIP?></b></td>
      <td valign=top>
      <input type=checkbox name=track_by_ip value=1 <?php echo ($_POST['track_by_ip'] == 1 ? 'checked' : '')?>>
      </td>
      <td valign=top rowspan=2>
      <?php showHelp('L_G_HLPTRACKREFSBYSESSION'); ?>
      </td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_IPADDRESSVALIDITY?></b></td>
      <td valign=top>
      <input type=text size=5 name=ip_validity value="<?php echo $_POST['ip_validity']?>">
      &nbsp;
      <select name=ip_validity_type>
        <option value="minutes" <?php echo ($_POST['ip_validity_type'] == 'minutes' ? 'selected' : '')?>><?php echo L_G_MINUTES?></option>
        <option value="hours" <?php echo ($_POST['ip_validity_type'] == 'hours' ? 'selected' : '')?>><?php echo L_G_HOURS?></option>
        <option value="days" <?php echo ($_POST['ip_validity_type'] == 'days' ? 'selected' : '')?>><?php echo L_G_DAYS?></option>
        <option value="years" <?php echo ($_POST['ip_validity_type'] == 'years' ? 'selected' : '')?>><?php echo L_G_YEARS?></option>
      </select><br>      
      </td>
    </tr>
    <tr><td colspan=3><hr></td></tr>
    
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SYSTEMEMAIL;?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=system_email value="<?php echo $_POST['system_email']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPSYSTEMEMAIL'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SYSTEMCURRENCY;?></b></td>
      <td valign=top><input type=text size=3 name=system_currency value="<?php echo $_POST['system_currency']?>"></td>
      <td valign=top><?php showHelp('L_G_HLPSYSTEMCURRENCY'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SYSTEMLANGUAGE;?></b></td>
      <td valign=top>
      <select name=default_lang>
<?php    while($data=$this->a_list_data->getNextRecord()) { ?>
        <option value="<?php echo $data?>" <?php echo ($_POST['default_lang'] == $data ? 'selected' : '')?>><?php echo $data?></option>
<?php    } ?>
      </select><br>
      </td>
      <td valign=top rowspan=2><?php showHelp('L_G_HLPSYSTEMLANGUAGE'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_ALLOWSELECTLANGUAGE;?></b></td>
      <td valign=top colspan=2><input type=checkbox name=allow_choose_lang value=1 <?php echo ($_POST['allow_choose_lang'] == 1 ? 'checked' : '')?>></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SHOWMINIHELP?></b></td>
      <td valign=top><input type=checkbox name=show_minihelp value=1 <?php echo ($_POST['show_minihelp'] == 1 ? 'checked' : '')?>></td>
      <td valign=top><?php showHelp('L_G_HLPSHOWMINIHELP', true); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;<b><?php echo L_G_LOG_LEVEL?></b>&nbsp;</td>
      <td valign=top>
        <input type=checkbox name=log_level_element[] value=<?php echo WLOG_DBERROR?> <?php echo (($_POST['log_level'] & WLOG_DBERROR) == WLOG_DBERROR ? ' checked' : '')?>><?php echo L_G_LOG_DBERROR?>
        <br><input type=checkbox name=log_level_element[] value=<?php echo WLOG_ERROR?> <?php echo (($_POST['log_level'] & WLOG_ERROR) == WLOG_ERROR ? ' checked' : '')?>><?php echo L_G_LOG_ERROR?>
        <br><input type=checkbox name=log_level_element[] value=<?php echo WLOG_ACTIONS?> <?php echo (($_POST['log_level'] & WLOG_ACTIONS) == WLOG_ACTIONS ? ' checked' : '')?>><?php echo L_G_LOG_ACTIONS?>
        <br><input type=checkbox name=log_level_element[] value=<?php echo WLOG_DEBUG?> <?php echo (($_POST['log_level'] & WLOG_DEBUG) == WLOG_DEBUG ? ' checked' : '')?>><?php echo L_G_LOG_DEBUG?>
      </td>
      <td valign=top><?php showHelp('L_G_HLP_LOG_LEVEL'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_DEBUGTRANSACTIONS?></b></td>
      <td valign=top>
      <select name=debug_trans>
        <option value="no" <?php echo ($_POST['debug_trans'] == 'no' ? 'selected' : '')?>><?php echo L_G_NO?></option>
        <option value="yes" <?php echo ($_POST['debug_trans'] == 'yes' ? 'selected' : '')?>><?php echo L_G_YES?></option>
      </select>      
      </td>
      <td valign=top><?php showHelp('L_G_HLPDEBUGTRANSACTIONS'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>

    <tr>
      <td class=header align=center colspan=3><?php echo L_G_LOGINPROTECTION?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top><b><?php echo L_G_LOGINPROTECTIONRETRIES;?></b></td>
      <td valign=top><input type=text size=3 name=login_protection_retries value="<?php echo $_POST['login_protection_retries']?>"><br><br></td>
      <td valign=top><?php showHelp('L_G_HLPLOGINPROTECTIONRETRIES'); ?></td>
    </tr>
    <tr><td colspan=3><hr></td></tr>

    <tr>
      <td class=dir_form valign=top><b><?php echo L_G_LOGINPROTECTIONDELAY;?></b></td>
      <td valign=top><input type=text size=3 name=login_protection_delay value="<?php echo $_POST['login_protection_delay']?>"><br><br></td>
      <td valign=top><?php showHelp('L_G_HLPLOGINPROTECTIONDELAY'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>

    <tr>
      <td class=header align=center colspan=3><?php echo L_G_FRAUDPROTECTION?></td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>
      <input type=checkbox name=declinefrequentclicks value=1 <?php echo ($_POST['declinefrequentclicks']==1 ? 'checked' : '')?>>
      <b>
      <?php echo L_G_DECLINEFREQUENTCLICKS?>
      <input type=text name=clickfrequency size=3 value='<?php echo $_POST['clickfrequency']?>'>
      <?php echo L_G_SECONDS?> <?php echo L_G_DECLINEFREQUENTCLICKS2?>
      </b>
      </td>
    </tr>
    <tr>
      <td class=listresult2 align=left colspan=3>
      <input type=checkbox name=declinefrequentsales value=1 <?php echo ($_POST['declinefrequentsales']==1 ? 'checked' : '')?>>
      <b>
      <?php echo L_G_DECLINEFREQUENTSALES?>
      <input type=text name=salefrequency size=3 value='<?php echo $_POST['salefrequency']?>'>
      <?php echo L_G_SECONDS?> <?php echo L_G_DECLINEFREQUENTSALES2?>
       </b>
      </td>
    </tr>
    <tr>
      <td align=left colspan=3>
      <input type=checkbox name=declinesameorderid value=1 <?php echo ($_POST['declinesameorderid']==1 ? 'checked' : '')?>>
      <b>
      <?php echo L_G_DECLINESALESSAMEORDERID?>
      </b>
      </td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>

    <tr>
      <td class=header align=center colspan=3><?php echo L_G_P3PPOLICY?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_URLTOP3PPOLICYXML?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=p3p_xml value="<?php echo $_POST['p3p_xml']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_COMPACTP3PPOLICY?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=p3p_compact value="<?php echo $_POST['p3p_compact']?>"></td>
    </tr>    
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPP3P'); ?></td>
    </tr>    
    <tr><td colspan=3>&nbsp;</td></tr>

    
    <tr>
      <td class=header align=center colspan=3><?php echo L_G_EMAILNOTIFICATIONS?></td>
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_SUPPORTDAILYREPORTS?></b></td>
      <td class=listresult2 align=left valign=top>
      <select name=email_supportdailyreports>
        <option value="no" <?php echo ($_POST['email_supportdailyreports'] == 'no' ? 'selected' : '')?>><?php echo L_G_NO?></option>
        <option value="yes" <?php echo ($_POST['email_supportdailyreports'] == 'yes' ? 'selected' : '')?>><?php echo L_G_YES?></option>
      </select>      
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPSUPPORTDAILYREPORTS'); ?></td>
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_ONAFFSIGNUP?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_onaffsignup value=1 <?php echo ($_POST['email_onaffsignup'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPONAFFSIGNUP'); ?></td>       
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_ONSALE?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_onsale value=1 <?php echo ($_POST['email_onsale'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPONSALE'); ?></td>      
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_DAILYREPORT?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_dailyreport value=1 <?php echo ($_POST['email_dailyreport'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPDAILYREPORT'); ?></td>       
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_ONRECURRINGTRANSGENERATED?></b></td>
      <td class=listresult2 align=left valign=top>
      <input type=checkbox name=email_recurringtrangenerated value=1 <?php echo ($_POST['email_recurringtrangenerated'] == 1 ? 'checked' : '')?>>
      </td>
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPRECURRINGTRANGENERATED'); ?></td>       
    </tr>

    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_EMAILFORSENDINGNOTIFICATIONS;?></b></td>
      <td valign=top colspan=2><input type=text size=50 name=notifications_email value="<?php echo $_POST['notifications_email']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPEMAILFORSENDINGNOTIFICATIONS'); ?></td>
    </tr>
    <tr><td class=listresult2 colspan=3>&nbsp;</td></tr>

    <tr>
      <td class=header align=center colspan=3><?php echo L_G_EDITCUSTOMIZATION?></td>
    </tr>
    <tr>
      <td class=listresult2 valign=top><b><?php echo L_G_AFFAPPROVAL?></b></td>
      <td class=listresult2 align=left valign=top>
      <select name=affiliateapproval>
        <option value="<?php echo APPROVE_AUTOMATIC?>" <?php echo ($_POST['affiliateapproval'] == APPROVE_AUTOMATIC ? 'selected' : '')?>><?php echo L_G_AUTOMATIC?></option>
        <option value="<?php echo APPROVE_MANUAL?>" <?php echo ($_POST['affiliateapproval'] == APPROVE_MANUAL ? 'selected' : '')?>><?php echo L_G_MANUAL?></option>
      </select>      
      <td class=listresult2 valign=top><?php showHelp('L_G_HLPAFFAPPROVAL'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_LOGOUTURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=afflogouturl value="<?php echo $_POST['afflogouturl']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPLOGOUTURL'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_POSTSIGNUPURL?></b></td>
      <td valign=top colspan=2><input type=text size=70 name=affpostsignupurl value="<?php echo $_POST['affpostsignupurl']?>"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan=2><?php showHelp('L_G_HLPPOSTSIGNUPURL'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_JOIN_CAMPAIGN?></b></td>
      <td valign=top><input type=checkbox name=join_campaign value=1 <?php echo ($_POST['join_campaign'] == 1 ? 'checked' : '')?>></td>
      <td><?php showHelp('L_G_HLPJOINCAMPAIGN'); ?></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?php echo L_G_SIGNUP_BONUS?></b></td>
      <td valign=top><input type=text name=program_signup_bonus value='<?php echo ($_POST['program_signup_bonus'] != '' ? $_POST['program_signup_bonus'] : '0')?>'></td>
      <td><?php showHelp('L_G_HLPPROGRAM_SIGNUP_BONUS'); ?></td>
    </tr>
    <tr><td class=listresult2 colspan=3>&nbsp;</td></tr>
    
    <tr>
      <td class=dir_form colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_Settings'>
      <input type=hidden name=action value='edit'>
      <input class=formbutton type=submit value="<?php echo L_G_SAVECHANGES?>">
      </td>
    </tr>    
    </table>
    
    </form>
    </center>
    <br>
