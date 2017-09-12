/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : caipiaokong.com

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-01-07 15:32:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cp_class
-- ----------------------------
DROP TABLE IF EXISTS `cp_class`;
CREATE TABLE `cp_class` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '彩种名称',
  `pinyin` char(10) NOT NULL DEFAULT '' COMMENT '彩种参数(如，七星彩=qxc)',
  `area` char(10) NOT NULL DEFAULT '' COMMENT '地区(全国=all；地方，如福建=fj)',
  `area_name` varchar(20) NOT NULL DEFAULT '' COMMENT '地区名称',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '机构(1福彩；2体彩；3赛马会)',
  `times` varchar(50) NOT NULL DEFAULT '' COMMENT '开奖次数(如，每周3期)',
  `time` varchar(50) NOT NULL DEFAULT '' COMMENT '开奖时间(如，每周二、四、六开奖)',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '额外说明',
  `ishigh` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为高频彩种(0否，1是)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_uniq` (`pinyin`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='彩票种类';

-- ----------------------------
-- Records of cp_class
-- ----------------------------
INSERT INTO `cp_class` VALUES ('1', '七星彩', 'qxc', 'all', '全国', '2', '每周3期', '每周二、五、日开奖', '', '0');
INSERT INTO `cp_class` VALUES ('2', '香港开奖', 'xglhc', 'xg', '香港', '3', '每周3期', '每周二、四、六开奖', '', '0');
INSERT INTO `cp_class` VALUES ('3', '广东快乐十分', 'gdklsf', 'gd', '广东', '1', '每日84期', '每10分钟开奖', '', '1');
INSERT INTO `cp_class` VALUES ('4', '北京赛车PK10', 'bjpks', 'bj', '北京', '1', '每日179期', '每5分钟开奖', '', '1');
INSERT INTO `cp_class` VALUES ('5', '重庆时时彩', 'cqssc', 'cq', '重庆', '1', '每日120期', '每10分钟开奖', '', '1');
