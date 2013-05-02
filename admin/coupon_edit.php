<?php
require('../includes/admin_application_top.php');

$titlex = "Create Coupon";

$id = 0;
if (isset($_GET['id'])) {
	$titlex = "Coupon Edit";
	$id = tep_get_value_get("id");
}

require(DIR_WS_INCLUDES . 'body_header.php');

$store_id		= 0;
$title			= "";
$description	= "";
$sort_description	= "";
$image_original	= "";
$image_web		= "";
$image_web_thumb= "";
$created		= "";
$is_gps_check	= "Y";
$distance		= "0.00";

if (isset($_POST["title"]))
{
	$store_id		= tep_get_value_post('store_id');
	$title			= tep_get_value_post('title', 'Title', 'require;length[5,200];');
	$description	= tep_get_value_post('description', 'Description', 'require;length[5,2000];');
	$sort_description	= tep_get_value_post('sort_description', 'Sort Description', 'require;length[5,500];');
	$is_gps_check	= tep_get_value_post('is_gps_check');
	if ($is_gps_check == 'Y') {
		$distance	= tep_get_value_post('distance', 'Distance', 'require;');
	} else {
		$is_gps_check = "N";
	}
	
	$image_original = upload_file($title, 'image', $id == 0);
	if ($image_original != '' && $upload_img_path != '') {
		$image_web			= formated_image($image_original, $upload_img_path, 600, 400);
		$image_web_thumb	= formated_image($image_original, $upload_img_path, 187, 105, true);
		$image_mobile		= formated_image($image_original, $upload_img_path, 320, 215);
		$image_mobile_thumb	= formated_image($image_original, $upload_img_path, 100, 100);
	}
	
	if ($message_cls->is_empty_error()) {
		$coupon = array(
			'store_id'			=> $store_id,
			'title'				=> $title,
			"sort_description"	=> $sort_description,
			"description"		=> $description,
			"is_gps_check"		=> $is_gps_check,
			"distance"			=> $distance
		);
		
		if ($id == 0) {
			$coupon['created']			= tep_now_datetime();
			$coupon['image_original']		= $image_original;
			$coupon['image_web']			= $image_web;
			$coupon['image_web_thumb']	= $image_web_thumb;
			$coupon['image_mobile']		= $image_mobile;
			$coupon['image_mobile_thumb']= $image_mobile_thumb;
			
			$result = tep_db_perform(TABLE_COUPONS, $coupon, 'insert');
			if ($result > 0) {
				$id = tep_db_insert_id();
				
				tep_success_redirect("Success new registed coupon!", "coupon_edit.php?id=".$id);
			}
		} else {
			if ($image_web != '') {
				$coupon['image_original']		= $image_original;
				$coupon['image_web']			= $image_web;
				$coupon['image_web_thumb']	= $image_web_thumb;
				$coupon['image_mobile']		= $image_mobile;
				$coupon['image_mobile_thumb']= $image_mobile_thumb;
			}
			
			$result = tep_db_perform(TABLE_COUPONS, $coupon, 'update', "id='".$id."'");
		}
		
		if ($result > 0) {
			tep_success_redirect("Success saved coupon information!", "coupon_edit.php?id=".$id);
		} else {
			$error_db = "Faild register Coupon.";
		}
	}
} elseif($id > 0) {
	$coupon_info = teb_one_query(TABLE_COUPONS, array("id"=>$id));
	
	$title			= $coupon_info['title'];
	$store_id		= $coupon_info['store_id'];
	$sort_description	= $coupon_info['sort_description'];
	$description	= $coupon_info['description'];
	$image_original	= $coupon_info['image_original'];
	$image_web_thumb= $coupon_info['image_web_thumb'];
	$created		= $coupon_info['created'];
	$is_gps_check	= $coupon_info['is_gps_check'];
	$distance		= $coupon_info['distance'];
}
?>

<form name="ad_form" encType="multipart/form-data" method="post" autocomplete="off" class="edit_form" id="ADForm">
	<?php if (isset($error_db)): ?>
	<p class="error"><?= $error_db?></p>
	<?php endif; ?>
	
    <table class="contents_edit" id="ad_basic">
    	<tr>
			<td class="label" width="120px">Location *</td>
			<td class="edit">
		    	<select name="store_id" style="width: 300px;">
		    		<option value="0" <?php if ($store_id == '0') echo "selected"?>>Others</option>
				<?php $stores = tep_db_query("select * from ".TABLE_STORES." order by title"); while($store = tep_db_fetch_array($stores)):?>
					<option value="<?= $store['id']?>" <?php if ($store_id == $store['id']) echo "selected"?>><?= $store['title']?></option>
				<?php endwhile;?>
				</select>
			</td>
		</tr>
    	<tr>
			<td class="label" width="120px">Title *</td>
			<td class="edit">
				<input type="text" name="title" id="title" value="<?= $title?>" style="width: 400px;" class="validate[required,length[5-200]]" />
				<?php $message_cls->show_error('title')?>
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
			<td class="label">Sort Description *</td>
			<td class="edit">
				<textarea name="sort_description" id="sort_description" style="width: 400px; height: 50px;" class="validate[required,length[5-500]]"><?= $sort_description?></textarea>
				<?php $message_cls->show_error('sort_description')?>
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
			<td class="label">Is GPS Check</td>
			<td class="edit">
				<input type="checkbox" id="is_gps_check" name="is_gps_check" value="Y" <?php if ($is_gps_check == 'Y') echo "checked"?> onclick="if(this.checked){$('#distance_input').show();}else{$('#distance_input').hide();}" />
			</td>
		</tr>
		<tr id="distance_input" style="display: <?= $is_gps_check == 'Y' ? "":"none"?>;">
			<td class="label">Distance *</td>
			<td class="edit">
				<input type="text" name="distance" id="distance" value="<?= $distance?>" style="width: 50px;"/>(KM)
				<?php $message_cls->show_error('distance')?>
			</td>
		</tr>
		<tr height="35px">
			<td class="label"></td>
			<td class="edit">
				<input type="submit" value="  Save " name="action" style="width:80px;"/>
			
				<input type="button" value="  Cancel " style="width:80px;" onclick="location.href='coupon_list.php'" />
			</td>
		</tr>	
	</table>
</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>