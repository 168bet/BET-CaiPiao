<?php
// 篮球赔率接口
require_once 'global.func.php';
require_once 'conn.php';

// bt_letgoal 让分赔率 3-1
// bt_europeodds 欧赔（标准盘）4-1
// bt_totalscore 大小球
// bt_letgoal_detail 让分盘赔率数据变化表
// bt_europeodds_detail 欧盘赔率变化表
// bt_totalscore_detail 大小(总分)盘赔率数据变化表
$tbNameArray = [
    ['bt_letgoal', 'bt_letgoal_detail'],
    ['bt_europeodds', 'bt_europeodds_detail'],
    ['bt_totalscore', 'bt_totalscore_detail'],
];

$selectArray = [
    [2 => '`letgoal`', 3 => '`homeodds`', 4 => '`guestodds`'],
    [2 => '`homewin`', 3 => '`guestwin`'],
    [2 => '`totalscore`', 3 => '`highodds`', 4 => '`lowodds`'],
];

$method = 'method=lqodds';
$values = http_get(PROXY_URL . $method, 1);

if (empty($values)) {
    return false;
}

$goalArray = getDivisionData($values);

if (count($goalArray) !== 3) {
    return false;
}

foreach ($tbNameArray as $tbKey => $tbName) {
    $scheduleIdArr = array_column($goalArray[$tbKey], 0);
    $scheduleIdStr = implode(',', array_unique($scheduleIdArr));

    $fields = rtrim(implode(',', $selectArray[$tbKey]), ',');

    // 判断detail表中最后一条数据, 与获取的数据比对, 若不同, 则插入+更新
    if ($tbKey === 1) {
        $sql = "SELECT `scheduleid`,`companyid`," . $fields . " FROM " . $tbName[1] . " WHERE `scheduleid` in (" . $scheduleIdStr . ') ORDER BY modifytime DESC';
    } else {
        $sql = "SELECT `scheduleid`,`companyid`,`type`," . $fields . " FROM " . $tbName[1] . " WHERE `scheduleid` in (" . $scheduleIdStr . ') ORDER BY modifytime DESC';
    }

    $result = $mysqli->query($sql);

    if ($result === false) {
        throw new \Exception('sql语句有误');
    }

    while (!empty($dataArray = $result->fetch_row())) {
        $key = $dataArray[0] . '-' . $dataArray[1];

        if ($tbKey !== 1) {
            $key .= '-' . $dataArray[2];
        }

        $return[$key][] = $dataArray;
    }

    $return2 = [];
    if (!empty($return)) {
        foreach ($return as $key => $item) {
            if ($tbKey === 1) {
                unset($item[0][0], $item[0][1]);
            } else {
                unset($item[0][0], $item[0][1], $item[0][2]);
            }

            $dataArray     = array_merge($item[0]);
            $return2[$key] = $dataArray;
        }
    }

    $paramCount       = getParamCount($mysqli, $tbName[0]);
    $insertParamCount = getParamCount($mysqli, $tbName[1]);

    if ($paramCount <= 0 || $insertParamCount <= 0) {
        continue;
    }

    foreach ($goalArray[$tbKey] as $goalKey => $goalValue) {
        foreach ([9, 10] as $item) {
            if ($goalValue[$item] === '') {
                $goalValue[$item] = '0.000';
            }
        }

        if ($goalValue[8] === '') {
            $goalValue[8] = '0.00';
        }

        $goalValues[] = $goalValue;
    }

    // 修改全场表数据
    if (!empty($goalValues)) {
        sqlReplace($mysqli, $tbName[0], $goalValues);
        unset($goalValues);
    }

    $insertSql = "REPLACE INTO `" . $tbName[1] . "` VALUES(" . rtrim(str_repeat('?,', $insertParamCount), ',') . ")";

    foreach ($goalArray[$tbKey] as $goalKey => $goalValue) {
        $insertArrays = getHandleData($goalValue, $tbKey);

        if (empty($insertArrays)) {
            continue;
        }

        foreach ([6, 7] as $type) {
            if (!isset($insertArrays[$type])) {
                continue;
            }

            $insertArray = $insertArrays[$type]; // 接口来的数据

            $flag = 1; // 1-不插入 0-插入

            if ($tbKey !== 1) {
                $key = $insertArray[0] . '-' . $insertArray[1] . '-' . $insertArray[5];
            } else {
                $key = $insertArray[0] . '-' . $insertArray[1];
            }

            if (isset($return2[$key])) {
                $tmp       = $insertArray;   // 接口来的数据
                $dataArray = $return2[$key]; // 数据库中数据

                // 判断数据是否重复
                if ($tbKey === 1) { // 欧盘
                    unset($tmp[0], $tmp[1], $tmp[4], $tmp[5], $tmp[6], $tmp[7]);
                } else { // 大小分 让分
                    unset($tmp[0], $tmp[1], $tmp[5], $tmp[6]);
                }

                $tmp = array_merge($tmp);

                if ($tmp != $dataArray) {
                    $flag = 0;
                }
            } else {
                $flag = 0;
            }

            if ($flag === 0) {
                $valuesArr[] = $insertArray;
            }
        }
    }

    if (!empty($valuesArr)) {
        sqlReplace($mysqli, $tbName[1], $valuesArr);
        unset($valuesArr);
    }
}

unset($tags, $values);
$mysqli->close();

/**
 * @decs  获取表字段数
 * @param         $mysqli
 * @param string  $tbName
 * @param string  $dbName
 * @return int
 */
function getParamCount($mysqli, $tbName, $dbName = 'win007.com') {
    $sql = "SELECT count(1) from information_schema.columns WHERE table_schema='" . $dbName . "' and table_name='" . $tbName . "'";;
    $result = $mysqli->query($sql);
    return (int)$result->fetch_row()[0];
}

/**
 * @desc  取得tag有效标签
 * @param array $tags
 * @param array $filterArray 不需要的标签
 * @return array
 */
function getXmlTags(array $tags, array $filterArray) {
    return array_merge(array_diff(array_keys($tags), $filterArray));
}

/**
 * @desc 数据逻辑处理
 * @param $string
 * @param $tagKey
 */
function getGoalValue($string, $tagKey) {
    if ($tagKey === 1) {
        $typeArray = ['delete' => 2, 'modify' => 1];
        return isset($typeArray[$string]) ? $typeArray[$string] : 0;
    } elseif ($tagKey === 2 || $tagKey === 3) {
        return strtotime($string);
    }

    return $string;
}

/**
 * @desc 将字符串转为指定规则的数组
 * @param        $string
 * @param string $division1
 * @param string $division2
 * @param string $division3
 * @return string
 */
function getDivisionData($string, $division1 = '$', $division2 = ';', $division3 = ',') {
    if (strpos($string, $division1) === false) {
        return '';
    }

    $firstParts = explode($division1, $string);
    $return     = $secondPartsArray = [];

    if (count($firstParts) !== 5) {
        return '';
    }

    unset($firstParts[0], $firstParts[1]);

    foreach ($firstParts as $key => $firstPart) {
        if (strpos($firstPart, $division2) === false) {
            $return[] = '';
        } else {
            $secondParts = explode($division2, rtrim($firstPart, $division2));

            foreach ($secondParts as $secondKey => $secondPart) {
                if (strpos($secondPart, $division3) === false) {
                    $secondPartsArray[] = '';
                } else {
                    $secondPartsArray[] = addRateValue(explode($division3, $secondPart), $key);
                }
            }

            $return[] = $secondPartsArray;
            unset($secondPartsArray);
        }
    }

    return $return;
}

/**
 * @param array $array
 * @param       $key 0->让分 1->欧盘 2->大小分
 * @return array|string
 */
function getHandleData(array $array, $key) {
    if ($key === 0 || $key === 2) {
        $tmp = $array;

        if (!empty($tmp[8]) || !empty($tmp[9]) || !empty($tmp[10])) {
            unset($tmp[2], $tmp[3], $tmp[4], $tmp[5], $tmp[6], $tmp[7]);
            $time    = $tmp[11];
            $tmp[11] = 7;
            $tmp[12] = $time;
            ksort($tmp);
            $return[7] = array_merge($tmp);
        } else {
            unset($array[2], $array[3], $array[4], $array[8], $array[9], $array[10]);
            $array[10] = 6;
            ksort($array);
            $return[6] = array_merge($array);
        }

        return $return;
    } elseif ($key === 1) {
        unset($array[2], $array[3], $array[6], $array[7], $array[8]);
        return [6 => array_merge($array)];
    }

    return '';
}

/**
 * @desc 添加胜率/返回率信息
 * @param array $array
 * @param       $key
 * @return array|bool
 */
function addRateValue(array $array, $key) {
    $now = time();

    if ($key === 2) {
        return array_merge($array, (array)$now);
    } elseif ($key === 3) {
        $homeWinRate  = winRate($array[2], $array[3]); // 初盘主胜赔率/初盘客胜赔率    -> 初盘主胜率
        $fHomeWinRate = winRate($array[4], $array[5]); // 即时盘主胜赔率/即时盘客胜赔率 -> 即时盘主胜率
        $addArray     = [
            $homeWinRate,                         // 初盘主胜率
            winRate($array[3], $array[2]),        // 初盘客胜率  -> 初盘客胜赔率/初盘主胜赔率
            returnRate($homeWinRate, $array[2]),  // 初盘返回率
            $fHomeWinRate,                        // 即时盘主胜率
            winRate($array[5], $array[4]),        // 即时盘客胜率 -> 即时盘客胜赔率/即时盘主胜赔率
            returnRate($fHomeWinRate, $array[4]), // 即时盘返回率
            $now,
        ];
        return array_merge($array, $addArray);
    } elseif ($key === 4) {
        return array_merge($array, (array)$now);
    }

    return false;
}

/**
 * @desc 胜率
 * @param string $odds1
 * @param string $odds2
 * @return float
 */
function winRate($odds1, $odds2) {
    return (float)round(1 / (1 + $odds1 / $odds2) * 100, 2);
}

/**
 * @desc 返回率
 * @param string $winRate
 * @param string $odds
 * @return float
 */
function returnRate($winRate, $odds) {
    return (float)round($winRate * $odds, 2);
}

function sqlReplace($mysqli, $tbName, $array) {
    if (empty($array)) {
        return false;
    }

    $str = '';
    foreach ($array as $item) {
        $str .= '(' . implode(',', $item) . '),';
    }

    $sql = "REPLACE INTO `" . $tbName . "` VALUES " . rtrim($str, ',');

    return $mysqli->query($sql);
}