
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `coupons`
-- ----------------------------
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `coupon_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` smallint(6) unsigned NOT NULL,
  `product_id` smallint(6) unsigned DEFAULT NULL,
  `amount` decimal(5,2) unsigned NOT NULL,
  `coupon_type_id` tinyint(3) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of coupons
-- ----------------------------
INSERT INTO `coupons` VALUES ('1', '1', null, '20.00', '1', '2018-03-01 10:15:53', '2019-03-01 10:15:53');
INSERT INTO `coupons` VALUES ('2', '2', null, '15.00', '1', '2018-07-19 18:16:22', '2018-07-28 18:16:31');
INSERT INTO `coupons` VALUES ('3', '3', null, '12.50', '2', '2018-06-05 19:23:11', '2018-12-05 19:23:11');
INSERT INTO `coupons` VALUES ('4', '4', null, '15.00', '2', '2018-02-13 08:28:31', '2018-05-13 08:28:31');
INSERT INTO `coupons` VALUES ('5', '5', '3', '1.00', '3', '2018-07-11 19:40:18', '2018-11-17 20:40:29');
INSERT INTO `coupons` VALUES ('6', '2', null, '5.00', '2', '2016-11-09 12:19:00', '2017-11-09 12:19:00');
INSERT INTO `coupons` VALUES ('7', '5', '4', '1.50', '3', '2018-07-05 10:21:54', '2019-07-04 10:21:54');
INSERT INTO `coupons` VALUES ('8', '1', '2', '3.33', '2', '2018-01-01 00:00:00', '2019-01-01 00:00:00');
INSERT INTO `coupons` VALUES ('9', '1', '1', '6.66', '2', '2018-01-01 00:00:00', '2019-01-01 00:00:00');
INSERT INTO `coupons` VALUES ('10', '1', '6', '20.00', '2', '2018-01-01 00:00:00', '2018-01-01 00:00:00');
INSERT INTO `coupons` VALUES ('11', '4', '6', '25.00', '2', '2017-05-05 00:00:00', '2019-05-04 00:00:00');
INSERT INTO `coupons` VALUES ('12', '6', '5', '3.00', '3', '2018-03-01 00:00:00', '2018-12-31 23:59:59');
INSERT INTO `coupons` VALUES ('13', '7', null, '0.98', '3', '2018-07-20 09:00:00', '2018-07-26 18:00:00');
INSERT INTO `coupons` VALUES ('14', '4', '1', '1.25', '3', '2018-06-22 06:00:00', '2019-01-01 00:00:00');
