<?php
//代理ip
if (!defined('IP')) define('IP', 'www.399cm.com');

/**
 * 获取 proxy url
 *
 * @return string proxy url
 */
function proxy_url()
{
    $proxy_url = 'http://' . IP . '/api/football_api.php?';
    return $proxy_url;
}

/**
 * http get 请求
 *
 * @param string $proxy_url 代理地址
 * @return array 返回的数据
 */
function http_get($proxy_url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $proxy_url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $return = curl_exec($ch);
    curl_close($ch);
    return json_decode($return, true);
}

/**
 * 任务日志(包括错误日志、成功日志、失败日志)
 *
 * @param string $msg 信息
 * @param int $type 类别(0成功；1失败；2错误)
 */
function cron_log($msg, $type = 0)
{
    $wrap = IS_WIN ? "\n\r" : "\n";
    switch($type){
        //成功日志
        case 0:
            file_put_contents('cron_success.log', date('Y/m/d H:i:s').
                ' '.$msg.$wrap, FILE_APPEND);
            break;
        //失败日志
        case 1:
            file_put_contents('cron_failed.log', date('Y/m/d H:i:s').
                ' '.$msg.$wrap, FILE_APPEND);
            break;
        //错误日志
        case 2:
            file_put_contents('cron_error.log', date('Y/m/d H:i:s').
                ' '.$msg.$wrap, FILE_APPEND);
            break;
        default:
            echo 'unknown type.';
    }
}

/**
 * 解决json_encode会将中文转为unicode编码的问题
 *
 * @param mixed $data 需要编码的数据
 * @return string json编码后的字符串
 */
function jsonEncode($data)
{
    // php 5.4.0以后json_encode()提供JSON_UNESCAPED_UNICODE选项
    // 使用该选项会以字面编码多字节 Unicode 字符
    if (PHP_VERSION >= '5.4.0')
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    // 5.4.0之前的版本对中文unicode码进行解码
    else
    {
        return decodeUnicode(json_encode($data));
    }
}

/**
 * 对json_encode()生成的中文unicode码进行解码
 *
 * @param string $str json字符串
 * @return string unicode解码后的json字符串
 */
function decodeUnicode($str)
{
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);
}

/*
 * 测试输出函数
 * @author lxt
 * @date 2016.05.18
 */
function dump($data, $exit = 1, $format = '<pre>')
{
    echo $format;
    var_dump($data);
    if ($exit) {
        exit;
    }
}

/**
 * 判断一个远程文件是否存在
 *
 * @param string $url 远程文件URL
 * @return bool
 */
function remote_file_exists($url)
{
    return @file_get_contents($url, null, null, -1, 1) ? true : false;
}

/**
 * 亚指公司与欧指公司的映射关系
 * 1、亚指公司编号映射到欧指公司编号
 * 2、亚指公司Mansion88暂未提供对应欧指公司
 *
 * @return array 映射数组
 */
function asia2euro()
{
    return array(
        3000271 => 1,       //10Bet
        3000471 => 117,     //12BET
        3000343 => 253,     //188Bet
        3000181 => 17,      //Bet365
        3000068 => 254,     //Ladbrokes
        3000248 => 250,     //Macauslot
        3000379 => 251,     //Mansion88
        3000368 => 172,     //SBOBET
        3000048 => 256,     //Victor Chandler
        3000021 => 255,     //William Hill
        3000390 => 257,     //YSB 88
        400000 => 308       //S2
    );
}

/**
 * 重要赛事
 * 包括：英超 西甲 意甲 德甲 法甲 欧冠 中超 亚冠
 */
function key_competitions()
{
   return array(92, 85, 34, 39, 93, 74, 152, 139);
}



