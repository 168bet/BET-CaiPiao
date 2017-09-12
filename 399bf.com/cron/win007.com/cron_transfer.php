<?php
//NBA转会记录
require_once 'global.func.php';
require_once 'conn.php';

$tbName     = 'bt_transfer_record';
$paramCount = getParamCount($mysqli, $tbName);

if ($paramCount <= 0) {
    return false;
}

$sql = "REPLACE INTO `" . $tbName . "` VALUES(" . rtrim(str_repeat('?,', $paramCount), ',') . ")";

if ($stmt = $mysqli->prepare($sql)) {
    $day = isset($argv[1]) ? $argv[1] : 0;

    if (empty($day)) {
        $method = 'method=transfer';
    } else {
        $method = 'method=transfer&p1=' . $day;
    }

    list($tags, $values) = http_get(PROXY_URL . $method);

    $array   = [];
    $xmlTags = [
        "PLAYERID", "TRANSFERTIME", "TEAMID", "TEAM", "TEAMNOWID", "TEAMNOW", "ZH_SEASON", "TYPE",
    ];

    if (!isset($tags['ID'])) {
        return false;
    }
    //var_dump($values);die();
    foreach ($tags['ID'] as $key => $val) {
        foreach ($xmlTags as $tagKey => $xmlTag) {
            if (!isset($tags[$xmlTag])) {
                $array[] = '';
                continue;
            }

            $dataArray = $values[$tags[$xmlTag][$key]];

            if (isset($dataArray['value'])) {
                //var_dump($dataArray['value'], $tagKey, getGoalValue($dataArray['value'], $tagKey));die();
                $array[] = getGoalValue($dataArray['value'], $tagKey);
            } else {
                if ($tagKey === 7) {
                    $array[] = 0;
                } else {
                    $array[] = '';
                }
            }
        }

        sqlExecute($stmt, $array, $paramCount, 'cron_transfer.php');
        unset($array);
    }
}

$stmt->close();
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
 * @desc 数据逻辑处理
 * @param $string
 * @param $tagKey
 */
function getGoalValue($string, $tagKey) {
    if (in_array($tagKey, [1, 2, 3, 4, 5])) {
        if ($string === false) {
            return '';
        }

        return $string;
    } elseif ($tagKey === 7) {

        $typeArray = ['交易' => 1, '续约' => 2, '解约' => 3, '自由签约' => 4, '选秀' => 5];
        return isset($typeArray[$string]) ? $typeArray[$string] : 0;
    }

    return $string;
}

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