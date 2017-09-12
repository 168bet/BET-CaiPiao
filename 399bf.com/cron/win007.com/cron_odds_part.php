<?php
//小节赔率
require_once 'global.func.php';
require_once 'conn.php';

if (!defined('DATA_FIELDS_COUNT')) define('DATA_FIELDS_COUNT', 14);  //每条记录的字段数

$fieldsArray = [
    'bt_letgoal_detail' => '`letgoal`,`homeodds`,`guestodds`',
    'bt_totalscore_detail' => '`totalscore`,`highodds`,`lowodds`'
];

$method = 'method=partodds';
$retval = http_get(PROXY_URL . $method, 1);

if (empty($retval)) {
    return false;
}

if (strpos($retval, '$') === false) {
    return false;
}

$sectionArray = explode('$', $retval);

if (empty($sectionArray[0]) && empty($sectionArray[1])) {
    return false;
}

foreach ($sectionArray as $sectionId => $section) {
    if ($section) {
        switch ($sectionId) {
            //第一部分 让分小节赔率
            case 0:
                doSectionTask($section, 'bt_letgoal_detail');
                break;
            //第二部分 大小(总分)小节赔率
            case 1:
                doSectionTask($section, 'bt_totalscore_detail');
                break;
            default:
                break;
        }
    }
}

unset($tags, $values);
$mysqli->close();

/**
 * @decs  获取表字段数
 * @param         $mysqli
 * @param string $tbName
 * @param string $dbName
 * @return int
 */
function getParamCount($mysqli, $tbName, $dbName = 'win007.com')
{
    $sql = "SELECT count(1) from information_schema.columns WHERE table_schema='" . $dbName . "' and table_name='" . $tbName . "'";;
    $result = $mysqli->query($sql);
    return (int)$result->fetch_row()[0];
}

/**
 * @desc 生成模板参数
 * @param $array
 * @param $paramCount
 * @return array
 */
function getParam(array $array, $paramCount)
{
    if ((int)$paramCount <= 0) {
        throw new Exception('invalid ParamCount');
    }

    $refs = [];

    foreach ($array as $key => $value) {
        $refs[$key] = &$array[$key];
    }

    return array_merge((array)str_repeat('s', $paramCount), $refs);
}

/**
 * 处理每个部分的数据
 * @param string $section
 * @param string $tbName
 * @return void
 */
function doSectionTask($section, $tbName)
{
    $recordArray = explode(';', trim($section, ';'));

    if (count($recordArray)) {
        $insertArray = getInsertRecord($recordArray, $tbName);
        insertRecord((array)$insertArray, $tbName);
    }
}

/**
 * 写入表
 * @param array $insertRecordArray
 * @param string $tbName
 * @return bool
 * @throws Exception
 */
function insertRecord(array $insertRecordArray, $tbName)
{
    if (empty($insertRecordArray) || empty($tbName)) {
        return false;
    }

    $paramCount = getParamCount($GLOBALS['mysqli'], $tbName);

    if ($paramCount <= 0) {
        return false;
    }

    $sql = "REPLACE INTO `" . $tbName . "` VALUES(" . rtrim(str_repeat('?,', $paramCount), ',') . ")";

    if ($stmt = $GLOBALS['mysqli']->prepare($sql)) {
        foreach ($insertRecordArray as $record) {
            if ($paramCount != count($record)) {
                continue;
            }

            call_user_func_array(array($stmt, 'bind_param'), getParam($record, $paramCount));
            $stmt->execute();
        }

        $stmt->close();
    }

}

/**
 * 获取待写入表中的数据
 * @param array $recordArray
 * @param string $tbName
 * @return array|bool
 */
function getInsertRecord(array $recordArray, $tbName)
{
    if (empty($recordArray)) {
        return false;
    }

    $insertArray = [];

    foreach ($recordArray as $record) {
        if (strpos($record, ',') === false) {
            continue;
        }

        $array = explode(',', $record);

        if (DATA_FIELDS_COUNT != count($array)) {
            continue;
        }

        $scheduleId = $array[0];
        $companyId = $array[1];

        $typeArray = [1, 2, 4, 5];      //第1节、第2节、第3节、第4节
        $handicapKey = 2;               //盘口数据对应索引

        foreach ($typeArray as $type) {
            $handicap = $array[$handicapKey];
            $oddsOne = $array[$handicapKey + 1];
            $oddsTwo = $array[$handicapKey + 2];

            if ($oddsOne && $oddsTwo) {
                $lastRecord = getLastRecord($scheduleId, $companyId, $type, $tbName);
                $newRecord = [$handicap, $oddsOne, $oddsTwo];

                if (!$lastRecord) {
                    $insertArray[] = [$scheduleId, $companyId, $handicap, $oddsOne, $oddsTwo, $type, SYS_TIME];
                }

                if (!isSameRecord((array)$lastRecord, $newRecord)) {
                    $insertArray[] = [$scheduleId, $companyId, $handicap, $oddsOne, $oddsTwo, $type, SYS_TIME];
                }
            }

            $handicapKey += 3;
        }

        unset($array);
    }

    return $insertArray;
}

/**
 * 获取最新赔率记录
 * @param int $scheduleId 比赛ID
 * @param int $companyId 公司ID
 * @param int $type 赔率种类(1第一节；2第二节；4第三节；5第四节；)
 * @param string $tbName 表名
 * @return bool|array
 */
function getLastRecord($scheduleId, $companyId, $type, $tbName)
{
    if (empty($scheduleId) || empty($companyId) || empty($type) || empty($tbName)) {
        return false;
    }

    global $fieldsArray;

    $sql = "SELECT " . $fieldsArray[$tbName] . " FROM $tbName WHERE `scheduleid`='$scheduleId' AND `companyid`='$companyId' AND `type`='$type' ORDER BY `modifytime` DESC LIMIT 1";
    $rst = $GLOBALS['mysqli']->query($sql);

    if (empty($lastRecord = $rst->fetch_row())) {
        return false;
    }

    return $lastRecord;
}

/**
 * 判断是否与最新赔率相同
 * @param array $lastRecord 最新赔率
 * @param array $newRecord 待比较的赔率
 * @return bool
 */
function isSameRecord(array $lastRecord, array $newRecord)
{
    if (empty($lastRecord)) {
        return false;
    }

    if (empty($newRecord)) {
        return true;
    }

    $isSame = true;

    foreach ($lastRecord as $key => $lastValue) {
        if ($lastValue != $newRecord[$key]) {
            $isSame = false;
            break;
        }
    }

    return $isSame;
}

