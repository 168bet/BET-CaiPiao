<?php
//最常见赛果统

require_once 'global.func.php';
require_once 'conn.php';

//获取联赛编号
$sql = "SELECT competitionid FROM `ft_competition` ";
$rst = $mysqli->query($sql);
$competitiondata = $rst->fetch_all(MYSQLI_ASSOC);
if($competitiondata != false)
{
    //将数据写入本地数据库
    $sql = "REPLACE INTO `ft_frequentresults_stats` VALUES(?,?,?,?,?);";
    if ($stmt = $mysqli->prepare($sql))
    {
        foreach($competitiondata as $competitionkey => $competitioninfo)
        {
            //通过7m接口获取数据
            $type = 'type=getcompetitionfrequentresults&p1=' . $competitioninfo['competitionid'];
            $return = http_get(proxy_url() . $type);

            // 确认返回数据格式
            if (is_array($return) && !empty($return) && !isset($return['error']))
            {
                $stmt->bind_param('issss',
                    $competitioninfo['competitionid'], 							// 联赛编号
                    jsonEncode($return['Stats']['Rank']), 						// 排名
                    jsonEncode($return['Stats']['Result']), 					// 赛果
                    jsonEncode($return['Stats']['No']), 						// 场数
                    jsonEncode($return['Stats']['Percentage']) 		// 占总场数的比例(百分比)
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
    cron_log('查询表ft_competition失败。', 2);
}

// 关闭mysql连接
$mysqli->close();





