<?php
// 重庆时时彩
require_once 'global.func.php';
require_once 'conn.php';

$tbName = 'cp_cqssc';
$method = 'name=cqssc';
$values = http_get(API_URL . '&' . $method);

if (empty($values) || !is_array($values)) {
    return false;
}

$lastKey = 0;

foreach ($values as $key => $value) {
    $number    = $value['number'];
    $numberArr = explode(',', $number);

    if (!isset($values[$lastKey])) {
        $lastKey = $key;
        continue;
    }

    $lastValue     = $values[$lastKey];
    $lastNumber    = $lastValue['number'];
    $lastNumberArr = explode(',', $lastNumber);
    $minusArr      = [];
    $count         = count($numberArr);

    for ($i = 0; $i < $count; ++$i) {
        $minusArr[] = $lastNumberArr[$i] - $numberArr[$i];
    }

    $sum      = floor(array_sum($lastNumberArr) / $count) - floor(array_sum($numberArr) / $count);
    $dataArr  = [$lastKey, $lastNumber, strtotime($lastValue['dateline'])];
    $return[] = array_merge($dataArr, $lastNumberArr, $minusArr, (array)$sum);
    $lastKey  = $key;
    unset($dataArr);
}

sqlReplace($mysqli, $tbName, $return);

function sqlReplace($mysqli, $tbName, $array) {
    if (empty($array)) {
        return false;
    }

    $str = '';

    foreach ($array as $key => $item) {
        $str .= '(';

        foreach ($item as $value) {
            $str .= "'" . $value . "',";
        }

        $str = rtrim($str, ',');
        $str .= '),';
    }

    $sql = "REPLACE INTO `" . $tbName . "` VALUES " . rtrim($str, ',');

    return $mysqli->query($sql);
}
