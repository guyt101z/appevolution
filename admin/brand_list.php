<?php
require('../includes/admin_application_top.php');

$titlex = "Brands";

require(DIR_WS_INCLUDES . 'body_header.php');

$action = tep_db_prepare_input($_REQUEST['action']);
if ($action == 'delete') {
	$id = tep_get_value_get('id');
	
	teb_delete_query(TABLE_BRANDS, array("id"=>$id));
	
	tep_success_redirect("Succesed delete brand.", "brand_list.php");
} elseif ($action == 'actived') {
	$id = tep_get_value_get('id');
	$actived = tep_get_value_get('actived');
	
	tep_db_query("update ".TABLE_BRANDS." set actived='".$actived."' where `id`='".$id."'");
} elseif ($action == 'all_actived') {
	$brand_ids = tep_get_value_post("brand_ids");
	
	for ($i = 0; $i < count($brand_ids); $i ++) {
		tep_db_query("update ".TABLE_BRANDS." set actived='Y' where `id`='".$brand_ids[$i]."'");
	}
} elseif ($action == 'all_disabled') {
	$brand_ids = tep_get_value_post("brand_ids");
	
	for ($i = 0; $i < count($brand_ids); $i ++) {
		tep_db_query("update ".TABLE_BRANDS." set actived='N' where `id`='".$brand_ids[$i]."'");
	}
} elseif ($action == 'all_delete') {
	$brand_ids = tep_get_value_post("brand_ids");
	
	for ($i = 0; $i < count($brand_ids); $i ++) {
		teb_delete_query(TABLE_BRANDS, array("id"=>$brand_ids[$i]));
	}
	
	tep_success_redirect("Succesed delete brand.", "brand_list.php");
}

$s_key = tep_db_prepare_input($_REQUEST['s_key']);
$s_store = tep_db_prepare_input($_REQUEST['s_store']);
$s_active = tep_db_prepare_input($_REQUEST['s_active']);
$s_start = tep_db_prepare_input($_REQUEST['s_start']);
$s_end = tep_db_prepare_input($_REQUEST['s_end']);

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
		Date: <input type="text" name="s_start" value="<?= $s_start?>" style="width: 90px;" id="s_start" class="input_date" />~<input type="text" name="s_end" value="<?= $s_end?>" style="width: 90px;" id="s_end" class="input_date" />
		<p>
			Search: <input type="text" name="s_key" value="<?= $s_key?>" />
			<input type="submit" value="Search" />&nbsp;&nbsp;&nbsp;
			<input type="button" value="Add Brand" onclick="location.href='brand_edit.php'"/>
		</p>
	</div>
</form>

<script type="text/javascript">
<!--
function delete_new(id, title) {
	if (confirm("Are you sure want to delete "+title+"?")) {
		location.href = "brand_list.php?action=delete&id=" + id;
	}
}

function all_action() {
	if (confirm("Are you sure want to process?")) {
		document.dataListForm.submit();
	}
}
//-->
</script>

<form name="dataListForm" method="post" action="brand_list.php" style="margin-top: 15px;">
	<input type="hidden" name="s_active" value="<?= $s_active?>">
	<input type="hidden" name="s_store" value="<?= $s_store?>">
	<input type="hidden" name="s_start" value="<?= $s_start?>">
	<input type="hidden" name="s_end" value="<?= $s_end?>">
	<input type="hidden" name="s_key" value="<?= $s_key?>">
	
	Selected brand to: <select name="action" onchange="all_action()">
		<option value="">---</option>
		<option value="all_actived">Active</option>
		<option value="all_disabled">InActive</option>
		<option value="all_delete">Delete</option>
	</select>
	
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
	$table_headers[] = array('id'=>'created', 'title'=>'When Posted', 'width'=>'170');
	$table_headers[] = array('id'=>'', 'title'=>'Action', 'width'=>'200');
	
	$column_count = count($table_headers);
	
	include DIR_WS_BOX.'table_header.php';
?>

<?
	$sql = "select * from " . TABLE_BRANDS. " where (created between '".$s_start." 00:00:00' and '".$s_end." 23:59:59')";
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
	$brand_list = tep_db_query($list_split->sql_query);
 
	$row = 0;
	while ($brand = tep_db_fetch_array($brand_list)) {
		$row ++;
		
		$ext_params = "&id=".$brand['id']."&s_store=".$s_store."&s_active=".$s_active."&s_start=".$s_start."&s_end=".$s_end."&s_key=".$s_key."&sort_column=".$sort_column."&sourt_order=".$sort_order."&page=".$page;
?>	
<tbody>   
	<tr class='dataTableRow'>
		<td align="center">
			<input type="checkbox" name="brand_ids[]" value="<?= $brand['id']?>" class="all_check" />
		</td>
		<td align="center">
			<a class="link" href="brand_edit.php?id=<?= $brand['id']?>" title="View Detail"><?=$brand['id']?></a>
		</td>
		<td align="center">
			<img src="<?=$brand['image_web_thumb']?>" width="50"/>
		</td>
		<td align="center">
		<?php if ($brand['store_id'] > 0) :?>
			<a class="link" href="store_edit.php?id=<?= $brand['store_id']?>" title="View Detail">
				<?= teb_query("select title from ".TABLE_STORES." where `id`='".$brand['store_id']."'", "title")?>
			</a>
		<?php endif;?>
		</td>
		<td align="left">
			<a class="link" href="brand_edit.php?id=<?= $brand['id']?>" title="View Detail"><?=$brand['title']?></a>
		</td>
		<td align="center"><?=$brand['created']?></td>
		<td align="center">
        	<a class="button" href="brand_edit.php?id=<?= $brand['id']?>" title="Edit">Edit</a>
        	<a class="button" href="javascript:delete_new(<?= $brand['id']?>, '<?=$brand['title']?>')" title="Edit">Delete</a>
        <?php if ($brand['actived'] == 'Y') : ?>
        	<a class="button" href="brand_list.php?action=actived&actived=N<?= $ext_params?>" title="Edit">Active</a>
        <?php else : ?>
        	<a class="button" href="brand_list.php?action=actived&actived=Y<?= $ext_params?>" title="Edit">InActive</a>
        <?php endif;?>
        </td>
	</tr>
<?php
	}
?>
</tbody>
<?php 
	$data_message = TEXT_DISPLAY_NUMBER_OF_BRANDS;
	$empty_message = "Empty brand";
	include DIR_WS_BOX.'table_footer.php';
?>
</table>

</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>