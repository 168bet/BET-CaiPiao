<?php
/**
 *  extention.func.php 用户自定义函数库
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-10-27
 */

/**
 * 判断是否为ajax请求
 * @author lxt
 * @date 2016.04.12 
 * @return bool
 */
 function is_ajax()
 {
     return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest";
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
 * 文件形式调试代码
 *
 * @author  tangkh<tangkh@yeah.net>
 * @param   mixed   $data
 * @param   bool    $file_append    是否追加内容
 * @param   string  $filename       文件名称
 */
function filebug($data = '', $file_append = true, $filename = 'log.txt')
{
    $flag = $file_append ? FILE_APPEND : 0;
    file_put_contents($filename, var_export($data, true), $flag);
}

/**
 * 获取缩略图地址
 * 根据前端需求获取小图(150*150)或中图(350*350)缩略图
 *
 * @author tangkh<tangkh@yeah.net>
 * @param string $path 图片路径
 * @param int $size 缩略图尺寸
 * @return string 缩略图地址
 */
function get_thumb($path, $size=0)
{
    if(empty($path) || empty($size)) return $path;
    //如果是缩略图，则返回原图片地址
    if(strpos($path, 'thumb') !== false) return $path;
    switch($size)
    {
        case 150:
        case 350:
            $path = dirname($path)."/thumb_{$size}_".basename($path);
            break;

        default:
            break;
    }
    return $path;
}