<?php
include 'mobileService.php';

class GetBrands extends MobileServce {
	function excute() {
		$startrow = (int)tep_get_value_require("startrow");
		
		$result = array();
		$temp = tep_db_query("select * from ".TABLE_BRANDS." where actived='Y' order by created desc limit ".$startrow.", ".$this->_list_count."");
		while($news = tep_db_fetch_array($temp)) {
			$news['store'] = array();
			if ($news['store_id'] > 0) {
				$news['store'] = teb_one_query(TABLE_STORES, array("id"=>$news['store_id'])); 
			}
			
			$result[] = $news;
		}
		
		$this->set_success_result("news", $result);
	}
}