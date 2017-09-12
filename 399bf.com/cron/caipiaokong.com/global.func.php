<?php
//API地址
if (!defined('API_URL')) define('API_URL', 'http://api.caipiaokong.com/lottery/?format=json&uid=657370&token=9e4d7930681a28879a9c911d964cb96e0f804339');

/**
 * http get 请求
 * @param string $api_url API地址
 * @return array 返回的数据
 */
function http_get($api_url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $return = curl_exec($ch);
    curl_close($ch);
    return json_decode($return, true);
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
            file_put_contents('cron_success.cp.log', date('Y/m/d H:i:s') . ' ' . $msg . $wrap, FILE_APPEND);
            break;
        //失败日志
        case 1:
            file_put_contents('cron_failed.cp.log', date('Y/m/d H:i:s') . ' ' . $msg . $wrap, FILE_APPEND);
            break;
        //错误日志
        case 2:
            file_put_contents('cron_error.cp.log', date('Y/m/d H:i:s') . ' ' . $msg . $wrap, FILE_APPEND);
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

/**
 * @desc 添加参数至模板
 * @param            $stmt
 * @param array      $array
 * @param int|string $paramCount
 * @return mixed
 */
function sqlExecute($stmt, array $array, $paramCount, $fileName='') {
    $refs = [];

    foreach ($array as $key => $noUse) {
        $refs[$key] = &$array[$key];
    }

    $param = array_merge((array)str_repeat('s', $paramCount), $refs);
    call_user_func_array(array($stmt, 'bind_param'), $param);
    unset($refs, $array);

    if ($stmt->execute() === false) {
        cron_log(sprintf('file[%s] ERROR %s [%s] %s', $fileName, $stmt->errno, $stmt->sqlstate, $stmt->error), 2);
        return false;
    }

    return true;
}

/**
 * @decs  获取表字段数
 * @param         $mysqli
 * @param string  $tbName
 * @param string  $dbName
 * @return int
 */
function getParamCount($mysqli, $tbName, $dbName = 'caipiaokong.com') {
    $sql = "SELECT count(1) from information_schema.columns WHERE table_schema='" . $dbName . "' and table_name='" . $tbName . "'";;
    $result = $mysqli->query($sql);

    return (int)$result->fetch_row()[0];
}



