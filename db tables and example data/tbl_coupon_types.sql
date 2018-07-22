
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `coupon_types`
-- ----------------------------
DROP TABLE IF EXISTS `coupon_types`;
CREATE TABLE `coupon_types` (
  `coupon_type_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_type_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`coupon_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of coupon_types
-- ----------------------------
INSERT INTO `coupon_types` VALUES ('1', 'value');
INSERT INTO `coupon_types` VALUES ('2', 'discount');
INSERT INTO `coupon_types` VALUES ('3', 'price');
