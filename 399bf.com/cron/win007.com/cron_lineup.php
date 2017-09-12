<?php
//阵容、伤停、心水推荐、赛前简报
require_once 'global.func.php';
require_once 'conn.php';

// 获取表字段数
$tbName     = 'bt_lineup';
$paramCount = getParamCount($mysqli, $tbName);

if ($paramCount <= 0) {
    return false;
}

$sql = "REPLACE INTO `bt_lineup` VALUES(" . rtrim(str_repeat('?,', $paramCount), ',') . ")";

if ($stmt = $mysqli->prepare($sql)) {
    $method = 'method=lineup';
    list($tags, $values) = http_get(PROXY_URL . $method);

    if (isset($tags['ID'])) {
        $refs    = $array = [];
        $xmlTags = getXmlTags($tags, ['LIST', 'MATCH']);

        foreach ($tags['ID'] as $key => $val) {
            foreach ($xmlTags as $xmlTag) {
                if (!isset($tags[$xmlTag])) {
                    $array[] = '';
                    continue;
                }

                $dataArray = $values[$tags[$xmlTag][$key]];

                if (isset($dataArray['value'])) {
                    $tmp = $dataArray['value'];

                    if (strpos($tmp, '<table') !== false) {
                        $array[] = getDataByHtml($tmp);
                        //} elseif (strpos($tmp, '<font') !== false) {
                        //    $array[] = strip_tags($tmp);
                    } else {
                        $array[] = $tmp;
                    }
                } else {
                    $array[] = '';
                }
            }
            
            sqlExecute($stmt, $array, $paramCount, 'cron_lineup.php');
            unset($refs, $array);
        }
    }

    $stmt->close();
}

unset($tags, $values);
$mysqli->close();

function getDataByHtml($html) {
    if (!is_string($html)) {
        return '';
    }

    $return = $trArray = [];
    $htmDoc = new DOMDocument;
    $htmDoc->loadHTML('<?xml encoding="utf-8"?>' . $html);
    $htmDoc->normalizeDocument();
    $tableList = $htmDoc->getElementsByTagName('table');

    foreach ($tableList as $table) {
        $trList = $table->getElementsByTagName('tr');

        foreach ($trList as $tr) {
            $tdList = $tr->getElementsByTagName('td');

            foreach ($tdList as $td) {
                $trArray[] = $td->nodeValue;
            }

            $return[] = $trArray;
            unset($trArray);
        }
    }

    return jsonEncode($return);
}

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
    return array_diff(array_keys($tags), $filterArray);
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
