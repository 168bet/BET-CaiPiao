<?php
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';
global $Users, $ConfigModel;
$ConfigModel_c = configModel("`g_close_time`");
if ($Users[0]['g_login_id'] != 89) exit;

if (isset($Users[0]['g_lock_1_6'])){
	if ($Users[0]['g_lock_1_6'] !=1) 
		exit(back('您的權限不足！'));
}
markPos("后台-PK10开盘");
$db=new DB();

if ($_GET['actcc']=="删除"){
mysql_query("Delete from g_kaipan6");
}


if (isset($_GET['delid']) && Matchs::isNumber($_GET['delid']))
{
	$delid = $_GET['delid'];
	$id = $db->query("SELECT g_lock FROM g_kaipan6 WHERE g_id = '{$delid}' LIMIT 1 ", 0);
	if ($id)
	{
		$db->query("DELETE FROM g_kaipan6 WHERE g_id = '{$delid}' LIMIT 1", 2);
		exit(alert_href('刪除成功', 'openNumbers_pk.php'));
	}
	else 
	{
		exit(back($delid.' ID 不存在！'));
	}
}
if (isset($_GET['openid']) && Matchs::isNumber($_GET['openid']))
{
	$openid = $_GET['openid'];
	$openids = $db->query("SELECT g_lock FROM g_kaipan6 WHERE g_qishu = '{$openid}' LIMIT 1 ", 0);
	if ($openids)
	{
		$db->query("DELETE FROM g_kaipan6 WHERE g_qishu < '{$openid}' ", 2);
		$db->query("UPDATE g_kaipan6 SET g_lock = 2 WHERE g_qishu = '{$openid}' LIMIT 1 ", 2);
		exit(alert_href('操作成功', 'NumberInclude.php'));
	}
}

?>
<?php 
//修改信息
if ($_POST["submit1"] == "加載號碼") {
	$did = 373380;
	$inserid = intval($_POST["inserid"]);

	if ("2014-02-07" <= date("Y-m-d")) {
		$day = (((strtotime(date("Y-m-d")) - strtotime("2013-07-20")) / 3600 / 24) + $inserid) - 8;
	}
	else if ("2014-01-30" <= date("Y-m-d")) {
		$day = ((strtotime("2014-01-30") - strtotime("2013-07-20")) / 3600 / 24) + $inserid;
	}
	else {
		$day = ((strtotime(date("Y-m-d")) - strtotime("2013-07-20")) / 3600 / 24) + $inserid;
	}

	$number = $did + (179 * $day);
	insertnumberpk($number, $inserid);
	echo "<script>alert('盘口修改成功!');window.location.href='/Manage/temp/openNumbers_pk.php';</script>";
	exit();
}
$result=mysql_query("select * from g_kaipan6  order by g_qishu desc LIMIT 1");
$row=mysql_fetch_array($result);
$nn=$row['g_qishu']+1;

$zfbdate=$row['g_feng_date'];
$zfbdate=date('Y-m-d H:i:s',strtotime($zfbdate)+300);

$zfbdate1=$row['g_open_date'];
$zfbdate1 = date('Y-m-d H:i:s',strtotime($zfbdate1));

$zfbdatend = $row['g_kai_date'];
$zfbdatend = date('Y-m-d H:i:s',strtotime($zfbdatend)+600);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Manage/temp/css/common.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #666666;
	font-weight: bold;
}
.style2 {color: #ffffff}
.STYLE3 {color: #FF3300}
-->
</style>
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
			if (confirm("警告：系統將會自動重新加載1-50期，開獎、封盤時間。\n你確定嗎？")){
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
<SCRIPT>
function SubChk()
{
	
 		if(document.all.testFrm.nn.value=='')
 		{ document.all.testFrm.nn.focus(); alert("期数请务必输入!!"); return false; }
		
		if(document.all.testFrm.dd.value=='')
 		{ document.all.testFrm.dd.focus(); alert("添加期数请务必输入!!"); return false; }
  	
 		if(document.all.testFrm.MM.value=='')
 		{ document.all.testFrm.MM.focus(); alert("提前封盘时间请务必输入!!"); return false; }
 		if(document.all.testFrm.zfbdatend.value=='')
 		{ document.all.testFrm.zfbdatend.focus(); alert("开奖时间请务必输入!!"); return false; }
		if(document.all.testFrm.zfbdate1.value=='')
 		{ document.all.testFrm.zfbdate1.focus(); alert("开盘时间请务必输入!!"); return false; }
 	
		if(!confirm("是否确定修改盘口?")){
  		return false;
 	}
}
</SCRIPT>
</head>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" class="a">
  <tr>
    <td width="6" height="99%" bgcolor="#5a5a5a"></td>
    <td class="c"><table border="0" cellspacing="0" class="main">
        <tr>
          <td width="12"><img src="/Manage/temp/images/tab_03.gif" alt="" /></td>
          <td background="/Manage/temp/images/tab_05.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="17"><img src="/Manage/temp/images/tb.gif" width="16" height="16" /></td>
                <td width="99%">&nbsp;開盤設置--北京賽車(PK10)</td>
              </tr>
            </table></td>
          <td width="16"><img src="/Manage/temp/images/tab_07.gif" alt="" /></td>
        </tr>
        <tr>
          <td class="t"></td>
          <td class="c"><!-- strat -->
            <table border="0" cellspacing="0" class="conter">
            
              <tr>
                <td><table id="tb"  border="0" align="center"  width="99%">
                    <tr class="tr_top">
                      <td height="28" colspan="7" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#D4E5F4">
					  <form name="testFrm" onSubmit="" method="post" action="">
					  <span class="odds">（注意：系統會自動加載1-179期號碼）</span>天:<input type="text" value="0" id="inserid" name="inserid" class="texta" /><input type="submit" class="inputs" name="submit1" value="加載號碼" /> 
					  </form>
					  </td>
                    </tr>
                    <tr class="tr_top">
                      <td width="4%"  align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#D4E5F4">序号</td>
                      <td align="center" bordercolor="cccccc" bgcolor="#D4E5F4">期数</td>
                      <td align="center" bordercolor="cccccc" bgcolor="#D4E5F4" class="m_title_reall">开盘时间</td>
                      <td align="center" bordercolor="cccccc" bgcolor="#D4E5F4" class="m_title_reall">封盘时间</td>
                      <td align="center" bordercolor="cccccc" bgcolor="#D4E5F4" class="m_title_reall">开奖时间</td>
                      <td align="center" bordercolor="cccccc" bgcolor="#D4E5F4" class="m_title_reall">状态</td>
                      <td align="center" bordercolor="cccccc" bgcolor="#D4E5F4" class="m_title_reall">操作</td>
                    </tr>
                    <?	
		 $result = mysql_query("SELECT `g_id`, `g_qishu`, `g_feng_date`, `g_open_date`, `g_kai_date`, `g_lock` FROM `g_kaipan6` ORDER BY g_qishu ASC "); 
		 
									if (!$result){echo '<tr><td align="center" colspan="7">暫無記錄</td></tr>';}
                                	else {		 
		   
									$ii=0;
									while($rs = mysql_fetch_array($result)){

									$ii++;

									if ($rs['g_lock'] == 2){
                                		$lock =  '<span class="odds">正在開盤中</span>';
                                		$open = '<span class="red">已開</span>';
                                	} else {
                                		$lock =  '未開盤';
                                		$open ="<a href=\"javascript:void(0)\" onclick=\"delNumber('{$rs['g_qishu']}','2')\">開盤</a>";
                                	}



?>
                    <form action="" method="post" name="form" id="form">
                      <tr >
                        <td  align="center" nowrap="nowrap" bordercolor="cccccc"><?=$ii?></td>
                        <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['g_qishu']?></td>
                        <td  align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['g_kai_date']?></td>
                        <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['g_feng_date']?></td>
                        <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['g_open_date']?></td>
                        <td align="center" nowrap="nowrap" bordercolor="cccccc"><?php echo$lock?></td>
                        <td align="center" nowrap="nowrap" bordercolor="cccccc"><input type="hidden" id="id" name="id" value="<?=$rs['g_id']?>" />
                          <input type="hidden" id="save" name="save" value="save" />
                          <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="nones" width="15"><img src="/Manage/temp/images/edit.gif"/></td>
                              <td class="nones" width="30"><?php echo$open?></td>
                              <td class="nones" width="16"><img src="/Manage/temp/images/55.gif" /></td>
                              <td class="nones" width="30"><a href="javascript:void(0)" onclick="delNumber('<?php echo$rs['g_id']?>','1')">刪除</a></td>
                            </tr>
                          </table>
                      </tr>
                    </form>
                    <? 
	  }
	  }?>
                  </table></td>
              </tr>
            </table>
            <!-- end -->
          </td>
          <td class="r"></td>
        </tr>
        <tr>
          <td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
          <td class="f" align="center"></td>
          <td width="16"><img src="/Manage/temp/images/tab_20.gif" alt="" /></td>
        </tr>
      </table></td>
    <td width="6" bgcolor="#5a5a5a"></td>
  </tr>
  <tr>
    <td height="6" bgcolor="#5a5a5a"> </td>
    <td bgcolor="#5a5a5a"></td>
    <td height="6" bgcolor="#5a5a5a"> </td>
  </tr>
</table>
<br />
</body>
</html>
