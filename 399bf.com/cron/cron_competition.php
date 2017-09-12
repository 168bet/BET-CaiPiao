<?php
//联赛信息

require_once 'global.func.php';
require_once 'conn.php';

//联赛编号数组
$rst = $mysqli->query("SELECT DISTINCT `eventid` FROM `ft_event`;");
$competitionids = array_column($rst->fetch_all(MYSQLI_ASSOC),'eventid');
$rst = $mysqli->query("SELECT `competitionid` FROM `ft_competition`;");
$old = array_column($rst->fetch_all(MYSQLI_ASSOC),'competitionid');
$competitionids = array_diff($competitionids, $old);
//释放内存
unset($old);

//从7m接口获取数据并写入本地数据库
$sql = "REPLACE INTO `ft_competition` VALUES(?,?,?,?,?,?,?);";
if ($stmt = $mysqli->prepare($sql)) 
{
	foreach ($competitionids as $competitionid)
	{
		// 通过接口获取数据
		$type = 'type=getcompetitioninfo&p1=' . $competitionid;
		$return = http_get(proxy_url() . $type);

		// 确认返回数据格式正确
		if (is_array($return) && !empty($return) && !isset($return['error']))
		{
			$stmt->bind_param('isssiis',
				$return['Id'], 							// 联赛编号
				$return['Name'], 						// 联赛名称
				$return['ShortName'], 					// 联赛简称
				$return['Color'], 						// 联赛颜色
				floor($return['StartDate']/1000), 		// 联赛开始时间
				floor($return['EndDate']/1000), 		// 联赛结束时间
				$return['System'] 						// 联赛赛制内容
			);

			$stmt->execute();
			cron_log('IP:' . IP . ' ' . $type . ' 请求接口数据成功');
		} elseif (isset($return['error'])) {
			cron_log('IP:' . IP . ' ' . $type . ' ' . $return['error'], 1);
		} elseif (empty($return)) {
			cron_log('IP:' . IP . ' ' . $type . ' 空值' . json_encode($return), 1);
		} else {
			cron_log('IP:' . IP . ' ' . $type . ' 网络错误', 1);
		}

		unset($return);
	}

	$stmt->close();
}
else
{
    cron_log('初始化语句对象失败。', 2);
}


// 关闭mysql连接
$mysqli->close();
