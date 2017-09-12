<?php
//盘路统计

require_once 'global.func.php';
require_once 'conn.php';

$sql = "SELECT competitionid FROM `ft_competition` ";
$rst = $mysqli->query($sql);
$competitiondata = $rst->fetch_all(MYSQLI_ASSOC);

if($competitiondata != false)
{
    $sql = "REPLACE INTO `ft_oddsway_stats` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);";
    if ($stmt = $mysqli->prepare($sql)) {
        foreach ($competitiondata as $competitionkey => $competitioninfo) {
            // 通过接口获取数据
            $type = 'type=getcompetitionoddsway&p1=' . $competitioninfo['competitionid'];
            $return = http_get(proxy_url().$type);

            if (is_array($return) && !empty($return) && !isset($return['error'])) {
                foreach($return['OddsWay'] as $returnkey => $returninfo)
                {
                    foreach($returninfo as $returninfokey => $returninfotwo)
                    {
                        $data7 = (float)$returninfotwo['Data'][7];
                        $returnkey = strtolower($returnkey);
                        $stmt->bind_param('isissiiiiiiid',
                            $competitioninfo['competitionid'],                            // 联赛编号
                            $returnkey,                        // 盘路统计类别
                            $returninfotwo['Team'],                        // 球队编号
                            $return['Team'][$returninfotwo['Team']]['Name'],                    // 球队名称
                            $return['Team'][$returninfotwo['Team']]['ShortName'],                        // 球队简称
                            $returninfotwo['Data'][0],                        // 总场数
                            $returninfotwo['Data'][1],                        // 开盘数
                            $returninfotwo['Data'][2],                        // 上盘数
                            $returninfotwo['Data'][3],                        // 赢盘数
                            $returninfotwo['Data'][4],                       // 走水数
                            $returninfotwo['Data'][5],                        // 输盘数
                            $returninfotwo['Data'][6],                        // 净胜盘数
                            $data7   // 赢盘率
                        );
                        $stmt->execute();
                    }
                }
                unset($return);
                cron_log('IP:' . IP . ' ' . $type . ' 请求接口数据成功');
            } elseif (isset($return['error'])) {
                cron_log('IP:' . IP . ' ' . $type . ' ' . $return['error'], 1);
            } elseif (empty($return)) {
                cron_log('IP:' . IP . ' ' . $type . ' 空值' . json_encode($return), 1);
            } else {
                cron_log('IP:' . IP . ' ' . $type . ' 网络错误', 1);
            }

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
    cron_log('ft_competition表请求失败。', 2);
}
// 关闭mysql连接
$mysqli->close();
