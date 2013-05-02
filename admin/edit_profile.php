<?php
require_once('../includes/admin_application_top.php');

$user_id = $appevolution_admin_userid;
$user_basic = teb_one_query(TABLE_USERS, array("user_id"=>$user_id));
$titlex = "Edit Profile";
require(DIR_WS_INCLUDES . 'body_header.php');

$user_name = "";
$user_email = "";
$user_phone = "";

if (isset($_POST['user_name']))
{
	$user_name = tep_get_value_post('user_name', 'First Name', 'require;userid;length[3,50]');
	$user_email = tep_get_value_post('user_email', 'Email', 'require;email;');
	$user_phone = tep_get_value_post('user_phone', 'Phone', '');

	if ($message_cls->is_empty_error()) {
		$user = array(
			'user_name'			=> $user_name,
			'user_email'		=> $user_email,
			'user_phone'		=> $user_phone,
			'user_modified' 	=> tep_now_datetime()
		);
		
		$result = tep_db_perform(TABLE_USERS, $user, 'update', "user_id='".$appevolution_admin_userid."'");
		
		if ($result > 0) {
			tep_success_redirect("Success saved profile!", "edit_profile.php");
		} else {
			$error_db = "Faild save profile.";
		}
	}
} else {
	$user_basic = teb_one_query(TABLE_USERS, array("user_id"=>$appevolution_admin_userid));
	
	$user_email = $user_basic['user_email'];
	$user_phone = $user_basic['user_phone'];
	$user_name = $user_basic['user_name'];
}
?>

<form name="user_form" encType="multipart/form-data" method="post" autocomplete="off" class="edit_form" id="UserForm">
	<?php if (isset($error_db)): ?>
	<p class="error"><?= $error_db?></p>
	<?php endif; ?>
	
	<div class="alert forward">* Required information</div>
	<br />
	<table class="contents_edit" id="user_basic">
    	<tr>
			<td class="label">User Name *</td>
			<td class="edit">
				<input type="text" name="user_name" id="user_name" value="<?= $user_name?>" style="width: 300px;" class="validate[required,length[3-50]]" />
				<?php $message_cls->show_error('user_name')?>
			</td>
		</tr>
		<tr>
			<td class="label">Email *</td>
			<td class="edit">
				<input type="text" name="user_email" id="user_email" value="<?= $user_email?>" style="width: 300px;" class="validate[required,custom[email]]" />
				<?php $message_cls->show_error('user_email')?>
			</td>
		</tr>
		<tr>
			<td class="label">Cell Phone No.</td>
			<td class="edit">
				<input type="text" name="user_phone" id="user_phone" value="<?= $user_phone?>" style="width: 300px;" class="validate[length[-20]]" />
				<?php $message_cls->show_error('user_phone')?>
			</td>
		</tr>
	</table>
	
	<br /><br />
	<table class="contents_edit">
		<tr height="35px">
			<td width="100px"/>
			<td class="edit">
				<input type="submit" value="  Save " name="action" style="width:80px;"/>
			
				<input type="button" value="  Cancel " style="width:80px;" onclick="location.href='users.php'" />
			</td>
		</tr>	
	</table>
</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>