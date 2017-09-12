<?php
//欧盘指数单场
//校对欧盘指数列表数据

require_once 'global.func.php';
require_once 'conn.php';

//比赛编号
$sql = "SELECT DISTINCT `gameid` FROM `ft_odds_euro` WHERE `date` = '".date('Y-m-d')."';";
$rst = $mysqli->query($sql);
$gameids = array_column($rst->fetch_all(MYSQLI_ASSOC), 'gameid');

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_odds_euro` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    foreach ($gameids as $gameid)
    {
        //通过接口获取数据
        $type = 'type=gethdaoddsinfo&p1=' . $gameid;
        $return = http_get(proxy_url() . $type);

        //确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error']))
        {
            foreach($return['Datas'] as $stat)
            {
                $stmt->bind_param('isiddddddddddddddis',
                    $stat['Cid'], 					        // 公司编号
                    $stat['Name'], 					        // 公司名称
                    $return['GameId'], 				        // 比赛编号
                    $stat['Data'][0], 			            // 主胜
                    $stat['Data'][1], 			            // 和局
                    $stat['Data'][2], 			            // 客胜
                    $stat['Data'][3], 			            // 主胜率
                    $stat['Data'][4], 			            // 和局率
                    $stat['Data'][5], 			            // 客胜率
                    $stat['Data'][6], 			            // 返还率
                    $stat['Data'][7], 		                // 主胜(初盘)
                    $stat['Data'][8], 		                // 和局(初盘)
                    $stat['Data'][9], 		                // 客胜(初盘)
                    $stat['Data'][10], 		                // 主胜率(初盘)
                    $stat['Data'][11], 		                // 和局率(初盘)
                    $stat['Data'][12], 		                // 客胜率(初盘)
                    $stat['Data'][13], 		                // 返还率(初盘)
                    floor($stat['Date']/1000), 		        // 指数变化的时间戳
                    date('Y-m-d') 		                    // 历史日期
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
    }

    $stmt->close();
}
else
{
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
