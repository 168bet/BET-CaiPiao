<?php
// 更新完场比赛动态数据定时任务
// 赛程赛果列表提供数据
// 忽略Weather字段；忽略ScorePoint字段(点球情况)；忽略Rank字段
// 增加更新YellowCard字段(接口文档未显示，但返回数据显示)

require_once 'global.func.php';
require_once 'conn.php';

// 从7m接口获取数据并写入本地数据库
$sql = "UPDATE `ft_game`
        SET `date` = ?,
            `neutral` = ?,
            `status` = ?,
            `homescore` = ?,
            `awayscore` = ?,
            `homeredcard` = ?,
            `awayredcard` = ?,
            `homeyellowcard` = ?,
            `awayyellowcard` = ?,
            `half` = ?,
            `note` = ?,
            `stats` = ?
        WHERE `gameid` = ?;";
if ($stmt = $mysqli->prepare($sql))
{
    // 通过接口获取数据
    $type = 'type=getschedulebydate&p1='.date('Y-m-d');
    $return = http_get(proxy_url().$type);

    // 确认返回数据格式
    if (is_array($return) && !empty($return) && !isset($return['error']))
    {
        $status = 10; // 10完成
        $default_score = 0; // 默认球队得分
        foreach($return['Schedule'] as $game)
        {
            $date = floor($game['Date']/1000); // 比赛时间
            $stmt->bind_param('iiiiiiiiisssi',
                $date, 					                            // 比赛时间
                $game['N'], 	                                    // 是否为中立场
                $status, 	                                        // 比赛状态
                isset($game['ScoreAll'])?
                    $game['ScoreAll'][0]:isset($game['Score'])?$game['Score'][0]:$default_score, 	    // 主队得分
                isset($game['ScoreAll'])?
                    $game['ScoreAll'][1]:isset($game['Score'])?$game['Score'][1]:$default_score, 	    // 客队得分
                $game['RedCard'][0], 		                        // 主队红牌
                $game['RedCard'][1], 		                        // 客队红牌
                $game['YellowCard'][0], 		                    // 主队黄牌
                $game['YellowCard'][1], 		                    // 客队黄牌
                $game['Half'],                                      // 半场比分
                isset($game['Note'])?$game['Note']:'',              // 备注信息
                isset($game['Stats'])?jsonEncode($game['Stats']):'', // 比赛统计数据(json数据)
                $game['Id'][0]                                      // 比赛编号
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
