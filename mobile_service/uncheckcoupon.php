<?php
include 'mobileService.php';

class UnCheckCoupon extends MobileServce {
	function excute() {
		$couponid = tep_get_value_require("couponid");
		
		teb_delete_query(TABLE_CHECKS, array("coupon_id"=>$couponid, "device_id"=>$this->_deviceid));
		
		$this->set_success("Successfulli checked");
	}
}