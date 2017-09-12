/*
Navicat MySQL Data Transfer

Source Server         : 399bf.com(阿里云)
Source Server Version : 50623
Source Host           : 127.0.0.1:3306
Source Database       : ticai.com

Target Server Type    : MYSQL
Target Server Version : 50623
File Encoding         : 65001

Date: 2016-07-19 15:38:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for v9_workflow
-- ----------------------------
DROP TABLE IF EXISTS `v9_workflow`;
CREATE TABLE `v9_workflow` (
  `workflowid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `steps` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `workname` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `setting` text NOT NULL,
  `flag` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`workflowid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v9_workflow
-- ----------------------------
INSERT INTO `v9_workflow` VALUES ('1', '1', '1', '一级审核', '审核一次', '', '0');
INSERT INTO `v9_workflow` VALUES ('2', '1', '2', '二级审核', '审核两次', '', '0');
INSERT INTO `v9_workflow` VALUES ('3', '1', '3', '三级审核', '审核三次', '', '0');
INSERT INTO `v9_workflow` VALUES ('4', '1', '4', '四级审核', '四级审核', '', '0');
