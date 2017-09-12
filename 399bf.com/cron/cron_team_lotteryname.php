<?php
//球队对应体彩名称

require_once 'global.func.php';
require_once 'conn.php';

// 通过接口获取数据
$type = 'type=getteam_lotteryname&teamid=0';
$return = http_get(proxy_url().$type);

// 确认返回数据格式
if (is_array($return) && !empty($return) && !isset($return['error']))
{
    // 从7m接口获取数据并写入本地数据库
    $sql = "REPLACE INTO `ft_team_lotteryname` VALUES(?,?,?);";
    if ($stmt = $mysqli->prepare($sql))
    {
        foreach ($return['Team'] as $teamid => $info) {
            $stmt->bind_param('iss',
                $teamid,                  //球队编号
                $info[0],                //球队名称
                $info[1]                //体彩名称(空表示无体彩名称或与球队名称一致)
            );

            $stmt->execute();
        }

        $stmt->close();
    }
    else
    {
        cron_log('初始化语句对象失败。', 2);
    }
    cron_log('IP:' . IP . ' ' . $type . ' 请求接口数据成功');
} elseif (isset($return['error'])) {
    cron_log('IP:' . IP . ' ' . $type . ' ' . $return['error'], 1);
} elseif (empty($return)) {
    cron_log('IP:' . IP . ' ' . $type . ' 空值' . json_encode($return), 1);
} else {
    cron_log('IP:' . IP . ' ' . $type . ' 网络错误', 1);
}

// 关闭mysql连接
$mysqli->close();
