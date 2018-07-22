<?php

/**
 * Class couponAdapter
 *
 * Data abstraction layer for Coupons
 */
class couponAdapter {


	/**
	 * Database connection
	 */
	protected $_conn;
	
	
	/**
	 * couponAdapter class constructor
	 *
	 * @param PDO $conn
	 */
	public function __construct($Conn) {
		$this->_conn = $Conn;
	}


	/**
	 * get all of the types of coupons
	 *
	 * @param string $Type coupon type (optional, if not specified returns all coupon types)
	 * @return string [] coupon types
	 */
	public function getCouponTypes($Type = null) {
		$result = null;
		$sql = 'SELECT coupon_type_name
				FROM coupon_types';
		if ($Type) {
			$sql .= ' WHERE coupon_type_name = :type';
			
			$stmt = $this->_conn->prepare($sql);
			$stmt->bindParam(':type', $Type);
			$stmt->execute();
			if ($row = $stmt->fetch()) {
				return [$row['coupon_type_name']];
			}
			
		} else {
			$sql .= ' ORDER BY coupon_type_name';
			
			$records = $this->_conn->query($sql)->fetchAll();
			foreach ($records as $row) {
				$result[] = $row['coupon_type_name'];
			}
		}
		return $result;
	}
	
	
	/**
	 * get all coupons of the specified type
	 *
	 * @param string $Type
	 * @param bool $OnlyValid only get valid coupons, i.e. exclude expired, not yet "live", etc.
	 */
	public function getCoupons($Type, $OnlyValid) {
		$sql = 'SELECT C.*, B.brand_name, P.product_name
				FROM coupons C
				JOIN brands B on C.brand_id = B.brand_id
				JOIN coupon_types CT on C.coupon_type_id = CT.coupon_type_id
									and CT.coupon_type_name = :type
				LEFT JOIN products P on C.product_id = P.product_id';
		if ($OnlyValid) {
			$sql .= ' WHERE C.expiry_date > now()';
		}
		$sql .= ' ORDER BY CT.coupon_type_name, B.brand_name, P.product_name';

		$stmt = $this->_conn->prepare($sql);
		$stmt->bindParam(':type', $Type);
		$stmt->execute();
		if ($records = $stmt->fetchALL()) {
			return $records;
		}
	}
	
	
	/**
	 * get all coupons for the specified product and the specified type
	 *
	 * @param string $Product, e.g. Lager, Cider, etc.
	 * @param string $Type e.g. discount, price, value, etc.
	 * @param bool $OnlyValid only get valid coupons, i.e. exclude expired, not yet "live", etc.
	 */
	public function getProductCoupons($Product, $Type, $OnlyValid) {
		$sql = 'SELECT C.*, B.brand_name, P.product_name
				FROM coupons C
				JOIN brands B on C.brand_id = B.brand_id
				JOIN coupon_types CT on C.coupon_type_id = CT.coupon_type_id
									and CT.coupon_type_name = :type
				JOIN products P on C.product_id = P.product_id
									and P.product_name = :product';
		if ($OnlyValid) {
			$sql .= ' WHERE C.expiry_date > now()';
		}
		$sql .= ' ORDER BY CT.coupon_type_name, B.brand_name';
		
		$stmt = $this->_conn->prepare($sql);
		$stmt->bindParam(':type', $Type);
		$stmt->bindParam(':product', $Product);
		$stmt->execute();
		if ($records = $stmt->fetchALL()) {
			return $records;
		}
	}
	

	/**
	 * check if brand has the product
	 *
	 * @param string $Brand
	 * @param stirng $Product
	 * @return boolean true if brand has the pruduct, false if brand does not have the product
	 */
	public function brandHasProduct($Brand, $Product) {
		$sql = 'SELECT 1
				FROM brands_products BP
				JOIN brands B on BP.brand_id = B.brand_id and B.brand_name = :brand
				JOIN products P on BP.product_id = P.product_id and P.product_name = :product';
		
		$stmt = $this->_conn->prepare($sql);
		$stmt->bindParam(':brand', $Brand);
		$stmt->bindParam(':product', $Product);
		$stmt->execute();
		return !empty($stmt->fetch());
	}
	
	
	/**
	 * create a new coupon
	 *
	 * @param string $Type type of coupon, e.g. value, price, discount, etc.
	 * @param string $Expiry the date the coupon will expire
	 * @param float $Amount the coupon amount, e.g. 20%, £5, etc (2 decimal places, numeric not string)
	 * @param string $Brand the brand of the coupon
	 * @param string $Product the product of the brand (optional)
	 * @return boolean true for success | false for fail
	 */
	public function createCoupon($Type, $Expiry, $Amount, $Brand, $Product = null) {
		try {
			$sql = 'INSERT INTO coupons(brand_id, product_id, amount, coupon_type_id, created_date, expiry_date)
					VALUES (
						(SELECT brand_id FROM brands where brand_name = :brand),
						(SELECT product_id FROM products where product_name = :product),
						:amount,
						(SELECT coupon_type_id FROM coupon_types where coupon_type_name = :type),
						now(),
						:expiry
					)';
			$stmt = $this->_conn->prepare($sql);
			$stmt->bindParam(':brand', $Brand);
			$stmt->bindParam(':product', $Product);
			$stmt->bindParam(':amount', $Amount);
			$stmt->bindParam(':type', $Type);
			$stmt->bindParam(':expiry', $Expiry);
			$stmt->execute();
		} catch (PDOException $e) {
			return false;
		}
		return true;
	}
	
	
}
