<?php
//即时变化的数据

require_once 'global.func.php';
require_once 'conn.php';

//从球探网获取数据
$method = 'method=change';
$data = http_get(PROXY_URL . $method, 3);

if (count($data->children())) {
    //表中已存在的记录
    $exists = $mysqli->query('SELECT `scheduleid` FROM bt_live_schedule;');
    $exists_ids = array_column($exists->fetch_all(MYSQLI_ASSOC), 'scheduleid');

    //遍历xml对象获取需要的记录
    foreach ($data->children() as $child) {
        $value = explode('^', $child);
        $schedule_ids[] = $value[0];
        $info[$value[0]] = $value;
    }

    //交集取需要更新的记录
    $update_ids = count($exists_ids) ? array_intersect($schedule_ids, $exists_ids) : array();

    //更新数据
    if (count($update_ids)) {

        $update_sql = 'UPDATE `bt_live_schedule` SET `status`=?,
                                                     `remaintime`=?,
                                                     `homescore`=?,
                                                     `guestscore`=?,
                                                     `homeone`=?,
                                                     `guestone`=?,
                                                     `hometwo`=?,
                                                     `guesttwo`=?,
                                                     `homethree`=?,
                                                     `guestthree`=?,
                                                     `homefour`=?,
                                                     `guestfour`=?,
                                                     `addtime`=?,
                                                     `note1`=?,
                                                     `sclasspart`=?,
                                                     `homeaddtime1`=?,
                                                     `guestaddtime1`=?,
                                                     `homeaddtime2`=?,
                                                     `guestaddtime2`=?,
                                                     `homeaddtime3`=?,
                                                     `guestaddtime3`=?,
                                                     `istechnic`=?,
                                                     `note2`=?,
                                                     `homewin`=?,
                                                     `guestwin`=?
                      WHERE `scheduleid`=?;';

        if ($stmt = $mysqli->prepare($update_sql)) {

            foreach ($update_ids as $id) {
                $value = $info[$id];
                list($home_win, $away_win) = explode(',', $value[24]);
                //是否有技术统计
                $is_technic = $value[23] == 'True' ? 1 : 0;
                $stmt->bind_param('isiiiiiiiiiiisiiiiiiiisddi',
                    $value[1],                                      //状态
                    $value[2],                                      //小节剩余时间
                    $value[3],                                      //主队得分
                    $value[4],                                      //客队得分
                    $value[5],                                      //主队一节得分
                    $value[6],                                      //客队一节得分
                    $value[7],                                      //主队二节得分
                    $value[8],                                      //客队二节得分
                    $value[9],                                      //主队三节得分
                    $value[10],                                     //客队三节得分
                    $value[11],                                     //主队四节得分
                    $value[12],                                     //客队四节得分
                    $value[13],                                     //加时
                    $value[14],                                     //备注1
                    $value[15],                                     //分几节
                    $value[16],                                     //主队1ot得分
                    $value[17],                                     //客队1ot得分
                    $value[18],                                     //主队2ot得分
                    $value[19],                                     //客队2ot得分
                    $value[20],                                     //主队3ot得分
                    $value[21],                                     //客队3ot得分
                    $is_technic,                                    //是否有技术统计
                    $value[22],                                     //备注2
                    $home_win,                                      //主队胜率
                    $away_win,                                      //客队胜率
                    $id                                             //比赛id，用作更新条件
                );

                $stmt->execute();
            }

            $stmt->close();
        }
    }
} else {
    //TODO
}

$mysqli->close();
