<?php
//亚盘指数

require_once 'global.func.php';
require_once 'conn.php';

//亚盘指数公司编号，名称
$company_sql = 'SELECT `companyid`,`name` FROM `ft_company` WHERE `area` = "亚指公司";';
$company_info = $mysqli->query($company_sql);
$companyids = $company = array();
while ($row = mysqli_fetch_array($company_info)) {
    $companyids[] = $row['companyid'];
    $company[$row['companyid']] = $row;
}

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_odds_asia` VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql)) {
    foreach ($companyids as $companyid) {
        //通过接口获取数据
        $type = 'type=getahoddslist&p1=1&p2=' . $companyid;
        $return = http_get(proxy_url() . $type);

        //确认返回数据格式正确
        if (is_array($return) && !empty($return) && !isset($return['error'])) {
            foreach ($return['Datas'] as $data) {
                $oddsdate = floor($data['Date'] / 1000);
                $date = date('Y-m-d');
                $stmt->bind_param(
                    'isiissssssis',
                    $return['CId'],                     //公司编号
                    $company[$return['CId']]['name'],   //公司名称
                    $data['GameId'],                    //比赛编号
                    $data['IsRun'],                     //是否走地盘
                    $data['Data'][0],                   //上盘
                    $data['Data'][1],                   //下盘
                    $data['Data'][2],                   //让球
                    $data['Data'][3],                   //上盘(初盘)
                    $data['Data'][4],                   //下盘(初盘)
                    $data['Data'][5],                   //让球(初盘)
                    $oddsdate,                          //指数变化的时间戳
                    $date                               //数据日期
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
} else {
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
