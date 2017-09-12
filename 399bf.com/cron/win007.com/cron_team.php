<?php
//球队

require_once 'global.func.php';
require_once 'conn.php';

//从球探网获取数据
$method = 'method=lqteam_xml';
$data = http_get(PROXY_URL . $method, 3);

if (count($data->children())) {

    $sql = "REPLACE INTO `bt_team` VALUES(" . rtrim(str_repeat('?,', 16), ',') . ")";

    if ($stmt = $mysqli->prepare($sql)) {

        foreach ($data->children() as $value) {
            $stmt->bind_param('iissssssiissiiis',
                $value->id,                 //球队id
                $value->lsID,               //所属联赛id
                $value->short,              //简称
                $value->gb,                 //简体名
                $value->big5,               //繁体名
                $value->en,                 //英文名
                $value->logo,               //队标
                $value->url,                //球队网址
                $value->LocationID,         //联盟id
                $value->MatchAddrID,        //分区id
                $value->City,               //所在城市
                $value->Gymnasium,          //球场
                $value->Capacity,           //可容纳人数
                $value->JoinYear,           //加入联盟年数
                $value->FirstTime,          //夺冠次数
                $value->Drillmaster         //教练名
            );

            $stmt->execute();
        }

        $stmt->close();
    } else {
        //TODO
    }
} else {
    //TODO
}

$mysqli->close();
