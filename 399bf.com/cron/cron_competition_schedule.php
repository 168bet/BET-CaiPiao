<?php
//联赛赛程

require_once 'global.func.php';
require_once 'conn.php';

//联赛编号数组
$competition_sql = 'SELECT `competitionid` FROM `ft_competition`;';
$competition_info = $mysqli->query($competition_sql);
$competitionids = array();
while ($row = mysqli_fetch_array($competition_info)) {
    $competitionids[] = $row['competitionid'];
}

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_competition_schedule` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql)) {
    foreach ($competitionids as $competitionid) {
        //通过接口获取数据
        $type = 'type=getcompetitionschedule&p1=' . $competitionid;
        $return = http_get(proxy_url() . $type);

        //确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error'])) {
            $mode = strtolower($return['Mode']);
            $none = '';
            $zero = 0;
            switch ($mode) {
                //轮次
                case 'round':
                    $period = $group = '';
                    foreach ($return['Schedule'] as $round => $schedule) {
                        foreach ($schedule as $data) {
                            $stmt->bind_param(
                                'iissssiiiiiiiis',
                                $data['Id'][0],                                                                                         //比赛编号
                                $data['Id'][1],                                                                                         //联赛编号
                                $mode,                                                                                                  //联赛模式
                                $period,                                                                                                //联赛阶段
                                $round,                                                                                                 //联赛轮次
                                $group,                                                                                                 //联赛分组
                                $data['Id'][2],                                                                                         //主场队id
                                $data['Id'][3],                                                                                         //客场队id
                                floor($data['Date'] / 1000),                                                                            //比赛时间
                                $data['N'],                                                                                             //是否中立场
                                isset($data['ScoreAll']) ? $data['ScoreAll'][0] : (isset($data['Score']) ? $data['Score'][0] : $zero),  //主队得分
                                isset($data['ScoreAll']) ? $data['ScoreAll'][1] : (isset($data['Score']) ? $data['Score'][1] : $zero),  //客队得分
                                isset($data['RedCard']) ? $data['RedCard'][0] : $zero,                                                  //主队红牌
                                isset($data['RedCard']) ? $data['RedCard'][1] : $zero,                                                  //客队红牌
                                isset($data['Half']) ? $data['Half'] : $none                                                            //半场比分
                            );

                            $stmt->execute();
                        }
                    }
                    break;
                //分组
                case 'group':
                    $round = $period = '';
                    foreach ($return['Schedule'] as $group => $schedule) {
                        foreach ($schedule as $data) {
                            $stmt->bind_param(
                                'iissssiiiiiiiis',
                                $data['Id'][0],                                                                                         //比赛编号
                                $data['Id'][1],                                                                                         //联赛编号
                                $mode,                                                                                                  //联赛模式
                                $period,                                                                                                //联赛阶段
                                $round,                                                                                                 //联赛轮次
                                $group,                                                                                                 //联赛分组
                                $data['Id'][2],                                                                                         //主场队id
                                $data['Id'][3],                                                                                         //客场队id
                                floor($data['Date'] / 1000),                                                                            //比赛时间
                                $data['N'],                                                                                             //是否中立场
                                isset($data['ScoreAll']) ? $data['ScoreAll'][0] : (isset($data['Score']) ? $data['Score'][0] : $zero),  //主队得分
                                isset($data['ScoreAll']) ? $data['ScoreAll'][1] : (isset($data['Score']) ? $data['Score'][1] : $zero),  //客队得分
                                isset($data['RedCard']) ? $data['RedCard'][0] : $zero,                                                  //主队红牌
                                isset($data['RedCard']) ? $data['RedCard'][1] : $zero,                                                  //客队红牌
                                isset($data['Half']) ? $data['Half'] : $none                                                            //半场比分
                            );

                            $stmt->execute();
                        }
                    }
                    break;
                //阶段
                case 'period':
                    foreach ($return['Period'] as $period => $schedule) {
                        if (! count($schedule)) {
                            continue;
                        }
                        //mode取各阶段的二级mode
                        $mode = strtolower($schedule['Mode']);
                        $round = '';
                        //二级mode为None时，赛程数组为简单的数字索引
                        if ($mode == 'none') {
                            $group = '';
                            foreach ($schedule['Schedule'] as $data) {
                                $stmt->bind_param(
                                    'iissssiiiiiiiis',
                                    $data['Id'][0],                                                                                         //比赛编号
                                    $data['Id'][1],                                                                                         //联赛编号
                                    $mode,                                                                                                  //联赛模式
                                    $period,                                                                                                //联赛阶段
                                    $round,                                                                                                 //联赛轮次
                                    $group,                                                                                                 //联赛分组
                                    $data['Id'][2],                                                                                         //主场队id
                                    $data['Id'][3],                                                                                         //客场队id
                                    floor($data['Date'] / 1000),                                                                            //比赛时间
                                    $data['N'],                                                                                             //是否中立场
                                    isset($data['ScoreAll']) ? $data['ScoreAll'][0] : (isset($data['Score']) ? $data['Score'][0] : $zero),  //主队得分
                                    isset($data['ScoreAll']) ? $data['ScoreAll'][1] : (isset($data['Score']) ? $data['Score'][1] : $zero),  //客队得分
                                    isset($data['RedCard']) ? $data['RedCard'][0] : $zero,                                                  //主队红牌
                                    isset($data['RedCard']) ? $data['RedCard'][1] : $zero,                                                  //客队红牌
                                    isset($data['Half']) ? $data['Half'] : $none                                                            //半场比分
                                );

                                $stmt->execute();
                            }
                        } else {
                            //二级mode不是None要判断是group还是round
                            foreach ($schedule['Schedule'] as $key => $info) {
                                switch ($mode) {
                                    case 'group':
                                        $group = $key;
                                        break;
                                    case 'round':
                                        $number = array();                                                                                      //每次循环前初始化，防止带入错误的数据
                                        preg_match('/\d+/', $key, $number);                                                                     //round只取数字
                                        $group = '';
                                        break;
                                    default:
                                        $group = '';
                                        break;
                                }
                                foreach ($info as $data) {
                                    $stmt->bind_param(
                                        'iissssiiiiiiiis',
                                        $data['Id'][0],                                                                                         //比赛编号
                                        $data['Id'][1],                                                                                         //联赛编号
                                        $mode,                                                                                                  //联赛模式
                                        $period,                                                                                                //联赛阶段
                                        $number ? $number[0] : $round,                                                                          //联赛轮次
                                        $group,                                                                                                 //联赛分组
                                        $data['Id'][2],                                                                                         //主场队id
                                        $data['Id'][3],                                                                                         //客场队id
                                        floor($data['Date'] / 1000),                                                                            //比赛时间
                                        $data['N'],                                                                                             //是否中立场
                                        isset($data['ScoreAll']) ? $data['ScoreAll'][0] : (isset($data['Score']) ? $data['Score'][0] : $zero),  //主队得分
                                        isset($data['ScoreAll']) ? $data['ScoreAll'][1] : (isset($data['Score']) ? $data['Score'][1] : $zero),  //客队得分
                                        isset($data['RedCard']) ? $data['RedCard'][0] : $zero,                                                  //主队红牌
                                        isset($data['RedCard']) ? $data['RedCard'][1] : $zero,                                                  //客队红牌
                                        isset($data['Half']) ? $data['Half'] : $none                                                            //半场比分
                                    );

                                    $stmt->execute();
                                }
                            }
                        }
                    }
                    break;
                default:
                    break;
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
