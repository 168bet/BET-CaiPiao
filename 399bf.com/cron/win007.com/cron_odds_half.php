<?php
//半场赔率

require_once 'global.func.php';
require_once 'conn.php';

//从球探网获取数据
$method = 'method=lqhalfodds';
$data = http_get(PROXY_URL . $method, 1);

if (strpos($data, '$') === false) {
//    $let_goal_data = explode(';', $data);
    //TODO
    exit;
} else {
    list($let_goal_data, $total_score_data) = explode('$', $data);
    $let_goal_data = explode(';', $let_goal_data);
    $total_score_data = explode(';', $total_score_data);
}

//类型:半场
$type = 3;

$date = time();

//让球
if (isset($let_goal_data) && count($let_goal_data)) {

    //查询条件
    foreach ($let_goal_data as $row) {
        $value = explode(',', $row);

        $schedule_ids[] = $value[0];
        $company_ids[] = $value[1];
    }

    //让球变化表中的最新记录
    $last_data_sql = 'SELECT * FROM `bt_letgoal_detail` WHERE `type`=' . $type . ' AND `scheduleid` IN (' . join(',', $schedule_ids) . ') AND `companyid` IN (' . join(',', $company_ids) . ') ORDER BY `modifytime` DESC';

    $last_sql = 'SELECT `scheduleid`,`companyid`,`letgoal`,`homeodds`,`guestodds` FROM (' . $last_data_sql . ') AS tmp GROUP BY `scheduleid`,`companyid`;';

    $result = $mysqli->query($last_sql);
    $last_data = $result->fetch_all(MYSQLI_ASSOC);

    //用比赛id，公司id，盘口，主队赔率，客队赔率作为唯一索引
    if (count($last_data)) {
        foreach ($last_data as $row) {
            $row = array_map('rtrim0', $row);
            $last[] = join('-', $row);
        }
    }

    $let_goal_sql = 'REPLACE INTO `bt_letgoal_half` VALUES (' . rtrim(str_repeat('?,', 9), ',') . ');';

    if ($stmt = $mysqli->prepare($let_goal_sql)) {

        foreach ($let_goal_data as $row) {
            $value = array_map('rtrim0', explode(',', $row));

            //如果变化表中有记录，则做判断，如果不同，则插入到变化表中
            if (isset($last)) {
                $index = $value[0] . '-' . $value[1] . '-' . $value[5] . '-' . $value[6] . '-' . $value[7];

                if (! in_array($index, $last)) {
                    $let_goal_detail_data[] = explode('-', $index . '-' . $type . '-' . $date);
                }
            //如果变化表中没有记录，则本次记录全部要插入到变化表中
            } else {
                $let_goal_detail_data[] = array($value[0], $value[1], $value[5], $value[6], $value[7], $type, $date);
            }

            $stmt->bind_param('iiddddddi',
                $value[0],      //比赛ID
                $value[1],      //公司ID
                $value[2],      //初盘盘口
                $value[3],      //初盘 主队赔率
                $value[4],      //初盘 客队赔率
                $value[5],      //即时盘口
                $value[6],      //主队即时赔率
                $value[7],      //客队即时赔率
                $date           //赔率修改时间
            );

            $stmt->execute();
        }

        unset($schedule_ids, $company_ids, $last);
        $stmt->close();
    }
}

//让球变化表
if (isset($let_goal_detail_data) && count($let_goal_detail_data)) {

    $let_goal_detail_sql = 'REPLACE INTO `bt_letgoal_detail` VALUES (' . rtrim(str_repeat('?,', 7), ',') . ')';

    if ($stmt = $mysqli->prepare($let_goal_detail_sql)) {

        foreach ($let_goal_detail_data as $value) {

            $stmt->bind_param('iidddii',
                $value[0],      //比赛ID
                $value[1],      //公司ID
                $value[2],      //盘口
                $value[3],      //主队赔率
                $value[4],      //客队赔率
                $value[5],      //让分盘赔率种类
                $value[6]       //赔率修改时间
            );

            $stmt->execute();
        }

        $stmt->close();
    }
}

//大小总分
if (isset($total_score_data) && count($total_score_data)) {

    //查询条件
    foreach ($total_score_data as $row) {
        $value = explode(',', $row);

        $schedule_ids[] = $value[0];
        $company_ids[] = $value[1];
    }

    //大小总分最新记录
    $last_data_sql = 'SELECT * FROM `bt_totalscore_detail` WHERE `type`=' . $type . ' AND `scheduleid` IN (' . join(',', $schedule_ids) . ') AND `companyid` IN (' . join(',', $company_ids) . ') ORDER BY `modifytime` DESC';

    $last_sql = 'SELECT `scheduleid`,`companyid`,`totalscore`,`highodds`,`lowodds` FROM (' . $last_data_sql . ') AS tmp GROUP BY `scheduleid`,`companyid`;';

    $result = $mysqli->query($last_sql);
    $last_data = $result->fetch_all(MYSQLI_ASSOC);

    //用比赛id，公司id，盘口，大分赔率，小分赔率作为唯一索引
    if (count($last_data)) {
        foreach ($last_data as $row) {
            $row = array_map('rtrim0', $row);
            $last[] = join('-', $row);
        }
    }

    $total_score_sql = 'REPLACE INTO `bt_totalscore_half` VALUES (' . rtrim(str_repeat('?,', 9), ',') . ');';

    if ($stmt = $mysqli->prepare($total_score_sql)) {

        foreach ($total_score_data as $row) {
            $value = array_map('rtrim0', explode(',', $row));

            //如果变化表中有记录，则做判断，如果不同，则插入到变化表中
            if (isset($last)) {
                $index = $value[0] . '-' . $value[1] . '-' . $value[5] . '-' . $value[6] . '-' . $value[7];

                if (! in_array($index, $last)) {
                    $total_score_detail_data[] = explode('-', $index . '-' . $type . '-' . $date);
                }
            //如果变化表中没有记录，则本次记录全部要插入到变化表中
            } else {
                $total_score_detail_data[] = array($value[0], $value[1], $value[5], $value[6], $value[7], $type, $date);
            }

            $stmt->bind_param('iiddddddi',
                $value[0],      //比赛ID
                $value[1],      //公司ID
                $value[2],      //初盘盘口
                $value[3],      //初盘大分赔率
                $value[4],      //初盘小分赔率
                $value[5],      //即时盘盘口
                $value[6],      //即时盘大分赔率
                $value[7],      //即时盘小分赔率
                $date           //赔率修改时间
            );

            $stmt->execute();
        }

        unset($schedule_ids, $company_ids, $last);
        $stmt->close();
    }
}

//大小总分变化表
if (isset($total_score_detail_data) && count($total_score_detail_data)) {

    $total_score_detail_sql = 'REPLACE INTO `bt_totalscore_detail` VALUES (' . rtrim(str_repeat('?,', 7), ',') . ')';

    if ($stmt = $mysqli->prepare($total_score_detail_sql)) {

        foreach ($total_score_detail_data as $value) {

            $stmt->bind_param('iidddii',
                $value[0],      //比赛ID
                $value[1],      //公司ID
                $value[2],      //盘口
                $value[3],      //大分赔率
                $value[4],      //小分赔率
                $value[5],      //总分盘赔率种类
                $value[6]       //赔率修改时间
            );

            $stmt->execute();
        }

        $stmt->close();
    }
}

$mysqli->close();
