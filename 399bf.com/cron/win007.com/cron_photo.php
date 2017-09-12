<?php
//球探网球队LOGO、球员头像

require_once 'global.func.php';
require_once 'conn.php';

if (!defined('ROOT_PATH')) define('ROOT_PATH', dirname(dirname(__DIR__)));
if (!defined('IMG_PATH')) define('IMG_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'statics' . DIRECTORY_SEPARATOR . 'images');
if (!defined('IMG_DOMAIN')) define('IMG_DOMAIN', 'http://nba.win007.com');
if (!defined('MD5_NOPIC')) define('MD5_NOPIC', md5_file(IMG_PATH . DIRECTORY_SEPARATOR . 'nopic.win007.com.gif'));
if (!defined('MD5_NOPHOTO')) define('MD5_NOPHOTO', md5_file(IMG_PATH . DIRECTORY_SEPARATOR . 'nophoto.win007.com.gif'));

//球队ID
$sql['team'] = "SELECT `teamid` AS `id`,`logo` AS `img` FROM bt_team";

//球员ID
$sql['player'] = "SELECT `playerid` AS `id`,`photo` AS `img` FROM bt_player";

$infos = array();

foreach ($sql as $name => $value) {
    $rst = $mysqli->query($value);
    $infos[$name] = $rst->fetch_all(MYSQLI_ASSOC);
}

$mysqli->close();

//图片保存基础路径
$photo_path = ROOT_PATH . DIRECTORY_SEPARATOR . 'uploadfile' . DIRECTORY_SEPARATOR . 'win007.com' . DIRECTORY_SEPARATOR . 'basketball';

if (count($infos)) {
    foreach ($infos as $name => $info) {
        //保存路径
        $dir_path = $photo_path . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;

        if (!file_exists($dir_path)) {
            mkdir($dir_path, 0777, true);
        }

        foreach ($info as $value) {
            if (empty($value['img'])) {
                continue;
            }

            $url = IMG_DOMAIN . $value['img'];
            $filename = $dir_path . $value['id'] . '.jpg';

            if (!file_exists($filename)) {
                if (remote_file_exists($url)) {
                    $md5_file = md5_file($url);

                    if (MD5_NOPIC == $md5_file) {
                        continue;
                    }

                    if (MD5_NOPHOTO == $md5_file) {
                        continue;
                    }

                    file_put_contents($filename, file_get_contents($url));
                } else {
                    cron_log($url . ' not found.', 2);
                }
            }
        }
    }
}
