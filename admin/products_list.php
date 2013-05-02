<?php
date_default_timezone_set('America/Los_Angeles');     
require('../includes/admin_application_top.php');

$titlex = "Products";

require(DIR_WS_INCLUDES . 'body_header.php');

$action = tep_db_prepare_input($_REQUEST['action']);
if ($action == 'delete') {
	$id = tep_get_value_get('id');
	
	teb_delete_query(TABLE_PRODUCTS, array("id"=>$id));
	
	tep_success_redirect("Succesed delete products.", "products_list.php");
} elseif ($action == 'actived') {
	$id = tep_get_value_get('id');
	$actived = tep_get_value_get('actived');
	
	tep_db_query("update ".TABLE_PRODUCTS." set actived='".$actived."' where `id`='".$id."'");
} elseif ($action == 'all_actived') {
	$products_ids = tep_get_value_post("products_ids");
	
	for ($i = 0; $i < count($products_ids); $i ++) {
		tep_db_query("update ".TABLE_PRODUCTS." set actived='Y' where `id`='".$products_ids[$i]."'");
	}
} elseif ($action == 'all_disabled') {
	$products_ids = tep_get_value_post("products_ids");
	
	for ($i = 0; $i < count($products_ids); $i ++) {
		tep_db_query("update ".TABLE_PRODUCTS." set actived='N' where `id`='".$products_ids[$i]."'");
	}
} elseif ($action == 'all_delete') {
	$products_ids = tep_get_value_post("products_ids");
	
	for ($i = 0; $i < count($products_ids); $i ++) {
		teb_delete_query(TABLE_PRODUCTS, array("id"=>$products_ids[$i]));
	}
	
	tep_success_redirect("Succesed delete products.", "products_list.php");
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
       Date: <input type="text" name="s_start" value="<?= $s_start?>" style="width: 90px;" id="s_start" class="input_date" />~<input type="text" name="s_end" value="<?= $s_end?>" style="width: 90px;" id="s_end" class="input_date" />
        <p>
            Search: <input type="text" name="s_key" value="<?= $s_key?>" />
            <input type="submit" value="Search" />&nbsp;&nbsp;&nbsp;
            <input type="button" value="Add Products" onclick="location.href='products_edit.php'"/>
        </p>
	</div>
</form>

<script type="text/javascript">
<!--
function delete_new(id, name) {
	if (confirm("Are you sure want to delete "+name+"?")) {
		location.href = "products_list.php?action=delete&id=" + id;
	}
}

function all_action() {
	if (confirm("Are you sure want to process?")) {
		document.dataListForm.submit();
	}
}
//-->
</script>

<form name="dataListForm" method="post" action="products_list.php" style="margin-top: 15px;">
	<input type="hidden" name="s_active" value="<?= $s_active?>">
	<input type="hidden" name="s_store" value="<?= $s_store?>">
	<input type="hidden" name="s_start" value="<?= $s_start?>">
	<input type="hidden" name="s_end" value="<?= $s_end?>">
	<input type="hidden" name="s_key" value="<?= $s_key?>">	
	
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
	$table_headers[] = array('id'=>'name', 'title'=>'Name', 'width'=>'200');
	$table_headers[] = array('id'=>'description', 'title'=>'Description', 'width'=>'');   
	$table_headers[] = array('id'=>'', 'title'=>'When Posted', 'width'=>'200');
	$table_headers[] = array('id'=>'', 'title'=>'Action', 'width'=>'170');
	
	$column_count = count($table_headers);
	
	include DIR_WS_BOX.'table_header.php';
?>

<?
	$sql = "select * from " . TABLE_PRODUCTS. " where (created between '".$s_start." 00:00:00' and '".$s_end." 23:59:59')";
	if ($s_key != '') {
		$sql.= " and LOWER(name) like '%".strtolower($s_key)."%'";
	}
	if ($s_active != '') {
		$sql.= " and actived = '".$s_active."'";
	}
	if ($s_store != '') {
		$sql.= " and store_id = '".$s_store."'";
	}
	$sql .= " order by ".$sort_column." ".$sort_order;
	
	$list_split = new splitPageResults($sql);
	$products_list = tep_db_query($list_split->sql_query);
 
	$row = 0;
	while ($products = tep_db_fetch_array($products_list)) {
		$row ++;
		
		$ext_params = "&id=".$products['id']."&s_store=".$s_store."&s_active=".$s_active."&s_start=".$s_start."&s_end=".$s_end."&s_key=".$s_key."&sort_column=".$sort_column."&sourt_order=".$sort_order."&page=".$page;
?>	
<tbody>   
	<tr class='dataTableRow'>
		<td align="center">
			<input type="checkbox" name="products_ids[]" value="<?= $products['id']?>" class="all_check" />
		</td>
		<td align="center">
			<a class="link" href="products_edit.php?id=<?= $products['id']?>" title="View Detail"><?=$products['id']?></a>
		</td>
		<td align="center">
			<img src="<?=$products['image_web_thumb']?>" width="50"/>
		</td>
		<td align="center">
		    <a class="link" href="products_edit.php?id=<?= $products['id']?>" title="View Detail"><?=$products['name']?></a>
		</td>
		<td align="left">
			<?=$products['description']?>
		</td>              
		<td align="center"><?=$products['created']?></td>
		<td align="center">
        	<a class="button" href="products_edit.php?id=<?= $products['id']?>" title="Edit">Edit</a>
        	<a class="button" href="javascript:delete_new(<?= $products['id']?>, '<?=$products['name']?>')" title="Edit">Delete</a>
        </td>
	</tr>
<?php
	}
?>
</tbody>
<?php 
	$data_message = TEXT_DISPLAY_NUMBER_OF_PRODUCTS;
	$empty_message = "Empty products";
	include DIR_WS_BOX.'table_footer.php';
?>
</table>

</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>