/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ticai.com

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-03-21 11:25:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for v9_wap
-- ----------------------------
DROP TABLE IF EXISTS `v9_wap`;
CREATE TABLE `v9_wap` (
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `sitename` char(30) NOT NULL,
  `logo` char(100) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `setting` mediumtext,
  `status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v9_wap
-- ----------------------------
INSERT INTO `v9_wap` VALUES ('1', '399彩迷网手机版', '/statics/images/wap/wlogo.gif', 'm.399bf.me', '{\"listnum\":\"10\",\"thumb_w\":\"220\",\"thumb_h\":\"0\",\"c_num\":\"1000\",\"index_template\":\"index\",\"category_template\":\"category\",\"list_template\":\"list\",\"show_template\":\"show\",\"hotwords\":\"\"}', '1');
