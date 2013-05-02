<?php

require('../includes/admin_application_top.php');

$titlex = "AdVeh Dashboard";
require(DIR_WS_INCLUDES . 'body_header.php');
?>

<div id="edit-pages" class="home_menu_box">
	<div class="menu_header">
		<div id="icon-edit-pages" class="icon"></div>
		<div class="title"><a href="products_list.php"><span style="font-size: 20px; line-height: 31px;">Products</span></a></div>
	</div>
	<div class="menu_body">
		<div class="item">- <a href="products_list.php">Total Count: <b><?= teb_query("select count(*) as data_count from " . TABLE_PRODUCTS, "data_count")?></b></a></div>
		<div class="item">- <a href="products_edit.php">Create Products</a></div>
		<div class="item">- <a href="products_export.php">Export Products Data(csv)</a></div>
	</div>
</div>

<div id="edit-pages" class="home_menu_box">
	<div class="menu_header">
		<div id="icon-edit-pages" class="icon"></div>
		<div class="title"><a href="stores_list.php"><span style="font-size: 20px; line-height: 31px;">Stores</span></a></div>
	</div>
	<div class="menu_body">
		<div class="item">- <a href="stores_list.php">Total Count: <b><?= teb_query("select count(*) as data_count from " . TABLE_STORES, "data_count")?></b></a></div>
		<div class="item">- <a href="stores_edit.php">Create Stores</a></div>
		<div class="item">- <a href="stores_export.php">Export Stores Data(csv)</a></div>
	</div>
</div>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>