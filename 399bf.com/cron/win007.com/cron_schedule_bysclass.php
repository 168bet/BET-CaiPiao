<?php
//赛程赛果
//按联赛获取比赛

require_once 'global.func.php';
require_once 'conn.php';

$sql    = "SELECT `sclassid` FROM `bt_sclass`";
$result = $mysqli->query($sql);

$paramCount = 44;
$sql        = "REPLACE INTO `bt_schedule` VALUES(" . rtrim(str_repeat('?,', $paramCount), ',') . ")";

if ($stmt = $mysqli->prepare($sql)) {
    while ($row = $result->fetch_assoc()) {
        $sClassID = $row['sclassid'];
        $method   = 'method=lqschedule&p1=&p2=' . $sClassID;

        list($tags, $values) = http_get(PROXY_URL . $method);

        if (isset($tags['H'])) {
            foreach ($tags['H'] as $validId) {
                if (!isset($values[$validId]['value']) || empty($values[$validId]['value'])) {
                    continue;
                }

                $data = $values[$validId]['value'];

                if (strpos($data, '^') === false) {
                    continue;
                }

                $array = explode('^', $data);

                if (strpos($array[3], ',') === false) {
                    continue;
                }

                if (strpos($array[10], ',') === false) {
                    continue;
                }

                if (strpos($array[12], ',') === false) {
                    continue;
                }

                $sClassNameArr = explode(',', $array[3]);
                $homeNameArr   = explode(',', $array[10]);
                $guestNameArr  = explode(',', $array[12]);
                $matchTime     = strtotime($array[6]);

                if ($array[32] === 'True') {
                    $isTechnique = 1;
                } else {
                    $isTechnique = 0;
                }

                foreach ([15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31] as $value) {
                    if ($array[$value] === '') {
                        $array[$value] = 0;
                    }
                }

                $catArray  = ['季前赛' => 1, '常规赛' => 2, '季后赛' => 3];
                $array[37] = isset($catArray[$array[37]]) ? $catArray[$array[37]] : 0;

                $stmt->bind_param(str_repeat('s', $paramCount),
                    $array[0], //0 ID      赛事ID
                    $array[1],//1 赛事类型ID（联赛/杯赛ID）
                    $array[2],//2 类型： 1联赛，2杯赛
                    $sClassNameArr[0],//3 联赛名，例如 NBA，WNBA，简体名与繁体名
                    $sClassNameArr[1],//3 联赛名，例如 NBA，WNBA，简体名与繁体名

                    $array[4],//4 分几节进行，2:上下半场，4：分4小节
                    $array[5], //5 颜色值
                    $matchTime, //6 开赛时间
                    $array[7], //7 状态:0:未开赛,1:一节,2:二节,5:1'OT，以此类推，-1:完场, -2:待定,-3:中断,-4:取消,-5:推迟,50中场
                    $array[8], //8 小节剩余时间
                    $array[9], //9 主队ID
                    $homeNameArr[0], //10 主队名，简繁
                    $homeNameArr[1], //10 主队名，简繁

                    $array[11], //11 客队ID
                    $guestNameArr[0], //12 客队名，简繁
                    $guestNameArr[1], //12 客队名，简繁

                    $array[13], //13 主队排名
                    $array[14], //14 客队排名
                    $array[15], //15 主队得分
                    $array[16], //16 客队得分
                    $array[17], //17 主队一节得分(上半场)
                    $array[18], //18 客队一节得分（上半场）
                    $array[19], //19 主队二节得分
                    $array[20], //20 客队二节得分
                    $array[21], //21 主队三节得分(下半场）
                    $array[22], //22 客队三节得分(下半场）
                    $array[23], //23 主队四节得分
                    $array[24], //24 客队四节得分
                    $array[25], //25 加时数 ，即几个加时
                    $array[26], //26 主队1'ot得分
                    $array[27], //27 客队1'ot得分
                    $array[28], //28 主队2'ot得分
                    $array[29], //29 客队2'ot得分
                    $array[30], //30 主队3'ot得分
                    $array[31], //31 客队3'ot得分

                    $isTechnique, //32 是否有技术统计

                    $array[33], //33 电视直播
                    $array[34], //34 备注，直播内容
                    $array[35], //35 中立场：1表示中立场
                    $array[36], //36 赛季，如11 赛季，11 - 12 赛季
                    $array[37], //37 类型，如季前赛，常规赛，季后赛 联赛阶段
                    $array[38], //38 比赛场所
                    $array[39], //39 比赛分类，例如第一圈，只有杯赛或季后赛才有数据
                    $array[40] //40 比赛子分类，例如A组，只有杯赛才有数据
                );

                if ($stmt->execute() === false) {
                    cron_log(sprintf('file[%s] ERROR %s [%s] %s', 'cron_schedule_byclass', $stmt->errno, $stmt->sqlstate, $stmt->error), 2);
                    continue;
                }
            }
        }
    }

    $stmt->close();
}


unset($tags, $values);
$mysqli->close();


/**
 * @desc 添加参数至模板
 * @param            $stmt
 * @param array      $array
 * @param int|string $paramCount
 * @return mixed
 */
function sqlExecute($stmt, array $array, $paramCount, $fileName = '') {
    $refs = [];

    foreach ($array as $key => $noUse) {
        $refs[$key] = &$array[$key];
    }

    $param = array_merge((array)str_repeat('s', $paramCount), $refs);
    call_user_func_array(array($stmt, 'bind_param'), $param);
    unset($refs, $array);

    if ($stmt->execute() === false) {
        cron_log(sprintf('file[%s] ERROR %s [%s] %s', $fileName, $stmt->errno, $stmt->sqlstate, $stmt->error), 2);
        return false;
    }

    return true;
}