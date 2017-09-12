<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include dirname(__FILE__).DIRECTORY_SEPARATOR.'phpcms/libs/classes/phpqrcode.class.php';

//定义纠错级别

$errorLevel = "L";

//定义生成图片宽度和高度;默认为3

$size = "6";

//定义生成内容0

$content = $_GET['url'];

//调用QRcode类的静态方法png生成二维码图片//

QRcode::png($content, false, $errorLevel, $size);