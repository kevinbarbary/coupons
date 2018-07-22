<?php

require 'couponAdapter.php';
require 'valueCoupons.php';
require 'discountCoupons.php';
require 'priceCoupons.php';

/**
 * Class couponModel
 *
 * All methods for coupons
 */
class couponModel {


	/**
	 * Data abstraction layer for Coupons
	 */
	protected $_adapter;
	
	
	/**
	 * couponModel class constructor
	 *
	 * @param PDO $Conn Database connection
	 */
	public function __construct($Conn) {
		$this->_adapter = new couponAdapter($Conn);
	}
	
	
	/**
	 * get a class of the specified coupon type
	 */
	private function getCouponTypeClass($CouponTypeName) {
		$className = $CouponTypeName . 'Coupons';
		return new $className($this->_adapter);
	}
	
	
	/**
	 * get all coupons of a single coupon type, returns null if type not recognised
	 *
	 * @param string $CouponType the name of the type of coupon, e.g. value, discount, etc.
	 * @param bool $OnlyValid Only get valid coupons, i.e. exclude expired, not yet "live", etc.
	 * @return []
	 */
	public function getCoupons($Product, $CouponType, $OnlyValid = true) {
		if ($type = $this->getCouponTypeClass($CouponType)) {
			return $type->getCoupons($Product, $OnlyValid);
		}
		return null;
	}
	
	
	/**
	 * get all coupons, optionally limit to a single product
	 *
	 * @param string $Product the name of the product, e.g. Lager, Cider, etc.
	 * @param bool $onlyValid Only get valid coupons, i.e. exclude expired, not yet "live", etc.
	 * @return []
	 */
	public function getAllCoupons($Product = null, $OnlyValid = true) {
		$allCoupons = [];
		$couponTypes = $this->_adapter->getCouponTypes();
		foreach ($couponTypes as $typeName) {
			if ($singleTypeCoupons = $this->getCoupons($Product, $typeName, $OnlyValid)) {
				$allCoupons = array_merge($allCoupons, $singleTypeCoupons);
			}
		}
		return $allCoupons;
	}


	/**
	 * get all coupons for a single product
	 *
	 * @param string $Product the name of the product, e.g. Lager, Cider, etc.
	 * @param string $CouponType the name of the type of coupon, e.g. value, discount, etc.
	 * @param bool $OnlyValid Only get valid coupons, i.e. exclude expired, not yet "live", etc.
	 * @return []
	 */
	public function getProductCoupons($Product, $CouponType = null, $OnlyValid) {
		return $CouponType ? $this->getCoupons($Product, $CouponType, $OnlyValid) :
								$this->getAllCoupons($Product, $OnlyValid);
	}
	
	
	/**
	 * create coupon
	 *
	 * @param string $Type type of coupon, e.g. value, price, discount, etc.
	 * @param string $Expiry the date the coupon will expire
	 * @param float $Amount the coupon amount, e.g. 20%, £5, etc (2 decimal places, numeric not string)
	 * @param string $Brand the brand of the coupon
	 * @param string $Product the product of the brand (optional)
	 * @return string error message | empty string for success
	 */
	public function createCoupon($Type, $Expiry, $Amount, $Brand, $Product = null) {
	
		// if a product is specified verify it is a valid product for the brand
		if ($Product && !$this->_adapter->brandHasProduct($Brand, $Product)) {
			return 'brand \'' . $Brand . '\' does not have product \'' . $Product . '\'.'; 
		}
		
		// verify the coupon type is valid
		if (empty($this->_adapter->getCouponTypes($Type))) {
			return 'coupon type \'' . $Type . '\' not found.'; 
		}
		
		// create the coupon
		if (!$this->_adapter->createCoupon($Type, $Expiry, $Amount, $Brand, $Product)) {
			return 'a problem occurred creating the coupon';
		}
		
		// coupon created successfully
		return '';
	}
	
	
}
