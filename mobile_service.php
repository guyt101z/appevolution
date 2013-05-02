<?php
require('includes/application_top.php');

$action = tep_get_value_require("action");

$service = null;

// get stores
if ($action == 'getstores') {
	require('mobile_service/getstores.php');

	$service = new GetStores();
}

// get news
if ($action == 'getproducts') {
	require('mobile_service/getproducts.php');

	$service = new GetProducts();
}

// get specials
if ($action == 'getspecials') {
	require('mobile_service/getspecials.php');

	$service = new GetSpecials();
}

// get brands
if ($action == 'getbrands') {
	require('mobile_service/getbrands.php');

	$service = new GetBrands();
}

// get coupon
if ($action == 'getcoupon') {
	require('mobile_service/getcoupon.php');

	$service = new GetCoupon();
}

// check coupon
if ($action == 'checkcoupon') {
	require('mobile_service/checkcoupon.php');

	$service = new checkCoupon();
}

// uncheck coupon
if ($action == 'uncheckcoupon') {
	require('mobile_service/uncheckcoupon.php');

	$service = new unCheckCoupon();
}

// about
if ($action == 'about') {
	require('mobile_service/about.php');

	$service = new About();
}


if ($service == null) {
	echo json_encode(array("status"=>"error", "action"=>$action, "msg"=>"This action don`t excute."));
} else {
	$service->excute();

	echo $service->get_result();
}