<?php
// 射手榜统计定时任务

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
$sql = "REPLACE INTO `ft_shooter_stats` VALUES(?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql)) {
    foreach ($competitionids as $competitionid) {
        // 通过接口获取数据
        $type = 'type=getcompetitionshooter&p1=' . $competitionid;
        $return = http_get(proxy_url().$type);

        // 确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error'])) {
            foreach ($return['Shooter'] as $shooter) {
                $stmt->bind_param(
                    'iiisisii',
                    $competitionid,             //联赛编号
                    $shooter['Rank'],           //排名
                    $shooter['PlayerId'],       //球员编号
                    $shooter['PlayerName'],     //球员姓名
                    $shooter['TeamId'],         //球队编号
                    $shooter['TeamName'],       //球队名称
                    $shooter['Data'][0],        //进球数
                    $shooter['Data'][1]         //点球数
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
