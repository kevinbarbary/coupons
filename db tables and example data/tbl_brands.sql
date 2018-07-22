
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `brands`
-- ----------------------------
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `brand_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of brands
-- ----------------------------
INSERT INTO `brands` VALUES ('1', 'Tesco');
INSERT INTO `brands` VALUES ('2', 'ASDA');
INSERT INTO `brands` VALUES ('3', 'Sainsbury\'s');
INSERT INTO `brands` VALUES ('4', 'Morrisons');
INSERT INTO `brands` VALUES ('5', 'McDonalds');
INSERT INTO `brands` VALUES ('6', 'KFC');
INSERT INTO `brands` VALUES ('7', 'Poundland');
