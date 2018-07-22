<?php

require_once 'abstractCoupons.php';

/**
 * Class discountCoupons
 *
 * All methods for discount coupons
 */
class discountCoupons extends abstractCoupons {


	/**
	 * discountCoupons class constructor
	 *
	 * @param couponAdapter $CouponAdapter
	 */
	public function __construct($CouponAdapter) {
		parent::__construct($CouponAdapter, 'discount');
	}
	
	
	/**
	 * get the name of a discount coupon
	 */
	public function getCouponName($Amount, $Brand, $Product = null) {
		$onProduct = $Product ? 'on ' . $Product . ' ' : '';
		return 'Save ' . rtrim(rtrim($Amount, '0'), '.') . '% ' . $onProduct . 'at ' . $Brand;
	}
	

}