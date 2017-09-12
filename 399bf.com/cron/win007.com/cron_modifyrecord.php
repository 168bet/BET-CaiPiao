<?php
// 比赛删除，改时间记录
require_once 'global.func.php';
require_once 'conn.php';

$tbName     = 'bt_schedule_modify_record';
$paramCount = getParamCount($mysqli, $tbName);

if ($paramCount <= 0) {
    return false;
}

$sql = "REPLACE INTO `" . $tbName . "` VALUES(" . rtrim(str_repeat('?,', $paramCount), ',') . ")";

if ($stmt = $mysqli->prepare($sql)) {
    $method = 'method=lqmodifyrecord';
    list($tags, $values) = http_get(PROXY_URL . $method);
    $array   = [];
    $xmlTags = getXmlTags($tags, ['LIST', 'MATCH']);

    if (!isset($tags['ID'])) {
        return false;
    }

    foreach ($tags['ID'] as $key => $val) {
        foreach ($xmlTags as $tagKey => $xmlTag) {
            if (!isset($tags[$xmlTag])) {
                $array[] = '';
                continue;
            }

            $dataArray = $values[$tags[$xmlTag][$key]];

            if (isset($dataArray['value'])) {
                $array[] = getGoalValue($dataArray['value'], $tagKey);
            } else { // 可再此设置默认值
                $array[] = 0;
            }
        }

        sqlExecute($stmt, $array, $paramCount, 'cron_modifyrecord.php');
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