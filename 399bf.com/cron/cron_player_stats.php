<?php
// 球员比赛技术统计定时任务

require_once 'global.func.php';
require_once 'conn.php';

//球员id
$player_sql = 'SELECT `playerid` FROM `ft_player`;';
$player_info = $mysqli->query($player_sql);
$playerids = array();
while ($row = mysqli_fetch_array($player_info)) {
    $playerids[] = $row['playerid'];
}

// 从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_player_stats` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql)) {
    foreach ($playerids as $playerid) {
        // 通过接口获取数据
        $type = 'type=getplayerstats&p1=' . $playerid;
        $return = http_get(proxy_url().$type);

        // 确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error'])) {
            $competition = $return['Competition'];
            $team = $return['Team'];
            foreach ($return['Stats'] as $stats) {
                $date = floor($stats['Date'] / 1000);
                $stmt->bind_param(
                    'iissiisssississiiiiiiii',
                    $playerid,                                      //球员编号
                    $stats['Team'],                                 //球队编号
                    $team[$stats['Team']]['Name'],                  //球队名称
                    $team[$stats['Team']]['ShortName'],             //球队简称
                    $stats['Id'][0],                                //比赛编号
                    $stats['Id'][1],                                //联赛编号
                    $competition[$stats['Id']['1']]['Name'],        //联赛名称
                    $competition[$stats['Id']['1']]['ShortName'],   //联赛简称
                    $competition[$stats['Id']['1']]['Color'],       //联赛颜色
                    $stats['Id'][2],                                //主队编号
                    $team[$stats['Id'][2]]['Name'],                 //主队名称
                    $team[$stats['Id'][2]]['ShortName'],            //主队简称
                    $stats['Id'][3],                                //客队编号
                    $team[$stats['Id'][3]]['Name'],                 //客队名称
                    $team[$stats['Id'][3]]['ShortName'],            //客队简称
                    $date,                                          //日期
                    $stats['Score'][0],                             //主队得分
                    $stats['Score'][1],                             //客队得分
                    $stats['Data'][0],                              //进球数
                    $stats['Data'][1],                              //点球数
                    $stats['Data'][2],                              //乌龙球数
                    $stats['Data'][3],                              //黄牌数
                    $stats['Data'][4]                               //红牌数
                );

                $stmt->execute();
            }
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
