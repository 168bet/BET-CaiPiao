<?php
//球探网篮球数据接口代理

//加载篮球接口
require_once 'basketball_api.class.php';

//获取参数
extract($_GET);

//确认指定了需要调用的接口
if (!isset($method)) {
    exit(json_encode(array('error' => '未指定要调用的接口.')));
}

//确认要调用的接口是否存在
if (!method_exists('basketball_api', $method)) {
    exit(json_encode(array('error' => '要调用的接口不存在.')));
}

//执行的方法有多少个参数
$param_num = count($_GET) - 1;

//调用接口
switch ($param_num) {
    case 0:
        echo basketball_api::$method();
        break;
    case 1:
        echo basketball_api::$method($p1);
        break;
    case 2:
        echo basketball_api::$method($p1, $p2);
        break;
    case 3:
        echo basketball_api::$method($p1, $p2, $p3);
        break;
    case 4:
        echo basketball_api::$method($p1, $p2, $p3, $p4);
        break;
    default:
        echo json_encode(array('error' => '参数个数不符合!'));
        break;
}

