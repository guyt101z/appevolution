<?php
include 'mobileService.php';

class About extends MobileServce {
	function excute() {
		$result = array();
		$temp = teb_one_query(TABLE_ABOUT);
		
		$this->set_success_result("about", $temp);
	}
}