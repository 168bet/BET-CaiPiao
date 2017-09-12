<?php
//代理ip
if (!defined('IP')) define('IP', 'www.399cm.com');
//代理地址
if (!defined('PROXY_URL')) define('PROXY_URL', 'http://' . IP . '/api/basketball_api.php?');

/**
 * http get 请求
 * @param string $proxy_url 代理地址
 * @param int $type 默认2(1xml数据;2解析到数组;)
 * @return array 返回的数据
 */
function http_get($proxy_url, $type = 2)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $proxy_url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $return = curl_exec($ch);
    curl_close($ch);
    switch ($type) {
        //返回xml数据
        case 1:
            return $return;
            break;
        //解析到数组
        case 2:
            $parser = xml_parser_create();
            xml_parse_into_struct($parser, $return, $values, $tags);
            xml_parser_free($parser);
            return array($tags, $values);
            break;
        //返回SimpleXML对象
        case 3:
            $xml = new SimpleXMLElement($return);
            return $xml;
            break;
        default:
            //TODO...
            break;
    }
}

/**
 * 任务日志(包括错误日志、成功日志、失败日志)
 * @param string $msg 信息
 * @param int $type 类别(0成功；1失败；2错误)
 */
function cron_log($msg, $type = 0)
{
    $wrap = IS_WIN ? "\n\r" : "\n";
    switch ($type) {
        //成功日志
        case 0:
            file_put_contents('cron_success.bt.log', date('Y/m/d H:i:s') . ' ' . $msg . $wrap, FILE_APPEND);
            break;
        //失败日志
        case 1:
            file_put_contents('cron_failed.bt.log', date('Y/m/d H:i:s') . ' ' . $msg . $wrap, FILE_APPEND);
            break;
        //错误日志
        case 2:
            file_put_contents('cron_error.bt.log', date('Y/m/d H:i:s') . ' ' . $msg . $wrap, FILE_APPEND);
            break;
        default:
            echo 'unknown type.';
    }
}

/**
 * 解决json_encode会将中文转为unicode编码的问题
 * @param mixed $data 需要编码的数据
 * @return string json编码后的字符串
 */
function jsonEncode($data)
{
    //php 5.4.0以后json_encode()提供JSON_UNESCAPED_UNICODE选项
    //使用该选项会以字面编码多字节 Unicode 字符
    if (PHP_VERSION >= '5.4.0') {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
        //5.4.0之前的版本对中文unicode码进行解码
    } else {
        return decodeUnicode(json_encode($data));
    }
}

/**
 * 对json_encode()生成的中文unicode码进行解码
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

/**
 * 格式化输出
 */
function dump($data, $exit = 1, $format = '<pre>')
{
    echo $format;
    var_dump($data);
    $exit && exit;
}

/**
 * 判断一个远程文件是否存在
 * @param string $url 远程文件URL
 * @return bool
 */
function remote_file_exists($url)
{
    return @file_get_contents($url, null, null, -1, 1) ? true : false;
}

/**
 * 去除小数点右侧无意义(在无精度要求的情况下)的零
 *
 * @param mixed $value
 * @return string 去除小数点右侧零后的字符串值
 */
function rtrim0($value)
{
    $result = trim(strval($value));
    if (preg_match('/^-?\d+?\.0+$/', $result)) {
        return preg_replace('/^(-?\d+?)\.0+$/','$1',$result);
    }
    if (preg_match('/^-?\d+?\.[0-9]+?0+$/', $result)) {
        return preg_replace('/^(-?\d+\.[0-9]+?)0+$/','$1',$result);
    }
    return $result;
}




