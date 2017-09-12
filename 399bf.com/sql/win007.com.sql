/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : win007.com

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-03-03 11:22:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bt_company
-- ----------------------------
DROP TABLE IF EXISTS `bt_company`;
CREATE TABLE `bt_company` (
  `companyid` int(10) unsigned NOT NULL COMMENT '开盘公司唯一编号',
  `kind` tinyint(1) NOT NULL COMMENT '开盘类型(1：让分盘 2：上下盘 3：单双盘)',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '公司名称',
  PRIMARY KEY (`companyid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='开盘公司资料表';

-- ----------------------------
-- Table structure for bt_europeodds
-- ----------------------------
DROP TABLE IF EXISTS `bt_europeodds`;
CREATE TABLE `bt_europeodds` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `companyid` int(10) unsigned NOT NULL COMMENT '公司ID',
  `homewin_f` decimal(5,3) NOT NULL COMMENT '初盘主胜赔率',
  `guestwin_f` decimal(5,3) NOT NULL COMMENT '初盘客胜赔率',
  `homewin` decimal(5,3) NOT NULL COMMENT '即时盘主胜赔率',
  `guestwin` decimal(5,3) NOT NULL COMMENT '即时盘客胜赔率',
  `probability_h0` decimal(5,3) NOT NULL COMMENT '初盘主胜率，为查询效率而设',
  `probability_g0` decimal(5,3) NOT NULL COMMENT '初盘客胜率',
  `probability_t0` decimal(5,3) NOT NULL COMMENT '初盘返回率',
  `probability_h1` decimal(5,3) NOT NULL COMMENT '即时盘主胜率',
  `probability_g1` decimal(5,3) NOT NULL COMMENT '即时盘客胜率',
  `probability_t1` decimal(5,3) NOT NULL COMMENT '即时盘返回率',
  `modifytime` int(10) NOT NULL COMMENT '赔率更新时间',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`companyid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='欧盘赔率表';

-- ----------------------------
-- Table structure for bt_europeodds_detail
-- ----------------------------
DROP TABLE IF EXISTS `bt_europeodds_detail`;
CREATE TABLE `bt_europeodds_detail` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `companyid` int(10) unsigned NOT NULL COMMENT '公司ID',
  `homewin` decimal(5,3) NOT NULL COMMENT '即时盘主胜赔率',
  `guestwin` decimal(5,3) NOT NULL COMMENT '即时盘客胜赔率',
  `probability_h` decimal(5,3) NOT NULL COMMENT '即时盘主胜率',
  `probability_g` decimal(5,3) NOT NULL COMMENT '即时盘客胜率',
  `probability_t` decimal(5,3) NOT NULL COMMENT '即时盘返回率',
  `modifytime` int(10) NOT NULL COMMENT '赔率更新时间',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`companyid`,`modifytime`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='欧盘赔率变化表';

-- ----------------------------
-- Table structure for bt_europeodds_total
-- ----------------------------
DROP TABLE IF EXISTS `bt_europeodds_total`;
CREATE TABLE `bt_europeodds_total` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `homewin_f` decimal(5,3) NOT NULL COMMENT '初盘平均主胜赔率',
  `guestwin_f` decimal(5,3) NOT NULL COMMENT '初盘平均客胜赔率',
  `homewin` decimal(5,3) NOT NULL COMMENT '即时盘平均主胜赔率',
  `guestwin` decimal(5,3) NOT NULL COMMENT '即时盘平均客胜赔率',
  `probability_h0` decimal(5,3) NOT NULL COMMENT '初盘平均主胜率',
  `probability_g0` decimal(5,3) NOT NULL COMMENT '初盘平均客胜率',
  `probability_t0` decimal(5,3) NOT NULL COMMENT '初盘平均返回率',
  `probability_h1` decimal(5,3) NOT NULL COMMENT '实盘平均主胜率',
  `probability_g1` decimal(5,3) NOT NULL COMMENT '实盘平均客胜率',
  `probability_t1` decimal(5,3) NOT NULL COMMENT '实盘平均返回率',
  PRIMARY KEY (`scheduleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='欧赔平均赔率表';

-- ----------------------------
-- Table structure for bt_europe_company
-- ----------------------------
DROP TABLE IF EXISTS `bt_europe_company`;
CREATE TABLE `bt_europe_company` (
  `companyid` int(10) unsigned NOT NULL COMMENT '开盘公司唯一编号',
  `name_cn` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `name_e` varchar(50) NOT NULL DEFAULT '' COMMENT '公司英文名称',
  `name_s` varchar(50) NOT NULL DEFAULT '' COMMENT '公司简称',
  PRIMARY KEY (`companyid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='百欧开盘公司资料表';

-- ----------------------------
-- Table structure for bt_letgoal
-- ----------------------------
DROP TABLE IF EXISTS `bt_letgoal`;
CREATE TABLE `bt_letgoal` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `companyid` int(10) unsigned NOT NULL COMMENT '公司ID',
  `letgoal_f` decimal(5,2) NOT NULL COMMENT '初盘盘口 （第一个赔率）',
  `homeodds_f` decimal(5,3) NOT NULL COMMENT '初盘 主队赔率',
  `guestodds_f` decimal(5,3) NOT NULL COMMENT '初盘 客队赔率',
  `letgoal` decimal(5,2) NOT NULL COMMENT '即时盘口（当前赔率，不包括走地）',
  `homeodds` decimal(5,3) NOT NULL COMMENT '主队即时赔率',
  `guestodds` decimal(5,3) NOT NULL COMMENT '客队即时赔率',
  `goal_r` decimal(5,2) NOT NULL COMMENT '走地盘口',
  `homeodds_r` decimal(5,3) NOT NULL COMMENT '主队走地赔率',
  `guestodds_r` decimal(5,3) NOT NULL COMMENT '客队走地赔率',
  `modifytime` int(10) NOT NULL COMMENT '赔率修改时间(如果接口未提供则显示当前系统时间)',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`companyid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='让分盘赔率数据(全场)';

-- ----------------------------
-- Table structure for bt_letgoal_detail
-- ----------------------------
DROP TABLE IF EXISTS `bt_letgoal_detail`;
CREATE TABLE `bt_letgoal_detail` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `companyid` int(10) unsigned NOT NULL COMMENT '公司ID',
  `letgoal` decimal(5,2) NOT NULL COMMENT '盘口',
  `homeodds` decimal(5,3) NOT NULL COMMENT '主队赔率',
  `guestodds` decimal(5,3) NOT NULL COMMENT '客队赔率',
  `type` tinyint(1) NOT NULL COMMENT '让分盘赔率种类(1第一节；2第二节；3半场；4第三节；5第四节；6全场；7滚球)',
  `modifytime` int(10) NOT NULL COMMENT '赔率修改时间(如果接口未提供则显示当前系统时间)',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`companyid`,`type`,`modifytime`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='让分盘赔率数据变化表';

-- ----------------------------
-- Table structure for bt_letgoal_half
-- ----------------------------
DROP TABLE IF EXISTS `bt_letgoal_half`;
CREATE TABLE `bt_letgoal_half` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `companyid` int(10) unsigned NOT NULL COMMENT '公司ID',
  `letgoal_f` decimal(5,2) NOT NULL COMMENT '初盘盘口 （第一个赔率）',
  `homeodds_f` decimal(5,3) NOT NULL COMMENT '初盘 主队赔率',
  `guestodds_f` decimal(5,3) NOT NULL COMMENT '初盘 客队赔率',
  `letgoal` decimal(5,2) NOT NULL COMMENT '即时盘口（当前赔率，不包括走地）',
  `homeodds` decimal(5,3) NOT NULL COMMENT '主队即时赔率',
  `guestodds` decimal(5,3) NOT NULL COMMENT '客队即时赔率',
  `modifytime` int(10) NOT NULL COMMENT '赔率修改时间',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`companyid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='让分盘赔率数据(半场)';

-- ----------------------------
-- Table structure for bt_lineup
-- ----------------------------
DROP TABLE IF EXISTS `bt_lineup`;
CREATE TABLE `bt_lineup` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `homelineup` text NOT NULL COMMENT '主队主选球员',
  `homebackup` text NOT NULL COMMENT '主队备选球员',
  `guestlineup` text NOT NULL COMMENT '客队主选球员',
  `guestbackup` text NOT NULL COMMENT '客队备选球员',
  `analyse` varchar(255) NOT NULL DEFAULT '' COMMENT '赛前简报',
  `injury` text NOT NULL COMMENT '伤停',
  `homenear6` char(6) NOT NULL DEFAULT '' COMMENT '主队近六场输赢',
  `homeodds` char(6) NOT NULL DEFAULT '' COMMENT '主队近六场让分盘路',
  `homeou` char(6) NOT NULL DEFAULT '' COMMENT '主队近六场大小球盘路',
  `guestnear6` char(6) NOT NULL DEFAULT '' COMMENT '客队近六场输赢',
  `guestodds` char(6) NOT NULL DEFAULT '' COMMENT '客队近六场让分盘路',
  `guestou` char(6) NOT NULL DEFAULT '' COMMENT '客队近六场大小球盘路',
  `confidence` varchar(255) NOT NULL DEFAULT '' COMMENT '信心指数',
  `vs` varchar(255) NOT NULL DEFAULT '' COMMENT '对赛往绩',
  `note` text NOT NULL COMMENT '说明',
  PRIMARY KEY (`scheduleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='阵容、伤停、预测、赛前简报';

-- ----------------------------
-- Table structure for bt_live_schedule
-- ----------------------------
DROP TABLE IF EXISTS `bt_live_schedule`;
CREATE TABLE `bt_live_schedule` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID(比赛唯一编号)',
  `sclassid` smallint(5) unsigned NOT NULL COMMENT '联赛ID(标识NBA、WNBA、CBA)',
  `sclasstype` tinyint(1) NOT NULL COMMENT '类型(1联赛，2杯赛)',
  `sclassname_cn` varchar(50) NOT NULL DEFAULT '' COMMENT '联赛简体名',
  `sclassname_tw` varchar(50) NOT NULL DEFAULT '' COMMENT '联赛繁体名',
  `sclasspart` tinyint(3) NOT NULL COMMENT '分几节进行，2:上下半场，4：分4小节',
  `sclasscolor` char(7) NOT NULL DEFAULT '' COMMENT '联赛颜色值',
  `date` int(10) NOT NULL COMMENT '开赛时间',
  `status` tinyint(3) NOT NULL COMMENT '状态:0:未开赛,1:一节,2:二节,5:1''OT，以此类推，-1:完场, -2:待定,-3:中断,-4:取消,-5:推迟,50中场',
  `remaintime` varchar(5) NOT NULL DEFAULT '' COMMENT '小节剩余时间',
  `hometeamid` int(10) unsigned NOT NULL COMMENT '主队ID',
  `homename_cn` varchar(20) NOT NULL DEFAULT '' COMMENT '主队简体名',
  `homename_tw` varchar(20) NOT NULL DEFAULT '' COMMENT '主队繁体名',
  `guestteamid` int(10) unsigned NOT NULL COMMENT '客队ID',
  `guestname_cn` varchar(20) NOT NULL DEFAULT '' COMMENT '客队简体名',
  `guestname_tw` varchar(20) NOT NULL DEFAULT '' COMMENT '客队繁体名',
  `homerank` varchar(10) NOT NULL DEFAULT '' COMMENT '主队排名',
  `guestrank` varchar(10) NOT NULL DEFAULT '' COMMENT '客队排名',
  `homescore` smallint(5) NOT NULL COMMENT '主队总得分',
  `guestscore` smallint(5) NOT NULL COMMENT '客队总得分',
  `homeone` smallint(5) NOT NULL COMMENT '主队在第一节的得分',
  `guestone` smallint(5) NOT NULL COMMENT '客队在第一节的得分',
  `hometwo` smallint(5) NOT NULL COMMENT '主队在第二节的得分',
  `guesttwo` smallint(5) NOT NULL COMMENT '客队在第二节的得分',
  `homethree` smallint(5) NOT NULL COMMENT '主队在第三节的得分',
  `guestthree` smallint(5) NOT NULL COMMENT '客队在第三节的得分',
  `homefour` smallint(5) NOT NULL COMMENT '主队在第四节的得分',
  `guestfour` smallint(5) NOT NULL COMMENT '客队在第四节的得分',
  `addtime` tinyint(3) NOT NULL COMMENT '加时数 ，即几个加时',
  `homeaddtime1` smallint(5) NOT NULL COMMENT '主队1''ot得分',
  `guestaddtime1` smallint(5) NOT NULL COMMENT '客队1''ot得分',
  `homeaddtime2` smallint(5) NOT NULL COMMENT '主队2''ot得分',
  `guestaddtime2` smallint(5) NOT NULL COMMENT '客队2''ot得分',
  `homeaddtime3` smallint(5) NOT NULL COMMENT '主队3''ot得分',
  `guestaddtime3` smallint(5) NOT NULL COMMENT '客队3''ot得分',
  `istechnic` tinyint(1) NOT NULL COMMENT '是否有技术统计',
  `tv` varchar(50) NOT NULL DEFAULT '' COMMENT '电视直播',
  `note1` text NOT NULL COMMENT '备注1，直播内容',
  `neutral` tinyint(1) NOT NULL COMMENT '中立场：1表示中立场',
  `note2` text NOT NULL COMMENT '备注2，赔率信息(该数据来自即时变化接口)',
  `homewin` decimal(5,3) NOT NULL COMMENT '主胜赔率(该数据来自即时变化接口)',
  `guestwin` decimal(5,3) NOT NULL COMMENT '客胜赔率(该数据来自即时变化接口)',
  PRIMARY KEY (`scheduleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='即时比分表';

-- ----------------------------
-- Table structure for bt_location
-- ----------------------------
DROP TABLE IF EXISTS `bt_location`;
CREATE TABLE `bt_location` (
  `locationid` int(10) unsigned NOT NULL COMMENT '联盟ID',
  `name_cn` varchar(12) NOT NULL DEFAULT '' COMMENT '联盟名称，如东部，西部，中国',
  `name_en` varchar(20) NOT NULL DEFAULT '' COMMENT '英文名称',
  `name_tw` varchar(12) NOT NULL DEFAULT '' COMMENT '繁体名称',
  PRIMARY KEY (`locationid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='联盟（国家）名称表';

-- ----------------------------
-- Table structure for bt_matchaddr
-- ----------------------------
DROP TABLE IF EXISTS `bt_matchaddr`;
CREATE TABLE `bt_matchaddr` (
  `matchaddrid` int(10) unsigned NOT NULL COMMENT '赛区ID',
  `name_cn` varchar(12) NOT NULL DEFAULT '' COMMENT '赛区名称，如太西洋赛区，中央赛区',
  `name_en` varchar(12) NOT NULL DEFAULT '' COMMENT '英文名称',
  `name_tw` varchar(12) NOT NULL DEFAULT '' COMMENT '繁体名称',
  `locationid` int(10) NOT NULL DEFAULT '0' COMMENT '联盟ID',
  PRIMARY KEY (`matchaddrid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赛区名称表';

-- ----------------------------
-- Table structure for bt_player
-- ----------------------------
DROP TABLE IF EXISTS `bt_player`;
CREATE TABLE `bt_player` (
  `playerid` int(10) unsigned NOT NULL COMMENT '球员ID(球员的唯一编号，改队不改号)',
  `number` tinyint(3) NOT NULL COMMENT '球员的球衣号码，改队改号',
  `name_tw` varchar(30) NOT NULL DEFAULT '' COMMENT '球员的繁体姓名',
  `name_s` varchar(20) NOT NULL DEFAULT '' COMMENT '球员的简体姓名简称',
  `name_cn` varchar(30) NOT NULL DEFAULT '' COMMENT '球员的简体姓名全称',
  `name_en` varchar(30) NOT NULL DEFAULT '' COMMENT '球员的英文名称',
  `teamid` int(10) unsigned NOT NULL COMMENT '目前效力的球队ID号',
  `place` varchar(10) NOT NULL DEFAULT '' COMMENT '前锋/中锋/后卫',
  `birthday` int(10) NOT NULL COMMENT '出生年月日',
  `tallness` smallint(5) NOT NULL COMMENT '身高，cm为单位',
  `weight` smallint(5) NOT NULL COMMENT '体重，kg为单位',
  `photo` varchar(50) NOT NULL DEFAULT '' COMMENT '球员的照片存放地址',
  `nbaage` smallint(5) NOT NULL COMMENT '在NBA的年资',
  PRIMARY KEY (`playerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球员资料表';

-- ----------------------------
-- Table structure for bt_player_technic
-- ----------------------------
DROP TABLE IF EXISTS `bt_player_technic`;
CREATE TABLE `bt_player_technic` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `teamid` int(10) unsigned NOT NULL COMMENT '球队ID',
  `playerid` int(10) unsigned NOT NULL COMMENT '球员ID',
  `firstjoin` varchar(10) NOT NULL DEFAULT '' COMMENT '首发的位置，并表明是否是首发',
  `playtime` smallint(5) NOT NULL COMMENT '上场时间',
  `shoot` smallint(5) NOT NULL COMMENT '投篮的个数',
  `shoot_hit` smallint(5) NOT NULL COMMENT '投篮的命中个数',
  `threemin` smallint(5) NOT NULL COMMENT '投三分球的个数',
  `threemin_hit` smallint(5) NOT NULL COMMENT '投三分球的命中个数',
  `punishball` smallint(5) NOT NULL COMMENT '罚球的个数',
  `punishball_hit` smallint(5) NOT NULL COMMENT '罚球的命中个数',
  `attack` smallint(5) NOT NULL COMMENT '进攻篮板的总数',
  `defend` smallint(5) NOT NULL COMMENT '防守篮板的总数',
  `helpattack` smallint(5) NOT NULL COMMENT '助攻篮板的总数',
  `rob` smallint(5) NOT NULL COMMENT '抢断篮板的总数',
  `cover` smallint(5) NOT NULL COMMENT '篮板盖帽的总数',
  `misplay` smallint(5) NOT NULL COMMENT '失误的总数',
  `foul` smallint(5) NOT NULL COMMENT '犯规的总数',
  `score` smallint(5) NOT NULL COMMENT '总得分数',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`teamid`,`playerid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='赛事详细技术统计表(记录每场比赛每个球员的技术情况)';

-- ----------------------------
-- Table structure for bt_player_technic_stats
-- ----------------------------
DROP TABLE IF EXISTS `bt_player_technic_stats`;
CREATE TABLE `bt_player_technic_stats` (
  `playerid` int(10) unsigned NOT NULL COMMENT '球员编号',
  `season` varchar(10) NOT NULL DEFAULT '' COMMENT '赛季，如03-04、季后赛',
  `teamid` int(10) unsigned NOT NULL COMMENT '球队ID',
  `jointime` smallint(5) NOT NULL COMMENT '当次赛季上场的次数',
  `firstjoin` smallint(5) NOT NULL COMMENT '当次赛季首发的次数',
  `playtime` smallint(5) NOT NULL COMMENT '当次赛季总上场时间',
  `shoot` smallint(5) NOT NULL COMMENT '当次赛季投篮的个数',
  `shoot_hit` smallint(5) NOT NULL COMMENT '当次赛季投篮的命中个数',
  `threemin` smallint(5) NOT NULL COMMENT '当次赛季投三分球的个数',
  `threemin_hit` smallint(5) NOT NULL COMMENT '当次赛季投三分球的命中个数',
  `punishball` smallint(5) NOT NULL COMMENT '当次赛季罚球的个数',
  `punishball_hit` smallint(5) NOT NULL COMMENT '当次赛季罚球的命中个数',
  `attack` smallint(5) NOT NULL COMMENT '当次赛季进攻篮板的总数',
  `defend` smallint(5) NOT NULL COMMENT '当次赛季防守篮板的总数',
  `helpattack` smallint(5) NOT NULL COMMENT '当次赛季助攻篮板的总数',
  `rob` smallint(5) NOT NULL COMMENT '当次赛季抢断篮板的总数',
  `cover` smallint(5) NOT NULL COMMENT '当次赛季篮板盖帽的总数',
  `misplay` smallint(5) NOT NULL COMMENT '当次赛季失误的总数',
  `foul` smallint(5) NOT NULL COMMENT '当次赛季犯规的总数',
  `score` smallint(5) NOT NULL COMMENT '当次赛季总的得分数',
  `double_2` smallint(5) NOT NULL COMMENT '得两双的次数(得分 篮板 助攻 盖帽 抢断这几项数据中有两项过10就算两双)',
  `double_3` smallint(5) NOT NULL COMMENT '得三双的次数',
  `double_4` smallint(5) NOT NULL COMMENT '得四双的次数',
  UNIQUE KEY `idx_uniq` (`playerid`,`season`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='球员技术资料表(按赛季统计)';

-- ----------------------------
-- Table structure for bt_schedule
-- ----------------------------
DROP TABLE IF EXISTS `bt_schedule`;
CREATE TABLE `bt_schedule` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID(比赛唯一编号)',
  `sclassid` smallint(5) unsigned NOT NULL COMMENT '联赛ID(标识NBA、WNBA、CBA)',
  `sclasstype` tinyint(1) NOT NULL COMMENT '类型(1联赛，2杯赛)',
  `sclassname_cn` varchar(50) NOT NULL DEFAULT '' COMMENT '联赛简体名',
  `sclassname_tw` varchar(50) NOT NULL DEFAULT '' COMMENT '联赛繁体名',
  `sclasspart` tinyint(3) NOT NULL COMMENT '分几节进行，2:上下半场，4：分4小节',
  `sclasscolor` char(7) NOT NULL DEFAULT '' COMMENT '联赛颜色值',
  `date` int(10) NOT NULL COMMENT '开赛时间',
  `status` tinyint(3) NOT NULL COMMENT '状态:0:未开赛,1:一节,2:二节,5:1''OT，以此类推，-1:完场, -2:待定,-3:中断,-4:取消,-5:推迟,50中场',
  `remaintime` varchar(5) NOT NULL DEFAULT '' COMMENT '小节剩余时间',
  `hometeamid` int(10) unsigned NOT NULL COMMENT '主队ID',
  `homename_cn` varchar(20) NOT NULL DEFAULT '' COMMENT '主队简体名',
  `homename_tw` varchar(20) NOT NULL DEFAULT '' COMMENT '主队繁体名',
  `guestteamid` int(10) unsigned NOT NULL COMMENT '客队ID',
  `guestname_cn` varchar(20) NOT NULL DEFAULT '' COMMENT '客队简体名',
  `guestname_tw` varchar(20) NOT NULL DEFAULT '' COMMENT '客队繁体名',
  `homerank` varchar(10) NOT NULL DEFAULT '' COMMENT '主队排名',
  `guestrank` varchar(10) NOT NULL DEFAULT '' COMMENT '客队排名',
  `homescore` smallint(5) NOT NULL COMMENT '主队总得分',
  `guestscore` smallint(5) NOT NULL COMMENT '客队总得分',
  `homeone` smallint(5) NOT NULL COMMENT '主队在第一节的得分',
  `guestone` smallint(5) NOT NULL COMMENT '客队在第一节的得分',
  `hometwo` smallint(5) NOT NULL COMMENT '主队在第二节的得分',
  `guesttwo` smallint(5) NOT NULL COMMENT '客队在第二节的得分',
  `homethree` smallint(5) NOT NULL COMMENT '主队在第三节的得分',
  `guestthree` smallint(5) NOT NULL COMMENT '客队在第三节的得分',
  `homefour` smallint(5) NOT NULL COMMENT '主队在第四节的得分',
  `guestfour` smallint(5) NOT NULL COMMENT '客队在第四节的得分',
  `addtime` tinyint(3) NOT NULL COMMENT '加时数 ，即几个加时',
  `homeaddtime1` smallint(5) NOT NULL COMMENT '主队1''ot得分',
  `guestaddtime1` smallint(5) NOT NULL COMMENT '客队1''ot得分',
  `homeaddtime2` smallint(5) NOT NULL COMMENT '主队2''ot得分',
  `guestaddtime2` smallint(5) NOT NULL COMMENT '客队2''ot得分',
  `homeaddtime3` smallint(5) NOT NULL COMMENT '主队3''ot得分',
  `guestaddtime3` smallint(5) NOT NULL COMMENT '客队3''ot得分',
  `istechnic` tinyint(1) NOT NULL COMMENT '是否有技术统计',
  `tv` varchar(50) NOT NULL DEFAULT '' COMMENT '电视直播',
  `note` text NOT NULL COMMENT '备注，直播内容',
  `neutral` tinyint(1) NOT NULL COMMENT '中立场：1表示中立场',
  `sclassseason` char(10) NOT NULL DEFAULT '' COMMENT '赛季，如11 赛季，11-12 赛季',
  `sclasscategory` tinyint(1) NOT NULL COMMENT '联赛阶段，如1季前赛，2常规赛，3季后赛',
  `stadium` varchar(40) NOT NULL DEFAULT '' COMMENT '比赛场所',
  `category` varchar(20) NOT NULL DEFAULT '' COMMENT '比赛分类，例如第一圈，只有杯赛或季后赛才有数据',
  `subcategory` varchar(20) NOT NULL DEFAULT '' COMMENT '比赛子分类，例如A组，只有杯赛才有数据',
  PRIMARY KEY (`scheduleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赛程表';

-- ----------------------------
-- Table structure for bt_schedule_modify_record
-- ----------------------------
DROP TABLE IF EXISTS `bt_schedule_modify_record`;
CREATE TABLE `bt_schedule_modify_record` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `type` tinyint(1) NOT NULL COMMENT '类型(1修改时间;2删除比赛)',
  `date` int(10) NOT NULL COMMENT '修改后的比赛时间',
  `optime` int(10) NOT NULL COMMENT '操作时间',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`optime`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='比赛删除，改时间记录';

-- ----------------------------
-- Table structure for bt_sclass
-- ----------------------------
DROP TABLE IF EXISTS `bt_sclass`;
CREATE TABLE `bt_sclass` (
  `sclassid` smallint(5) unsigned NOT NULL COMMENT '联赛ID(标识NBA、WNBA等)',
  `sclasscolor` char(7) NOT NULL DEFAULT '' COMMENT '颜色值',
  `name_s` varchar(20) NOT NULL DEFAULT '' COMMENT '简称',
  `name_cn` varchar(50) NOT NULL DEFAULT '' COMMENT '简体全称',
  `name_tw` varchar(50) NOT NULL DEFAULT '' COMMENT '繁体全称',
  `name_en` varchar(50) NOT NULL DEFAULT '' COMMENT '英文全称',
  `sclasspart` tinyint(3) NOT NULL COMMENT '比赛分几节',
  `currseason` char(5) NOT NULL DEFAULT '' COMMENT '当前赛季',
  `countryid` smallint(5) unsigned NOT NULL COMMENT '国家ID',
  `countryname` varchar(20) NOT NULL DEFAULT '' COMMENT '国家名称',
  `curryear` smallint(5) NOT NULL COMMENT '当前年份',
  `currmonth` tinyint(3) NOT NULL COMMENT '当前月份',
  `sclasstype` tinyint(1) NOT NULL COMMENT '类型(1:联赛,2:杯赛)',
  `sclasstime` varchar(10) NOT NULL DEFAULT '' COMMENT '1节打几分钟',
  PRIMARY KEY (`sclassid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='联赛表';

-- ----------------------------
-- Table structure for bt_shangpan
-- ----------------------------
DROP TABLE IF EXISTS `bt_shangpan`;
CREATE TABLE `bt_shangpan` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `companyid` int(10) unsigned NOT NULL COMMENT '公司ID',
  `shangpan` tinyint(1) NOT NULL COMMENT '上下盘(1：主上盘，2：客上盘，0：未开盘)',
  `result` tinyint(1) NOT NULL COMMENT '结果(1：主队赢盘，0：走盘，-1：输盘)',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`companyid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='各公司上盘资料表';

-- ----------------------------
-- Table structure for bt_team
-- ----------------------------
DROP TABLE IF EXISTS `bt_team`;
CREATE TABLE `bt_team` (
  `teamid` int(10) unsigned NOT NULL COMMENT '球队ID',
  `sclassid` smallint(5) unsigned NOT NULL COMMENT '所属联赛ID',
  `name_s` varchar(10) NOT NULL DEFAULT '' COMMENT '简称',
  `name_cn` varchar(20) NOT NULL DEFAULT '' COMMENT '简体名',
  `name_tw` varchar(20) NOT NULL DEFAULT '' COMMENT '繁体名',
  `name_en` varchar(20) NOT NULL DEFAULT '' COMMENT '英文名',
  `logo` varchar(100) NOT NULL DEFAULT '' COMMENT '队标',
  `url` varchar(40) NOT NULL DEFAULT '' COMMENT '球队网址',
  `locationid` int(10) unsigned NOT NULL COMMENT '联盟ID',
  `matchaddrid` int(10) unsigned NOT NULL COMMENT '分区ID',
  `city` varchar(20) NOT NULL DEFAULT '' COMMENT '所在城市',
  `gymnasium` varchar(40) NOT NULL DEFAULT '' COMMENT '球场',
  `capacity` mediumint(8) NOT NULL COMMENT '可容纳的人数',
  `joinyear` smallint(5) NOT NULL COMMENT '加入联盟年数',
  `firsttime` smallint(5) NOT NULL COMMENT '球队在NBA中得冠的次数',
  `drillmaster` varchar(20) NOT NULL DEFAULT '' COMMENT '教练名',
  PRIMARY KEY (`teamid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球队资料表';

-- ----------------------------
-- Table structure for bt_team_standings
-- ----------------------------
DROP TABLE IF EXISTS `bt_team_standings`;
CREATE TABLE `bt_team_standings` (
  `teamid` int(10) unsigned NOT NULL COMMENT '球队ID',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名',
  `sclassid` int(10) unsigned NOT NULL COMMENT '联赛ID',
  `season` varchar(10) NOT NULL DEFAULT '' COMMENT '赛季(如“04-05-1”)',
  `locationname` varchar(12) NOT NULL DEFAULT '' COMMENT '所在联盟(名称)',
  `homewin` smallint(5) NOT NULL COMMENT '主场战胜的总场数',
  `homeloss` smallint(5) NOT NULL COMMENT '主场战败场数',
  `guestwin` smallint(5) NOT NULL COMMENT '客场战胜的总场数',
  `guestloss` smallint(5) NOT NULL COMMENT '客场战败场数',
  `winscale` decimal(5,2) NOT NULL COMMENT '胜率',
  `state` smallint(5) NOT NULL COMMENT '连胜场数，负数表示连败',
  `homerank` smallint(5) NOT NULL COMMENT '主场联盟排名',
  `guestrank` smallint(5) NOT NULL COMMENT '客场联盟排名',
  `totalrank` smallint(5) NOT NULL COMMENT '联盟排名',
  `homescore` mediumint(8) NOT NULL COMMENT '主场总得分',
  `homelossscore` mediumint(8) NOT NULL COMMENT '主场总失分',
  `guestscore` mediumint(8) NOT NULL COMMENT '客场总得分',
  `guestlossscore` mediumint(8) NOT NULL COMMENT '客场总失分',
  `near10win` tinyint(3) NOT NULL COMMENT '最近10场赢的场数',
  `near10loss` tinyint(3) NOT NULL COMMENT '最近10场输的场数',
  UNIQUE KEY `idx_uniq` (`teamid`,`sclassid`,`season`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球队排名表';

-- ----------------------------
-- Table structure for bt_team_technic
-- ----------------------------
DROP TABLE IF EXISTS `bt_team_technic`;
CREATE TABLE `bt_team_technic` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `teamid` int(10) unsigned NOT NULL COMMENT '球队ID',
  `ishome` tinyint(1) NOT NULL COMMENT '表示是主场还是客场',
  `score` smallint(5) NOT NULL COMMENT '某场球赛总的得分',
  `lossscore` smallint(5) NOT NULL COMMENT '某场球赛总的失分',
  `fast` smallint(5) NOT NULL COMMENT '某场球赛快攻得分',
  `inside` smallint(5) NOT NULL COMMENT '某场球赛内线得分',
  `exceed` smallint(5) NOT NULL COMMENT '某场球赛最多领先分数',
  `twoattack` smallint(5) NOT NULL COMMENT '某场球赛两次进攻数',
  `totalmis` smallint(5) NOT NULL COMMENT '某场球赛总失误数',
  `playtime` smallint(5) NOT NULL COMMENT '某场球赛各球员总的上场时间',
  `shoot` smallint(5) NOT NULL COMMENT '某场球赛投篮的个数',
  `shoot_hit` smallint(5) NOT NULL COMMENT '某场球赛投篮的命中个数',
  `threemin` smallint(5) NOT NULL COMMENT '某场球赛投三分球的个数',
  `threemin_hit` smallint(5) NOT NULL COMMENT '某场球赛投三分球的命中个数',
  `punishball` smallint(5) NOT NULL COMMENT '某场球赛罚球的个数',
  `punishball_hit` smallint(5) NOT NULL COMMENT '某场球赛罚球的命中个数',
  `attack` smallint(5) NOT NULL COMMENT '某场球赛进攻篮板的总数',
  `defend` smallint(5) NOT NULL COMMENT '某场球赛防守篮板的总数',
  `helpattack` smallint(5) NOT NULL COMMENT '某场球赛助攻篮板的总数',
  `rob` smallint(5) NOT NULL COMMENT '某场球赛抢断篮板的总数',
  `cover` smallint(5) NOT NULL COMMENT '某场球赛篮板盖帽的总数',
  `misplay` smallint(5) NOT NULL COMMENT '某场球赛失误的总数',
  `foul` smallint(5) NOT NULL COMMENT '某场球赛犯规的总数',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球队技术资料表(记录每场比赛每个球队的技术情况)';

-- ----------------------------
-- Table structure for bt_textlive
-- ----------------------------
DROP TABLE IF EXISTS `bt_textlive`;
CREATE TABLE `bt_textlive` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `textlive` text NOT NULL COMMENT '文字直播内容(以“$”分隔小节（依次第1节、2节、3节、4节、第1加时、第2加时、第3加时），以“！”分隔记录，“^”分隔字段)',
  PRIMARY KEY (`scheduleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文字直播(总量)';

-- ----------------------------
-- Table structure for bt_totalscore
-- ----------------------------
DROP TABLE IF EXISTS `bt_totalscore`;
CREATE TABLE `bt_totalscore` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `companyid` int(10) unsigned NOT NULL COMMENT '公司ID',
  `totalscore_f` decimal(5,2) NOT NULL COMMENT '初盘盘口（第一个赔率）',
  `highodds_f` decimal(5,3) NOT NULL COMMENT '初盘大分赔率',
  `lowodds_f` decimal(5,3) NOT NULL COMMENT '初盘小分赔率',
  `totalscore` decimal(5,2) NOT NULL COMMENT '即时盘盘口（当前赔率，不包括走地）',
  `highodds` decimal(5,3) NOT NULL COMMENT '即时盘大分赔率',
  `lowodds` decimal(5,3) NOT NULL COMMENT '即时盘小分赔率',
  `totalscore_r` decimal(5,2) NOT NULL COMMENT '走地盘口',
  `highodds_r` decimal(5,3) NOT NULL COMMENT '大分走地赔率',
  `lowodds_r` decimal(5,3) NOT NULL COMMENT '小分走地赔率',
  `modifytime` int(10) NOT NULL COMMENT '赔率修改时间',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`companyid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='大小(总分)盘赔率数据(全场)';

-- ----------------------------
-- Table structure for bt_totalscore_detail
-- ----------------------------
DROP TABLE IF EXISTS `bt_totalscore_detail`;
CREATE TABLE `bt_totalscore_detail` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `companyid` int(10) unsigned NOT NULL COMMENT '公司ID',
  `totalscore` decimal(5,2) NOT NULL COMMENT '盘口',
  `highodds` decimal(5,3) NOT NULL COMMENT '大分赔率',
  `lowodds` decimal(5,3) NOT NULL COMMENT '小分赔率',
  `type` tinyint(1) NOT NULL COMMENT '总分盘赔率种类(1第一节；2第二节；3半场；4第三节；5第四节；6全场；7滚球)',
  `modifytime` int(10) NOT NULL COMMENT '赔率修改时间',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`companyid`,`type`,`modifytime`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='大小(总分)盘赔率数据变化表';

-- ----------------------------
-- Table structure for bt_totalscore_half
-- ----------------------------
DROP TABLE IF EXISTS `bt_totalscore_half`;
CREATE TABLE `bt_totalscore_half` (
  `scheduleid` int(10) unsigned NOT NULL COMMENT '比赛ID',
  `companyid` int(10) unsigned NOT NULL COMMENT '公司ID',
  `totalscore_f` decimal(5,2) NOT NULL COMMENT '初盘盘口（第一个赔率）',
  `highodds_f` decimal(5,3) NOT NULL COMMENT '初盘大分赔率',
  `lowodds_f` decimal(5,3) NOT NULL COMMENT '初盘小分赔率',
  `totalscore` decimal(5,2) NOT NULL COMMENT '即时盘盘口（当前赔率，不包括走地）',
  `highodds` decimal(5,3) NOT NULL COMMENT '即时盘大分赔率',
  `lowodds` decimal(5,3) NOT NULL COMMENT '即时盘小分赔率',
  `modifytime` int(10) NOT NULL COMMENT '赔率修改时间',
  UNIQUE KEY `idx_uniq` (`scheduleid`,`companyid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='大小(总分)盘赔率数据(半场)';

-- ----------------------------
-- Table structure for bt_transfer_record
-- ----------------------------
DROP TABLE IF EXISTS `bt_transfer_record`;
CREATE TABLE `bt_transfer_record` (
  `playerid` int(10) unsigned NOT NULL COMMENT '球员ID',
  `date` char(10) NOT NULL DEFAULT '' COMMENT '转会日期',
  `srcteamid` int(10) unsigned NOT NULL COMMENT '转出球队ID',
  `srcteamname` varchar(20) NOT NULL DEFAULT '' COMMENT '转出球队名',
  `destteamid` int(10) unsigned NOT NULL COMMENT '转入球队ID',
  `destteamname` varchar(20) NOT NULL DEFAULT '' COMMENT '转入球队名',
  `season` char(9) NOT NULL DEFAULT '' COMMENT '转会赛季',
  `type` tinyint(1) NOT NULL COMMENT '转会类型(0-为空或未知 1-交易 2-续约  3-解约 4-自由签约 5-选秀)',
  UNIQUE KEY `idx_uniq` (`playerid`,`date`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='NBA转会记录表';
