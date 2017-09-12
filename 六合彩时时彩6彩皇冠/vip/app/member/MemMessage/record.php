<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
include "../include/login_session.php";
$uid=$_REQUEST["uid"];
if ($_REQUEST['langx']=='')
	$langx="zh-cn";
else
	$langx=$_REQUEST["langx"];
$username=$_REQUEST['username'];
//require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
if (isset($_POST['delete']))
{
	$arr = $_POST['msgid'];
	foreach ($arr as $v)
	{
		$del = "delete from `web_member_msg` where id = '".$v."' and `receive`='".$row['UserName']."';";
		mysql_query($del) or die(mysql_error());
	}	
	echo "<script>alert('删除成功!');hisotry.back();</script>";
}
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
if ($page < 1)
{
	$page=0;
}
if ($_GET['type']=='')
	$mysql="select * from web_member_msg where `receive`='".$row['UserName']."' order by id desc";
else
	$mysql="select * from web_member_msg where `receive`='".$row['UserName']."' order by state, id desc";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
//echo $cou;
$page_size=10;
$page_count=ceil($cou/$page_size);
if ($page > $page_count)
{
	$page = $page_count-1;
}
$offset=$page*$page_size;
$mysql.="  limit $offset,$page_size;";
//echo $mysql;
//echo $page;
$result = mysql_db_query($dbname,$mysql) or die(mysql_error().$mysql);
if ($cou==0){
	$page_count=1;
}
?>
<html>
<head>
<title>History</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">
<style>
<!--
#MFT #box { width:650px;}
#MFT .news { white-space: normal!important; color:#300; text-align:left; padding:2px 4px;}
-->
.title a:link {
	font-size: 12px;
	color: #000;
	font-weight:normal;
}
.title a:visited {
	font-size: 12px;
	color: #000;
	font-weight:normal;
}
body {
	font-size: 12px;
}
</style>
<script src="day.js"></script>
<script>
function changePage(obj)
{
	window.location.replace("<?=($_SERVER['PHP_SELF']."?uid=".$uid."&langx=".$langx."&page=")?>"+obj.value);
}
</script>
</HEAD>
<BODY id="MFT" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form method="post" name="main" action="record.php?uid=<?=$uid?>&langx=<?=$langx?>&do=yes">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="500" valign="top"><table border="0" cellpadding="0" cellspacing="0" id="box">
        <tr>
          <td class="top"><h1><em>会员短信息</em></h1></td>
        </tr>
        <tr>
          <td class="mem"><table width="100%" border="0" cellpadding="0" cellspacing="1" class="game">
            <tr class="b_rig">
              <td width="38" height="30" align="center">&nbsp;</td>
              <td width="357" align="center">标题</td>
              <td width="166" align="center">日期</td>
              <td width="84" align="center">状态</td>
              </tr>
            <?
//echo $mysql;
$result=mysql_db_query($dbname,$mysql);
if ($cou >= 1) {
	while ($myrow=mysql_fetch_array($result)){
	?>
				<tr class="b_rig">
				  <td height="30" align="center"><input type="checkbox" name="msgid[]" id="msgid[]" value="<?=$myrow['id']?>"></td>
				  <td align="center"><span class="title"><a href="view.php?uid=<?=$uid?>&msgid=<?=($myrow['id'])?>"><?=$myrow['title']?></a></span>
					<br></td>
				  <td align="center"><?=$myrow['creatdate']?></td>
				  <td align="center">
                  <?php
					if ($myrow['state']==0)
					{
						echo "<font color='red'>未读</font>";
					}else{
						echo "<font color='green'>已读</font>";
					}
				  ?>
					
				  </td>
				  </tr>
				<?
	}
}
else
{
	?>
    <tr class="b_rig">
				  <td height="30" align="center"></td>
				  <td align="center">您暂时没有短信息！</a>
					<br></td>
				  <td align="center"></td>
				  <td align="center">
					
				  </td>
				  </tr>
<?php
}
?>
            <tr class="b_rig">
              <td height="30" align="center">&nbsp;</td>
              <td align="center">排列方式: <a href="?uid=<?=($uid)?>&langx=<?=($langx)?>&type=1">[未读优先]</a> <a href="?uid=<?=($uid)?>&langx=<?=($langx)?>">[时间优先]</a></td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" bordercolor="#CCCCCC">
          <tr>
            <td width="492" align="center" style="font-size: 12px;"><label>
              <input type="submit" style="height: 25px;" name="delete" id="delete" value="删除选中信息">
            </label>
              | 当前第<?=($page+1)?>页 | <a href="record.php?uid=<?=($uid)?>&langx=<?=($langx)?>&page=0">首 页</a> | <a href="record.php?uid=<?=($uid)?>&langx=<?=($langx)?>&page=<?=($page-1)?>">上一页</a> | <a href="record.php?uid=<?=($uid)?>&langx=<?=($langx)?>&page=<?=($page+1)?>">下一页</a> | <a href="record.php?uid=<?=($uid)?>&langx=<?=($langx)?>&page=<?=($page_count-1)?>">尾页</a></td>
            <td width="155" align="center">共 <?=$page_count?>
              頁</td>
          </tr>
        </table>
        </td></tr>
        <tr>
          <td id="foot">&nbsp;</td>
        </tr>
      </table>
</td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
