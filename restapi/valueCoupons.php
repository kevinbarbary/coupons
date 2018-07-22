<?php

require_once 'abstractCoupons.php';

/**
 * Class valueCoupons
 *
 * All methods for value coupons
 */
class valueCoupons extends abstractCoupons {


	/**
	 * valueCoupons class constructor
	 *
	 * @param couponAdapter $CouponAdapter
	 */
	public function __construct($CouponAdapter) {
		parent::__construct($CouponAdapter, 'value');
	}
	
	
	/**
	 * get the name of a value coupon
	 */
	public function getCouponName($Amount, $Brand, $Product = null) {
		$onProduct = $Product ? 'on ' . $Product . ' ' : '';
		return 'Save £' . rtrim(rtrim($Amount, '00'), '.') . ' ' . $onProduct . 'at ' . $Brand;
	}
	
	
}