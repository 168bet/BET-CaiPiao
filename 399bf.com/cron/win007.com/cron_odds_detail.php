<?php
//赔率变化数据

require_once 'global.func.php';
require_once 'conn.php';

//从球探网获取数据
$method = 'method=ch_oddsBsk';
list($tag, $data) = http_get(PROXY_URL . $method);

$date = time();

if (isset($tag['C']) && isset($tag['H'])) {

    //让分盘赔率种类
    $type = 6;

    $let_point_info = $euro_odds_info = $total_score_info = array();

    //让球索引
    if (isset($tag['A'][1])) {
        $let_point_index = array(
            'start' => $tag['A'][0],
            'end' => $tag['A'][1]
        );
    }

    //欧赔索引
    if (isset($tag['O'][1])) {
        $euro_odds_index = array(
            'start' => $tag['O'][0],
            'end' => $tag['O'][1]
        );
    }

    //大小总分索引
    if (isset($tag['D'][1])) {
        $total_score_index = array(
            'start' => $tag['D'][0],
            'end' => $tag['D'][1]
        );
    }

    foreach ($tag['H'] as $index) {

        $value = isset($data[$index]['value']) ? $data[$index]['value'] : false;

        //让球
        if (isset($let_point_index) && $index >= $let_point_index['start'] && $index <= $let_point_index['end']) {

            //补充类型和修改时间
            $value .= ',' . $type . ',' . $date;
            $value = array_map('rtrim0', explode(',', $value));

            //查询条件
            $schedule_ids['let_goal'][] = $value[0];
            $company_ids['let_goal'][] = $value[1];

            $let_point_info[] = $value;

        //欧赔
        } elseif (isset($euro_odds_index) && $index >= $euro_odds_index['start'] && $index <= $euro_odds_index['end']) {

            $value = array_map('rtrim0', explode(',', $value));

            //主胜率
            $value[] = round((1 / (1 + ($value[2] / $value[3])) * 100), 2);

            //客胜率
            $value[] = round((1 / (1 + ($value[3] / $value[2])) * 100), 2);

            //返回率
            $value[] = round($value[2] * $value[3], 2);

            $value[] = $date;

            //查询条件
            $schedule_ids['euro'][] = $value[0];
            $company_ids['euro'][] = $value[1];

            $euro_odds_info[] = $value;

        //大小总分
        } elseif (isset($total_score_index) && $index >= $total_score_index['start'] && $index <= $total_score_index['end']) {

            //补充类型和修改时间
            $value .= ',' . $type . ',' . $date;
            $value = array_map('rtrim0', explode(',', $value));
            $value[2] = floatval($value[2]);

            //查询条件
            $schedule_ids['total_score'][] = $value[0];
            $company_ids['total_score'][] = $value[1];

            $total_score_info[] = $value;
        } else {
            //TODO
        }
    }

    //让球
    if (count($let_point_info)) {

        if (isset($schedule_ids['let_goal']) && isset($company_ids['let_goal'])) {
            //让球变化表中的最新记录
            $last_data_sql = 'SELECT * FROM `bt_letgoal_detail` WHERE `type`=' . $type . ' AND `scheduleid` IN (' . join(',', $schedule_ids['let_goal']) . ') AND `companyid` IN (' . join(',', $company_ids['let_goal']) . ') ORDER BY `modifytime` DESC';

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
        }

        $let_point_sql = 'REPLACE INTO `bt_letgoal_detail` VALUES (' . rtrim(str_repeat('?,', 7), ',') . ')';

        if ($stmt = $mysqli->prepare($let_point_sql)) {

            foreach ($let_point_info as $value) {

                //插入标签，用于判断是否插入
                $tag = false;

                //如果变化表中有记录，则做判断，如果不同，则插入到变化表中，否则不插入
                if (isset($last)) {
                    $index = $value[0] . '-' . $value[1] . '-' . $value[2] . '-' . $value[3] . '-' . $value[4];

                    if (! in_array($index, $last)) {
                        $tag = true;
                    }
                } else {
                    $tag = true;
                }

                if ($tag) {
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
            }

            unset($last);
            $stmt->close();
        }
    }

    //欧赔
    if (count($euro_odds_info)) {

        if (isset($schedule_ids['euro']) && isset($company_ids['euro'])) {
            //让球变化表中的最新记录
            $last_data_sql = 'SELECT * FROM `bt_europeodds_detail` WHERE `scheduleid` IN (' . join(',', $schedule_ids['euro']) . ') AND `companyid` IN (' . join(',', $company_ids['euro']) . ') ORDER BY `modifytime` DESC';

            $last_sql = 'SELECT `scheduleid`,`companyid`,`homewin`,`guestwin` FROM (' . $last_data_sql . ') AS tmp GROUP BY `scheduleid`,`companyid`;';

            $result = $mysqli->query($last_sql);
            $last_data = $result->fetch_all(MYSQLI_ASSOC);

            //用比赛id，公司id，主胜赔率，客胜赔率作为唯一索引
            if (count($last_data)) {
                foreach ($last_data as $row) {
                    $row = array_map('rtrim0', $row);
                    $last[] = join('-', $row);
                }
            }
        }

        $euro_odds_sql = 'REPLACE INTO `bt_europeodds_detail` VALUES (' . rtrim(str_repeat('?,', 8), ',') . ')';

        if ($stmt = $mysqli->prepare($euro_odds_sql)) {

            foreach ($euro_odds_info as $value) {

                //插入标签，用于判断是否插入
                $tag = false;

                //如果变化表中有记录，则做判断，如果不同，则插入到变化表中，否则不插入
                if (isset($last)) {
                    $index = $value[0] . '-' . $value[1] . '-' . $value[2] . '-' . $value[3];

                    if (! in_array($index, $last)) {
                        $tag = true;
                    }
                } else {
                    $tag = true;
                }

                if ($tag) {
                    $stmt->bind_param('iidddddi',
                        $value[0],      //比赛ID
                        $value[1],      //公司ID
                        $value[2],      //即时盘主胜赔率
                        $value[3],      //即时盘客胜赔率
                        $value[4],      //即时盘主胜率
                        $value[5],      //即时盘客胜率
                        $value[6],      //即时盘返回率
                        $value[7]       //赔率更新时间
                    );

                    $stmt->execute();
                }
            }

            unset($last);
            $stmt->close();
        }
    }

    //大小总分
    if (count($total_score_info)) {

        if (isset($schedule_ids['total_score']) && isset($company_ids['total_score'])) {
            //大小总分最新记录
            $last_data_sql = 'SELECT * FROM `bt_totalscore_detail` WHERE `type`=' . $type . ' AND `scheduleid` IN (' . join(',', $schedule_ids['total_score']) . ') AND `companyid` IN (' . join(',', $company_ids['total_score']) . ') ORDER BY `modifytime` DESC';

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
        }

        $total_score_sql = 'REPLACE INTO `bt_totalscore_detail` VALUES (' . rtrim(str_repeat('?,', 7), ',') . ')';

        if ($stmt = $mysqli->prepare($total_score_sql)) {

            foreach ($total_score_info as $value) {

                //插入标签，用于判断是否插入
                $tag = false;

                //如果变化表中有记录，则做判断，如果不同，则插入到变化表中，否则不插入
                if (isset($last)) {
                    $index = $value[0] . '-' . $value[1] . '-' . $value[2] . '-' . $value[3] . '-' . $value[4];

                    if (! in_array($index, $last)) {
                        $tag = true;
                    }
                } else {
                    $tag = true;
                }

                if ($tag) {
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
            }

            unset($last);
            $stmt->close();
        }
    }

} else {
    //TODO
}

$mysqli->close();
