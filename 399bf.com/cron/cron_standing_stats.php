<?php
//积分排名统计

require_once 'global.func.php';
require_once 'conn.php';

// 联赛编号数组
$sql = 'SELECT `competitionid` FROM `ft_competition`;';
$rst = $mysqli->query($sql);
$competitionids = array_column($rst->fetch_all(MYSQLI_ASSOC),'competitionid');

// 从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_standings_stats`()VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    foreach ($competitionids as $competitionid)
    {
        // 通过接口获取数据
        $type = 'type=getcompetitionstanding&p1=' . $competitionid;
        $return = http_get(proxy_url().$type);

        // 确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error']))
        {
            $team = $return['Team'];
            foreach ($return['Standing'] as $name => $info)
            {
                foreach ($info as $type => $stat)
                {
                    foreach ($stat as $teaminfo)
                    {
                        $stmt->bind_param(
                            'ississiiiiiiiis',
                            $competitionid,                         //联赛编号
                            $name,                                  //联赛名称、分区或阶段
                            strtolower($type),                      //积分排名类别
                            $teaminfo['Team'],                      //球队编号
                            $team[$teaminfo['Team']]['Name'],       //球队名称
                            $team[$teaminfo['Team']]['ShortName'],  //球队简称
                            $teaminfo['Data'][0],                   //总场数
                            $teaminfo['Data'][1],                   //胜场数
                            $teaminfo['Data'][2],                   //平场数
                            $teaminfo['Data'][3],                   //负场数
                            $teaminfo['Data'][4],                   //进球数
                            $teaminfo['Data'][5],                   //失球数
                            $teaminfo['Data'][6],                   //积分
                            $teaminfo['Data'][7],                   //扣分
                            isset($teaminfo['Note']) ? $teaminfo['Note'] : '' //备注
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
