<?php
//联赛、赛事类型

require_once 'global.func.php';
require_once 'conn.php';

//从球探网获取数据
$method = 'method=lqleague_xml';
list($tags, $values) = http_get(PROXY_URL . $method);

if (isset($tags['MATCH'])) {
    $sql = "REPLACE INTO `bt_sclass` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if ($stmt = $mysqli->prepare($sql)) {
        foreach ($tags['ID'] as $key => $value) {
            $color = strtoupper($values[$tags['COLOR'][$key]]['value']);
            $curr_year = isset($values[$tags['CURR_YEAR'][$key]]['value']) ? $values[$tags['CURR_YEAR'][$key]]['value'] : '';
            $curr_month = isset($values[$tags['CURR_MONTH'][$key]]['value']) ? $values[$tags['CURR_MONTH'][$key]]['value'] : '';
            $stmt->bind_param('ssssssssssssss',
                $values[$tags['ID'][$key]]['value'],                //联赛ID
                $color,                                             //颜色值
                $values[$tags['SHORT'][$key]]['value'],             //简称
                $values[$tags['GB'][$key]]['value'],                //简体全称
                $values[$tags['BIG'][$key]]['value'],               //繁体全称
                $values[$tags['EN'][$key]]['value'],                //英文全称
                $values[$tags['TYPE'][$key]]['value'],              //比赛分几节
                $values[$tags['CURR_MATCHSEASON'][$key]]['value'],  //当前赛事
                $values[$tags['COUNTRYID'][$key]]['value'],         //国家ID
                $values[$tags['COUNTRY'][$key]]['value'],           //国家名
                $curr_year,                                         //当前年份
                $curr_month,                                        //当前月份
                $values[$tags['SCLASS_KIND'][$key]]['value'],       //类型，1联赛2杯赛
                $values[$tags['SCLASS_TIME'][$key]]['value']        //1节打几分钟
            );
            $stmt->execute();
        }
        unset($tags, $values);
        $stmt->close();
    } else {
        //TODO
    }
} else {
    //TODO
}

$mysqli->close();
