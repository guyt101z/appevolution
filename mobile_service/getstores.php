<?php
include 'mobileService.php';

class GetStores extends MobileServce {
	function excute() {
		$result = array();
		$temp = tep_db_query("select * from ".TABLE_STORES." where actived='Y' order by name");
		while($store = tep_db_fetch_array($temp)) {
			$result[] = $store;
		}
		
		$this->set_success_result("stores", $result);
	}
}