<?php
//欧盘指数

require_once 'global.func.php';
require_once 'conn.php';

//减少接口请求次数，仅获取亚指公司对应的欧赔公司指数
$where = " WHERE `companyid` IN(".join(',', asia2euro()).")";
$sql = "SELECT `companyid`,`name` companyname FROM `ft_company` $where";
$rst = $mysqli->query($sql);
$companies = $rst->fetch_all(MYSQLI_ASSOC);

// 从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_odds_euro` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    foreach ($companies as $company)
    {
        extract($company);

        //通过接口获取数据
        $type = 'type=gethdaoddslist&p1=1&p2=' . $companyid;
        $return = http_get(proxy_url() . $type);

        //确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error']))
        {
            $default = 0.00;
            foreach($return['Datas'] as $stat)
            {
                $stmt->bind_param('isiddddddddddddddis',
                    $return['CId'], 					    // 公司编号
                    $companyname, 					        // 公司名称
                    $stat['GameId'], 				        // 比赛编号
                    $stat['Data'][0], 			            // 主胜
                    $stat['Data'][1], 			            // 和局
                    $stat['Data'][2], 			            // 客胜
                    $default, 			                    // 主胜率
                    $default, 			                    // 和局率
                    $default, 			                    // 客胜率
                    $default, 			                    // 返还率
                    $stat['Data'][3], 		                // 主胜(初盘)
                    $stat['Data'][4], 		                // 和局(初盘)
                    $stat['Data'][5], 		                // 客胜(初盘)
                    $default, 		                        // 主胜率(初盘)
                    $default, 		                        // 和局率(初盘)
                    $default, 		                        // 客胜率(初盘)
                    $default, 		                        // 返还率(初盘)
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
