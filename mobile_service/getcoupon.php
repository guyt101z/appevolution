<?php
include 'mobileService.php';

class GetCoupon extends MobileServce {
	function excute() {
		$storeid = tep_get_value_require("storeid");

		$coupon = teb_one_query(TABLE_COUPONS, array("store_id"=>$storeid, "actived"=>"Y"));

		if (is_array($coupon)) {
			$check_count = teb_query("select count(*) as data_count from ".TABLE_CHECKS." where coupon_id='".$coupon['id']."' and device_id='".$this->_deviceid."'", "data_count");
			if ($check_count > 0) {
				$coupon['is_checked'] = "Y";
			} else {
				$coupon['is_checked'] = "N";
			}
				
			$this->set_success_result("coupon", $coupon);
		} else {
			$this->set_success_result("coupon", $result);
		}
	}
}