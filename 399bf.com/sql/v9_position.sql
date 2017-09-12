/*
Navicat MySQL Data Transfer

Source Server         : [阿里云]web-test
Source Server Version : 50623
Source Host           : 127.0.0.1:3306
Source Database       : 399bf.com

Target Server Type    : MYSQL
Target Server Version : 50623
File Encoding         : 65001

Date: 2017-05-11 13:31:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for v9_position
-- ----------------------------
DROP TABLE IF EXISTS `v9_position`;
CREATE TABLE `v9_position` (
  `posid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `modelid` smallint(5) unsigned DEFAULT '0',
  `catid` smallint(5) unsigned DEFAULT '0',
  `name` char(30) NOT NULL DEFAULT '',
  `maxnum` smallint(5) NOT NULL DEFAULT '20',
  `extention` char(100) DEFAULT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`posid`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v9_position
-- ----------------------------
INSERT INTO `v9_position` VALUES ('1', '0', '0', '首页焦点图推荐', '20', null, '1', '1', '');
INSERT INTO `v9_position` VALUES ('2', '0', '0', '首页头条推荐', '20', '{relation}', '4', '0', '');
INSERT INTO `v9_position` VALUES ('13', '82', '0', '栏目页焦点图', '20', null, '0', '1', '');
INSERT INTO `v9_position` VALUES ('5', '69', '0', '推荐下载', '20', null, '0', '1', '');
INSERT INTO `v9_position` VALUES ('8', '3', '20', '图片频道首页焦点图', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('9', '0', '0', '网站顶部推荐', '20', null, '0', '1', '');
INSERT INTO `v9_position` VALUES ('10', '0', '0', '栏目首页推荐', '20', null, '0', '1', '');
INSERT INTO `v9_position` VALUES ('12', '0', '0', '首页图片推荐', '20', null, '0', '1', '');
INSERT INTO `v9_position` VALUES ('14', '0', '0', '视频首页焦点图', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('15', '0', '0', '视频首页头条推荐', '20', '', '0', '0', '');
INSERT INTO `v9_position` VALUES ('16', '0', '0', '视频首页每日热点', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('17', '0', '0', '视频栏目精彩推荐', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('19', '1', '0', '国际足球推荐图文', '20', '{keywords}', '0', '1', '');
INSERT INTO `v9_position` VALUES ('21', '1', '0', '中国足球推荐图文', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('22', '1', '0', '中国足球推荐资讯', '20', '{keywords}', '0', '1', '');
INSERT INTO `v9_position` VALUES ('23', '1', '12', '欧洲杯推荐资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('24', '1', '13', '欧冠推荐资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('25', '1', '15', '西甲推荐资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('26', '1', '14', '英超推荐资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('27', '1', '16', '意甲推荐资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('28', '1', '17', '德甲推荐资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('29', '1', '14', '英超频道头条推荐', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('30', '3', '0', '英超频道头条小图', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('31', '0', '0', '英超频道头条大图', '20', '', '0', '0', '');
INSERT INTO `v9_position` VALUES ('32', '1', '14', '英超频道球队相关资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('33', '1', '14', '英超频道热点资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('34', '3', '0', '英超宝贝', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('35', '1', '15', '西甲频道头条推荐', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('36', '0', '0', '西甲频道头条大图', '20', '', '0', '0', '');
INSERT INTO `v9_position` VALUES ('37', '3', '0', '西甲频道头条小图', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('38', '1', '15', '西甲频道球队相关资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('39', '1', '15', '西甲频道热点资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('40', '1', '9', '中超频道头条推荐', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('41', '3', '0', '中超频道头条小图', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('42', '0', '0', '中超频道头条大图', '20', '', '0', '0', '');
INSERT INTO `v9_position` VALUES ('43', '1', '9', '中超频道球队相关资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('44', '1', '9', '中超频道热点资讯', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('45', '1', '9', '中超频道球队资讯头条', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('46', '1', '12', '欧洲杯频道头条推荐', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('47', '3', '0', '欧洲杯频道头条小图', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('48', '3', '0', '欧洲杯频道头条大图', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('49', '0', '0', '首页视频推荐', '20', '{timelen}', '0', '0', '');
INSERT INTO `v9_position` VALUES ('50', '0', '0', '意甲频道头条大图', '20', '', '0', '0', '');
INSERT INTO `v9_position` VALUES ('51', '0', '0', '德甲频道头条大图', '20', '', '0', '0', '');
INSERT INTO `v9_position` VALUES ('52', '0', '0', '法甲频道头条大图', '20', '', '0', '0', '');
INSERT INTO `v9_position` VALUES ('53', '0', '0', '首页banner', '20', '', '0', '0', '');
INSERT INTO `v9_position` VALUES ('54', '0', '0', '欧冠频道头条大图', '20', '', '0', '0', '');
INSERT INTO `v9_position` VALUES ('55', '3', '0', '首页足球宝贝推荐', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('56', '3', '0', '首页篮球宝贝推荐', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('57', '3', '0', '首页体坛美图推荐', '20', '', '0', '1', '');
INSERT INTO `v9_position` VALUES ('58', '0', '0', '首页焦点图推荐(WAP)', '20', '', '2', '0', '');
