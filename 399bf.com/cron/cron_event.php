<?php
//赛事资料库

require_once 'global.func.php';
require_once 'conn.php';

$sql = "REPLACE INTO `ft_event`(eventid,eventname,eventtype,currentseason,countryid,".
    "countryname,countrylogo,zoneid,zonename)VALUES(?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    $type = 'type=getcompetitionlist';
    $return = http_get(proxy_url() . $type);

    if (is_array($return) && !empty($return) && !isset($return['error'])) {
        foreach ($return['Zone'] as $key => $info) {
            foreach ($info['Country'] as $Ckey => $Cinfo) {
                foreach ($Cinfo['Competition'] as $COkey => $COinfo) {
                    $stmt->bind_param('isisissis',
                        $COinfo['Id'],                            // 赛事编号
                        $COinfo['Name'],                          // 赛事名称
                        $COinfo['CompetitionType'],               // 赛事类别(1杯赛；2联赛)
                        $COinfo['CurrentSeason'],                 // 当前赛季
                        $Cinfo['Id'],                             // 国家编号
                        $Cinfo['Name'],                           // 国家名称
                        $Cinfo['Logo'],                           // 国家logo地址
                        $info['Id'],                              // 洲编号
                        $info['Name']                             // 洲名称
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
    $stmt->close();
}
else
{
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
