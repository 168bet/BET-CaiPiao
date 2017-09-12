/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : caipiaokong.com

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-01-07 15:32:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cp_bjpks
-- ----------------------------
DROP TABLE IF EXISTS `cp_bjpks`;
CREATE TABLE `cp_bjpks` (
  `id` mediumint(8) unsigned NOT NULL COMMENT '赛车PK10期号',
  `numbers` char(29) NOT NULL DEFAULT '' COMMENT '开奖号码',
  `uptime` int(10) NOT NULL COMMENT '更新时间',
  `n1` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '冠军',
  `n2` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '亚军',
  `n3` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '季军',
  `n4` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '四名',
  `n5` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '五名',
  `n6` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '六名',
  `n7` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '七名',
  `n8` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '八名',
  `n9` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '九名',
  `n10` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '十名',
  `diff1` tinyint(2) NOT NULL DEFAULT '0' COMMENT '一位升平降(大于0升；等于0平；小于0降)',
  `diff2` tinyint(2) NOT NULL DEFAULT '0' COMMENT '二位升平降(大于0升；等于0平；小于0降)',
  `diff3` tinyint(2) NOT NULL DEFAULT '0' COMMENT '三位升平降(大于0升；等于0平；小于0降)',
  `diff4` tinyint(2) NOT NULL DEFAULT '0' COMMENT '四位升平降(大于0升；等于0平；小于0降)',
  `diff5` tinyint(2) NOT NULL DEFAULT '0' COMMENT '五位升平降(大于0升；等于0平；小于0降)',
  `diff6` tinyint(2) NOT NULL DEFAULT '0' COMMENT '六位升平降(大于0升；等于0平；小于0降)',
  `diff7` tinyint(2) NOT NULL DEFAULT '0' COMMENT '七位升平降(大于0升；等于0平；小于0降)',
  `diff8` tinyint(2) NOT NULL DEFAULT '0' COMMENT '八位升平降(大于0升；等于0平；小于0降)',
  `diff9` tinyint(2) NOT NULL DEFAULT '0' COMMENT '九位升平降(大于0升；等于0平；小于0降)',
  `diff10` tinyint(2) NOT NULL DEFAULT '0' COMMENT '十位升平降(大于0升；等于0平；小于0降)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='赛车PK10(北京)';

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
-- Table structure for cp_cqssc
-- ----------------------------
DROP TABLE IF EXISTS `cp_cqssc`;
CREATE TABLE `cp_cqssc` (
  `id` bigint(20) unsigned NOT NULL COMMENT '时时彩期号',
  `numbers` char(9) NOT NULL DEFAULT '' COMMENT '开奖号码',
  `uptime` int(10) NOT NULL COMMENT '更新时间',
  `n1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '一位',
  `n2` tinyint(1) NOT NULL DEFAULT '0' COMMENT '二位',
  `n3` tinyint(1) NOT NULL DEFAULT '0' COMMENT '三位',
  `n4` tinyint(1) NOT NULL DEFAULT '0' COMMENT '四位',
  `n5` tinyint(1) NOT NULL DEFAULT '0' COMMENT '五位',
  `diff1` tinyint(2) NOT NULL DEFAULT '0' COMMENT '一位升平降(大于0升；等于0平；小于0降)',
  `diff2` tinyint(2) NOT NULL DEFAULT '0' COMMENT '二位升平降(大于0升；等于0平；小于0降)',
  `diff3` tinyint(2) NOT NULL DEFAULT '0' COMMENT '三位升平降(大于0升；等于0平；小于0降)',
  `diff4` tinyint(2) NOT NULL DEFAULT '0' COMMENT '四位升平降(大于0升；等于0平；小于0降)',
  `diff5` tinyint(2) NOT NULL DEFAULT '0' COMMENT '五位升平降(大于0升；等于0平；小于0降)',
  `diff_avg` tinyint(2) NOT NULL DEFAULT '0' COMMENT '均值升平降(大于0升；等于0平；小于0降)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='时时彩(重庆)';

-- ----------------------------
-- Table structure for cp_gdklsf
-- ----------------------------
DROP TABLE IF EXISTS `cp_gdklsf`;
CREATE TABLE `cp_gdklsf` (
  `id` int(10) unsigned NOT NULL COMMENT '快乐十分期号',
  `numbers` char(23) NOT NULL DEFAULT '' COMMENT '开奖号码',
  `uptime` int(10) NOT NULL COMMENT '更新时间',
  `n1` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '一位',
  `n2` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '二位',
  `n3` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '三位',
  `n4` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '四位',
  `n5` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '五位',
  `n6` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '六位',
  `n7` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '七位',
  `n8` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '八位',
  `diff1` tinyint(2) NOT NULL DEFAULT '0' COMMENT '一位升平降(大于0升；等于0平；小于0降)',
  `diff2` tinyint(2) NOT NULL DEFAULT '0' COMMENT '二位升平降(大于0升；等于0平；小于0降)',
  `diff3` tinyint(2) NOT NULL DEFAULT '0' COMMENT '三位升平降(大于0升；等于0平；小于0降)',
  `diff4` tinyint(2) NOT NULL DEFAULT '0' COMMENT '四位升平降(大于0升；等于0平；小于0降)',
  `diff5` tinyint(2) NOT NULL DEFAULT '0' COMMENT '五位升平降(大于0升；等于0平；小于0降)',
  `diff6` tinyint(2) NOT NULL DEFAULT '0' COMMENT '六位升平降(大于0升；等于0平；小于0降)',
  `diff7` tinyint(2) NOT NULL DEFAULT '0' COMMENT '七位升平降(大于0升；等于0平；小于0降)',
  `diff8` tinyint(2) NOT NULL DEFAULT '0' COMMENT '八位升平降(大于0升；等于0平；小于0降)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='快乐十分(广东)';

-- ----------------------------
-- Table structure for cp_qxc
-- ----------------------------
DROP TABLE IF EXISTS `cp_qxc`;
CREATE TABLE `cp_qxc` (
  `id` mediumint(8) unsigned NOT NULL COMMENT '七星彩期号',
  `numbers` char(13) NOT NULL DEFAULT '' COMMENT '开奖号码',
  `uptime` int(10) NOT NULL COMMENT '更新时间',
  `n1` tinyint(1) NOT NULL DEFAULT '0' COMMENT '一位',
  `n2` tinyint(1) NOT NULL DEFAULT '0' COMMENT '二位',
  `n3` tinyint(1) NOT NULL DEFAULT '0' COMMENT '三位',
  `n4` tinyint(1) NOT NULL DEFAULT '0' COMMENT '四位',
  `n5` tinyint(1) NOT NULL DEFAULT '0' COMMENT '五位',
  `n6` tinyint(1) NOT NULL DEFAULT '0' COMMENT '六位',
  `n7` tinyint(1) NOT NULL DEFAULT '0' COMMENT '七位',
  `diff1` tinyint(2) NOT NULL DEFAULT '0' COMMENT '一位升平降(大于0升；等于0平；小于0降)',
  `diff2` tinyint(2) NOT NULL DEFAULT '0' COMMENT '二位升平降(大于0升；等于0平；小于0降)',
  `diff3` tinyint(2) NOT NULL DEFAULT '0' COMMENT '三位升平降(大于0升；等于0平；小于0降)',
  `diff4` tinyint(2) NOT NULL DEFAULT '0' COMMENT '四位升平降(大于0升；等于0平；小于0降)',
  `diff5` tinyint(2) NOT NULL DEFAULT '0' COMMENT '五位升平降(大于0升；等于0平；小于0降)',
  `diff6` tinyint(2) NOT NULL DEFAULT '0' COMMENT '六位升平降(大于0升；等于0平；小于0降)',
  `diff7` tinyint(2) NOT NULL DEFAULT '0' COMMENT '七位升平降(大于0升；等于0平；小于0降)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='七星彩(全国)';

-- ----------------------------
-- Table structure for cp_xglhc
-- ----------------------------
DROP TABLE IF EXISTS `cp_xglhc`;
CREATE TABLE `cp_xglhc` (
  `id` mediumint(8) unsigned NOT NULL COMMENT '香港开奖期号',
  `numbers` char(20) NOT NULL DEFAULT '' COMMENT '开奖号码',
  `uptime` int(10) NOT NULL COMMENT '更新时间',
  `n1` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '正码一位',
  `n2` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '正码二位',
  `n3` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '正码三位',
  `n4` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '正码四位',
  `n5` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '正码五位',
  `n6` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '正码六位',
  `n7` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00' COMMENT '特码',
  `diff1` tinyint(2) NOT NULL DEFAULT '0' COMMENT '一位升平降(大于0升；等于0平；小于0降)',
  `diff2` tinyint(2) NOT NULL DEFAULT '0' COMMENT '二位升平降(大于0升；等于0平；小于0降)',
  `diff3` tinyint(2) NOT NULL DEFAULT '0' COMMENT '三位升平降(大于0升；等于0平；小于0降)',
  `diff4` tinyint(2) NOT NULL DEFAULT '0' COMMENT '四位升平降(大于0升；等于0平；小于0降)',
  `diff5` tinyint(2) NOT NULL DEFAULT '0' COMMENT '五位升平降(大于0升；等于0平；小于0降)',
  `diff6` tinyint(2) NOT NULL DEFAULT '0' COMMENT '六位升平降(大于0升；等于0平；小于0降)',
  `diff7` tinyint(2) NOT NULL DEFAULT '0' COMMENT '蓝球升平降(大于0升；等于0平；小于0降)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='香港开奖(香港)';
