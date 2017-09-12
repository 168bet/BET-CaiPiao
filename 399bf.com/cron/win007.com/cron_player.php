<?php
//球员

require_once 'global.func.php';
require_once 'conn.php';

//从球探网获取数据
$method = 'method=lqplayer_xml';
$data = http_get(PROXY_URL . $method, 3);

if (count($data->children())) {

    $sql = "REPLACE INTO `bt_player` VALUES(" . rtrim(str_repeat('?,', 13), ',') . ")";

    if ($stmt = $mysqli->prepare($sql)) {

        foreach ($data->children() as $value) {

            //生日日期转换
            $birthday = isset($value->Birthday) ? strtotime($value->Birthday) : 0;

            $stmt->bind_param('iissssisiiisi',
                $value->id,                 //球员id
                $value->Number,             //球衣号码
                $value->Name_F,             //繁体姓名
                $value->Name_JS,            //简体姓名简称
                $value->Name_J,             //简体姓名全称
                $value->Name_E,             //英文名
                $value->TeamID,             //目前效力的球队ID号
                $value->Place,              //前锋/中锋/后卫
                $birthday,                  //出生年月日
                $value->Tallness,           //身高，cm为单位
                $value->Weight,             //体重，kg为单位
                $value->Photo,              //球员的照片存放地址
                $value->NbaAge              //在NBA的年资
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
