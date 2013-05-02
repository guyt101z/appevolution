<?php
require('../includes/admin_application_top.php');

$titlex = "Change Password";
require(DIR_WS_INCLUDES . 'body_header.php');

$password = "";
$repassword = "";

if (isset($_POST['action']))
{
	$old_password = tep_get_value_post("old_password", "require;length[3,20]");
	$newpassword = tep_get_value_post("newpassword", "require;length[3,20]");
	$repassword = tep_get_value_post("repassword", "require;equals['password']");
	
	$old_pwd = teb_query("select user_password from " . TABLE_USERS . " where user_id='".$appevolution_admin_userid."'", "user_password");
	if (!tep_validate_password($old_password, $old_pwd)) {
		$message_cls->set_error('old_password', "Old password is incorrect.");
	}
	
	if ($message_cls->is_empty_error()) {
		$reulst = tep_db_perform(TABLE_USERS, array("user_password" => tep_encrypt_password($newpassword)), "update", "user_id='".$appevolution_admin_userid."'");

		if ($reulst > 0) {
			tep_success_redirect("Success changed password!", "change_password.php");
		}
	}
} else {
	
}

?>

<?= $message_cls->show_error("database", "database_error")?>
<form name="action_form" method="post" class="edit_form" id="EditForm" autocomplete="off">
	<table class="contents_edit" cellpadding="1" cellspacing="3">
		<tr>					
			<td class="label">Old Password:</td>
			<td class="edit">
				<input type="password" name="old_password" id="old_password" class="validate[required]" value="" size="20" />				
				<?= $message_cls->show_error("old_password")?>
			</td> 				
		</tr>
		
		<tr>					
			<td class="label">New Password:</td>
			<td class="edit">
				<input type="password" name="newpassword" id="newpassword" class="validate[required,length[6-20]]" value="" size="20" />				
				<?= $message_cls->show_error("newpassword")?>
			</td> 				
		</tr>
		
		<tr>					
			<td class="label" width="10%">Re Password:</td>
			<td class="edit">
				<input type="password" name="repassword" id="repassword" class="validate[required,equals[newpassword]]" value="" size="20" />
				<?= $message_cls->show_error("repassword")?>
			</td> 				
		</tr>
		
		<tr height="35px">
			<td />
			<td class="edit">
				<input type="submit" value="  Save " name="action"/>
			</td>
		</tr>
	</table>
</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>