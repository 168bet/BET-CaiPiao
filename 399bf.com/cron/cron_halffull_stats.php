<?php
// 半全场统计定时任务

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
$sql = "REPLACE INTO `ft_halffull_stats` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql)) {
    foreach ($competitionids as $competitionid) {
        // 通过接口获取数据
        $method = 'type=getcompetitionhfstat&p1=' . $competitionid;
        $return = http_get(proxy_url().$method);

        // 确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error'])) {
            $team = $return['Team'];
            foreach ($return['Stats'] as $type => $info) {
                $type = strtolower($type);
                foreach ($info as $stats) {
                    $stmt->bind_param(
                        'isissiiiiiiiii',
                        $competitionid,                         //联赛编号
                        $type,                                  //统计类型
                        $stats['TeamId'],                       //球队编号
                        $team[$stats['TeamId']]['Name'],        //球队名称
                        $team[$stats['TeamId']]['ShortName'],   //球队简称
                        $stats['Data'][0],                      //半场胜，全场胜次数
                        $stats['Data'][1],                      //半场胜，全场和次数
                        $stats['Data'][2],                      //半场胜，全场负次数
                        $stats['Data'][3],                      //半场和，全场胜次数
                        $stats['Data'][4],                      //半场和，全场和次数
                        $stats['Data'][5],                      //半场和，全场负次数
                        $stats['Data'][6],                      //半场负，全场胜次数
                        $stats['Data'][7],                      //半场负，全场和次数
                        $stats['Data'][8]                       //半场负，全场负次数
                    );

                    $stmt->execute();
                }
            }
            cron_log('IP:' . IP . ' ' . $method . ' 请求接口数据成功');
        } elseif (isset($return['error'])) {
            cron_log('IP:' . IP . ' ' . $method . ' ' . $return['error'], 1);
        } elseif (empty($return)) {
            cron_log('IP:' . IP . ' ' . $method . ' 空值' . json_encode($return), 1);
        } else {
            cron_log('IP:' . IP . ' ' . $method . ' 网络错误', 1);
        }

        unset($return);
    }

    $stmt->close();
} else {
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
