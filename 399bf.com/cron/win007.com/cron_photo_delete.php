<?php
//清理重复存储的图像

require_once 'global.func.php';
require_once 'conn.php';

if (!defined('ROOT_PATH')) define('ROOT_PATH', dirname(dirname(__DIR__)));
if (!defined('IMG_PATH')) define('IMG_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'statics' . DIRECTORY_SEPARATOR . 'images');
if (!defined('IMG_DOMAIN')) define('IMG_DOMAIN', 'http://nba.win007.com');
if (!defined('MD5_NOPIC')) define('MD5_NOPIC', md5_file(IMG_PATH . DIRECTORY_SEPARATOR . 'nopic.win007.com.gif'));
if (!defined('MD5_NOPHOTO')) define('MD5_NOPHOTO', md5_file(IMG_PATH . DIRECTORY_SEPARATOR . 'nophoto.win007.com.gif'));
if (!defined('BASKETBALL_PATH')) define('BASKETBALL_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'uploadfile' . DIRECTORY_SEPARATOR . 'win007.com' . DIRECTORY_SEPARATOR . 'basketball');

//需要清理的目录team、player
$dirArr = [
    'team' => BASKETBALL_PATH . DIRECTORY_SEPARATOR . 'team' . DIRECTORY_SEPARATOR . '*',
    'player' => BASKETBALL_PATH . DIRECTORY_SEPARATOR . 'player' . DIRECTORY_SEPARATOR . '*'
];

//清理nopic.jpg、nophoto.jpg
foreach ($dirArr as $dir) {
    foreach (glob($dir) as $file) {
        $md5File = md5_file($file);

        if (MD5_NOPIC == $md5File) {
            unlink($file);
            continue;
        }

        if (MD5_NOPHOTO == md5_file($file)) {
            unlink($file);
        }
    }
}

