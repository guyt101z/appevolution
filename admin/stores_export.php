<?php
require('../includes/admin_application_top.php');

$action = tep_get_value_post('action');
if ($action == 'Export') {
	$export_file_name = tep_get_value_post('export_file_name');
	
	export_table_csv(TABLE_STORES, $export_file_name);
	exit();
}

$titlex = "Stores export(.csv)";
require(DIR_WS_INCLUDES . 'body_header.php');
?>

<form name="" encType="multipart/form-data" method="post" autocomplete="off" class="edit_form" id="EditForm" target="export_result">
	CVS file name: <input type="text" name="export_file_name" id="export_file_name" value="location_list_<?= date('YmdHis')?>.csv" style="width: 250px;" class="validate[required]"/>
	<input type="submit" value="Export" name="action"/>
</form>

<iframe name="export_result" style="display: ; width: 500px; height: 200px;"></iframe>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>