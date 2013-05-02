<?php include '../includes/application_top.php';?>
<html>
<head>
	<title>Send Email</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	
	<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/jquery_ui/jquery-ui-1.8.16.custom.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/jquery_ui/validationEngine.jquery.css' type='text/css'/>
	
	<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/global.css' type='text/css' />
	
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/jquery-1.6.2.min.js'></script>
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/jquery-ui-1.8.16.custom.min.js'></script>
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/jscript_jquery.validationEngine-en.js'></script>
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/jscript_jquery.validationEngine.js'></script>
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/general.js'></script>
</head>

<body>
<?php 
$user_id = tep_get_value_get("user_id");
$user_info = teb_one_query(TABLE_USERS, array("user_id"=>$user_id));

if (isset($_POST['action'])) {
	$email_subject = tep_get_value_post("email_subject", "Subject", "require;");
	$email_body = tep_get_value_post("email_body");
	
	$result = tep_phpmail($user_info['user_firstname']." ".$user_info['user_lastname'], $user_info['user_email'], $email_subject, $email_body);
	
	if ($result) {
		$s_process = "Succesed sent email.";
	} else {
		$db_error = "Failed send email.";
	}
}
?>

<form name="action_form" method="post" id="EditForm" autocomplete="off" style="width: 600px; margin: 20px 30px; height: 400px;">

	<?php if (isset($s_process)):?>
	<div class="message"><?= $s_process?></div>
	<?php endif;?>
	
	<?php if (isset($error_db)): ?>
	<p class="error"><?= $error_db?></p>
	<?php endif; ?>

	<table class="contents_edit" cellpadding="1" cellspacing="3">
		<tr>					
			<td align="left" style="width: 80px;">To Name:</td>
			<td class="edit"><?= $user_info['user_firstname']?> <?= $user_info['user_lastname']?></td> 				
		</tr>
		
		<tr>					
			<td align="left" style="width: 80px;">To Email:</td>
			<td class="edit"><?= $user_info['user_email']?></td> 				
		</tr>
		
		<tr>					
			<td align="left" style="width: 80px;">Subject:</td>
			<td class="edit">
				<input type="text" name="email_subject" id="email_subject" value="<?=$email_subject?>" style="width: 500px;" />
				<?= $message_cls->show_error("email_subject")?>
			</td> 				
		</tr>
		
		<tr>					
			<td colspan="2">
				<textarea name="email_body" style="width: 100%; height: 150px;"><?= $email_body?></textarea>
			</td>
		</tr>
		
		<tr height="35px">
			<td colspan="2">
				<input type="submit" value="  Send " name="action"/>
			</td>
		</tr>
	</table>
</form>

</body>