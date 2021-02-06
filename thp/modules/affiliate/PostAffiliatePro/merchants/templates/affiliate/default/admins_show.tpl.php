<script>
function addAdmin()
{
document.location.href= "index.php?md=Affiliate_Merchants_Views_AdminsManager&action=add_new&<?php echo SID?>";
}

function editAdmin(ID)
{
document.location.href= "index.php?md=Affiliate_Merchants_Views_AdminsManager&action=edit&aid="+ID+"&<?php echo SID?>";
}

function setMainAffiliateManager(ID)
{
document.location.href= "index.php?md=Affiliate_Merchants_Views_AdminsManager&action=set_main_affiliate_manager&aid="+ID+"&<?php echo SID?>";
}

function deleteAdmin(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEADMIN?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_AdminsManager&aid="+ID+"&action=delete"+"&<?php echo SID?>";
}

function changeAdminStatus(ID)
{
  if(confirm("<?php echo L_G_CONFIRM_CHANGE_ADMIN?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_AdminsManager&aid="+ID+"&action=change_status"+"&<?php echo SID?>";
}
</script>

<!--
<script>
function Delete(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEAFF?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_AdminsManager&aid="+ID+"&action=delete"+"&<?php echo SID?>";
}

function editUser(ID)
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AdminsManager&action=edit&aid="+ID+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0";
}

function addAdmin()
{
	//var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AdminsManager&action=add"+"&<?php echo SID?>","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    //wnd.focus();
    document.location.href= "index.php?md=Affiliate_Merchants_Views_AdminsManager&action=add_new"+"&<?php echo SID?>";
}
-->


</script>

<form name=FilterForm id=FilterForm action=index.php method=get>
<input type=hidden name=filtered value=1>
<input type=hidden name=md value='Affiliate_Merchants_Views_AdminsManager'>
<input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
<input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
<input type=hidden id=action name=action value=''>
<input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">

    <table cellpadding="0" cellspacing="0" border="0" width="780">
    <tr>
        <td valign=top><?php echo L_G_ADMINS_DESCRIPTION?><br><br>
        </td>
    </table>
    <br>
    <table border=0 cellspacing=0>
     <tr>
     <?php if($this->a_action_permission['add_new']) { ?>
       <td><input type=button class=formbutton value="<?php echo L_G_ADD_ADMIN?>"  onclick="javascript:addAdmin();">&nbsp;&nbsp;&nbsp;</td>
      <?php } ?>
     </tr>
     <tr>
        <td>&nbsp;</td>
     </tr>
     </table>

    <table class=listingClosed border=0 cellspacing=0 cellpadding=0>
    <tr>
        <td class=listPaging align=right>
        <table width="100%" border="0" height="18" cellspacing="0" cellpadding="0">
        <tr>
            <td align="left" class=listheaderNoLine nowrap>
                <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
            </td>
        </tr>
        </table>

        </td>
    </tr>
</form>
<form action=index.php method=post>

    <tr>
        <td align=left>
            <table width="100%" cellspacing="0" cellpadding="1">
            <tr class=listheader>
        <?php
            QUnit_Templates::printHeader(L_G_ID, 'a.userid');
            QUnit_Templates::printHeader(L_G_USER_NAME, 'a.username');
            QUnit_Templates::printHeader(L_G_NAME, 'a.name');
            QUnit_Templates::printHeader(L_G_SURNAME, 'a.surname');
            QUnit_Templates::printHeader(L_G_ACCOUNT, 'account_name');
            QUnit_Templates::printHeader(L_G_USER_PROFILE, 'userprofile_name');
            QUnit_Templates::printHeader(L_G_STATUS, 'a.rstatus');
            QUnit_Templates::printHeader(L_G_JOINED, 'a.dateinserted');
            QUnit_Templates::printHeader(L_G_ACTIONS);
        ?>
            </tr>
        <?php
            while($data=$this->a_list_data->getNextRecord())
            {
        ?>
            <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
            <td class=listresultnocenter align=right nowrap><?php echo $data['userid']?></td>
            <td class=listresult nowrap style="font-weight: <?php echo  ($this->main_affiliate_manager == $data['userid']) ? "bold" : "normal"?>">&nbsp;<?php echo $data['username']?>&nbsp;</td>
            <td class=listresult nowrap>&nbsp;<?php echo $data['name']?>&nbsp;</td>
            <td class=listresult nowrap>&nbsp;<?php echo $data['surname']?>&nbsp;</td>
            <td class=listresult nowrap>&nbsp;<?php echo $data['account_name']?>&nbsp;</td>
            <td class=listresult nowrap>&nbsp;<?php echo $data['userprofile_name']?>&nbsp;</td>
            <td class=listresult nowrap>&nbsp;<?php if($data['rstatus'] == STATUS_ENABLED) echo L_G_ENABLE;
                                            else echo L_G_DISABLE;?> &nbsp;</td>
            <td class=listresult nowrap>&nbsp;<?php echo $data['dateinserted']?>&nbsp;</td>
            <td class=listresultnocenter align="left">
                <?php $this->a_this->printActions($data) ?>
<!--                <select name=action_select OnChange="performAction(this);">
                <option value="-">------------------------</option>
                <?php if($this->a_action_permission['edit']) { ?>
                    <option value="javascript:editAdmin('<?php echo $data['userid']?>');"><?php echo L_G_EDIT?></option>
                <?php } ?>
                <?php if($this->a_Auth->getUserID() != $data['userid']) {
                    if($this->a_action_permission['delete']) {
                ?>
                    <option value="javascript:deleteAdmin('<?php echo $data['userid']?>');"><?php echo L_G_DELETE?></option>
                <?php }
                    if($this->a_action_permission['change_status']) {
                ?>
                    <option value="javascript:changeAdminStatus('<?php echo $data['userid']?>');">
                    <?php if($data['rstatus'] == STATUS_ENABLED) echo L_G_DISABLE; else echo L_G_ENABLE; ?></option>
                <?php   }
                    }
                ?>
                </select> -->
            </td>
            </tr>
            <?php
                }
            ?>
            </table>
        </td>
    </tr>
    <tr>
        <td align=left>
            <table width="100%" border="0" height="18" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" class=listheaderNoLine nowrap>
                    <?php QUnit_Templates::printPaging($this->a_list_page, $this->a_list_pages, $this->a_allcount) ?>
                </td>
            </tr>
            </table>
        </td>
    </tr>
    </table>
      <input type=hidden name=md value='Affiliate_Merchants_Views_AdminsManager'>
      <input type=hidden id=action name=action value=''>
      <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
      <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
 </form>
