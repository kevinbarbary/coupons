<?php

/**
 * Abstract coupon class
 */
abstract class abstractCoupons {


	/**
	 * Data abstraction layer for Coupons
	 */
	protected $_adapter;
	
	
	/**
	 * Coupon Type Name
	 */
	private $_couponType;
	
	
	/**
	 * abstractCoupons class constructor
	 *
	 * @param couponAdapter $CouponAdapter
	 * @param string $CouponType
	 */
	public function __construct($CouponAdapter, $CouponType) {
		$this->_adapter = $CouponAdapter;
		$this->_couponType = $CouponType;
	}
	

	/**
	 * MUST BE OVERRIDDEN IN A DESCENDANT
	 *
	 * get the name of a coupon
	 */
	abstract function getCouponName($Amount, $Brand, $Product = null);
	

		
	/**
	 * get all coupon data for a single coupon type and optionally a single product
	 */
	protected function getCouponData($Product, $OnlyValid) {
		if ($Product) {
			return $this->_adapter->getProductCoupons($Product, $this->_couponType, $OnlyValid);
		}
		return $this->_adapter->getCoupons($this->_couponType, $OnlyValid);
	}
	

	/**
	 * get a class of the specified coupon type
	 */
	private function getCouponTypeClass($CouponTypeName) {
		$className = $CouponTypeName . 'Coupons';
		return new $className();
	}
	
	
	/**
	 * get all coupons of a specified type and optionally for a single product
	 */
	public function getCoupons($Product = null, $OnlyValid) {
		$typeCoupons = [];
		if ($typeCouponData = $this->getCouponData($Product, $OnlyValid)) {
			foreach ($typeCouponData as $coupon) {
				$typeCoupons[] = ['name' => utf8_encode($this->getCouponName($coupon['amount'], $coupon['brand_name'], $coupon['product_name'])),
									'brand' => $coupon['brand_name'],
									$this->_couponType => $coupon['amount'],
									'createdAt' => $coupon['created_date'],
									'expiry' => $coupon['expiry_date'],
								];
			}
		}
		return $typeCoupons;
	}
	
	
	/**
	 * get all coupons of all types
	 *
	 * @param bool $onlyValid Only get valid coupons, i.e. exclude expired, not yet "live", etc.
	 * @return []
	 */
	public function getAllCoupons($OnlyValid = true) {
		$allCoupons = [];
		$couponTypes = $this->getCouponTypes();
		foreach ($couponTypes as $typeName) {
			$type = $this->getCouponTypeClass($typeName);
			$allCoupons = array_merge($allCoupons, $type->getCoupons($OnlyValid));
		}
		return $allCoupons;
	}
	
	
	/**
	 * get all of the coupon types
	 */
	public function getAllCouponTypes() {
		return $this->_adapter->getCouponTypes();
	}
	
	
}
