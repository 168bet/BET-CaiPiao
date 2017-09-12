/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : 127.0.0.1:3306
Source Database       : ticai.com

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-04-14 14:47:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for v9_wap_type
-- ----------------------------
DROP TABLE IF EXISTS `v9_wap_type`;
CREATE TABLE `v9_wap_type` (
  `typeid` smallint(5) NOT NULL AUTO_INCREMENT,
  `cat` smallint(5) NOT NULL,
  `parentid` smallint(5) NOT NULL,
  `typename` varchar(30) NOT NULL,
  `siteid` smallint(5) NOT NULL,
  `listorder` smallint(5) DEFAULT '0',
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v9_wap_type
-- ----------------------------
INSERT INTO `v9_wap_type` VALUES ('1', '1', '0', '足彩分析', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('2', '18', '1', '竞彩足球分析', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('3', '19', '1', '亚盘分析法', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('4', '0', '1', '足彩单场分析', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('5', '22', '1', '竞彩足球怎么玩', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('6', '21', '1', '欧赔和亚盘', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('7', '20', '1', '欧赔分析技巧', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('8', '2', '0', '足彩预测', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('9', '0', '8', '竞彩足球胜平负', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('10', '25', '8', '胜负彩14场专家预测', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('11', '24', '8', '竞彩足球预测', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('12', '3', '0', '足彩推荐', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('13', '27', '12', '今日强胆推荐', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('14', '4', '0', '竞彩篮球预测', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('15', '5', '0', '竞彩篮球分析', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('16', '6', '0', '竞彩体育资讯', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('17', '30', '16', '世界足坛', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('18', '29', '16', '中国足坛', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('19', '28', '16', '五大联赛', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('20', '7', '0', '体坛图库', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('21', '13', '20', '篮球宝贝', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('22', '9', '20', '足球宝贝', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('23', '8', '0', '体坛视频', '1', '0');
INSERT INTO `v9_wap_type` VALUES ('24', '31', '12', '足彩单场分析', '1', '0');
