<?php
//即时比分

require_once 'global.func.php';
require_once 'conn.php';

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_live_game` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql)) {
    //通过接口获取数据
    $type = 'type=getlivegame';
    $return = http_get(proxy_url() . $type);

    //确认返回数据格式正确
    if (is_array($return) && !empty($return) && !isset($return['error'])) {
        $competition = $return['Competition'];
        $team = $return['Team'];
        $adddate = date('Y-m-d'); //添加日期
        foreach ($return['Schedule'] as $data) {
            $date = floor($data['Date'] / 1000);
            $none = '';
            $stmt->bind_param(
                'iisssississiiiiss',
                $data['Id'][0],                                     //比赛编号
                $data['Id'][1],                                     //联赛编号
                $competition[$data['Id'][1]]['Name'],               //联赛名称
                $competition[$data['Id'][1]]['ShortName'],          //联赛简称
                $competition[$data['Id'][1]]['Color'],              //联赛颜色
                $data['Id'][2],                                     //主队编号
                $team[$data['Id'][2]]['Name'],                      //主队名称
                $team[$data['Id'][2]]['ShortName'],                 //主队简称
                $data['Id'][3],                                     //客队编号
                $team[$data['Id'][3]]['Name'],                      //客队名称
                $team[$data['Id'][3]]['ShortName'],                 //客队简称
                $date,                                              //比赛时间
                $data['N'],                                         //是否中立
                isset($data['Rank']) ? $data['Rank'][0] : $none,    //主队排名
                isset($data['Rank']) ? $data['Rank'][1] : $none,    //客队排名
                isset($data['Weather']) ? $data['Weather'] : $none, //天气
                $adddate                                            //添加日期
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
    $stmt->close();
} else {
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
