<?php
//球队、球员技术统计

require_once 'global.func.php';
require_once 'conn.php';

//即时比赛
$starttime  = SYS_TIME - 1.5 * 60 * 60;
$sql = "SELECT `scheduleid` FROM `bt_live_schedule` WHERE `istechnic` = '1' AND (`status` > 0 OR (`status` = '-1' AND `date` > $starttime))";
$schedule = $mysqli->query($sql);
$schedule_ids = array_column($schedule->fetch_all(MYSQLI_ASSOC), 'scheduleid');

if (count($schedule_ids)) {

    $team_data = $player_data = array();

    foreach ($schedule_ids as $id) {
        //从球探网获取数据
        $method = 'method=lqteahniccount&p1=' . $id;
        list($tag, $data) = http_get(PROXY_URL . $method);

        if (isset($tag['MATCH'])) {

            $team_info = $player_info = array();

            //主队信息
            $team_info['home'] = array(
                'scheduleid' => $id,
                'teamid' => $data[$tag['HOMETEAMID'][0]]['value'],
                'ishome' => 1,                                                                                              //主队必为主场
                'score' => isset($data[$tag['HOMESCORE'][0]]['value']) ? $data[$tag['HOMESCORE'][0]]['value'] : 0,
                'lossscore' => isset($data[$tag['GUESTSCORE'][0]]['value']) ? $data[$tag['GUESTSCORE'][0]]['value'] : 0,    //总失分为对手得分
                'fast' => isset($data[$tag['HOMEFAST'][0]]['value']) ? $data[$tag['HOMEFAST'][0]]['value'] : 0,
                'inside' => isset($data[$tag['HOMEINSIDE'][0]]['value']) ? $data[$tag['HOMEINSIDE'][0]]['value'] : 0,
                'exceed' => isset($data[$tag['HOMEEXCEED'][0]]['value']) ? $data[$tag['HOMEEXCEED'][0]]['value'] : 0,
                'twoattack' => isset($data[$tag['TWOATTACK'][0]]['value']) ? $data[$tag['TWOATTACK'][0]]['value'] : 0,
                'totalmis' => isset($data[$tag['TOTALMIS'][0]]['value']) ? $data[$tag['TOTALMIS'][0]]['value'] : 0,
                'playtime' => 0,
                'shoot' => 0,
                'shoot_hit' => 0,
                'threemin' => 0,
                'threemin_hit' => 0,
                'punishball' => 0,
                'punishball_hit' => 0,
                'attack' => 0,
                'defend' => 0,
                'helpattack' => 0,
                'rob' => 0,
                'cover' => 0,
                'misplay' => 0,
                'foul' => 0
            );

            //客队信息
            $team_info['away'] = array(
                'scheduleid' => $id,
                'teamid' => $data[$tag['GUESTTEAMID'][0]]['value'],
                'ishome' => 0,                                                                                                      //客队必不为主场
                'score' => isset($data[$tag['GUESTSCORE'][0]]['value']) ? $data[$tag['GUESTSCORE'][0]]['value'] : 0,
                'lossscore' => isset($data[$tag['HOMESCORE'][0]]['value']) ? $data[$tag['HOMESCORE'][0]]['value'] : 0,              //总失分为对手得分
                'fast' => isset($data[$tag['GUESTFAST'][0]]['value']) ? $data[$tag['GUESTFAST'][0]]['value'] : 0,
                'inside' => isset($data[$tag['GUESTINSIDE'][0]]['value']) ? $data[$tag['GUESTINSIDE'][0]]['value'] : 0,
                'exceed' => isset($data[$tag['GUESTEXCEED'][0]]['value']) ? $data[$tag['GUESTEXCEED'][0]]['value'] : 0,
                'twoattack' => isset($data[$tag['GUESTTWOATTACK'][0]]['value']) ? $data[$tag['GUESTTWOATTACK'][0]]['value'] : 0,
                'totalmis' => isset($data[$tag['GUESTTOTALMIS'][0]]['value']) ? $data[$tag['GUESTTOTALMIS'][0]]['value'] : 0,
                'playtime' => 0,
                'shoot' => 0,
                'shoot_hit' => 0,
                'threemin' => 0,
                'threemin_hit' => 0,
                'punishball' => 0,
                'punishball_hit' => 0,
                'attack' => 0,
                'defend' => 0,
                'helpattack' => 0,
                'rob' => 0,
                'cover' => 0,
                'misplay' => 0,
                'foul' => 0
            );

            if (isset($tag['HOMEPLAYERLIST']) && isset($tag['HOMEPLAYERLIST'][1])) {
                //每条球员数据需要整理的字段
                $field_list = array('PLAYERID', 'LOCATION', 'PLAYTIME', 'SHOOT_HIT', 'SHOOT', 'THREEMIN_HIT', 'THREEMIN', 'PUNISHBALL_HIT', 'PUNISHBALL', 'ATTACK', 'DEFEND', 'HELPATTACK', 'FOUL', 'ROB', 'MISPLAY', 'COVER', 'SCORE');

                //需要统计到球队中的数据
                $stat_field = array('PLAYTIME', 'SHOOT_HIT', 'SHOOT', 'THREEMIN_HIT', 'THREEMIN', 'PUNISHBALL_HIT', 'PUNISHBALL', 'ATTACK', 'DEFEND', 'HELPATTACK', 'FOUL', 'ROB', 'MISPLAY', 'COVER');

                foreach ($tag as $index => $row) {
                    if (in_array($index, $field_list)) {
                        foreach ($row as $key => $value) {
                            //如果索引的位置小于主队球员的关闭标签的话，则为主队球员数据
                            $type = $value < $tag['HOMEPLAYERLIST'][1] ? 'home' : 'away';

                            //填充数据
                            $player_info[$type][$key][strtolower($index)] = isset($data[$value]['value']) && $data[$value]['value'] ? $data[$value]['value'] : 0;
                            $player_info[$type][$key]['scheduleid'] = $id;
                            $player_info[$type][$key]['teamid'] = $team_info[$type]['teamid'];

                            //统计字段
                            if (in_array($index, $stat_field)) {
                                $team_info[$type][strtolower($index)] += $player_info[$type][$key][strtolower($index)];
                            }
                        }
                    }
                }

                foreach ($player_info as $list) {
                    foreach ($list as $row) {
                        $player_data[] = $row;
                    }
                }
            }

            $team_data[] = $team_info['home'];
            $team_data[] = $team_info['away'];
        }
    }

    //统一插入球队信息
    if (isset($team_data) && count($team_data)) {

        $team_sql = 'REPLACE INTO `bt_team_technic` VALUES(' . rtrim(str_repeat('?,', 24), ',') . ')';

        if ($stmt = $mysqli->prepare($team_sql)) {

            foreach ($team_data as $value) {
                $stmt->bind_param(str_repeat('i', 24),
                    $value['scheduleid'],           //比赛id
                    $value['teamid'],               //球队id
                    $value['ishome'],               //表示是主场还是客场
                    $value['score'],                //某场球赛总的得分
                    $value['lossscore'],            //某场球赛总的失分
                    $value['fast'],                 //某场球赛快攻得分
                    $value['inside'],               //某场球赛内线得分
                    $value['exceed'],               //某场球赛最多领先分数
                    $value['twoattack'],            //某场球赛两次进攻数
                    $value['totalmis'],             //某场球赛总失误数
                    $value['playtime'],             //某场球赛各球员总的上场时间
                    $value['shoot'],                //某场球赛投篮的个数
                    $value['shoot_hit'],            //某场球赛投篮的命中个数
                    $value['threemin'],             //某场球赛投三分球的个数
                    $value['threemin_hit'],         //某场球赛投三分球的命中个数
                    $value['punishball'],           //某场球赛罚球的个数
                    $value['punishball_hit'],       //某场球赛罚球的命中个数
                    $value['attack'],               //某场球赛进攻篮板的总数
                    $value['defend'],               //某场球赛防守篮板的总数
                    $value['helpattack'],           //某场球赛助攻篮板的总数
                    $value['rob'],                  //某场球赛抢断篮板的总数
                    $value['cover'],                //某场球赛篮板盖帽的总数
                    $value['misplay'],              //某场球赛失误的总数
                    $value['foul']                  //某场球赛犯规的总数
                );

                $stmt->execute();
            }

            $stmt->close();
        }
    }

    //统一插入球员信息
    if (isset($player_data) && count($player_data)) {

        $player_sql = 'REPLACE INTO `bt_player_technic` VALUES(' . rtrim(str_repeat('?,', 19), ',') . ')';

        if ($stmt = $mysqli->prepare($player_sql)) {

            foreach ($player_data as $value) {
                $stmt->bind_param('iiis' . str_repeat('i', 15),
                    $value['scheduleid'],           //比赛ID
                    $value['teamid'],               //球队ID
                    $value['playerid'],             //球员ID
                    $value['location'],             //首发的位置，并表明是否是首发
                    $value['playtime'],             //上场时间
                    $value['shoot'],                //投篮的个数
                    $value['shoot_hit'],            //投篮的命中个数
                    $value['threemin'],             //投三分球的个数
                    $value['threemin_hit'],         //投三分球的命中个数
                    $value['punishball'],           //罚球的个数
                    $value['punishball_hit'],       //罚球的命中个数
                    $value['attack'],               //进攻篮板的总数
                    $value['defend'],               //防守篮板的总数
                    $value['helpattack'],           //助攻篮板的总数
                    $value['rob'],                  //抢断篮板的总数
                    $value['cover'],                //篮板盖帽的总数
                    $value['misplay'],              //失误的总数
                    $value['foul'],                 //犯规的总数
                    $value['score']                 //总得分数
                );

                $stmt->execute();
            }

            $stmt->close();
        }
    }
}

$mysqli->close();
