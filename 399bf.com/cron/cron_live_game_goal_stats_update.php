<?php
//进球名单
//手动校对数据

require_once 'global.func.php';
require_once 'conn.php';

//获取校对记录
fwrite(STDOUT, 'Please enter game ids. (e.g 1381621|1381621,1381622)' . "\n");
$gameids = trim(fgets(STDIN));
while (!preg_match('/^\d[\d,]*\d$/', $gameids)) {
    fwrite(STDOUT, 'Please enter game ids again.' . "\n");
    $gameids = trim(fgets(STDIN));
}
$gameids = explode(',', $gameids);

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

// 关闭mysql连接
$mysqli->close();
