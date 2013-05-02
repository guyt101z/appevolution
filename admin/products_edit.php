<?php
require('../includes/admin_application_top.php');

$titlex = "Create Products";

$id = 0;
$gallery_num = 0;
if (isset($_GET['id'])) {
	$titlex = "Products Edit";
	$id = tep_get_value_get("id");
}

require(DIR_WS_INCLUDES . 'body_header.php');

$store_id		= 0;
$name			= "";
$description	= "";
$image_original	= "";
$image_web		= "";
$image_web_thumb= "";
$created		= "";
$gallery_id     = array();
$gallery_original   = array();
$gallery_thumb      = array();


if (isset($_POST["name"]))
{
	$store_id		= tep_get_value_post('store_id');     
	$name			= tep_get_value_post('name', 'Name', 'require;length[5,200];');
	$description	= tep_get_value_post('description', 'Description', 'require;length[5,2000];');	

	$image_original = upload_file($name, 'image', $id == 0);
              
	if ($image_original != '' && $upload_img_path != '') {
		$image_web			= formated_image($image_original, $upload_img_path, 600, 400);
		$image_web_thumb	= formated_image($image_original, $upload_img_path, 187, 105, true);
		$image_mobile		= formated_image($image_original, $upload_img_path, 320, 215);
		$image_mobile_thumb	= formated_image($image_original, $upload_img_path, 100, 100);
	}

    $gallery_num        = tep_get_value_post('gallery_num');    

    for ( $j = 1; $j <= $gallery_num; $j++ ) {
        $filename = upload_file("gallery" . $name . $j, 'gallery' . $j ,  0);
        if ($filename != '' && $upload_img_path != '') {            
            array_push($gallery_original, formated_image($filename, $upload_img_path, 600, 400));
            array_push($gallery_thumb, formated_image($filename, $upload_img_path, 187, 105, true));
        }
        else {
            array_push($gallery_original, $galleries[$j]['gallery_original']);
            array_push($gallery_thumb, $galleries[$j]['gallery_thumb']);
        }
    }
                                     
	if ($message_cls->is_empty_error()) {
		$products = array(
			'store_id'			=> $store_id,         
			'name'				=> $name,			
			"description"		=> $description
		);
		if ($id == 0) {
			$products['created']			= tep_now_datetime();
			$products['image_original']		= $image_original;
			$products['image_web']			= $image_web;
			$products['image_web_thumb']	= $image_web_thumb;
			$products['image_mobile']		= $image_mobile;
			$products['image_mobile_thumb'] = $image_mobile_thumb;
            $products['store_id']           = $store_id;
            $products['gallery_num']        = $gallery_num;
			
			$result = tep_db_perform(TABLE_PRODUCTS, $products, 'insert');
               
			if ($result > 0) {
                $id = tep_db_insert_id();
                $galleries['product_id'] = tep_db_insert_id();                           
                for ($j = 0; $j < $gallery_num; $j++) {
                    $galleries[$j]['gallery_original']     = $gallery_original[$j];
                    $galleries[$j]['gallery_thumb']        = $gallery_thumb[$j];
                    $galleries[$j]['product_id']           = $id;
                    $result2 = tep_db_perform(TABLE_GALLERIES, $galleries[$j], 'insert');
                    $gallery_id[$j]        = tep_db_insert_id();
                }
                
				tep_success_redirect("Success new registed products!", "products_edit.php?id=".$id);
			}
            
		} else {
			if ($image_web != '') {
				$products['image_original']		= $image_original;
				$products['image_web']			= $image_web;
				$products['image_web_thumb']	= $image_web_thumb;
				$products['image_mobile']		= $image_mobile;
				$products['image_mobile_thumb'] = $image_mobile_thumb;
			}
			$result = tep_db_perform(TABLE_PRODUCTS, $products, 'update', "id='".$id."'");
            
            
            for ($j = 0; $j < $gallery_num; $j++) {
                $gallery_id[$j] = tep_get_value_post('g_' . ($j + 1));
                if ($gallery_original[$j] != '')
                {
                    $galleries[$j]['product_id']           = $id;                            
                    $galleries[$j]['gallery_original']     = $gallery_original[$j];
                    $galleries[$j]['gallery_thumb']        = $gallery_thumb[$j];
                    $result2 = tep_db_perform(TABLE_GALLERIES, $galleries[$j], 'update', "id='".$gallery_id[$j]."'");
                } 
            }
		}
		
		if ($result > 0) {
			tep_success_redirect("Success saved products information!", "products_edit.php?id=".$id);
		} else {
			$error_db = "Faild register Products.";
		}
	}
    else
    {
        $gallery_num = 0;
    }
} elseif($id > 0) {
	$products_info = teb_one_query(TABLE_PRODUCTS, array("id"=>$id));
	$store_id		= $products_info['store_id'];
	$name			= $products_info['name'];	
	$description	= $products_info['description'];
	$image_original	= $products_info['image_original'];
	$image_web_thumb= $products_info['image_web_thumb'];
	$created		= $products_info['created'];
    $gallery_num    = $products_info['gallery_num'];

    $object_query = tep_db_query("select * from ".TABLE_GALLERIES." where product_id={$id}");
    $j = 0;
    while ($row = tep_db_fetch_array($object_query)) {
        $gallery_id[$j] = $row['id'];
        $galleries[$j]['gallery_original'] = $row['gallery_original'];
        $galleries[$j]['gallery_thumb'] = $row['gallery_thumb'];
        $galleries[$j]['product_id'] = $row['product_id'];
        $j++;
    }
    $gallery_num = $j;
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
                <?php $stores = tep_db_query("select * from ".TABLE_STORES." order by name"); while($store = tep_db_fetch_array($stores)):?>
                    <option value="<?= $store['id']?>" <?php if ($store_id == $store['id']) echo "selected"?>><?= $store['name']?></option>
                <?php endwhile;?>
                </select>
            </td>
        </tr>
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
            <td class="label">Gallery</td>
            <td class="edit">
            <div id="gallery"></div> 
                <input type="hidden" name="gallery_num" id="gallery_num" value="<?= $gallery_num?>" style="width: 400px;" />                                 
                <?php                
                 for ($j = 1; $j <= $gallery_num; $j++) {
                     echo '<input type="hidden" name="g_' . $j . '" value="' . $gallery_id[$j-1] . '">';
                     echo "<a href='". $galleries[$j-1]['gallery_original'] . "' target='_image'><img src='" . $galleries[$j-1]['gallery_thumb'] . "' /></a><br />";
                     echo '<input type="file" name="gallery' . $j . '"><br/>';
                 }                 
                ?>
                
                <?php if ($id == 0):?>                  
                <a href="#" onclick="add_gallery()">Add Gallery</a>
                <?php endif;?>
            </td>
        </tr>
		<tr height="35px">
			<td class="label"></td>
			<td class="edit">
				<input type="submit" value="  Save " name="action" style="width:80px;"/>
			
				<input type="button" value="  Cancel " style="width:80px;" onclick="location.href='products_list.php'" />
			</td>
		</tr>	
	</table>
</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>