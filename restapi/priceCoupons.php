<?php

require_once 'abstractCoupons.php';

/**
 * Class priceCoupons
 *
 * All methods for price coupons
 */
class priceCoupons extends abstractCoupons {


	/**
	 * priceCoupons class constructor
	 *
	 * @param couponAdapter $CouponAdapter
	 */
	public function __construct($CouponAdapter) {
		parent::__construct($CouponAdapter, 'price');
	}
	
	
	/**
	 * get the name of a price coupon
	 */
	public function getCouponName($Amount, $Brand, $Product = null) {
		$price = $Amount < 1 ? ltrim($Amount ,'0.') . 'p' : '£' . $Amount;
		if ($Product) {
			return $Brand . ' ' . $Product . ' for ' . $price;
		}
		return 'Pay just ' . $price . ' for ANYTHING at ' . $Brand . '!';
	}


}