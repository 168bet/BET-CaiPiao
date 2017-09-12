<?php
// 入球总数及单双数统计定时任务

require_once 'global.func.php';
require_once 'conn.php';

// 联赛编号数组
$competition_sql = 'SELECT `competitionid` FROM `ft_competition`;';
$competition_info = $mysqli->query($competition_sql);
$competitionids = array();
while ($row = mysqli_fetch_array($competition_info)) {
    $competitionids[] = $row['competitionid'];
}

// 从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_oddeven_stats` VALUES(?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql)) {
    foreach ($competitionids as $competitionid) {
        // 通过接口获取数据
        $type = 'type=getcompetitionoddeven&p1=' . $competitionid;
        $return = http_get(proxy_url().$type);

        // 确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error'])) {
            $team = $return['Team'];
            foreach ($return['Stats'] as $stats) {
                $stmt->bind_param(
                    'iissiiiiii',
                    $competitionid,                         //联赛编号
                    $stats['TeamId'],                       //球队编号
                    $team[$stats['TeamId']]['Name'],        //球队名称
                    $team[$stats['TeamId']]['ShortName'],   //球队简称
                    $stats['Data'][0],                      //全场入球总数为0-1球的次数
                    $stats['Data'][1],                      //全场入球总数为2-3球的次数
                    $stats['Data'][2],                      //全场入球总数为4-6球的次数
                    $stats['Data'][3],                      //全场入球总数为7球或以上的次数
                    $stats['Data'][4],                      //全场入球为单的次数
                    $stats['Data'][5]                       //全场入球为双的次数
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
