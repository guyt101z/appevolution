<?php
require('../includes/admin_application_top.php');

$coupon_id = tep_get_value_get("coupon_id");
$coupon_info = teb_one_query(TABLE_COUPONS, array("id"=>$coupon_id)); 

$titlex = 'Check List of "'.$coupon_info['title'].'"';

require(DIR_WS_INCLUDES . 'body_header.php');

$action = tep_db_prepare_input($_REQUEST['action']);
if ($action == 'all_delete') {
	$check_ids = tep_get_value_post("check_ids");
	
	for ($i = 0; $i < count($check_ids); $i ++) {
		teb_delete_query(TABLE_CHECKS, array("id"=>$check_ids[$i]));
	}
	
	tep_success_redirect("Succesed delete coupon.", "check_list.php?coupon_id=".$coupon_id);
}
?>

<?php if ($errors['db'] != ""): ?>
<p class="error"><?= $errors['db']?></p>
<?php endif; ?>

<form class="search_form" name="search_form" method="post">
	<div>
		<input type="button" value="Back" onclick="location.href='coupon_list.php'"/>
	</div>
</form>

<script type="text/javascript">
<!--
function all_action() {
	if (confirm("Are you sure want to delete?")) {
		document.dataListForm.submit();
	}
}
//-->
</script>

<form name="dataListForm" method="post" action="check_list.php?coupon_id=<?=$coupon_id?>" style="margin-top: 15px;">
	<input type="hidden" name="action" value="all_delete">
	Selected checks to <input type="button" value="Delete" onclick="all_action()">
<table class="contents_list" cellpadding="0" cellspacing="1">
<?php 
	$sort_column = "registed";
	$sort_order = "DESC";
	if (isset($_REQUEST['sort_column']))	$sort_column = tep_db_prepare_input($_REQUEST['sort_column']);
	if (isset($_REQUEST['sort_order']))		$sort_order = tep_db_prepare_input($_REQUEST['sort_order']);

	$table_headers = array();
	$table_headers[] = array('id'=>'', 'title'=>'<input type="checkbox" onchange="all_checkbox($(this))" />', 'width'=>'50');
	$table_headers[] = array('id'=>'', 'title'=>'Device');
	$table_headers[] = array('id'=>'registed', 'title'=>'When checked?', 'width'=>'200');
	
	$column_count = count($table_headers);
	
	include DIR_WS_BOX.'table_header.php';
?>

<?
	$sql = "select * from " . TABLE_CHECKS. " where coupon_id='".$coupon_id."'";
	$sql .= " order by ".$sort_column." ".$sort_order;
	
	$list_split = new splitPageResults($sql);
	$check_list = tep_db_query($list_split->sql_query);
 
	$row = 0;
	while ($check = tep_db_fetch_array($check_list)) {
		$row ++;
		
		$device = teb_one_query(TABLE_DEVICES, array("id"=>$check['device_id']));
?>	
<tbody>   
	<tr class='dataTableRow'>
		<td align="center">
			<input type="checkbox" name="check_ids[]" value="<?= $check['id']?>" class="all_check" />
		</td>
		<td>
			<?= $device['os']?> - <?= $device['device']?>
		</td>
		<td align="center">
			<?= $check['registed']?>
		</td>
	</tr>
<?php
	}
?>
</tbody>
<?php 
	$data_message = TEXT_DISPLAY_NUMBER_OF_CHECKS;
	$empty_message = "Empty check";
	include DIR_WS_BOX.'table_footer.php';
?>
</table>

</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>