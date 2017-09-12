<?php
//即时添加球队近两年赛绩，未来赛程，历史统计
//球队id通过即时比分获取
//解决即时比分经常没有球队近两年赛绩，未来赛程，历史统计

require_once 'global.func.php';
require_once 'conn.php';

//根据即时比分表获取球队编号
$starttime = SYS_TIME;
$endtime = SYS_TIME + 10*60;
$team_sql = "SELECT
                `hometeamid` AS `teamid`,
                `homename` AS `name`,
                `homeshortname` AS `shortname`
            FROM `ft_live_game`
            WHERE `date` > '$starttime' AND `date` < '$endtime'
            UNION
            SELECT
                `awayteamid` AS `teamid`,
                `awayname` AS `name`,
                `awayshortname` AS `shortname`
            FROM `ft_live_game`
            WHERE `date` > '$starttime' AND `date` < '$endtime'";
$rst = $mysqli->query($team_sql);
$teams = $rst->fetch_all(MYSQLI_ASSOC);
$teamids = array_column($teams, 'teamid');
$rst = $mysqli->query("SELECT `teamid` FROM `ft_team_stats`");
$old_teamids = array_column($rst->fetch_all(MYSQLI_ASSOC), 'teamid');
$new_teamids = array_diff($teamids, $old_teamids);
//获取新增球队
foreach($teams as $key => $team){
    if(!in_array($team['teamid'], $new_teamids)){
        unset($teams[$key]);
    }
}
//释放内存
unset($teamids);
unset($old_teamids);
unset($new_teamids);

if($teams != false)
{
    $sql = "REPLACE INTO `ft_team_stats` VALUES(?,?,?,?,?,?);";
    if ($stmt = $mysqli->prepare($sql))
    {
        foreach ($teams as $team)
        {
            //通过接口获取数据
            $type = 'type=getteamstats&p1=' . $team['teamid'];
            $return = http_get(proxy_url() . $type);
            $default = '';

            if (is_array($return) && !empty($return) && !isset($return['error'])) {
                $stmt->bind_param('isssss',
                    $team['teamid'],                        //球队编号
                    $team['name'],                          //球队名称(冗余)
                    $team['shortname'],                     //球队简称(冗余)
                    !empty($return['Historys']) ? jsonEncode($return['Historys']) : $default,        //近两年历史数据json数据
                    !empty($return['Fixtures']) ? jsonEncode($return['Fixtures']) : $default, //未来赛程json数据
                    !empty($return['Stats']) ? jsonEncode($return['Stats']) : $default            //球队统计json数据
                );

                $stmt->execute();
                cron_log('IP:' . IP . ' ' . $type . ' 请求接口数据成功');
            } elseif (isset($return['error'])) {
                cron_log('IP:' . IP . ' ' . $type . ' ' . $return['error'], 1);
            } elseif (empty($return)) {
                cron_log('IP:' . IP . ' ' . $type . ' 空值' . json_encode($return), 1);
            } else {
                cron_log('IP:' . IP . ' ' . $type . ' 网络错误', 1);
            }

            unset($return);
        }

        $stmt->close();
    }
    else
    {
        cron_log('初始化语句对象失败。', 2);
    }

}
else
{
    cron_log('ft_live_game表请求失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
