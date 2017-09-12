<?php
//球员基本资料

require_once 'global.func.php';
require_once 'conn.php';

//获取球员ID
$rst = $mysqli->query("SELECT `playerids` FROM `ft_team`");
$playerids_info = $rst->fetch_all(MYSQLI_ASSOC);
if($playerids_info != false)
{
    $playerids = '';
    foreach($playerids_info as $key => $value){
        $playerids .= $key == 0 ? $value['playerids'] : ','.$value['playerids'];
    }
    $playerids = array_unique(explode(',', $playerids));
    //获取ft_player的playerid
    $rst = $mysqli->query("SELECT `playerid` FROM `ft_player`");
    $old_playerids = array_column($rst->fetch_all(MYSQLI_ASSOC), 'playerid');
    $playerids = array_diff($playerids, $old_playerids);

    $sql = "REPLACE INTO `ft_player` VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    if ($stmt = $mysqli->prepare($sql))
    {
        foreach($playerids as $playerid)
        {
            //通过接口获取数据
            $type = 'type=getplayerinfo&p1='.$playerid;
            $return = http_get(proxy_url().$type);

            //确认返回数据格式正确
            if (is_array($return) && !empty($return) && !isset($return['error']))
            {
                $stmt->bind_param('isssssssssissssss',
                    $playerid, 							//球员编号
                    $return['Name'], 					//球员名称
                    $return['EnName'], 					//球员英文名称
                    $return['sName'], 					//球员简称
                    $return['Birthday'], 				//出生日期
                    $return['Height'], 					//身高
                    $return['Weight'], 					//体重
                    $return['Nationality'], 			//国籍
                    $return['Club'], 					//效力球队
                    $return['JoinDate'], 				//加盟日期
                    $return['ClubShirtNo'], 			//球衣号码
                    $return['Position'], 				//场上位置
                    $return['Formerclub'], 				//前度效力球队
                    $return['Onceclub'], 				//曾经效力球队
                    $return['Profile'], 				//球员简介
                    $return['Honours'], 				//球员荣誉
                    $return['Photo'] 	    			//球员头像
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
}
else
{
    cron_log('ft_team表请求失败。', 2);
}

// 关闭mysql连接
$mysqli->close();