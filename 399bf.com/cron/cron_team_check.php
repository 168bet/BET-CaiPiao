<?php
//即时添加球队信息定时任务
//球队id通过即时比分获取
//解决即时比分经常没有球队信息的问题

require_once 'global.func.php';
require_once 'conn.php';

//根据即时比分表获取球队编号
$starttime = SYS_TIME;
$endtime = SYS_TIME + 10*60;
$team_sql = "SELECT
                `competitionid`,
                `hometeamid` AS `teamid`
            FROM `ft_live_game`
            WHERE `date` > '$starttime' AND `date` < '$endtime'
            UNION
            SELECT
                `competitionid`,
                `awayteamid` AS `teamid`
            FROM `ft_live_game`
            WHERE `date` > '$starttime' AND `date` < '$endtime'";
$rst = $mysqli->query($team_sql);
$teams = $rst->fetch_all(MYSQLI_ASSOC);
$teamids = array_column($teams, 'teamid');
$rst = $mysqli->query("SELECT `teamid` FROM `ft_team`");
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

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_team` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    foreach ($teams as $team)
    {
        //通过接口获取数据
        $type = 'type=getteaminfo&p1=' . $team['teamid'];
        $return = http_get(proxy_url() . $type);

        //确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error']))
        {
            $info = $return['TeamInfo'];
            $players = $return['Players'];
            $coach = $return['coach'];
            $coachids = '';
            $temp = array();
            foreach ($players as $player) {
                $temp['playerids'][] = $player['Id'];
            }
            $playerids = join(',', $temp['playerids']);
            $short_name = '';
            $json['players'] = jsonEncode($players);
            $json['coach'] = jsonEncode($coach);
            $player_age_avg = $info['PlayerAgeAvg'];
            $stmt->bind_param(
                'isssisssssssssssssssss',
                $info['Id'],            //球队编号
                $info['Name'],          //球队名称
                $short_name,            //球队简称，接口数据暂无
                $info['EnName'],        //球队英文名
                $team['competitionid'], //所属联赛id
                $info['EstablishDate'], //成立时间
                $info['Capacity'],      //球场容量
                $info['website'],       //官方地址
                $info['Email'],         //官方邮箱
                $info['Country'],       //国家地区
                $info['Address'],       //地址
                $info['City'],          //所在城市
                $info['Stadium'],       //球场
                $info['Profile'],       //球队简介
                $info['Best'],          //球队之最
                $info['Glory'],         //球队荣誉
                $player_age_avg,        //球员平均年龄
                $info['Photo'],         //球队图标
                $playerids,             //球员id字符串
                $coachids,              //教练id
                $json['players'],       //球员信息json数组
                $json['coach']          //教练信息json数组
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
} else {
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
