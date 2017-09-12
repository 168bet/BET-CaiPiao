<?php
//通过即时比分添加比赛往绩数据
//通过即时比分获取比赛id
//解决即时比分赛事没有比赛往绩的情况

require_once 'global.func.php';
require_once 'conn.php';

//比赛编号，获取ft_live_game表中新增的比赛
$rst = $mysqli->query("SELECT `gameid` FROM `ft_live_game`;");
$gameids = array_column($rst->fetch_all(MYSQLI_ASSOC), 'gameid');
$rst = $mysqli->query("SELECT `gameid` FROM `ft_game_stats`;");
$old_gameids = array_column($rst->fetch_all(MYSQLI_ASSOC), 'gameid');
//获取新比赛的id
$new_gameids = array_diff($gameids, $old_gameids);
unset($gameids);
unset($old_gameids);

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_game_stats` VALUES(?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    foreach ($new_gameids as $gameid)
    {
        //通过接口获取数据
        $type = 'type=getgameanalyse&p1=' . $gameid;
        $return = http_get(proxy_url() . $type);

        //确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error']))
        {
            $meeting = count($return['Meeting']) ? jsonEncode($return['Meeting']) : '';
            $team_history = '';
            $team_stats = jsonEncode($return['TeamStats']);
            $standings = (isset($return['Standings']) && count($return['Standings'])) ? jsonEncode($return['Standings']) : '';
            $team_fixture = (count($return['TeamFixture']['Home']) || count($return['TeamFixture']['Away'])) ? jsonEncode($return['TeamFixture']) : '';
            $competition = jsonEncode($return['Competition']);
            $team = jsonEncode($return['Team']);
            if (count($return['TeamHistory']['Home']) || count($return['TeamHistory']['Away'])) {
                //日期时间戳改为10位
                foreach ($return['TeamHistory'] as &$info) {
                    if (count($info)) {
                        foreach ($info as &$data) {
                            if (isset($data['Date'])) {
                                $data['Date'] = floor($data['Date'] / 1000);
                            }
                        }
                    }
                }
                $team_history = jsonEncode($return['TeamHistory']);
            }
            $stmt->bind_param(
                'isssssss',
                $gameid,        //比赛编号
                $meeting,       //交锋往绩json数据
                $team_history,  //双方球队近两年战绩数据，home主队，away客队
                $team_stats,    //双方球队历史战绩统计数据，home主队，away客队
                $standings,     //双方球队排名统计数据，home主队，away客队
                $team_fixture,  //双方球队未来赛程数据，home主队，away客队
                $competition,   //联赛json数组
                $team           //球队json数组
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
} else {
    cron_log('初始化语句对象失败。', 2);
}

//关闭mysql连接
$mysqli->close();

exit;
