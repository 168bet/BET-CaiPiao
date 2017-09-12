<?php
//开盘公司资料

require_once 'global.func.php';
require_once 'conn.php';

//含有让分赔率开盘公司
$companies[1] = [1, '澳门'];
$companies[2] = [1, '易胜博'];
$companies[3] = [1, '皇冠'];
$companies[8] = [1, 'Bet365'];
$companies[9] = [1, '韦德'];
//含有总分赔率开盘公司
$companies[4] = [2, '澳门'];
$companies[5] = [2, '易胜博'];
$companies[6] = [2, '皇冠'];
$companies[11] = [2, 'Bet365'];
$companies[12] = [2, '韦德'];


$sql = "REPLACE INTO `bt_company` VALUES(?,?,?)";
if ($stmt = $mysqli->prepare($sql)) {
    foreach ($companies as $companyid => $company) {
        $stmt->bind_param('iis',
            $companyid,                             //公司编号
            $company[0],                            //开盘类型(1：让分盘 2：上下盘 3：单双盘)
            $company[1]                             //公司名称
        );
        $stmt->execute();
    }
    $stmt->close();
} else {
    cron_log($sql . ' 初始化失败', 2);
}

$mysqli->close();
