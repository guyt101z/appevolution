<?php
include '../includes/application_top.php';

$country_code = tep_get_value_require("country_code");
$state_filed = tep_get_value_require("filed_name");
$default_value = tep_get_value_require("default_value");

$status_count = teb_one_query(TABLE_STATES, array("country_code"=>$country_code), "count(*) as data_count");
if ($status_count['data_count'] > 0) {
	$states = teb_multi_query(TABLE_STATES, array("country_code"=>$country_code));
	
	echo "\n".'<select name="'.$state_filed.'" id="'.$state_filed.'" style="width: 200px;"  class="validate[required]">'."\n";
	echo "\t".'<option value=""> -- select state -- </option>'."\n";
	while($state = tep_db_fetch_array($states)) {
		echo "\t".'<option value="'.$state['cd'].'" '.($default_value == $state['cd'] ? 'selected' : '').'>'.$state['name']."</option>\n";
	}
	echo '';
} else {
	echo '<input type="text" value="'.$default_value.'" name="'.$state_filed.'" id="'.$state_filed.'" style="width: 200px;"  class="validate[required]" />';
}