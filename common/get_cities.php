<?php
include '../includes/application_top.php';

$country_code = tep_get_value_require("country_code");
$state_code = tep_get_value_require("state_code");
$city_filed = tep_get_value_require("filed_name");
$default_value = urldecode(tep_get_value_require("default_value"));

$city_count = teb_one_query(TABLE_CITIES, array("state_code"=>$state_code, "country_code"=>$country_code), "count(*) as data_count");
if ($city_count['data_count'] > 0) {
	$cities = teb_multi_query(TABLE_CITIES, array("state_code"=>$state_code, "country_code"=>$country_code), "*", "city");
	
	echo "\n".'<select name="'.$city_filed.'" id="'.$city_filed.'" style="width: 200px;" >'."\n";
	echo "\t".'<option value=""> -- select state -- </option>'."\n";
	while($city = tep_db_fetch_array($cities)) {
		echo "\t".'<option value="'.$city['city'].'" '.($default_value == $city['city'] ? 'selected' : '').'>'.$city['city']."</option>\n";
	}
	echo '';
} else {
	echo '<input type="text" value="'.$default_value.'" name="'.$city_filed.'" id="'.$city_filed.'" style="width: 200px;"  />';
}