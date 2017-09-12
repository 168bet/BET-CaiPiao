/*
Navicat MySQL Data Transfer

Source Server         : 399bf.com(阿里云)
Source Server Version : 50623
Source Host           : 127.0.0.1:3306
Source Database       : ticai.com

Target Server Type    : MYSQL
Target Server Version : 50623
File Encoding         : 65001

Date: 2016-07-19 15:29:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for v9_poster_space
-- ----------------------------
DROP TABLE IF EXISTS `v9_poster_space`;
CREATE TABLE `v9_poster_space` (
  `spaceid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` char(50) NOT NULL,
  `type` char(30) NOT NULL,
  `path` char(40) NOT NULL,
  `width` smallint(4) unsigned NOT NULL DEFAULT '0',
  `height` smallint(4) unsigned NOT NULL DEFAULT '0',
  `setting` char(100) NOT NULL,
  `description` char(100) NOT NULL,
  `items` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`spaceid`),
  KEY `disabled` (`disabled`,`siteid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v9_poster_space
-- ----------------------------
INSERT INTO `v9_poster_space` VALUES ('1', '1', '顶部搜索右侧广告位', 'banner', 'poster_js/1.js', '430', '63', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '', '1', '0');
INSERT INTO `v9_poster_space` VALUES ('2', '1', '会员登陆页广告', 'banner', 'poster_js/2.js', '310', '304', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '会员登陆页广告右侧代替外部通行证广告', '1', '0');
INSERT INTO `v9_poster_space` VALUES ('3', '1', '图片频道图片排行下方', 'banner', 'poster_js/3.js', '249', '87', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '', '1', '0');
INSERT INTO `v9_poster_space` VALUES ('4', '1', '新闻中心推荐链接左侧', 'banner', 'poster_js/4.js', '748', '91', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '', '1', '0');
INSERT INTO `v9_poster_space` VALUES ('5', '1', '下载列表页右侧顶部', 'banner', 'poster_js/5.js', '248', '162', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '', '1', '0');
INSERT INTO `v9_poster_space` VALUES ('6', '1', '下载详情页右侧顶部', 'banner', 'poster_js/6.js', '248', '162', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '', '1', '0');
INSERT INTO `v9_poster_space` VALUES ('7', '1', '下载详情页右侧下部', 'banner', 'poster_js/7.js', '248', '162', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '', '1', '0');
INSERT INTO `v9_poster_space` VALUES ('8', '1', '下载频道首页', 'banner', 'poster_js/8.js', '698', '80', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '', '1', '0');
INSERT INTO `v9_poster_space` VALUES ('9', '1', '下载详情页地址列表右侧', 'banner', 'poster_js/12.js', '330', '50', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '', '1', '0');
INSERT INTO `v9_poster_space` VALUES ('10', '1', '首页关注下方广告', 'banner', 'poster_js/10.js', '307', '60', 'array (\n  \'paddleft\' => \'\',\n  \'paddtop\' => \'\',\n)', '', '1', '0');
