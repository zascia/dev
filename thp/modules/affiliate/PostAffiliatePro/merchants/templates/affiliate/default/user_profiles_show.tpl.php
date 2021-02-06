
<script>
function addUserProfile()
{
document.location.href= "index.php?md=Affiliate_Merchants_Views_UserProfiles&action=add_new&<?php echo SID?>";
}

function editUserProfile(ID)
{
document.location.href= "index.php?md=Affiliate_Merchants_Views_UserProfiles&action=edit&upid="+ID+"&<?php echo SID?>";
}

function deleteUserProfile(ID)
{
  if(confirm("<?php echo L_G_CONFIRMDELETEUSERPROFILE?>"))
	document.location.href = "index.php?md=Affiliate_Merchants_Views_UserProfiles&upid="+ID+"&action=delete"+"&<?php echo SID?>";
}
</script>

<form name=FilterForm id=FilterForm action=index.php method=get>
<input type=hidden name=filtered value=1>
<input type=hidden name=md value='Affiliate_Merchants_Views_UserProfiles'>
<input type=hidden id=list_page name=list_page value='<?php echo $_REQUEST['list_page']?>'>
<input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
<input type=hidden id=action name=action value=''>
<input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
    <table cellpadding="0" cellspacing="0" border="0" width="780">
    <tr>
        <td valign=top><?php echo L_G_USERPROFILES_DESCRIPTION?><br><br>
        </td>
    </table>
    <br>

    <table border=0 cellspacing=0>
    <tr>
     <?php if($this->a_action_permission['add_new']) { ?>
       <td><input type=button class=formbutton value="<?php echo L_G_ADD_USER_PROFILE?>"  onclick="javascript:addUserProfile();">&nbsp;&nbsp;&nbsp;</td>
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
            <tr class=tablelistheader>
        <?php
            QUnit_Templates::printHeader(L_G_ID, 'up.userprofileid');
            QUnit_Templates::printHeader(L_G_NAME2, 'up.name');
            QUnit_Templates::printHeader(L_G_ACTIONS, '');
        ?>
            </tr>
        <?php
            while($data=$this->a_list_data->getNextRecord())
            {
        ?>
            <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
                <td class=listresultnocenter align=left nowrap>&nbsp;<?php echo $data['userprofileid']?>&nbsp;</td>
                <td class=listresultnocenter width="180%" align=left nowrap>&nbsp;<?php echo $data['name']?>&nbsp;</td>
                <td class=listresultnocenter align="left">
                <?php $this->a_this->printActions($data) ?>

<!--                    <select name=action_select OnChange="performAction(this);">
                    <option value="-">------------------------</option>
                    <?php if($this->a_action_permission['edit']) { ?>
                        <option value="javascript:editUserProfile('<?php echo $data['userprofileid']?>');"><?php echo L_G_EDIT?></option>
                    <?php }
                        if($this->a_action_permission['delete']) { ?>
                        <option value="javascript:deleteUserProfile('<?php echo $data['userprofileid']?>');"><?php echo L_G_DELETE?></option>
                    <?php } ?>
                    </select>-->
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

      <input type=hidden name=md value='Affiliate_Merchants_Views_UserProfiles'>
      <input type=hidden id=action name=action value=''>
      <input type=hidden id=sortby name=sortby value="<?php echo $_REQUEST['sortby']?>">
      <input type=hidden id=sortorder name=sortorder value="<?php echo $_REQUEST['sortorder']?>">
	</form>

</table>
</form>
<!-- FILTER -->
