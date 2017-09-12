<?php
//比赛预测
//获取一次完场预测，每天14:00执行一次
//前一天12:00-12:00

require_once 'global.func.php';
require_once 'conn.php';

$starttime = strtotime(date('Y-m-d', SYS_TIME - 24 * 60 * 60) . ' 12:00:00');
$endtime = strtotime(date('Y-m-d') . ' 11:59:59');
$rst = $mysqli->query("SELECT `gameid` FROM `ft_live_game` WHERE `date` >= '$starttime' AND `date` <= '$endtime'");
$gameids = array_column($rst->fetch_all(MYSQLI_ASSOC), 'gameid');

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_game_forecast` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    foreach ($gameids as $gameid)
    {
        //通过接口获取数据
        $type = 'type=getgameprediction&p1=' . $gameid;
        $return = http_get(proxy_url() . $type);

        //确认返回数据格式
        if (is_array($return) && !isset($return['error']) && !empty($return))
        {
            $tip = isset($return['Tip']) ? $return['Tip'] : array();
            $lineup = isset($return['Lineup']) ? $return['Lineup'] : array();
            $default = '';

            $stmt->bind_param('isssssssssssi',
                $gameid, 					        //比赛编号
                isset($tip['HomeRecentTendency']) ? $tip['HomeRecentTendency'] : $default,        //主队近况走势(W胜；D平；L负)
                isset($tip['AwayRecentTendency']) ? $tip['AwayRecentTendency'] : $default,        //客队近况走势
                isset($tip['HomeOddsWinLose']) ? $tip['HomeOddsWinLose'] : $default,                //主队盘路输赢
                isset($tip['AwayOddsWinLose']) ? $tip['AwayOddsWinLose'] : $default,            //客队盘路输赢
                isset($tip['Confidence']) ? jsonEncode($tip['Confidence']) : $default,     //信心指数
                isset($tip['ResultsOfTheMatch']) ? $tip['ResultsOfTheMatch'] : $default,            //主队对塞成绩，胜场数、平场数、负场数
                isset($tip['Content']) ? jsonEncode($tip['Content']) : $default,        //预测内容
                isset($lineup['HomePlayers']) ? jsonEncode($lineup['HomePlayers']) : $default, //主队阵容json数据
                isset($lineup['AwayPlayers']) ? jsonEncode($lineup['AwayPlayers']) : $default, //客队阵容json数据
                isset($lineup['HFormation']) ? $lineup['HFormation'] : $default,              //主队阵型
                isset($lineup['AFormation']) ? $lineup['AFormation'] : $default,              //客队阵型
                isset($lineup['Forecast']) ? $lineup['Forecast'] : $default                 //是否正式阵容(1是;0否)
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

//关闭mysql连接
$mysqli->close();
