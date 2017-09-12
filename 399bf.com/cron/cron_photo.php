<?php
//7m联赛、球队、球员图片定时任务

require_once 'global.func.php';
require_once 'conn.php';

//联赛编号
$sql['competition'] = "SELECT `competitionid` AS `id` FROM ft_competition;";

//球队编号
$sql['team'] = "SELECT `teamid` AS `id` FROM ft_team;";

//球员编号
$sql['player'] = "SELECT `playerid` AS `id` FROM ft_player;";

//国家编号
$sql['country'] = "SELECT DISTINCT `countryid` AS `id` FROM ft_event;";

$ids = array();

foreach ($sql as $name => $value) {
    $result = $mysqli->query($value);
    $ids[$name] = array_column($result->fetch_all(MYSQLI_ASSOC), 'id');
}

// 关闭mysql连接
$mysqli->close();

//7m图片地址
$urls = array(
    'competition' => 'http://data.7m.cn/matches_data/competition_id/match_logo.jpg',
    'team' => 'http://data.7m.cn/team_data/team_id/logo_Img/club_logo.jpg',
    'player' => 'http://data.7m.cn/player_data/player_id/logo_img/player_photo.jpg',
    'country' => 'http://data.7m.cn/database/icons/country_id.jpg'
);

//图片保存基础路径
$photo_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploadfile' . DIRECTORY_SEPARATOR . 'photo';

if (count($ids)) {
    foreach ($ids as $name => $value) {
        //7m基础地址
        $base_url = $urls[$name];
        //保存路径
        $dir_path = $photo_path . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
        if (! file_exists($dir_path)) {
            mkdir($dir_path, 0777, true);
        }
        foreach ($value as $id) {
            $url = str_replace($name . '_id', $id, $base_url);
            $file_name = $dir_path . $id . '.jpg';
            if (! file_exists($file_name)) {
                if (remote_file_exists($url)) {
                    file_put_contents($file_name, file_get_contents($url));
                } elseif(remote_file_exists(str_replace('.jpg', '.gif', $url))) {
                    file_put_contents($file_name, file_get_contents(str_replace('.jpg', '.gif', $url)));
                } else {
                    cron_log($url.'|gif都不存在', 2);
                }
            }
        }
    }
}
