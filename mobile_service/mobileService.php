<?php
abstract class MobileServce {
	var $_result;
	var $_list_count = 20;
	
	var $_deviceid = 0;
	
	function __construct() {
		$this->_result = array();
		$this->_result['status'] = "error";
		
		if ($this->_debug) {
			$this->_process_start_time = microtime(true); 
		}
		
		if ($device == "") return;
		
		$os = tep_get_value_post("os");
		$device = tep_get_value_post("device");
		
		if ($os == '') $os="iphone";
		
		$check = teb_one_query(TABLE_DEVICES, array("device"=>$device, "os"=>$os));
		if ($check == "") {
			$device = array("os"=>$os, "device"=>$device);
			tep_db_perform(TABLE_DEVICES, $device, "insert");
			
			$this->_deviceid = $check['id'];
		} else {
			$this->_deviceid = $check['id'];
		}
	}
	
	function set_success_result($key, $result) {
		$this->_result['status']	= "success";
		$this->_result[$key]		= $result;
	}
	
	function set_success($msg) {
		$this->_result['status']	= "success";
		$this->_result['msg']		= $msg;
	}
	
	function set_error($error_msg) {
		$this->_result['status']	= "error";
		$this->_result['msg']		= $error_msg;
		
		echo $this->get_result();
			
		exit(0);
	}
	
	function check_valudations() {
		global $message_cls;
		
		if (!$message_cls->is_empty_error()) {
			$this->set_error($message_cls->get_all_message());
				
			echo get_result();
			
			exit(0);
		}
	}
	
	abstract function excute();
	
	function get_result() {
		if ($this->_debug) {
			$this->_result['process_time']	= microtime(true) - $this->_process_start_time;
			$this->_result['action_url']	= HTTP_SERVER.$_SERVER['REQUEST_URI'];
		}
		
		return json_encode($this->_result);
	}
}