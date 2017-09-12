/*
Navicat MySQL Data Transfer

Source Server         : 399bf.com(阿里云)
Source Server Version : 50623
Source Host           : 127.0.0.1:3306
Source Database       : ticai.com

Target Server Type    : MYSQL
Target Server Version : 50623
File Encoding         : 65001

Date: 2016-07-19 15:41:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for v9_admin
-- ----------------------------
DROP TABLE IF EXISTS `v9_admin`;
CREATE TABLE `v9_admin` (
  `userid` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `roleid` smallint(5) DEFAULT '0',
  `encrypt` varchar(6) DEFAULT NULL,
  `lastloginip` varchar(15) DEFAULT NULL,
  `lastlogintime` int(10) unsigned DEFAULT '0',
  `email` varchar(40) DEFAULT NULL,
  `realname` varchar(50) NOT NULL DEFAULT '',
  `card` varchar(255) NOT NULL,
  `lang` varchar(6) NOT NULL,
  PRIMARY KEY (`userid`),
  KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v9_admin
-- ----------------------------
INSERT INTO `v9_admin` VALUES ('1', 'phpcms', 'a586d7420218674cc350403c2fe37d31', '1', '43bGUV', '222.76.235.52', '1467273036', 'tangkh@yeah.net', '汤开华', '', '');
INSERT INTO `v9_admin` VALUES ('2', 'hemengfang', '97db58c993f59c37645b374b9b6d58d6', '2', 'JIkBrn', '59.57.220.168', '1464142767', '56658677@qq.com', '何梦舫', '', '');
INSERT INTO `v9_admin` VALUES ('3', 'yangyuqing', '82b3662034faff845c8217de30b723c6', '5', '1xG5KT', '120.42.92.27', '1465262908', '609371636@qq.com', '杨雨晴', '', '');
INSERT INTO `v9_admin` VALUES ('4', 'caiying', '299c40a887106a2f103c8127cf2bfe77', '7', '6WquUt', '192.168.0.38', '1463455213', '1966940032@qq.com', '蔡莹', '', '');
