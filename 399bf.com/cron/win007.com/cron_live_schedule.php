<?php
//当天比赛数据（通过篮球比分接口）

require_once 'global.func.php';
require_once 'conn.php';

//从球探网获取数据
$method = 'method=today';
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

    //差集取需要插入的记录
    $insert_ids = count($exists_ids) ? array_diff($schedule_ids, $exists_ids) : $schedule_ids;
    //交集取需要更新的记录
    $update_ids = count($exists_ids) ? array_intersect($schedule_ids, $exists_ids) : array();

    //插入数据
    if (count($insert_ids)) {

        $insert_sql = 'INSERT INTO `bt_live_schedule` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

        if ($stmt = $mysqli->prepare($insert_sql)) {

            foreach ($insert_ids as $id) {
                $value = $info[$id];
                list($cn_name, $tw_name) = explode(',', $value[3]);
                list($home_cn_name, $home_tw_name) = explode(',', $value[10]);
                list($away_cn_name, $away_tw_name) = explode(',', $value[12]);
                //是否有技术统计
                $is_technic = $value[32] == 'True' ? 1 : 0;
                $date = strtotime($value[6]);
                $note = '';
                $float = 0.000;
                $stmt->bind_param('iiissisiisississssiiiiiiiiiiiiiiiiiissisdd',
                    $id,                                                            //比赛id
                    $value[1],                                                      //联赛id
                    $value[2],                                                      //类型
                    $cn_name,                                                       //联赛简体名
                    $tw_name,                                                       //联赛繁体名
                    $value[4],                                                      //分几节进行
                    $value[5],                                                      //联赛颜色
                    $date,                                                          //时间
                    $value[7],                                                      //状态
                    $value[8],                                                      //小节剩余时间
                    $value[9],                                                      //主队id
                    $home_cn_name,                                                  //主队简体名称
                    $home_tw_name,                                                  //主队繁体名称
                    $value[11],                                                     //客队id
                    $away_cn_name,                                                  //客队简体名称
                    $away_tw_name,                                                  //客队繁体名称
                    $value[13],                                                     //主队排名
                    $value[14],                                                     //客队排名
                    $value[15],                                                     //主队得分
                    $value[16],                                                     //客队得分
                    $value[17],                                                     //主队一节得分
                    $value[18],                                                     //客队一节得分
                    $value[19],                                                     //主队二节得分
                    $value[20],                                                     //客队二节得分
                    $value[21],                                                     //主队三节得分
                    $value[22],                                                     //客队三节得分
                    $value[23],                                                     //主队四节得分
                    $value[24],                                                     //客队四节得分
                    $value[25],                                                     //加时
                    $value[26],                                                     //主队1ot得分
                    $value[27],                                                     //客队1ot得分
                    $value[28],                                                     //主队2ot得分
                    $value[29],                                                     //客队2ot得分
                    $value[30],                                                     //主队3ot得分
                    $value[31],                                                     //客队3ot得分
                    $is_technic,                                                    //是否有技术统计
                    $value[33],                                                     //电视直播
                    $value[34],                                                     //备注1
                    $value[35],                                                     //中立场
                    $note,
                    $float,
                    $float
                );

                $stmt->execute();
            }

            $stmt->close();
        } else {
            //TODO
        }
    }

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
                                                     `istechnic`=?
                      WHERE `scheduleid`=?;';

        if ($stmt = $mysqli->prepare($update_sql)) {

            foreach ($update_ids as $id) {
                $value = $info[$id];
                //是否有技术统计
                $is_technic = $value[32] == 'True' ? 1 : 0;
                $stmt->bind_param('isiiiiiiiiiiisiiiiiiiii',
                    $value[7],                                      //状态
                    $value[8],                                      //小节剩余时间
                    $value[15],                                     //主队得分
                    $value[16],                                     //客队得分
                    $value[17],                                     //主队一节得分
                    $value[18],                                     //客队一节得分
                    $value[19],                                     //主队二节得分
                    $value[20],                                     //客队二节得分
                    $value[21],                                     //主队三节得分
                    $value[22],                                     //客队三节得分
                    $value[23],                                     //主队四节得分
                    $value[24],                                     //客队四节得分
                    $value[25],                                     //加时
                    $value[34],                                     //备注1
                    $value[4],                                      //分几节
                    $value[26],                                     //主队1ot得分
                    $value[27],                                     //客队1ot得分
                    $value[28],                                     //主队2ot得分
                    $value[29],                                     //客队2ot得分
                    $value[30],                                     //主队3ot得分
                    $value[31],                                     //客队3ot得分
                    $is_technic,                                     //是否有技术统计
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
