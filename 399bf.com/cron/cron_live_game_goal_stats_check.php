<?php
//进球名单
//数据校对脚本

require_once 'global.func.php';
require_once 'conn.php';

//获取校对记录
$sql = "SELECT
          gameid
        FROM ft_live_game_goal_stats
        WHERE `goal` = '' OR `goal` IS NULL";
$rst = $mysqli->query($sql);
$gameids = array_column($rst->fetch_all(MYSQLI_ASSOC), 'gameid');
if(!empty($gameids))
{
    $sql = "REPLACE INTO `ft_live_game_goal_stats` VALUES(?,?,?,?);";
    if ($stmt = $mysqli->prepare($sql))
    {
        foreach ($gameids as $gameid)
        {
            //通过接口获取数据
            $type = 'type=getgamegoaldata&p1=' . $gameid;
            $return = http_get(proxy_url() . $type);

            //确认返回数据格式
            if (is_array($return) && !empty($return) && !isset($return['error'])) {
                $default = '';
                $stmt->bind_param('isss',
                    $gameid,                                                // 比赛编号
                    !empty($return['Goal']) ?
                        jsonEncode($return['Goal']) : $default,             // 进球情况json数据
                    !empty($return['Stat']) ?
                        jsonEncode($return['Stat']) : $default,             // 数据统计json数据
                    !empty($return['Substitutes']) ?
                        jsonEncode($return['Substitutes']) : $default       // 球员替换json数据
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
    cron_log('ft_live_game_goal_stats表请求失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
