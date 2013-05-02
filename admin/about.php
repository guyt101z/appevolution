<?php
require('../includes/admin_application_top.php');

$titlex = "About for Mobile";

require(DIR_WS_INCLUDES . 'body_header.php');

$image			= "";
$description	= "";

if (isset($_POST["description"]))
{
	$description	= tep_get_value_post('description', 'Description', 'require;');
	$image = upload_file("about", 'image', false);
	
	if ($message_cls->is_empty_error()) {
		$about = array(
			'image'			=> $image,
			"description"	=> $description
		);
		
		teb_delete_query(TABLE_ABOUT);
		tep_db_perform(TABLE_ABOUT, $about, 'insert');
		
		tep_success_redirect("Success saved about information!", "about.php");
	}
}

$about			= teb_one_query(TABLE_ABOUT);
$image			= $about["image"];
$description	= $about["description"];
?>

<form name="ad_form" encType="multipart/form-data" method="post" autocomplete="off" class="edit_form" id="ADForm">
	<?php if (isset($error_db)): ?>
	<p class="error"><?= $error_db?></p>
	<?php endif; ?>
	
    <table class="contents_edit" id="ad_basic">
		<tr>
			<td class="label">Description *</td>
			<td class="edit">
				<textarea name="description" id="description" style="width: 400px; height: 150px;" class="validate[required]"><?= $description?></textarea>
				<?php $message_cls->show_error('description')?>
			</td>
		</tr>
		<tr>
			<td class="label">Image *</td>
			<td class="edit">
				<input type="file" name="image">
				<?php $message_cls->show_error('image')?>
				<?php if ($image != ''):?>
					<a href="<?= $image?>" target="_image"><img src="<?= $image?>" width="400px;"/></a><br />
				<?php endif;?>
			</td>
		</tr>
		<tr height="35px">
			<td class="label"></td>
			<td class="edit">
				<input type="submit" value="  Save " name="action" style="width:80px;"/>
			
				<input type="button" value="  Cancel " style="width:80px;" onclick="location.href='brand_list.php'" />
			</td>
		</tr>	
	</table>
</form>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>