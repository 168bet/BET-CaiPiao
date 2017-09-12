<?php
//文字直播
//获取正在进行的比赛
require_once 'global.func.php';
require_once 'conn.php';

$starttime  = SYS_TIME - 1.5 * 60 * 60;
$tbName     = 'bt_textlive';
$paramCount = getParamCount($mysqli, $tbName);

if ($paramCount <= 0) {
    return false;
}

$sql    = "SELECT `scheduleid` FROM `bt_live_schedule` WHERE `status` > 0 OR (`status` = '-1' AND `date` > $starttime)";
$result = $mysqli->query($sql);

$sql = "REPLACE INTO `" . $tbName . "` VALUES(" . rtrim(str_repeat('?,', $paramCount), ',') . ")";

if ($stmt = $mysqli->prepare($sql)) {
    while ($row = $result->fetch_assoc()) {
        $scheduleId    = $row['scheduleid'];
        $method        = 'method=textlive&p1=' . $scheduleId;
        $values        = http_get(PROXY_URL . $method, 1);
        $sectionsArray = $fieldsArray = $recordsArray = $refs = [];

        if ($values === '暂无数据') {
            $jsonData = '';
        } else {
            $jsonData = getJson($values);
        }

        $array = [$scheduleId, $jsonData];

        sqlExecute($stmt, $array, $paramCount, 'cron_textlive');
        unset($refs, $array, $sectionsArray);
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
 * @desc  key值映射为小节/加时
 * @param $key
 * @return mixed
 */
function keyToSection($key) {
    if ((int)$key < 0 || (int)$key > 6) {
        return $key;
    }

    $sections = [
        '第1节', '第2节', '第3节', '第4节', '第1加时', '第2加时', '第3加时',
    ];

    return $sections[$key];
}

/**
 * @desc 将字符串转为json数据
 * @param string $string
 * @return string
 */
function getJson($string) {
    if (strpos($string, '$') === false) {
        return '';
    }

    $sections      = explode('$', $string);
    $sectionsArray = $recordsArray = [];

    foreach ($sections as $key => $section) {
        if (strpos($section, '!') === false) { // 小节数据有误
            $sectionsArray[] = '';
        } else {
            $records = explode('!', rtrim($section, '!'));

            foreach ($records as $record) {
                if (strpos($record, '^') === false) { // 记录数据有误
                    $recordsArray[] = '';
                } else {
                    $recordsArray[] = explode('^', $record);
                }
            }

            $sectionKey                 = keyToSection($key);
            $sectionsArray[$sectionKey] = $recordsArray;
            unset($recordsArray);
        }
    }

    return jsonEncode($sectionsArray);
}

/**
 * @desc 添加参数至模板
 * @param            $stmt
 * @param array      $array
 * @param int|string $paramCount
 * @return mixed
 */
function sqlExecute($stmt, array $array, $paramCount, $fileName='') {
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