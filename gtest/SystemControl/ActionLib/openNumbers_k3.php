<?php
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';
global $Users, $ConfigModel;
if ($Users[0]['g_login_id'] != 89) exit;

if (isset($Users[0]['g_lock_1_6'])){
	if ($Users[0]['g_lock_1_6'] !=1) 
		exit(back('您的權限不足！'));
}
markPos("后台-快3开盘");
$db=new DB();

if (isset($_GET['delid']) && Matchs::isNumber($_GET['delid']))
{
	$delid = $_GET['delid'];
	$id = $db->query("SELECT g_lock FROM g_kaipan7 WHERE g_id = '{$delid}' LIMIT 1 ", 0);
	if ($id)
	{
		$db->query("DELETE FROM g_kaipan7 WHERE g_id = '{$delid}' LIMIT 1", 2);
		exit(alert_href('刪除成功', 'openNumbers_k3.php'));
	}
	else 
	{
		exit(back($delid.' ID 不存在！'));
	}
}
if (isset($_GET['openid']) && Matchs::isNumber($_GET['openid'], 10, 15))
{
	$openid = $_GET['openid'];
	$openids = $db->query("SELECT g_lock FROM g_kaipan7 WHERE g_qishu = '{$openid}' LIMIT 1 ", 0);
	if ($openids)
	{
		$db->query("DELETE FROM g_kaipan7 WHERE g_qishu < '{$openid}' ", 2);
		$db->query("UPDATE g_kaipan7 SET g_lock = 2 WHERE g_qishu = '{$openid}' LIMIT 1 ", 2);
		exit(alert_href('操作成功', 'NumberInclude.php'));
	}
}
if (isset($_GET['inserid']) && Matchs::isNumber($_GET['inserid']))
{
	$inserid = $_GET['inserid'];
	InsertNumberk3($inserid, $ConfigModel['g_close_time']);
	exit(alert_href('操作成功', 'NumberInclude.php'));
}
else 
{
	$result = $db->query("SELECT `g_id`, `g_qishu`, `g_feng_date`, `g_open_date`, `g_lock` FROM `g_kaipan7` ORDER BY g_qishu ASC ", 1);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/SystemControl/ActionLib/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<title></title>
<script type="text/javascript">
<!--
	function delNumber(id, sInt){
		var href, lock=false;
		if (sInt == 1){
			if (confirm("警告：沒必要情況下建議不要操作。\n你確定刪除嗎？")){
				href = "?delid=";
				lock =true;
			}
		} else if (sInt == 2) {
			if (confirm("警告：系統將會自動刪除 "+id+" 之前的期數。\n你確定開盤嗎？")){
				href = "?openid=";
				lock =true;
			}
		} else {
			if (confirm("警告：系統將會自動重新加載1-82期，開獎、封盤時間。\n你確定嗎？")){
				href = "?inserid=";
				id = document.getElementById("day").value;
				lock =true;
			}
		}
		if (lock==true)
			location.href = location.href + href +id;
	}
-->
</script>
</head>
<body>
	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_03.gif" alt="" /></td>
                        <td background="/SystemControl/ActionLib/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="17"><img src="/SystemControl/ActionLib/images/tb.gif" width="16" height="16" /></td>
                                    <td width="99%">&nbsp;開盤設置--江苏骰寶(快3)</td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
                            <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<td>期數</td>
                                    <td>封盤時間</td>
                                    <td>開獎時間</td>
                                    <td width="150">狀態</td>
                                    <td width="120">基本操作</td>
                                </tr>
                                <?php if (!$result){echo '<tr><td align="center" colspan="4">暫無記錄</td></tr>';}
                                	else {for ($i=0; $i<count($result); $i++){
                                	if ($result[$i]['g_lock'] == 2){
                                		$lock =  '<span class="odds">正在開盤中</span>';
                                		$open = '<span class="red">已開</span>';
                                	} else {
                                		$lock =  '未開盤';
                                		$open ="<a href=\"javascript:void(0)\" onclick=\"delNumber('{$result[$i]['g_qishu']}','2')\">開盤</a>";
                                	}
                                ?>
                                <tr align="center" style="height:28px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                	<td><?php echo $result[$i]['g_qishu']?></td>
                                    <td><?php echo $result[$i]['g_feng_date']?></td>
                                    <td><?php echo $result[$i]['g_open_date']?></td>
                                    <td><?php echo$lock?></td>
                                    <td>
                                    	<table border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                    <td class="nones" width="15"><img src="/SystemControl/ActionLib/images/edit.gif"/></td>
                                                    <td class="nones" width="30"><?php echo$open?></td>
                                                    <td class="nones" width="16"><img src="/SystemControl/ActionLib/images/55.gif" /></td>
                                                    <td class="nones" width="30"><a href="javascript:void(0)" onclick="delNumber('<?php echo$result[$i]['g_id']?>','1')">刪除</a></td>
                                              </tr>
                                        </table>
									</td>
                                </tr>
                                <?php }}?>
                            </table>
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="center">
                        <span class="odds">（注意：系統會自動加載1-82期號碼）</span>
                        天:
                        <input type="text" value="1" id="day" class="texta" <?php echo$disabled?> />
                        	<input type="submit" class="inputs" onclick="delNumber(1, 3)" value="加載號碼" <?php echo$disabled?> />
						</td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_20.gif" alt="" /></td>
                    </tr>
                </table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"> </td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"> </td>
        </tr>
    </table>
</body>
</html>