<?php
require('../includes/admin_application_top.php');

$titlex = "Create Store";

$id = 0;
if (isset($_GET['id'])) {
	$titlex = "Store Edit";
	$id = tep_get_value_get("id");
}

require(DIR_WS_INCLUDES . 'body_header.php');

$name			= "";
$sort_description	= "";
$description	= "";
$image_original	= "";
$image_web		= "";
$image_web_thumb= "";
$location		= "";
$latitude		= 0;
$longitude		= 0;
$created		= "";

if (isset($_POST["name"]))
{
	$name			= tep_get_value_post('name', 'Name', 'require;length[5,200];');
	$description	= tep_get_value_post('description', 'Description', 'require;length[5,2000];');

	$image_original = upload_file($name, 'image', $id == 0);
	if ($image_original != '' && $upload_img_path != '') {
		$image_web			= formated_image($image_original, $upload_img_path, 600, 400);
		$image_web_thumb	= formated_image($image_original, $upload_img_path, 187, 105, true);
		$image_mobile		= formated_image($image_original, $upload_img_path, 320, 215);
		$image_mobile_thumb	= formated_image($image_original, $upload_img_path, 100, 100);
	}
        
	$location		= tep_get_value_post('location', 'Location', 'require');
	$latitude		= tep_get_value_post('latitude', 'Latitude', 'require');
	$longitude		= tep_get_value_post('longitude', 'Longitude', 'require');
	
	if ($message_cls->is_empty_error()) {
		$store = array(
			'name'			=> $name,
			"description"	=> $description,			
			'location'		=> $location,
			'latitude'		=> $latitude,
			'longitude'		=> $longitude
		);
		
		if ($id == 0) {
			$store['created']			= tep_now_datetime();
			$store['image_original']	= $image_original;
			$store['image_web']			= $image_web;
			$store['image_web_thumb']	= $image_web_thumb;
			$store['image_mobile']		= $image_mobile;
			$store['image_mobile_thumb']= $image_mobile_thumb;
			
			$result = tep_db_perform(TABLE_STORES, $store, 'insert');
			if ($result > 0) {
				$id = tep_db_insert_id();
				
				tep_success_redirect("Success new registed location!", "stores_edit.php?id=".$id);
			}
		} else {
			if ($image_web != '') {
				$store['image_original']		= $image_original;
				$store['image_web']			= $image_web;
				$store['image_web_thumb']	= $image_web_thumb;
				$store['image_mobile']		= $image_mobile;
				$store['image_mobile_thumb']= $image_mobile_thumb;
			}
			
			$result = tep_db_perform(TABLE_STORES, $store, 'update', "id='".$id."'");
		}
		
		if ($result > 0) {
			tep_success_redirect("Success saved store information!", "stores_edit.php?id=".$id);
		} else {
			$error_db = "Faild register Location.";
		}
	}
} elseif($id > 0) {
	$store_info = teb_one_query(TABLE_STORES, array("id"=>$id));
	
	$name			= $store_info['name'];
	$sort_description	= $store_info['sort_description'];
	$description	= $store_info['description'];
	$image_original	= $store_info['image_original'];
	$image_web_thumb= $store_info['image_web_thumb'];
	$location		= $store_info['location'];
	$latitude		= $store_info['latitude'];
	$longitude		= $store_info['longitude'];
	$created		= $store_info['created'];
}
?>

<form name="ad_form" encType="multipart/form-data" method="post" autocomplete="off" class="edit_form" id="ADForm">
	<?php if (isset($error_db)): ?>
	<p class="error"><?= $error_db?></p>
	<?php endif; ?>
	
    <table class="contents_edit" id="ad_basic">
    	<tr>
			<td class="label" width="120px">Name *</td>
			<td class="edit">
				<input type="text" name="name" id="name" value="<?= $name?>" style="width: 400px;" class="validate[required,length[5-200]]" />
				<?php $message_cls->show_error('name')?>
			</td>
		</tr>
		<tr>
			<td class="label">Image *</td>
			<td class="edit">
				<?php if ($image_web_thumb != ''):?>
					<a href="<?= $image_original?>" target="_image"><img src="<?= $image_web_thumb?>" /></a><br />
				<?php endif;?>
				<input type="file" name="image">
				<?php $message_cls->show_error('image')?>
			</td>
		</tr>		
		<tr>
			<td class="label">Description *</td>
			<td class="edit">
				<textarea name="description" id="description" style="width: 400px; height: 150px;" class="validate[required,length[5-2000]]"><?= $description?></textarea>
				<?php $message_cls->show_error('description')?>
			</td>
		</tr>
		<tr>
			<td class="label">Location *</td>
			<td class="edit">
				<input type="text" name="location" id="store_location" value="<?= $location?>" style="width: 350px;" class="validate[required]"/>
				<a href="#" onclick="find_location()">find</a>
				<?php $message_cls->show_error('location')?>
			</td>
		</tr>
		<tr>
			<td class="label">Latitude *</td>
			<td class="edit">
				<input type="text" name="latitude" id="store_latitude" value="<?= $latitude?>" style="width: 400px;" class="validate[required]"/>
				<?php $message_cls->show_error('latitude')?>
			</td>
		</tr>		
		<tr>
			<td class="label">Longitude *</td>
			<td class="edit">
				<input type="text" name="longitude" id="store_longitude" value="<?= $longitude?>" style="width: 400px;" class="validate[required]"/>
				<?php $message_cls->show_error('longitude')?>
			</td>
		</tr>
		<tr height="35px">
			<td class="label"></td>
			<td class="edit">
				<input type="submit" value="  Save " name="action" style="width:80px;"/>
			
				<a href="stores_list.php" class="button">&nbsp;&nbsp;&nbsp;Cancel&nbsp;&nbsp;&nbsp;</a>
			</td>
		</tr>	
	</table>
</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>