/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : sportsdt.com

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-09-26 16:29:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ft_coach
-- ----------------------------
DROP TABLE IF EXISTS `ft_coach`;
CREATE TABLE `ft_coach` (
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '教练名称',
  `enname` varchar(50) NOT NULL DEFAULT '' COMMENT '教练英文名',
  `birthday` char(10) NOT NULL DEFAULT '' COMMENT '出生日期',
  `joindate` char(10) NOT NULL DEFAULT '' COMMENT '加盟日期',
  `country` varchar(20) NOT NULL DEFAULT '' COMMENT '国籍',
  `club` varchar(20) NOT NULL DEFAULT '' COMMENT '效力球队',
  `formerclub` varchar(20) NOT NULL DEFAULT '' COMMENT '前度效力球队',
  `onceclub` varchar(255) NOT NULL DEFAULT '' COMMENT '曾经效力球队',
  `glory` text NOT NULL COMMENT '教练荣誉',
  `profile` text NOT NULL COMMENT '教练简介',
  `photo` varchar(100) NOT NULL DEFAULT '' COMMENT '教练头像',
  UNIQUE KEY `idx_uniq` (`name`,`club`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='教练';

-- ----------------------------
-- Table structure for ft_company
-- ----------------------------
DROP TABLE IF EXISTS `ft_company`;
CREATE TABLE `ft_company` (
  `companyid` mediumint(8) unsigned NOT NULL COMMENT '公司编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `area` varchar(20) NOT NULL DEFAULT '' COMMENT '所属区域',
  `country` varchar(20) NOT NULL DEFAULT '' COMMENT '所属国家',
  PRIMARY KEY (`companyid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='指数公司';

-- ----------------------------
-- Table structure for ft_competition
-- ----------------------------
DROP TABLE IF EXISTS `ft_competition`;
CREATE TABLE `ft_competition` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '联赛名称',
  `shortname` varchar(20) NOT NULL DEFAULT '' COMMENT '联赛简称',
  `color` char(6) NOT NULL DEFAULT '' COMMENT '联赛颜色',
  `startdate` int(10) NOT NULL COMMENT '联赛开始时间',
  `enddate` int(10) NOT NULL COMMENT '联赛结束时间',
  `system` text NOT NULL COMMENT '联赛赛制内容',
  PRIMARY KEY (`competitionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='联赛';

-- ----------------------------
-- Table structure for ft_competition_schedule
-- ----------------------------
DROP TABLE IF EXISTS `ft_competition_schedule`;
CREATE TABLE `ft_competition_schedule` (
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `competitionid` mediumint(8) NOT NULL COMMENT '联赛编号',
  `mode` char(6) NOT NULL DEFAULT '' COMMENT '赛制形式(round轮次；group分组；none无)',
  `period` varchar(20) NOT NULL DEFAULT '' COMMENT '阶段(非阶段赛制则为空)',
  `round` varchar(20) NOT NULL DEFAULT '' COMMENT '轮次(非轮次赛制则为空)',
  `group` varchar(20) NOT NULL DEFAULT '' COMMENT '分组(非分组赛制则为空)',
  `hometeamid` mediumint(8) NOT NULL COMMENT '主队编号',
  `awayteamid` mediumint(8) NOT NULL COMMENT '客队编号',
  `date` int(10) NOT NULL COMMENT '比赛时间',
  `neutral` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为中立场(1是；0否)',
  `homescore` tinyint(2) NOT NULL DEFAULT '0' COMMENT '主队得分(比赛结束数据)',
  `awayscore` tinyint(2) NOT NULL DEFAULT '0' COMMENT '客队得分(比赛结束数据)',
  `homeredcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '主队红牌(比赛结束数据)',
  `awayredcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '客队红牌(比赛结束数据)',
  `half` char(5) NOT NULL DEFAULT '' COMMENT '半场比分(比赛结束数据)\r\n',
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='联赛赛程';

-- ----------------------------
-- Table structure for ft_correctscore_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_correctscore_stats`;
CREATE TABLE `ft_correctscore_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称(冗余)',
  `data` text NOT NULL COMMENT '统计信息\r\n\r\ndata统计信息数组:\r\n第1位：1:0 次数\r\n第2位：2:0 次数\r\n第3位：2:1 次数\r\n第4位：3:0 次数\r\n第5位：3:1 次数\r\n第6位：3:2 次数\r\n第7位：4:0 次数\r\n第8位：4:1 次数\r\n第9位：4:2 次数\r\n第10位：4:3 次数\r\n第11位：0:0 次数\r\n第12位：1:1 次数\r\n第13位：2:2 次数\r\n第14位：3:3 次数\r\n第15位：4:4 次数\r\n第16位：0:1 次数\r\n第17位：0:2 次数\r\n第18位：1:2 次数\r\n第19位：0:3 次数\r\n第20位：1:3 次数\r\n第21位：2:3 次数\r\n第22位：0:4 次数\r\n第23位：1:4 次数\r\n第24位：2:4 次数\r\n第25位：3:4 次数\r\n第26位：其它 次数',
  UNIQUE KEY `idx_uniq` (`competitionid`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='波胆分布统计';

-- ----------------------------
-- Table structure for ft_event
-- ----------------------------
DROP TABLE IF EXISTS `ft_event`;
CREATE TABLE `ft_event` (
  `eventid` mediumint(8) unsigned NOT NULL COMMENT '赛事编号',
  `eventname` varchar(20) NOT NULL DEFAULT '' COMMENT '赛事名称',
  `eventtype` tinyint(1) NOT NULL DEFAULT '2' COMMENT '赛事类别(1杯赛；2联赛)',
  `currentseason` char(9) NOT NULL DEFAULT '' COMMENT '当前赛季',
  `countryid` smallint(5) NOT NULL COMMENT '国家编号',
  `countryname` varchar(20) NOT NULL DEFAULT '' COMMENT '国家名称',
  `countrylogo` varchar(100) NOT NULL DEFAULT '' COMMENT '国家logo地址',
  `zoneid` tinyint(3) NOT NULL COMMENT '洲编号',
  `zonename` varchar(20) NOT NULL DEFAULT '' COMMENT '洲名称',
  UNIQUE KEY `idx_uniq` (`eventid`,`currentseason`,`countryid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赛事资料库';

-- ----------------------------
-- Table structure for ft_fgetmiss_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_fgetmiss_stats`;
CREATE TABLE `ft_fgetmiss_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称(冗余)',
  `fgettotal` smallint(5) NOT NULL DEFAULT '0' COMMENT '最先入球 总次数',
  `fgethome` smallint(5) NOT NULL DEFAULT '0' COMMENT '最先入球 主场次数',
  `fgetaway` smallint(5) NOT NULL DEFAULT '0' COMMENT '最先入球 客场次数',
  `fmisstotal` smallint(5) NOT NULL DEFAULT '0' COMMENT '最先失球 总次数',
  `fmisshome` smallint(5) NOT NULL DEFAULT '0' COMMENT '最先失球 主场次数',
  `fmissaway` smallint(5) NOT NULL DEFAULT '0' COMMENT '最先失球 客场次数',
  UNIQUE KEY `idx_uniq` (`competitionid`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='最先入球、失球统计';

-- ----------------------------
-- Table structure for ft_frequentresults_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_frequentresults_stats`;
CREATE TABLE `ft_frequentresults_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `rank` text NOT NULL COMMENT '排名',
  `result` text NOT NULL COMMENT '赛果',
  `no` text NOT NULL COMMENT '场数',
  `percentage` text NOT NULL COMMENT '占总场数的比例(百分比)',
  PRIMARY KEY (`competitionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='最常见赛果统计';

-- ----------------------------
-- Table structure for ft_game
-- ----------------------------
DROP TABLE IF EXISTS `ft_game`;
CREATE TABLE `ft_game` (
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `competitionid` mediumint(8) NOT NULL COMMENT '联赛编号',
  `competitionname` varchar(20) NOT NULL DEFAULT '' COMMENT '联赛名称(冗余)',
  `competitionshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '联赛简称(冗余)',
  `competitioncolor` char(6) NOT NULL COMMENT '联赛颜色(冗余)',
  `hometeamid` mediumint(8) NOT NULL COMMENT '主队编号',
  `homename` varchar(20) NOT NULL DEFAULT '' COMMENT '主队名称(冗余)',
  `homeshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '主队简称(冗余)',
  `homerank` varchar(20) NOT NULL DEFAULT '' COMMENT '主队排名',
  `homephoto` varchar(100) NOT NULL DEFAULT '' COMMENT '主队图标(冗余)',
  `awayteamid` mediumint(8) NOT NULL COMMENT '客队编号',
  `awayname` varchar(20) NOT NULL DEFAULT '' COMMENT '客队名称(冗余)',
  `awayshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '客队简称(冗余)',
  `awayrank` varchar(20) NOT NULL DEFAULT '' COMMENT '客队排名',
  `awayphoto` varchar(100) NOT NULL DEFAULT '' COMMENT '客队图标(冗余)',
  `date` int(10) NOT NULL COMMENT '比赛时间',
  `neutral` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为中立场(1是；0否)',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '"比赛状态值(0未开始；1上；2中；3下；4完；5断；\n6取；7加；8加；9加；10完；11点；12全；13延；\n14斩；15待；16金；17未开始)"',
  `homescore` tinyint(2) NOT NULL DEFAULT '0' COMMENT '主队得分',
  `awayscore` tinyint(2) NOT NULL DEFAULT '0' COMMENT '客队得分',
  `homeredcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '主队红牌',
  `awayredcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '客队红牌',
  `homeyellowcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '主队黄牌',
  `awayyellowcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '客队黄牌',
  `half` char(5) NOT NULL DEFAULT '' COMMENT '半场比分',
  `handicap` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '让球',
  `channel` varchar(255) NOT NULL DEFAULT '' COMMENT '直播频道',
  `weather` varchar(20) NOT NULL DEFAULT '' COMMENT '天气',
  `stadium` varchar(20) NOT NULL DEFAULT '' COMMENT '比赛场地',
  `localtime` char(5) NOT NULL DEFAULT '' COMMENT '当地时间',
  `referee` varchar(20) NOT NULL DEFAULT '' COMMENT '裁判',
  `capacity` varchar(10) NOT NULL DEFAULT '' COMMENT '球馆容量',
  `spectator` varchar(10) NOT NULL DEFAULT '' COMMENT '现场观众',
  `note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注信息',
  `stats` text NOT NULL COMMENT '比赛统计数据(json数据)\r\n\r\nstats:分flag数组对象和data数组对象\r\n\r\nflag数组共9位，每一位有三种标识值，1标识主队，2标识客队，0标识未知\r\n第1位 哪队先开球；第2位 首个角球；第3位 末个角球；第4位 首张黄牌；\r\n第5位 末张黄牌；第6位 首个换人；第7位 末个换人；第8位 首个越位；\r\n第9位 末个越位；\r\n\r\ndata数组共18位，\r\n第1位 主队射门次数；第2位 客队射门次数；第3位 主队犯规次数；\r\n第4位 客队犯规次数；第5位 主队角球次数；第6位 客队角球次数；\r\n第7位 主队任意球次数；第8位 客队任意球次数；第9位 主队黄牌数；\r\n第10位 客队黄牌数；第11位 主队越位次数；第12位 客队越位次数；\r\n第13位 主队换人次数；第14位 客队换人次数；第15位 主队救球次数；\r\n第16位 客队救球次数；第17位 主队控球率；第18位 客队控球率； \r\n',
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='比赛';

-- ----------------------------
-- Table structure for ft_game_forecast
-- ----------------------------
DROP TABLE IF EXISTS `ft_game_forecast`;
CREATE TABLE `ft_game_forecast` (
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `homerecenttendency` char(11) NOT NULL DEFAULT '' COMMENT '主队近况走势(W胜；D平；L负)',
  `awayrecenttendency` char(11) NOT NULL DEFAULT '' COMMENT '客队近况走势',
  `homeoddswinlose` char(11) NOT NULL DEFAULT '' COMMENT '主队盘路输赢',
  `awayoddswinlose` char(11) NOT NULL DEFAULT '' COMMENT '客队盘路输赢',
  `confidence` varchar(20) NOT NULL DEFAULT '' COMMENT '信心指数',
  `resultsofthematch` varchar(10) NOT NULL DEFAULT '' COMMENT '主队对赛成绩，胜场数、平场数、负场数',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '预测内容',
  `homeplayers` text NOT NULL COMMENT '主队阵容(json数据)\r\n\r\nplayerid	球员编号\r\nname	球员名称\r\nshirtno	球衣号码\r\npos	场上位置(0守门员；1后卫；2中场；3前锋)\r\nstatus	"状态(0后备球员；1停赛球员；2伤病球员；\n3首发球员；4其它原因缺阵球员)"\r\n',
  `awayplayers` text NOT NULL COMMENT '客队阵容(json数据)\r\n\r\nplayerid	球员编号\r\nname	球员名称\r\nshirtno	球衣号码\r\npos	场上位置(0守门员；1后卫；2中场；3前锋)\r\nstatus	"状态(0后备球员；1停赛球员；2伤病球员；\n3首发球员；4其它原因缺阵球员)"\r\n',
  `hformation` varchar(10) NOT NULL DEFAULT '' COMMENT '主队阵型',
  `aformation` varchar(10) NOT NULL DEFAULT '' COMMENT '客队阵型',
  `forecast` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否正式阵容(1是;0否)',
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='比赛预测';

-- ----------------------------
-- Table structure for ft_game_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_game_stats`;
CREATE TABLE `ft_game_stats` (
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `meeting` text NOT NULL COMMENT '交锋往绩json数据\r\n\r\nmeeting数组:\r\nid(编号数组，共4位，第1位比赛编号，第2位联赛编号，第3位主队编号，第4位客队编号)\r\ndate(比赛时间)\r\nscore(比分数组，共2位，第1位主队比分，第2位客队比分)\r\nredcard(红牌数组，共2位，第1位主队红牌，第2位客队红牌)\r\nhalf(半场比分)\r\nn(是否为中立场)\r\nhandicap(让球)',
  `teamhistory` text NOT NULL COMMENT '双方球队近两年战绩数据，home主队，away客队\r\n\r\nhome/away数组:\r\nid(编号数组，共4位，第1位比赛编号，第2位联赛编号，第3位主队编号，第4位客队编号)\r\ndate(比赛时间)\r\nscore(比分数组，共2位，第1位主队比分，第2位客队比分)\r\nredcard(红牌数组，共2位，第1位主队红牌，第2位客队红牌)\r\nhalf(半场比分)\r\nn(是否为中立场)\r\nhandicap(让球)\r\n',
  `teamstats` text NOT NULL COMMENT '双方球队历史战绩统计数据，home主队，away客队\r\n\r\nhome/away数组:\r\ntotalgoal:双方总入球数、单双统计数组，共6位\r\n第1位，0-1球场数\r\n第2位，2-3球场数\r\n第3位，4-6球场数\r\n第4位，7球或以上场数\r\n第5位，单数\r\n第6位，双数\r\n\r\ngoal:进球统计json数据，分为total(总)，home(主队)，away(客队)，neutral(中立场)4个数组，每个数组共9位\r\n第1位，净胜2+场数\r\n第2位，净胜1场数\r\n第3位，平局场数\r\n第4位，净负1场数\r\n第5位，净负2+场数\r\n第6位，进球数0场数\r\n第7位，进球数1场数\r\n第8位，进球数2场数\r\n第9位，进球数3+场数\r\n\r\nodds:以往盘路json数据，分为total(总)，home(主队)，away(客队)，neutral(中立场)4个数组，每个数组共9位\r\n第1位：上盘赢场数\r\n第2位：上盘走场数\r\n第3位：上盘输场数\r\n第4位：下盘赢场数\r\n第5位：下盘走场数\r\n第6位：下盘输场数\r\n第7位：平盘赢场数\r\n第8位：平盘走场数\r\n第9位：平盘输场数\r\n',
  `standings` text NOT NULL COMMENT '双方球队排名统计数据，home主队，away客队\r\n\r\nstandings数组:\r\ncompetition:所属联赛\r\n\r\ntotal:总排名统计数据数组，共10位\r\n第1位：比赛场数\r\n第2位：胜场数\r\n第3位：平场数\r\n第4位：负场数\r\n第5位：总进球\r\n第6位：总失球\r\n第7位：净胜球\r\n第8位：积分\r\n第9位：排名\r\n第10位：胜率\r\n\r\nhome:主场排名统计数据数组，共10位\r\n第1位：比赛场数\r\n第2位：胜场数\r\n第3位：平场数\r\n第4位：负场数\r\n第5位：总进球\r\n第6位：总失球\r\n第7位：净胜球\r\n第8位：积分\r\n第9位：排名\r\n第10位：胜率\r\n\r\naway:客场排名统计数据数组，共10位\r\n第1位：比赛场数\r\n第2位：胜场数\r\n第3位：平场数\r\n第4位：负场数\r\n第5位：总进球\r\n第6位：总失球\r\n第7位：净胜球\r\n第8位：积分\r\n第9位：排名\r\n第10位：胜率\r\n\r\nlast6game:最近6场排名统计数据数组，共10位\r\n第1位：比赛场数\r\n第2位：胜场数\r\n第3位：平场数\r\n第4位：负场数\r\n第5位：总进球\r\n第6位：总失球\r\n第7位：净胜球\r\n第8位：积分\r\n第9位：排名\r\n第10位：胜率',
  `teamfixture` text NOT NULL COMMENT '双方球队未来赛程数据，home主队，away客队\r\n\r\nhome/away数组:\r\n\r\nid:编号数组，共4位\r\n第1位比赛编号\r\n第2位联赛编号\r\n第3位主队编号\r\n第4位客队编号\r\n\r\ndate:比赛时间\r\n\r\nn:是否为中立场(1是；0否)\r\n',
  `competition` text NOT NULL COMMENT '联赛json数组\r\n\r\ncompetition数组:\r\nkey:联赛编号\r\nname:联赛名称\r\nshortname:联赛简称\r\ncolor:联赛颜色',
  `team` text NOT NULL COMMENT '球队json数组\r\n\r\nteam数组:\r\nkey:球队编号\r\nname:球队名称\r\nshortname:球队简称\r\n',
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='比赛往绩';

-- ----------------------------
-- Table structure for ft_getmiss_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_getmiss_stats`;
CREATE TABLE `ft_getmiss_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `type1` char(5) NOT NULL DEFAULT '' COMMENT '统计类别1\r\n\r\nget进攻统计数据\r\nmiss防守统计数据',
  `type2` char(5) NOT NULL DEFAULT '' COMMENT '统计类别2\r\n\r\ntotal总场数\r\nhome主队场数\r\naway客队场数\r\n',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称(冗余)',
  `total` smallint(5) NOT NULL DEFAULT '0' COMMENT '场次',
  `goal` smallint(5) NOT NULL DEFAULT '0' COMMENT '进球数(失球数)',
  UNIQUE KEY `idx_uniq` (`competitionid`,`type1`,`type2`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='攻守统计';

-- ----------------------------
-- Table structure for ft_goaltime_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_goaltime_stats`;
CREATE TABLE `ft_goaltime_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `type` char(5) NOT NULL DEFAULT '' COMMENT '统计类别\r\n\r\ntotal总场数\r\nhome主场\r\naway客场',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称(冗余)',
  `minute1_10` smallint(5) NOT NULL DEFAULT '0' COMMENT '第1分钟至第10分钟入球次数',
  `minute11_20` smallint(5) NOT NULL DEFAULT '0' COMMENT '第11分钟至第20分钟入球次数',
  `minute21_30` smallint(5) NOT NULL DEFAULT '0' COMMENT '第21分钟至第30分钟入球次数',
  `minute31_40` smallint(5) NOT NULL DEFAULT '0' COMMENT '第31分钟至第40分钟入球次数',
  `minute41_45` smallint(5) NOT NULL DEFAULT '0' COMMENT '第41分钟至第45分钟入球次数',
  `minute46_55` smallint(5) NOT NULL DEFAULT '0' COMMENT '第46分钟至第55分钟入球次数',
  `minute56_65` smallint(5) NOT NULL DEFAULT '0' COMMENT '第56分钟至第65分钟入球次数',
  `minute66_75` smallint(5) NOT NULL DEFAULT '0' COMMENT '第66分钟至第75分钟入球次数',
  `minute76_85` smallint(5) NOT NULL DEFAULT '0' COMMENT '第76分钟至第85分钟入球次数',
  `minute86_90` smallint(5) NOT NULL DEFAULT '0' COMMENT '第86分钟至第90分钟入球次数',
  UNIQUE KEY `idx_uniq` (`competitionid`,`type`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='进球时间分布统计';

-- ----------------------------
-- Table structure for ft_halffull_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_halffull_stats`;
CREATE TABLE `ft_halffull_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `type` char(5) NOT NULL DEFAULT '' COMMENT '统计类别\r\n\r\ntotal总场数统计数据\r\nhome主场统计数据\r\naway客场统计数据',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称(冗余)',
  `hwinfwin` smallint(5) NOT NULL DEFAULT '0' COMMENT '半场胜，全场胜次数',
  `hwinfdraw` smallint(5) NOT NULL DEFAULT '0' COMMENT '半场胜，全场和次数',
  `hwinflose` smallint(5) NOT NULL DEFAULT '0' COMMENT '半场胜，全场负次数',
  `hdrawfwin` smallint(5) NOT NULL DEFAULT '0' COMMENT '半场和，全场胜次数',
  `hdrawfdraw` smallint(5) NOT NULL DEFAULT '0' COMMENT '半场和，全场和次数',
  `hdrawflose` smallint(5) NOT NULL DEFAULT '0' COMMENT '半场和，全场负次数',
  `hlosefwin` smallint(5) NOT NULL DEFAULT '0' COMMENT '半场负，全场胜次数',
  `hlosefdraw` smallint(5) NOT NULL DEFAULT '0' COMMENT '半场负，全场和次数',
  `hloseflose` smallint(5) NOT NULL DEFAULT '0' COMMENT '半场负，全场负次数',
  UNIQUE KEY `idx_uniq` (`competitionid`,`type`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='半全场统计';

-- ----------------------------
-- Table structure for ft_hsscores_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_hsscores_stats`;
CREATE TABLE `ft_hsscores_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `type` char(5) NOT NULL COMMENT '统计类别\r\n\r\ntotal总场数统计数据\r\nhome主场统计数据\r\naway客场统计数据',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL COMMENT '球队简称(冗余)',
  `upmore` smallint(5) NOT NULL DEFAULT '0' COMMENT '上半场入球较多次数',
  `updownsame` smallint(5) NOT NULL DEFAULT '0' COMMENT '上下半场入球相同次数',
  `downmore` smallint(5) NOT NULL DEFAULT '0' COMMENT '下半场入球较多次数',
  UNIQUE KEY `idx_uniq` (`competitionid`,`type`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上/下半场入球较多统计';

-- ----------------------------
-- Table structure for ft_live_game
-- ----------------------------
DROP TABLE IF EXISTS `ft_live_game`;
CREATE TABLE `ft_live_game` (
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `competitionid` mediumint(8) NOT NULL COMMENT '联赛编号',
  `competitionname` varchar(20) NOT NULL DEFAULT '' COMMENT '联赛名称(冗余)',
  `competitionshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '联赛简称(冗余)',
  `competitioncolor` char(6) NOT NULL COMMENT '联赛颜色(冗余)',
  `hometeamid` mediumint(8) NOT NULL COMMENT '主队编号',
  `homename` varchar(20) NOT NULL DEFAULT '' COMMENT '主队名称(冗余)',
  `homeshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '主队简称(冗余)',
  `awayteamid` mediumint(8) NOT NULL COMMENT '客队编号',
  `awayname` varchar(20) NOT NULL DEFAULT '' COMMENT '客队名称(冗余)',
  `awayshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '客队简称(冗余)',
  `date` int(10) NOT NULL COMMENT '比赛时间',
  `neutral` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为中立场(1是；0否)',
  `homerank` varchar(20) NOT NULL COMMENT '主队排名',
  `awayrank` varchar(20) NOT NULL COMMENT '客队排名',
  `weather` varchar(20) NOT NULL DEFAULT '' COMMENT '天气信息',
  `adddate` char(10) NOT NULL DEFAULT '' COMMENT '添加日期',
  PRIMARY KEY (`gameid`),
  KEY `idx_date` (`date`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='即时比分';

-- ----------------------------
-- Table structure for ft_live_game_data
-- ----------------------------
DROP TABLE IF EXISTS `ft_live_game_data`;
CREATE TABLE `ft_live_game_data` (
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `tstarttime` int(10) NOT NULL COMMENT '比赛实际开始时间',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '"比赛状态值(0未开始；1上；2中；3下；4完；5断；\n6取；7加；8加；9加；10完；11点；12全；13延；\n14斩；15待；16金；17未开始)"',
  `homescore` tinyint(2) NOT NULL DEFAULT '0' COMMENT '主队得分',
  `awayscore` tinyint(2) NOT NULL DEFAULT '0' COMMENT '客队得分',
  `homeredcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '主队红牌',
  `awayredcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '客队红牌',
  `homeyellowcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '主队黄牌',
  `awayyellowcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '客队黄牌',
  `half` char(5) NOT NULL DEFAULT '' COMMENT '半场比分',
  `note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注信息',
  `stats` text NOT NULL COMMENT '比赛统计数据(json数据)\r\n\r\nstats:分flag数组对象和data数组对象\r\n\r\nflag数组共9位，每一位有三种标识值，1标识主队，2标识客队，0标识未知\r\n第1位 哪队先开球；第2位 首个角球；第3位 末个角球；第4位 首张黄牌；\r\n第5位 末张黄牌；第6位 首个换人；第7位 末个换人；第8位 首个越位；\r\n第9位 末个越位；\r\n\r\ndata数组共18位，\r\n第1位 主队射门次数；第2位 客队射门次数；第3位 主队犯规次数；\r\n第4位 客队犯规次数；第5位 主队角球次数；第6位 客队角球次数；\r\n第7位 主队任意球次数；第8位 客队任意球次数；第9位 主队黄牌数；\r\n第10位 客队黄牌数；第11位 主队越位次数；第12位 客队越位次数；\r\n第13位 主队换人次数；第14位 客队换人次数；第15位 主队救球次数；\r\n第16位 客队救球次数；第17位 主队控球率；第18位 客队控球率； ',
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='即时比分数据\r\n';

-- ----------------------------
-- Table structure for ft_live_game_goal_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_live_game_goal_stats`;
CREATE TABLE `ft_live_game_goal_stats` (
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `goal` text NOT NULL COMMENT '进球情况json数据\r\n\r\n进球情况json数据:\r\nminute:时间发生时的比赛时间(第XX分钟)\r\ntype:类型(1主队；2客队)\r\nevent:时间编号(0-5)\r\nename:事件名称(0进球；1点球；2乌龙球；3黄牌；4红牌；5两黄变一红)\r\nscore:事件发生后的比分\r\npid:相关球员编号\r\npname:相关球员名称\r\npsname相关球员简称',
  `stat` text NOT NULL COMMENT '数据统计json数据\r\n\r\n数据统计json数据:\r\nname:统计项名称(开球,首个角球,首个换人,首个越位,首张黄牌,首个界外球,首个任意球,首个球门球,射门次数,射正球门次数,犯规次数,角球次数,角球次数(加时),\r\n任意球次数,越位次数,乌龙球,黄牌数,黄牌数(加时),红牌数,控球率,头球,救球,守门员出击,丢球,成功抢断,阻截,长传,短传,助攻,成功传中,换人数,\r\n换人数(加时),越位次数(加时),红牌数(加时),最后角球,最后换人,最后越位,最后黄牌,最后界外球,最后任意球,最后球门球)\r\nhome:主队数值\r\naway:客队数值',
  `substitutes` text NOT NULL COMMENT '球员替换json数据\r\n\r\n球员替换json数据:\r\nminute:换人发生时的比赛时间(第xx分钟)\r\ntype:类型(1主队；2客队)\r\nupid:上场球员编号\r\nupname:上场球员名称\r\ndownid:下场球员编号\r\ndownname:下场球员名称\r\n',
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='进球名单';

-- ----------------------------
-- Table structure for ft_oddeven_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_oddeven_stats`;
CREATE TABLE `ft_oddeven_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称(冗余)',
  `goal0_1` smallint(5) NOT NULL DEFAULT '0' COMMENT '全场入球总数为0-1球的次数',
  `goal2_3` smallint(5) NOT NULL DEFAULT '0' COMMENT '全场入球总数为2-3球的次数',
  `goal4_6` smallint(5) NOT NULL DEFAULT '0' COMMENT '全场入球总数为4-6球的次数',
  `goal7` smallint(5) NOT NULL DEFAULT '0' COMMENT '全场入球总数为7球或以上的次数',
  `goalsingle` smallint(5) NOT NULL DEFAULT '0' COMMENT '全场入球为单的次数',
  `goaldouble` smallint(5) NOT NULL DEFAULT '0' COMMENT '全场入球为双的次数',
  UNIQUE KEY `idx_uniq` (`competitionid`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='入球总数及单双数统计';

-- ----------------------------
-- Table structure for ft_oddsway_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_oddsway_stats`;
CREATE TABLE `ft_oddsway_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `type` char(5) NOT NULL DEFAULT '' COMMENT '盘路统计类别\r\n\r\ntotal总盘路统计；\r\nhome主队盘路统计；\r\naway客队盘路统计',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称',
  `total` smallint(5) NOT NULL DEFAULT '0' COMMENT '总场数',
  `open` smallint(5) NOT NULL DEFAULT '0' COMMENT '开盘数',
  `up` smallint(5) NOT NULL DEFAULT '0' COMMENT '上盘数',
  `win` smallint(5) NOT NULL DEFAULT '0' COMMENT '赢盘数',
  `draw` smallint(5) NOT NULL DEFAULT '0' COMMENT '走水数',
  `lose` smallint(5) NOT NULL DEFAULT '0' COMMENT '输盘数',
  `winlose` smallint(5) NOT NULL DEFAULT '0' COMMENT '净胜盘数',
  `winrate` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '赢盘率',
  UNIQUE KEY `idx_uniq` (`competitionid`,`type`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='盘路统计';

-- ----------------------------
-- Table structure for ft_odds_asia
-- ----------------------------
DROP TABLE IF EXISTS `ft_odds_asia`;
CREATE TABLE `ft_odds_asia` (
  `companyid` mediumint(8) unsigned NOT NULL COMMENT '公司编号',
  `companyname` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `isrun` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否走地盘(1是；0否)',
  `up` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '上盘指数',
  `down` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '下盘指数',
  `give` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '让球指数',
  `fup` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '上盘指数(初盘)',
  `fdown` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '下盘指数(初盘)',
  `fgive` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '让球指数(初盘)',
  `oddsdate` int(10) NOT NULL COMMENT '指数变化的时间戳',
  `date` char(10) NOT NULL DEFAULT '' COMMENT '历史日期',
  UNIQUE KEY `idx_uniq` (`companyid`,`gameid`,`oddsdate`) USING BTREE,
  KEY `idx_gameid` (`gameid`,`companyid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='亚盘指数';

-- ----------------------------
-- Table structure for ft_odds_euro
-- ----------------------------
DROP TABLE IF EXISTS `ft_odds_euro`;
CREATE TABLE `ft_odds_euro` (
  `companyid` mediumint(8) unsigned NOT NULL COMMENT '公司编号',
  `companyname` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `homewin` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '主胜指数',
  `draw` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '和局指数',
  `awaywin` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '客胜指数',
  `homewinrate` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '主胜率指数',
  `drawrate` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '和局率指数',
  `awaywinrate` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '客胜率指数',
  `returnrate` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '返还率指数',
  `fhomewin` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '主胜指数(初盘)',
  `fdraw` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '和局指数(初盘)',
  `fawaywin` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '客胜指数(初盘)',
  `fhomewinrate` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '主胜率指数(初盘)',
  `fdrawrate` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '和局率指数(初盘)',
  `fawaywinrate` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '客胜率指数(初盘)',
  `freturnrate` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '返还率指数(初盘)',
  `oddsdate` int(10) NOT NULL COMMENT '指数变化的时间戳',
  `date` char(10) NOT NULL DEFAULT '' COMMENT '历史日期',
  UNIQUE KEY `idx_uniq` (`companyid`,`gameid`,`oddsdate`) USING BTREE,
  KEY `idx_gameid` (`gameid`,`companyid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='欧盘指数';

-- ----------------------------
-- Table structure for ft_odds_ou
-- ----------------------------
DROP TABLE IF EXISTS `ft_odds_ou`;
CREATE TABLE `ft_odds_ou` (
  `companyid` mediumint(8) unsigned NOT NULL COMMENT '公司编号',
  `companyname` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `isrun` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否走地盘(1是；0否)',
  `big` decimal(5,3) NOT NULL DEFAULT '0.000' COMMENT '大球指数',
  `small` decimal(5,3) NOT NULL DEFAULT '0.000' COMMENT '小球指数',
  `total` decimal(5,3) NOT NULL DEFAULT '0.000' COMMENT '总分指数',
  `fbig` decimal(5,3) NOT NULL DEFAULT '0.000' COMMENT '大球指数(初盘)',
  `fsmall` decimal(5,3) NOT NULL DEFAULT '0.000' COMMENT '小球指数(初盘)',
  `ftotal` decimal(5,3) NOT NULL DEFAULT '0.000' COMMENT '总分指数(初盘)',
  `oddsdate` int(10) NOT NULL COMMENT '指数变化的时间戳',
  `date` char(10) NOT NULL COMMENT '历史日期',
  UNIQUE KEY `idx_uniq` (`companyid`,`gameid`,`oddsdate`) USING BTREE,
  KEY `idx_gameid` (`gameid`,`companyid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='大小球指数';

-- ----------------------------
-- Table structure for ft_overunder_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_overunder_stats`;
CREATE TABLE `ft_overunder_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称(冗余)',
  `total` smallint(5) NOT NULL DEFAULT '0' COMMENT '总场数',
  `goal0_2` smallint(5) NOT NULL DEFAULT '0' COMMENT '全场入球2球或以下的次数',
  `goal3` smallint(5) NOT NULL DEFAULT '0' COMMENT '全场入球3球或以上的次数',
  UNIQUE KEY `idx_uniq` (`competitionid`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上/下盘全场入球统计';

-- ----------------------------
-- Table structure for ft_player
-- ----------------------------
DROP TABLE IF EXISTS `ft_player`;
CREATE TABLE `ft_player` (
  `playerid` mediumint(8) unsigned NOT NULL COMMENT '球员编号',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '球员名称',
  `enname` varchar(50) NOT NULL DEFAULT '' COMMENT '球员英文名称',
  `shortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球员简称',
  `birthday` char(10) NOT NULL DEFAULT '' COMMENT '出生日期',
  `height` char(10) NOT NULL DEFAULT '' COMMENT '身高',
  `weight` char(10) NOT NULL DEFAULT '' COMMENT '体重',
  `nationality` varchar(20) NOT NULL DEFAULT '' COMMENT '国籍',
  `club` varchar(20) NOT NULL DEFAULT '' COMMENT '效力球队',
  `joindate` char(10) NOT NULL DEFAULT '' COMMENT '加盟日期',
  `clubshirtno` tinyint(3) NOT NULL COMMENT '球衣号码',
  `position` varchar(20) NOT NULL DEFAULT '' COMMENT '场上位置',
  `formerclub` varchar(20) NOT NULL DEFAULT '' COMMENT '前度效力球队',
  `onceclub` varchar(255) NOT NULL DEFAULT '' COMMENT '曾经效力球队',
  `profile` text NOT NULL COMMENT '球员简介',
  `honours` text NOT NULL COMMENT '球员荣誉',
  `photo` varchar(100) NOT NULL DEFAULT '' COMMENT '球员头像',
  PRIMARY KEY (`playerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球员';

-- ----------------------------
-- Table structure for ft_player_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_player_stats`;
CREATE TABLE `ft_player_stats` (
  `playerid` mediumint(8) unsigned NOT NULL COMMENT '所属球员编号',
  `teamid` mediumint(8) NOT NULL COMMENT '所属球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '所属球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '所属球队简称(冗余)',
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `competitionid` mediumint(8) NOT NULL COMMENT '联赛编号',
  `competitionname` varchar(20) NOT NULL DEFAULT '' COMMENT '联赛名称(冗余)',
  `competitionshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '联赛简称(冗余)',
  `competitioncolor` char(6) NOT NULL DEFAULT '' COMMENT '联赛颜色(冗余)',
  `hometeamid` mediumint(8) NOT NULL COMMENT '主队编号',
  `homename` varchar(20) NOT NULL DEFAULT '' COMMENT '主队名称(冗余)',
  `homeshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '主队简称(冗余)',
  `awayteamid` mediumint(8) NOT NULL COMMENT '客队编号',
  `awayname` varchar(20) NOT NULL DEFAULT '' COMMENT '客队名称(冗余)',
  `awayshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '客队简称(冗余)',
  `date` int(10) NOT NULL COMMENT '比赛时间',
  `homescore` tinyint(2) NOT NULL DEFAULT '0' COMMENT '主队得分',
  `awayscore` tinyint(2) NOT NULL DEFAULT '0' COMMENT '客队得分',
  `goal` tinyint(2) NOT NULL DEFAULT '0' COMMENT '进球数',
  `goalpenalty` tinyint(2) NOT NULL DEFAULT '0' COMMENT '点球数',
  `goalown` tinyint(2) NOT NULL DEFAULT '0' COMMENT '乌龙球数',
  `yellowcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '黄牌数',
  `redcard` tinyint(2) NOT NULL DEFAULT '0' COMMENT '红牌数',
  UNIQUE KEY `idx_uniq` (`playerid`,`gameid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球员比赛技术统计';

-- ----------------------------
-- Table structure for ft_shooter_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_shooter_stats`;
CREATE TABLE `ft_shooter_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `rank` smallint(5) NOT NULL COMMENT '排名位置',
  `playerid` mediumint(8) unsigned NOT NULL COMMENT '球员编号',
  `playername` varchar(20) NOT NULL DEFAULT '' COMMENT '球员名称',
  `teamid` mediumint(8) NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称',
  `goal` smallint(5) NOT NULL DEFAULT '0' COMMENT '进球数',
  `goalpenalty` smallint(5) NOT NULL DEFAULT '0' COMMENT '点球数',
  UNIQUE KEY `idx_uniq` (`competitionid`,`playerid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='射手榜统计';

-- ----------------------------
-- Table structure for ft_standings_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_standings_stats`;
CREATE TABLE `ft_standings_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `competitionname` varchar(20) NOT NULL DEFAULT '' COMMENT '联赛名称、分区或阶段',
  `type` char(5) NOT NULL COMMENT '积分排名类别\r\n\r\ntotal总积分排名；\r\nhome主队积分排名；\r\naway客队积分排名\r\n',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称',
  `total` smallint(5) NOT NULL DEFAULT '0' COMMENT '总场数',
  `win` smallint(5) NOT NULL DEFAULT '0' COMMENT '胜场数',
  `draw` smallint(5) NOT NULL DEFAULT '0' COMMENT '平场数',
  `lose` smallint(5) NOT NULL DEFAULT '0' COMMENT '负场数',
  `goal` smallint(5) NOT NULL DEFAULT '0' COMMENT '进球数',
  `nongoal` smallint(5) NOT NULL DEFAULT '0' COMMENT '失球数',
  `score` smallint(5) NOT NULL DEFAULT '0' COMMENT '积分',
  `nonscore` smallint(5) NOT NULL DEFAULT '0' COMMENT '扣分',
  `note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  UNIQUE KEY `idx_uniq` (`competitionname`,`type`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分排名统计';

-- ----------------------------
-- Table structure for ft_team
-- ----------------------------
DROP TABLE IF EXISTS `ft_team`;
CREATE TABLE `ft_team` (
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称',
  `shortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称',
  `enname` varchar(50) NOT NULL DEFAULT '' COMMENT '球队英文名称',
  `competitionid` mediumint(8) NOT NULL COMMENT '所属联赛id',
  `establishdate` char(4) NOT NULL DEFAULT '' COMMENT '成立时间',
  `capacity` varchar(10) NOT NULL DEFAULT '' COMMENT '球场容量',
  `website` varchar(50) NOT NULL DEFAULT '' COMMENT '官方地址',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '官方信箱',
  `country` varchar(20) NOT NULL DEFAULT '' COMMENT '国家地区',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '联系地址',
  `city` varchar(20) NOT NULL DEFAULT '' COMMENT '所在城市',
  `stadium` varchar(20) NOT NULL DEFAULT '' COMMENT '球场',
  `profile` text NOT NULL COMMENT '球队简介',
  `best` text NOT NULL COMMENT '球队之最',
  `glory` text NOT NULL COMMENT '球队荣誉',
  `playerageavg` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '球员平均年龄',
  `photo` varchar(100) NOT NULL DEFAULT '' COMMENT '球队图标',
  `playerids` varchar(255) NOT NULL DEFAULT '' COMMENT '球员ids(冗余)',
  `coachids` varchar(255) NOT NULL DEFAULT '' COMMENT '教练ids(冗余)',
  `players` text NOT NULL COMMENT '球员json数据(冗余)',
  `coaches` text NOT NULL COMMENT '教练json数据(冗余)',
  PRIMARY KEY (`teamid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球队';

-- ----------------------------
-- Table structure for ft_teamscores_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_teamscores_stats`;
CREATE TABLE `ft_teamscores_stats` (
  `competitionid` mediumint(8) unsigned NOT NULL COMMENT '联赛编号',
  `type` char(5) NOT NULL DEFAULT '' COMMENT '统计类别\r\n\r\ntotal球队总入球数(总场数)\r\nhome球队总入球数(主场数)\r\naway球队总入球数(客场数)',
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称(冗余)',
  `goal0` smallint(5) NOT NULL DEFAULT '0' COMMENT '没有入球的次数',
  `goal1` smallint(5) NOT NULL DEFAULT '0' COMMENT '入1球的次数',
  `goal2` smallint(5) NOT NULL DEFAULT '0' COMMENT '入2球的次数',
  `goal3` smallint(5) NOT NULL DEFAULT '0' COMMENT '入3球的次数',
  `goal4` smallint(5) NOT NULL DEFAULT '0' COMMENT '入4球的次数',
  `goal5` smallint(5) NOT NULL DEFAULT '0' COMMENT '入5球或以上的次数',
  UNIQUE KEY `idx_uniq` (`competitionid`,`type`,`teamid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球队总入球数统计';

-- ----------------------------
-- Table structure for ft_team_lotteryname
-- ----------------------------
DROP TABLE IF EXISTS `ft_team_lotteryname`;
CREATE TABLE `ft_team_lotteryname` (
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称',
  `lotteryname` varchar(20) NOT NULL DEFAULT '' COMMENT '体彩名称(空表示无体彩名称或与球队名称一致)',
  UNIQUE KEY `idx_uniq` (`teamid`,`lotteryname`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球队对应体彩名称';

-- ----------------------------
-- Table structure for ft_team_stats
-- ----------------------------
DROP TABLE IF EXISTS `ft_team_stats`;
CREATE TABLE `ft_team_stats` (
  `teamid` mediumint(8) unsigned NOT NULL COMMENT '球队编号',
  `teamname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队名称(冗余)',
  `teamshortname` varchar(20) NOT NULL DEFAULT '' COMMENT '球队简称(冗余)',
  `historys` text NOT NULL COMMENT '近两年历史数据json数据',
  `fixtures` text NOT NULL COMMENT '未来赛程json数据',
  `stats` text NOT NULL COMMENT '球队统计json数据',
  PRIMARY KEY (`teamid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='球队近两年赛绩，未来赛程，历史统计';

-- ----------------------------
-- Table structure for ft_wlive_list
-- ----------------------------
DROP TABLE IF EXISTS `ft_wlive_list`;
CREATE TABLE `ft_wlive_list` (
  `gameid` int(10) unsigned NOT NULL COMMENT '比赛编号',
  `islive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有文字直播(1是，0否)',
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文字直播列表';
