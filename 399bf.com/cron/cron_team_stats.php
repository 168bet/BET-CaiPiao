<?php
//球队近两年赛绩，未来赛程，历史统计

require_once 'global.func.php';
require_once 'conn.php';

$sql = "SELECT teamid,name,shortname FROM `ft_team` ";
$rst = $mysqli->query($sql);
$teamdata = $rst->fetch_all(MYSQLI_ASSOC);

if($teamdata != false)
{
    $sql = "REPLACE INTO `ft_team_stats` VALUES(?,?,?,?,?,?);";
    if ($stmt = $mysqli->prepare($sql))
    {
        foreach ($teamdata as $teamkey => $teaminfo)
        {
            // 通过接口获取数据
            $type = 'type=getteamstats&p1=' . $teaminfo['teamid'];
            $return = http_get(proxy_url().$type);

            if (is_array($return) && !empty($return) && !isset($return['error'])) {
                $stmt->bind_param('isssss',
                    $teaminfo['teamid'],                      // 球队编号
                    $teaminfo['name'],                        // 球队名称(冗余)
                    $teaminfo['shortname'],                   // 球队简称(冗余)
                    jsonEncode($return['Historys']),          // 近两年历史数据json数据
                    !empty($return['Fixtures'])?
                        jsonEncode($return['Fixtures']):'',  // 未来赛程json数据
                    jsonEncode($return['Stats'])              // 球队统计json数据
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
    cron_log('ft_team表请求失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
