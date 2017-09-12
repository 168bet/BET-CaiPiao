<?php
// 近期取消、延期、腰斩的赛事定时任务

require_once 'global.func.php';
require_once 'conn.php';

// 从7m接口获取数据并写入本地数据库
$sql = "UPDATE `ft_game` SET `status`=?,`date`=?,`neutral`=?,`note`=? WHERE `gameid`=? ;";
if ($stmt = $mysqli->prepare($sql)) {
    // 通过接口获取数据
    $type = 'type=getrevocatorygame';
    $return = http_get(proxy_url().$type);

    // 确认返回数据格式正确
    if (is_array($return) && !empty($return) && !isset($return['error'])) {
        $status_info = array(
            '延期' => 13,
            '腰斩' => 14,
            '取消' => 6
        );
        foreach ($return['Games'] as $data) {
            $date = floor($data['Date'] / 1000);
            $note = isset($data['Note']) ? $data['Note'] : '';
            $stmt->bind_param(
                'iiisi',
                $status_info[$data['Status']],  //比赛状态
                $date,                          //比赛日期
                $data['N'],                     //是否中立场
                $note,                          //备注
                $data['Id'][0]                 //比赛编号
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
