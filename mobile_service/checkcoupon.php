<?php
include 'mobileService.php';

class CheckCoupon extends MobileServce {
	function excute() {
		$couponid = tep_get_value_require("couponid");
		
		$check = array("coupon_id"=>$couponid, "device_id"=>$this->_deviceid, "registed"=>tep_now_datetime());
		tep_db_perform(TABLE_CHECKS, $check, "insert");
		
		$this->set_success("Successfulli checked");
	}
}