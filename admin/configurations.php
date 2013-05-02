<?php
require('../includes/admin_application_top.php');

$titlex = "Edit Profile";
require(DIR_WS_INCLUDES . 'body_header.php');

$action = tep_db_prepare_input($_POST['action']);
if ($action == 'save') {
	$order_num		= tep_get_value_post("order_num");
	$config_name	= tep_get_value_post("config_name");
	$config_value	= tep_get_value_post("config_value");
	$config_comment = tep_get_value_post("config_comment");
	
	tep_db_query("delete from " . TABLE_CONFIGURATIONS);
	
	for ($i = 0; $i < count($order_num); $i ++) {
		$config = array(
				"order_num"		=> $order_num[$i],
				"config_name"	=> $config_name[$i], 
				"config_value"	=> $config_value[$i], 
				"config_comment"=> $config_comment[$i]
		);
		
		tep_db_perform(TABLE_CONFIGURATIONS, $config, "insert");
	}
	
	tep_success_redirect("Success saved configurations!", "configurations.php");
}
?>

<form name="frm_define" method="post">
<input type="submit" value="  Save Options  ">
<br />
<table class="contents_list" cellpadding="0" cellspacing="1">
	<tr class="headerRow">
		<td width="50">Order</td>
		<td width="250" style="text-align:left;">&nbsp;&nbsp;Name</td>
		<td width="500" style="text-align:left;">&nbsp;&nbsp;Value</td>
        <td>Comment</td>
	</tr>
    <tr>
    	<td colspan="4"  height=1 ></td>
	</tr>
<?
	$sql = "select sql_cache * from " . TABLE_CONFIGURATIONS . " order by order_num";
	$defines = tep_db_query($sql);
    
	$row = 0;
	while ($define = tep_db_fetch_array($defines)) {
		$row ++;
?>	   
	<tr class='dataTableRow'>
		<td align="center">
			<input type="text" name="order_num[]" value="<?php echo $define['order_num']?>"style="width: 50px; text-align: right;" />
		</td>
		<td align="left">
			<?php echo $define['config_name']?>
			<input type="hidden" name="config_name[]" value="<?php echo $define['config_name']?>">
		</td>
		<td align="left" valign="top">
			<input type="text" name="config_value[]" value="<?php echo $define['config_value']?>" style="width: 98%">
		</td>
        <td align="center">
        	<input type="text" name="config_comment[]" value="<?php echo $define['config_comment']?>" style="width: 99%">
        </td>
	</tr>
<?php
	}
?>
	<tr>
		<td colspan="4"  height=1 ></td>
	</tr>
</table>
<br />
<input type="hidden" name="action" value="save" />
<input type="hidden" name="config_count" value="<?= $row?>" />
<input type="submit" value="  Save Options  ">

</form>
<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>