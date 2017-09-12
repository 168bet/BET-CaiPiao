<?php
// 攻守统计定时任务

require_once 'global.func.php';
require_once 'conn.php';

// 联赛编号
$sql = "SELECT competitionid FROM `ft_competition`;";
$rst = $mysqli->query($sql);
$competitionids = array_column($rst->fetch_all(MYSQLI_ASSOC),'competitionid');

// 从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_getmiss_stats` VALUES(?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    foreach ($competitionids as $competitionid)
    {
        // 通过接口获取数据
        $type = 'type=getcompetitiongetmiss&p1='.$competitionid;
        $return = http_get(proxy_url().$type);

        // 确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error']))
        {
            $team = $return['Team'];
            foreach($return['Stats'] as $type1 => $info1)
            {
                foreach($info1 as $type2 => $info2)
                {
                    foreach($info2 as $teaminfo)
                    {
                        $stmt->bind_param('ississii',
                            $competitionid, 					        // 联赛编号
                            strtolower($type1), 				        // 统计类别1
                            strtolower($type2), 				        // 统计类别2
                            $teaminfo['TeamId'], 			            // 球队编号
                            $team[$teaminfo['TeamId']]['Name'], 	    // 球队名称
                            $team[$teaminfo['TeamId']]['ShortName'], 	// 球队简称
                            $teaminfo['Data'][0], 		                // 场次
                            $teaminfo['Data'][1] 		                // 进球数/失球数
                        );

                        $stmt->execute();
                    }
                }
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
}
else
{
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
