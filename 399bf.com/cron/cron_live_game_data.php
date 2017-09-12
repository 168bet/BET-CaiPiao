<?php
//即时比分数据

require_once 'global.func.php';
require_once 'conn.php';

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_live_game_data` VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    //通过接口获取数据
    $type = 'type=getlivedata';
    $return = http_get(proxy_url() . $type);

    //确认返回数据格式
    if (is_array($return) && !empty($return) && !isset($return['error']))
    {
        foreach($return['LiveData'] as $gameid => $gameinfo)
        {
            $stmt->bind_param('iiiiiiiiisss',
                $gameid, 					                                // 比赛编号
                floor($gameinfo['TStartTime']/1000), 				        // 比赛实际开始时间
                $gameinfo['Status'], 			                            // 比赛状态
                isset($gameinfo['ScoreAll'])?
                    $gameinfo['ScoreAll'][0]:$gameinfo['Score'][0], 	    // 主队得分
                isset($gameinfo['ScoreAll'])?
                    $gameinfo['ScoreAll'][1]:$gameinfo['Score'][1], 	    // 客队得分
                $gameinfo['RedCard'][0], 		                            // 主队红牌
                $gameinfo['RedCard'][1], 		                            // 客队红牌
                $gameinfo['YellowCard'][0], 		                        // 主队黄牌
                $gameinfo['YellowCard'][1], 		                        // 客队黄牌
                $gameinfo['Half'], 		                                    // 半场比分
                isset($gameinfo['Note'])?jsonEncode($gameinfo['Note']):'',  // 备注信息
                isset($gameinfo['Stats'])?jsonEncode($gameinfo['Stats']):'' // 比赛统计数据(json数据)
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
}
else
{
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
