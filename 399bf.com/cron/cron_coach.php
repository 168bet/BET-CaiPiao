<?php
//教练信息

require_once 'global.func.php';
require_once 'conn.php';

//教练数据
$sql = "SELECT `coaches` FROM `ft_team`;";
$rst = $mysqli->query($sql);
$coaches = array_column($rst->fetch_all(MYSQLI_ASSOC),'coaches');

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_coach` VALUES(?,?,?,?,?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql))
{
    foreach ($coaches as $coach)
    {
        $coach = json_decode($coach, true);

        if (is_array($coach) && !empty($coach))
        {
            $stmt->bind_param('sssssssssss',
                $coach['Name'], 					        // 教练名称
                $coach['EnName'], 				            // 教练英文名
                $coach['BirthDay'], 			            // 出生日期
                $coach['JoinDate'], 	                    // 加盟日期
                $coach['Country'], 	                        // 国籍
                $coach['Club'], 		                    // 效力球队
                $coach['FormerClub'], 		                // 前度效力球队
                $coach['Onceclub'], 		                // 曾经效力球队
                isset($coach['Glory'])?$coach['Glory']:'',  // 教练荣誉
                $coach['Profile'], 		                    // 教练简介
                $coach['Photo'] 		                    // 教练头像
            );

            $stmt->execute();
        }

        unset($coach);
    }

    $stmt->close();
}
else
{
    cron_log('初始化语句对象失败。', 2);
}

// 关闭mysql连接
$mysqli->close();
