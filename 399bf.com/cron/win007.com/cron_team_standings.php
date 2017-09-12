<?php
//球队积分排名

require_once 'global.func.php';
require_once 'conn.php';

//联赛id
$sclass = $mysqli->query('SELECT `sclassid` FROM bt_sclass;');
$sclass_ids = array_column($sclass->fetch_all(MYSQLI_ASSOC), 'sclassid');

if (count($sclass_ids)) {

    foreach ($sclass_ids as $id) {
        //从球探网获取数据
        $method = 'method=lqrankings&p1=' . $id;
        $data = http_get(PROXY_URL . $method, 3);

        if ($data->getName() == 'list') {

            $sql = 'REPLACE INTO `bt_team_standings` VALUES (' . rtrim(str_repeat('?,', 20), ',') . ')';

            if ($stmt = $mysqli->prepare($sql)) {

                foreach ($data->children() as $value) {
                    $stmt->bind_param('isissiiiid' . str_repeat('i', 10),
                        $value->TeamID,             //球队ID
                        $value->Name,               //球队名
                        $id,                        //联赛ID
                        $value->matchSeason,        //赛季
                        $value->league,             //所在联盟
                        $value->homewin,            //主场战胜的总场数
                        $value->homeloss,           //主场战败场数
                        $value->awaywin,            //客场战胜的总场数
                        $value->awayloss,           //客场战败场数
                        $value->WinScale,           //胜率
                        $value->state,              //连胜场数，负数表示连败
                        $value->homeOrder,          //主场联盟排名
                        $value->awayOrder,          //客场联盟排名
                        $value->TotalOrder,         //联盟排名
                        $value->HomeScore,          //主场总得分
                        $value->HomeLossScore,      //主场总失分
                        $value->awayScore,          //客场总得分
                        $value->awayLossScore,      //客场总失分
                        $value->Near10Win,          //最近10场赢的场数
                        $value->Near10loss          //最近10场输的场数
                    );

                    $stmt->execute();
                }

                $stmt->close();
            } else {
                //TODO
            }
        }
    }
} else {
    //TODO
}

$mysqli->close();
