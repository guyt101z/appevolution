<?php
require_once('../includes/admin_application_top.php');

$titlex = "Send Message";
require(DIR_WS_INCLUDES . 'body_header.php');

$message = "";

if (isset($_POST['message']))
{
	$message = tep_get_value_post('message', 'Message', 'require;length[3,200]');

	if ($message_cls->is_empty_error()) {
		$devices = teb_multi_query(TABLE_DEVICES, array());
		while ($device = tep_db_fetch_array($devices)) {
			if ($device['os'] == 'iphone') {
				iphone_push_notification($device['device'], $message);
			}
		}
	}
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
			<td class="label">Message *</td>
			<td class="edit">
				<input type="text" name="message" id="message" value="" style="width: 600px;" class="validate[required,length[3-50]]" />
				<?php $message_cls->show_error('message')?>
			</td>
		</tr>
	</table>
	
	<table class="contents_edit">
		<tr height="35px">
			<td width="120px"/>
			<td class="edit">
				<input type="submit" value="  Send " name="action" style="width:80px;"/>
			</td>
		</tr>	
	</table>
</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>