<?php
//球员技术统计（按赛季）

require_once 'global.func.php';
require_once 'conn.php';

//从球员技术统计表中获取所有记录，得分、篮板、助攻、抢断、盖帽超10的总和作为计算‘得几双’的判断条件，即tag字段，firstjoin_tag用于统计首发次数
$source_sql = 'SELECT IF(a.score>=10,1,0) + IF(a.attack>=10,1,0) + IF(a.helpattack>=10,1,0) + IF(a.cover>=10,1,0) + IF(a.rob>=10,1,0) AS tag,
                      a.*,
                      b.sclassseason AS season,
					  IF(a.firstjoin<>"0",1,0) AS firstjoin_tag
               FROM bt_player_technic a LEFT JOIN bt_schedule b on a.scheduleid=b.scheduleid';

//从上个查询中统计出需要的字段
$sql = 'REPLACE INTO `bt_player_technic_stats` SELECT playerid,
			   season,
			   teamid,
			   COUNT(firstjoin) AS jointime,
			   SUM(firstjoin_tag) AS firstjoin,
			   SUM(playtime) AS playtime,
               SUM(shoot) AS shoot,
               SUM(shoot_hit) AS shoot_hit,
               SUM(threemin) AS threemin,
               SUM(threemin_hit) AS threemin_hit,
               SUM(punishball) AS punishball,
               SUM(punishball_hit) AS punishball_hit,
               SUM(attack) AS attack,
               SUM(defend) AS defend,
               SUM(helpattack) AS helpattack,
               SUM(rob) AS rob,
               SUM(cover) AS cover,
               SUM(misplay) AS misplay,
               SUM(foul) AS foul,
               SUM(score) AS score,
               SUM(IF(tag=2,1,0)) AS double_2,
               SUM(IF(tag=3,1,0)) AS double_3,
               SUM(IF(tag=4,1,0)) AS double_4
         FROM (' . $source_sql . ') AS tmp  GROUP BY playerid,season;';

$mysqli->query($sql);
$mysqli->close();

