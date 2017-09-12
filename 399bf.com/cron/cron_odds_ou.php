<?php
//大小球指数

require_once 'global.func.php';
require_once 'conn.php';

// 亚指公司t
$sql = "SELECT companyid,name FROM `ft_company` WHERE `area` = '亚指公司'";
$rst = $mysqli->query($sql);
$companydata = $rst->fetch_all(MYSQLI_ASSOC);

if($companydata != false)
{
    $sql = "REPLACE INTO `ft_odds_ou` VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
    if ($stmt = $mysqli->prepare($sql))
    {
        foreach ($companydata as $companykey => $companyinfo)
        {
            // 通过接口获取数据
            $type = 'type=getouoddslist&p1=1&p2=' . $companyinfo['companyid'];
            $return = http_get(proxy_url() . $type);

            // 确认返回数据格式
            if (is_array($return) && !empty($return) && !isset($return['error']))
            {
                foreach($return['Datas'] as $returnkey => $returninfo)
                {
                    $stmt->bind_param('isiiddddddis',
                        $companyinfo['companyid'],                      // 公司编号
                        $companyinfo['name'],                           // 公司名称
                        $returninfo['GameId'],                          // 比赛编号
                        $returninfo['IsRun'],                           // 是否走地盘(1是；0否)
                        $returninfo['Data'][0],                         // 大球指数
                        $returninfo['Data'][1],                         // 小球指数
                        $returninfo['Data'][2],                         // 总分指数
                        $returninfo['Data'][3],                         // 大球指数(初盘)
                        $returninfo['Data'][4],                         // 小球指数(初盘)
                        $returninfo['Data'][5],                         // 总分指数(初盘)
                        floor(($returninfo['Date'] / 1000)),            // 指数变化的时间戳
                        date('Y-m-d')                                   // 历史日期
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
}
else
{
    cron_log('ft_company表请求失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
