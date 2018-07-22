<?php

require 'vendor/autoload.php';
include 'restapi/config.php';

require 'restapi/couponModel.php';


// db init
$app = new Slim\App(["settings" => $config]);
$container = $app->getContainer();
$container['db'] = function ($c) {
	try{
		$db = $c['settings']['db'];
		$options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		);
		$pdo = new PDO("mysql:host=" . $db['servername'] . ";dbname=" . $db['dbname'] . ';charset=utf8',
						$db['username'],
						$db['password'],
						$options
		);
		return $pdo;
	}
	catch(\Exception $ex){
		return $ex->getMessage();
	}
};


/**
 * get all coupons of all types, and optionally invalid coupons, e.g. expired, not yet "live"
 *
 * @param bool OnlyValidCoupons
 * @return json []
 
 * e.g. /getAllCoupons will return all valid coupons
 * e.g. /getAllCoupons/0 will return all coupons whether valid or not
 */
$app->get('/getAllCoupons[/{valid}]', function ($Request,$Response) {
	$valid = $Request->getAttribute('valid');
	if (is_null($valid)) {
		$valid = 1; // default - only get valid coupons
	}
	$couponModel = new couponModel($this->db);
	$allCoupons = $couponModel->getAllCoupons(null, $valid);
	if (is_null($allCoupons)) {
		return $Response->withJson(null, 400);
	}
	return $Response->withJson($allCoupons, 200);
});


/**
 * get all coupons of a specified type, and optionally invalid coupons, e.g. expired, not yet "live"
 *
 * @param bool OnlyValidCoupons
 * @return json []
 
 * e.g. /getCoupons/discount will return all valid discount coupons
 * e.g. /getCoupons/value/0 will return all value coupons whether valid or not
 */
$app->get('/getCoupons/{type}[/{valid}]', function ($Request,$Response) {
	$type = $Request->getAttribute('type');
	$valid = $Request->getAttribute('valid');
	if (is_null($valid)) {
		$valid = 1; // default - only get valid coupons
	}
	$couponModel = new couponModel($this->db);
	$typeCoupons = $couponModel->getCoupons(null, $type, $valid);
	if (is_null($typeCoupons)) {
		return $Response->withJson(null, 400);
	}
	return $Response->withJson($typeCoupons, 200);
});


/**
 * get all coupons for a specified product and optionally type
 *
 * @param string product
 * @param string coupon type, e.g. price, discount, etc.
 * @param bool OnlyValidCoupons
 * @return json []
 *
 * e.g. getProductCoupons/Lager will return all valid Lager coupons
 * e.g. getProductCoupons/Lager/price will return all valid Lager special offer price coupons
 * e.g. getProductCoupons/Lager/price/0 will return all Lager special offer price coupons whether expired or not
 */
$app->get('/getProductCoupons/{params:.*}', function ($Request,$Response) {
	$product = $type = null;
	$valid = 1; // default - only get valid coupons
	if ($params = explode('/', $Request->getAttribute('params'))) {
		$product = array_shift($params);
		if ($params) {
			$type = array_shift($params);
			if ($params) {
				$valid = array_shift($params);
			}
		}
	}
	$couponModel = new couponModel($this->db);
	$productCoupons = $couponModel->getProductCoupons($product, $type, $valid);
	if (is_null($productCoupons)) {
		return $Response->withJson(null, 400);
	}
	return $Response->withJson($productCoupons, 200);
});


/**
 * create a new coupon
 *
 * @param string $type type of coupon, e.g. value, price, discount, etc.
 * @param string $expiry the date the coupon will expire
 * @param float $amount the coupon amount, e.g. 20%, £5, etc (2 decimal places, numeric not string)
 * @param string $brand the brand of the coupon
 * @param string $product the product of the brand (optional)
 * @return json success/error message
 */
$app->post('/createCoupon/{type}/{expiry}/{amount}/{brand}[/{product}]', function ($Request,$Response) {
	$type = $Request->getAttribute('type');
	$expiry = $Request->getAttribute('expiry');
	$amount = $Request->getAttribute('amount');
	$brand = $Request->getAttribute('brand');
	if (!$product = $Request->getAttribute('product')) {
		$product = null;
	}
	$couponModel = new couponModel($this->db);
	if ($error = $couponModel->createCoupon($type, $expiry, $amount, $brand, $product)) {
		return $Response->withJson("Error creating coupon: " . $error, 400);
	}
	return $Response->withJson("Coupon created successfully", 200);
});


$app->run();