<?php
require('../includes/application_top.php');

if (tep_session_is_registered('appevolution_admin_userid')) {
	tep_redirect("admin/index.php");
}

$error = false;
$error_confirm = false;

$action = (isset($HTTP_POST_VARS['action']) ? $HTTP_POST_VARS['action'] : '');

$loginmsg = "";

if (tep_not_null($action) && $action == "process" )
{
	$user_name = tep_db_prepare_input($HTTP_POST_VARS['user_name']);
	$user_password = tep_db_prepare_input($HTTP_POST_VARS['user_password']);
	
	if ($user_name == "") {
		$error = true;
		$loginmsg = "Input Name.";
	} elseif ($user_password == "") {
		$error = true;
		$loginmsg = "Input password.";
	} else {
		$sql = "select * from " . TABLE_USERS . " where `user_name`='".$user_name."'";

		$check_query = tep_db_query($sql);
		if (tep_db_num_rows($check_query) == 1)
		{
			$loginned_user_info = tep_db_fetch_array($check_query);
			
			if (tep_validate_password($user_password, $loginned_user_info['user_password'])) {
				$appevolution_admin_userid			= $loginned_user_info['user_id'];
				$appevolution_admin_username		= $loginned_user_info['user_name'];
				
				tep_db_query("update ".TABLE_USERS." set user_last_logined='".tep_now_datetime()."' where user_id='".$appevolution_admin_userid."'");
				
				tep_session_register('appevolution_admin_userid');
				tep_session_register('appevolution_admin_username');
				
				tep_redirect("index.php");
			}
			else
			{
				$error = true;
				$loginmsg = "Incorrect password.";
			}
		} else {
			$error = true;
			$loginmsg = "Name or Password is not validate.";
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<title>Login: <?=SITE_TITLE?> Dashboard</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/global.css' type='text/css' />
<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/login.css' type='text/css' />
</head>

<body class="login">
	<div id="login">
		<!-- <h1>Chongtong Projects</h1> -->
		<form name="loginform" id="loginform" method="post" class="loginform">
			<input type=hidden name=action value="process" />
			
			<h1><?= SITE_TITLE?> Dashboard</h1>
			<p class="error">
			<?php if ($error == true): ?>
			<?= $loginmsg?>
			<?php endif; ?>
			</p>
			<p>
				<label>UserName:</label>
				<input type="text" name="user_name" id="user_login" class="input" value="" size="20" tabindex="10" />
			</p>
			<p>
				<label>Password:</label> 
				<input type="password" name="user_password" id="user_pass" class="input" value="" size="20" tabindex="20" />
			</p>
			
			<p class="submit">
				<input type="submit" name="wp-submit" onclick="" class="button-secondary action" value="Login" tabindex="100" />
				&nbsp;&nbsp;
				<input type="reset" name="wp-submit" value="Reset" tabindex="100" />
			</p>
		</form>		
	</div>
</body>
</html>