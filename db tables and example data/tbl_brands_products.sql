
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `brands_products`
-- ----------------------------
DROP TABLE IF EXISTS `brands_products`;
CREATE TABLE `brands_products` (
  `brand_id` smallint(5) unsigned NOT NULL,
  `product_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`brand_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of brands_products
-- ----------------------------
INSERT INTO `brands_products` VALUES ('1', '1');
INSERT INTO `brands_products` VALUES ('1', '2');
INSERT INTO `brands_products` VALUES ('2', '1');
INSERT INTO `brands_products` VALUES ('3', '1');
INSERT INTO `brands_products` VALUES ('4', '2');
INSERT INTO `brands_products` VALUES ('5', '3');
INSERT INTO `brands_products` VALUES ('5', '4');
INSERT INTO `brands_products` VALUES ('6', '5');
