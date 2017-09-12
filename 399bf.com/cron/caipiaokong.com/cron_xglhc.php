<?php
//香港开奖

require_once "conn.php";
require_once "global.func.php";

$method = '&name=xglhc&num=50';
$json_data = http_get(API_URL . $method);

$table_name = 'cp_xglhc';
$param_count = getParamCount($mysqli, $table_name);

if ($param_count <= 0) {
    return false;
}

if (is_array($json_data) && count($json_data)) {

    $data = array();
    foreach ($json_data as $key => $value) {
        $row = array();
        $numbers = explode(',', $value['number']);
        $row['id'] = $key;
        $row['numbers'] = $value['number'];
        $row['uptime'] = strtotime($value['dateline']);

        foreach ($numbers as $index => $num) {
            $row['n' . ($index + 1)] = $num;
        }

        $data[] = $row;
    }

    if (count($data)) {
        $sql = 'REPLACE INTO `' . $table_name . '` VALUES (' . rtrim(str_repeat('?,', $param_count), ',') . ')';

        if ($stmt = $mysqli->prepare($sql)) {

            foreach ($data as $key => &$value) {

                //如果没有下条数据，则从数据库中查找小于本期的最新记录做比较
                if (isset($data[$key + 1])) {
                    $next = $data[$key + 1];
                } else {
                    $last = $mysqli->query('SELECT * FROM `' . $table_name . '` WHERE `id`<' . $value['id'] . ' ORDER BY `id` DESC LIMIT 1');
                    $next = $last->fetch_array(MYSQLI_ASSOC);
                }

                //比较升平降
                $compare_item = array(
                    'diff1' => 'n1',
                    'diff2' => 'n2',
                    'diff3' => 'n3',
                    'diff4' => 'n4',
                    'diff5' => 'n5',
                    'diff6' => 'n6',
                    'diff7' => 'n7'
                );

                foreach ($compare_item as $index => $item) {
                    $value[$index] = is_array($next) ? $value[$item] - $next[$item] : 0;
                }

                //插入数据
                sqlExecute($stmt, $value, $param_count, basename(__FILE__));
            }

            $stmt->close();
        } else{
            //TODO
        }
    }
} else {
    //TODO
}

$mysqli->close();


