<?php
require('../includes/admin_application_top.php');

$titlex = "Coupons";

require(DIR_WS_INCLUDES . 'body_header.php');

$action = tep_db_prepare_input($_REQUEST['action']);
if ($action == 'delete') {
	$id = tep_get_value_get('id');
	
	teb_delete_query(TABLE_COUPONS, array("id"=>$id));
	
	tep_success_redirect("Succesed delete coupon.", "coupon_list.php");
} elseif ($action == 'actived') {
	$id = tep_get_value_get('id');
	$actived = tep_get_value_get('actived');
	
	if ($actived == 'Y') {
		$coupon = teb_one_query(TABLE_COUPONS, array("id"=>$id));
		
		tep_db_query("update ".TABLE_COUPONS." set actived='N' where `store_id`='".$coupon['store_id']."'");
	}
	
	tep_db_query("update ".TABLE_COUPONS." set actived='".$actived."' where `id`='".$id."'");
} elseif ($action == 'all_actived') {
	$coupon_ids = tep_get_value_post("coupon_ids");
	
	for ($i = 0; $i < count($coupon_ids); $i ++) {
		tep_db_query("update ".TABLE_COUPONS." set actived='Y' where `id`='".$coupon_ids[$i]."'");
	}
} elseif ($action == 'all_disabled') {
	$coupon_ids = tep_get_value_post("coupon_ids");
	
	for ($i = 0; $i < count($coupon_ids); $i ++) {
		tep_db_query("update ".TABLE_COUPONS." set actived='N' where `id`='".$coupon_ids[$i]."'");
	}
} elseif ($action == 'all_delete') {
	$coupon_ids = tep_get_value_post("coupon_ids");
	
	for ($i = 0; $i < count($coupon_ids); $i ++) {
		teb_delete_query(TABLE_COUPONS, array("id"=>$coupon_ids[$i]));
	}
	
	tep_success_redirect("Succesed delete coupon.", "coupon_list.php");
}

$s_key = tep_db_prepare_input($_REQUEST['s_key']);
$s_store = tep_db_prepare_input($_REQUEST['s_store']);
$s_active = tep_db_prepare_input($_REQUEST['s_active']);
//$s_start = tep_db_prepare_input($_REQUEST['s_start']);
//$s_end = tep_db_prepare_input($_REQUEST['s_end']);

if ($s_start == '') $s_start = date('2012-01-01');
if ($s_end == '') $s_end = date('Y-m-d');
?>

<?php if ($errors['db'] != ""): ?>
<p class="error"><?= $errors['db']?></p>
<?php endif; ?>

<form class="search_form" name="search_form" method="post">
	<div>
		Location: <select name="s_store" onchange="this.form.submit()" style="width: 150px;">
			<option value="">-- All --</option>
		<?php $stores = tep_db_query("select * from ".TABLE_STORES." order by title"); while($store = tep_db_fetch_array($stores)):?>
			<option value="<?= $store['id']?>" <?php if ($s_store == $store['id']) echo "selected"?>><?= $store['title']?></option>
		<?php endwhile;?>
			<option value="0" <?php if ($s_store == '0') echo "selected"?>>Others</option>
		</select>&nbsp;&nbsp;&nbsp;
		Active: <select name="s_active" onchange="this.form.submit()">
			<option value="">-- All --</option>
			<option value="Y" <?php if ($s_active == 'Y') echo "selected"?>>Active</option>
			<option value="N" <?php if ($s_active == 'N') echo "selected"?>>InActive</option>
		</select>&nbsp;&nbsp;&nbsp;
		
		Search: <input type="text" name="s_key" value="<?= $s_key?>" />
		<input type="submit" value="Search" />&nbsp;&nbsp;&nbsp;
		<input type="button" value="Add Coupon" onclick="location.href='coupon_edit.php'"/>
	</div>
</form>

<script type="text/javascript">
<!--
function delete_new(id, title) {
	if (confirm("Are you sure want to delete "+title+"?")) {
		location.href = "coupon_list.php?action=delete&id=" + id;
	}
}

function all_action() {
	if (confirm("Are you sure want to delete?")) {
		document.dataListForm.submit();
	}
}
//-->
</script>

<form name="dataListForm" method="post" action="coupon_list.php" style="margin-top: 15px;">
	<input type="hidden" name="s_active" value="<?= $s_active?>">
	<input type="hidden" name="s_store" value="<?= $s_store?>">
	<input type="hidden" name="s_key" value="<?= $s_key?>">
	<input type="hidden" name="action" value="all_delete">
	
	Selected coupon to <input type="button" value="Delete" onclick="all_action()">
<table class="contents_list" cellpadding="0" cellspacing="1">
<?php 
	$sort_column = "created";
	$sort_order = "DESC";
	if (isset($_REQUEST['sort_column']))	$sort_column = tep_db_prepare_input($_REQUEST['sort_column']);
	if (isset($_REQUEST['sort_order']))		$sort_order = tep_db_prepare_input($_REQUEST['sort_order']);

	$table_headers = array();
	$table_headers[] = array('id'=>'', 'title'=>'<input type="checkbox" onchange="all_checkbox($(this))" />', 'width'=>'50');
	$table_headers[] = array('id'=>'id', 'title'=>'ID', 'width'=>'100');
	$table_headers[] = array('id'=>'', 'title'=>'Photo', 'width'=>'60');
	$table_headers[] = array('id'=>'', 'title'=>'Location', 'width'=>'200');
	$table_headers[] = array('id'=>'title', 'title'=>'Title', 'width'=>'');
	$table_headers[] = array('title'=>'GPS', 'width'=>'50');
	$table_headers[] = array('title'=>'Distance', 'width'=>'110');
	$table_headers[] = array('title'=>'Check Count', 'width'=>'100');
	$table_headers[] = array('id'=>'', 'title'=>'Action', 'width'=>'200');
	
	$column_count = count($table_headers);
	
	include DIR_WS_BOX.'table_header.php';
?>

<?
	$sql = "select * from " . TABLE_COUPONS. " where 1=1";
	if ($s_key != '') {
		$sql.= " and LOWER(title) like '%".strtolower($s_key)."%'";
	}
	if ($s_active != '') {
		$sql.= " and actived = '".$s_active."'";
	}
	if ($s_store != '') {
		$sql.= " and store_id = '".$s_store."'";
	}
	$sql .= " order by ".$sort_column." ".$sort_order;
	
	$list_split = new splitPageResults($sql);
	$coupon_list = tep_db_query($list_split->sql_query);
 
	$row = 0;
	while ($coupon = tep_db_fetch_array($coupon_list)) {
		$row ++;
		
		$check_count = teb_query("select count(*) as data_count from ".TABLE_CHECKS." where coupon_id='".$coupon['id']."'", "data_count");
		
		$ext_params = "&id=".$coupon['id']."&s_store=".$s_store."&s_active=".$s_active."&s_start=".$s_start."&s_end=".$s_end."&s_key=".$s_key."&sort_column=".$sort_column."&sourt_order=".$sort_order."&page=".$page;
?>	
<tbody>   
	<tr class='dataTableRow'>
		<td align="center">
			<input type="checkbox" name="coupon_ids[]" value="<?= $coupon['id']?>" class="all_check" />
		</td>
		<td align="center">
			<a class="link" href="coupon_edit.php?id=<?= $coupon['id']?>" title="View Detail"><?=$coupon['id']?></a>
		</td>
		<td align="center">
			<img src="<?=$coupon['image_web_thumb']?>" width="50"/>
		</td>
		<td align="center">
		<?php if ($coupon['store_id'] > 0) :?>
			<a class="link" href="store_edit.php?id=<?= $coupon['store_id']?>" title="View Detail">
				<?= teb_query("select title from ".TABLE_STORES." where `id`='".$coupon['store_id']."'", "title")?>
			</a>
		<?php endif;?>
		</td>
		<td align="left">
			<a class="link" href="coupon_edit.php?id=<?= $coupon['id']?>" title="View Detail"><?=$coupon['title']?></a>
		</td>
		<td align="center"><?=$coupon['is_gps_check']?></td>
		<td align="center"><?=$coupon['distance']?></td>
		<td align="center">
			<a href="check_list.php?coupon_id=<?= $coupon['id']?>"><?=$check_count?></a>
		</td>
		<td align="center">
        	<a class="button" href="coupon_edit.php?id=<?= $coupon['id']?>" title="Edit">Edit</a>
        	<a class="button" href="javascript:delete_new(<?= $coupon['id']?>, '<?=$coupon['title']?>')" title="Edit">Delete</a>
        <?php if ($coupon['actived'] == 'Y') : ?>
        	<a class="button" href="coupon_list.php?action=actived&actived=N<?= $ext_params?>" title="Edit"><font color="red">Active</font></a>
        <?php else : ?>
        	<a class="button" href="coupon_list.php?action=actived&actived=Y<?= $ext_params?>" title="Edit">InActive</a>
        <?php endif;?>
        </td>
	</tr>
<?php
	}
?>
</tbody>
<?php 
	$data_message = TEXT_DISPLAY_NUMBER_OF_BRANDS;
	$empty_message = "Empty coupon";
	include DIR_WS_BOX.'table_footer.php';
?>
</table>

</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>