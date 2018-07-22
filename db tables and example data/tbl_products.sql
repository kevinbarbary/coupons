
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `product_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', 'Lager');
INSERT INTO `products` VALUES ('2', 'Cider');
INSERT INTO `products` VALUES ('3', 'Big Mac');
INSERT INTO `products` VALUES ('4', '12 McChicken Nuggets');
INSERT INTO `products` VALUES ('5', 'Zinger Tower meal');
INSERT INTO `products` VALUES ('6', 'Red wine');
