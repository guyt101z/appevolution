<?php
include 'mobileService.php';

class GetProducts extends MobileServce {
	function excute() {
		$startrow = (int)tep_get_value_require("startrow");
		
		$result = array();
		$temp = tep_db_query("select * from ".TABLE_PRODUCTS." where actived='Y' order by created desc limit ".$startrow.", ".$this->_list_count."");
		while($news = tep_db_fetch_array($temp)) {
			$news['store'] = array();
			if ($news['store_id'] > 0) {
				$news['store'] = teb_one_query(TABLE_STORES, array("id"=>$news['store_id'])); 
			}
            
            $news['gallery'] = array();
            if ($news['gallery_num'] > 0) {
                
                $object_query = tep_db_query("select * from ".TABLE_GALLERIES." where product_id={$news['id']}");
                $j = 0;
                while ($row = tep_db_fetch_array($object_query)) {
                    $news['gallery'][$j]['gallery_original'] = $row['gallery_original'];
                    $news['gallery'][$j]['gallery_thumb'] = $row['gallery_thumb'];
                    $j++;
                }
            }
			$result[] = $news;
		}
		
		$this->set_success_result("products", $result);
	}
}