<?php
require('../includes/admin_application_top.php');

$titlex = "Stores";

require(DIR_WS_INCLUDES . 'body_header.php');

$action = tep_db_prepare_input($_REQUEST['action']);
if ($action == 'delete') {
	$id = tep_get_value_get('id');
	
	teb_delete_query(TABLE_STORES, array("id"=>$id));
	
	tep_success_redirect("Succesed delete store.", "stores_list.php");
} elseif ($action == 'actived') {
	$id = tep_get_value_get('id');
	$actived = tep_get_value_get('actived');
	
	tep_db_query("update ".TABLE_STORES." set actived='".$actived."' where `id`='".$id."'");
} elseif ($action == 'all_actived') {
	$store_ids = tep_get_value_post("store_ids");
	
	for ($i = 0; $i < count($store_ids); $i ++) {
		tep_db_query("update ".TABLE_STORES." set actived='Y' where `id`='".$store_ids[$i]."'");
	}
} elseif ($action == 'all_disabled') {
	$store_ids = tep_get_value_post("store_ids");
	
	for ($i = 0; $i < count($store_ids); $i ++) {
		tep_db_query("update ".TABLE_STORES." set actived='N' where `id`='".$store_ids[$i]."'");
	}
} elseif ($action == 'all_delete') {
	$store_ids = tep_get_value_post("store_ids");
	
	for ($i = 0; $i < count($store_ids); $i ++) {
		teb_delete_query(TABLE_STORES, array("id"=>$store_ids[$i]));
	}
	
	tep_success_redirect("Succesed delete store.", "stores_list.php");
}

$s_key = tep_db_prepare_input($_REQUEST['s_key']);
$s_active = tep_db_prepare_input($_REQUEST['s_active']);
?>

<?php if ($errors['db'] != ""): ?>
<p class="error"><?= $errors['db']?></p>
<?php endif; ?>

<form class="search_form" name="search_form" method="post">
	<div>		
		Search: <input type="text" name="s_key" value="<?= $s_key?>" />
		<input type="submit" value="Search" />&nbsp;&nbsp;&nbsp;
		<input type="button" value="Add Store" onclick="location.href='stores_edit.php'"/>
	</div>
</form>

<script type="text/javascript">
<!--
function delete_new(id, title) {
	if (confirm("Are you sure want to delete "+title+"?")) {
		location.href = "stores_list.php?action=delete&id=" + id;
	}
}

function all_action() {
	if (confirm("Are you sure want to process?")) {
		document.dataListForm.submit();
	}
}
//-->
</script>

<form name="dataListForm" method="post" action="stores_list.php" style="margin-top: 15px;"> 
	
<table class="contents_list" cellpadding="0" cellspacing="1">
<?php 
	$sort_column = "name";
	$sort_order = "ASC";
	if (isset($_REQUEST['sort_column']))	$sort_column = tep_db_prepare_input($_REQUEST['sort_column']);
	if (isset($_REQUEST['sort_order']))		$sort_order = tep_db_prepare_input($_REQUEST['sort_order']);

	$table_headers = array();
	$table_headers[] = array('id'=>'', 'title'=>'<input type="checkbox" onchange="all_checkbox($(this))" />', 'width'=>'50');
	$table_headers[] = array('id'=>'id', 'title'=>'ID', 'width'=>'100');
	$table_headers[] = array('id'=>'', 'title'=>'Photo', 'width'=>'60');
	$table_headers[] = array('id'=>'name', 'title'=>'Name', 'width'=>'100');
	$table_headers[] = array('id'=>'', 'title'=>'Location', 'width'=>'300');   
    $table_headers[] = array('id'=>'description', 'title'=>'Description', 'width'=>'');
	$table_headers[] = array('id'=>'created', 'title'=>'When Posted', 'width'=>'170');
	$table_headers[] = array('id'=>'', 'title'=>'Action', 'width'=>'200');
	
	$column_count = count($table_headers);
	
	include DIR_WS_BOX.'table_header.php';
?>

<?
	$sql = "select * from " . TABLE_STORES. " where 1=1";
	if ($s_key != '') {
		$sql.= " and LOWER(name) like '%".strtolower($s_key)."%'";
	}
	if ($s_active != '') {
		$sql.= " and actived = '".$s_active."'";
	}
	$sql .= " order by ".$sort_column." ".$sort_order;
	
	$list_split = new splitPageResults($sql);
	$stores_list = tep_db_query($list_split->sql_query);
 
	$row = 0;
	while ($store = tep_db_fetch_array($stores_list)) {
		$row ++;
		
		$ext_params = "&id=".$store['id']."&s_active=".$s_active."&s_key=".$s_key."&sort_column=".$sort_column."&sourt_order=".$sort_order."&page=".$page;
?>	
<tbody>   
	<tr class='dataTableRow'>
		<td align="center">
			<input type="checkbox" name="store_ids[]" value="<?= $store['id']?>" class="all_check" />
		</td>
		<td align="center">
			<a class="link" href="stores_edit.php?id=<?= $store['id']?>" title="View Detail"><?=$store['id']?></a>
		</td>
		<td align="center">
			<img src="<?=$store['image_web_thumb']?>" width="50"/>
		</td>
		<td align="left">
			<a class="link" href="stores_edit.php?id=<?= $store['id']?>" title="View Detail"><?=$store['name']?></a>
		</td>
		<td align="center">
			<a href="#" onclick="view_location('<?=$store['latitude']?>', '<?=$store['longitude']?>')"><?= $store['location']?></a>
		</td>
		<td align="center"><?=$store['description']?></td>
		<td align="center"><?=$store['created']?></td>
		<td align="center">
        	<a class="button" href="stores_edit.php?id=<?= $store['id']?>" title="Edit">Edit</a>
        	<a class="button" href="javascript:delete_new(<?= $store['id']?>, '<?=$store['name']?>')" title="Edit">Delete</a>        
        </td>
	</tr>
<?php
	}
?>
</tbody>
<?php 
	$data_message = TEXT_DISPLAY_NUMBER_OF_STORES;
	$empty_message = "Empty store";
	include DIR_WS_BOX.'table_footer.php';
?>
</table>

</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>