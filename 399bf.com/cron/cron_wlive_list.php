<?php
//文字直播列表

require_once 'global.func.php';
require_once 'conn.php';

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_wlive_list` VALUES(?,?);";
if ($stmt = $mysqli->prepare($sql)) {
    //通过接口获取数据
    $type = 'type=getwlivedatelistId';
    $return = http_get(proxy_url().$type);

    //确认返回数据格式正确
    if (is_array($return) && !empty($return) && !isset($return['error'])) {
        foreach ($return['wliveMatchsID'] as $gameid => $islive) {
            $stmt->bind_param(
                'ii',
                $gameid,                                     //比赛编号
                $islive                                      //是否有文字直播
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
    $stmt->close();
} else {
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
