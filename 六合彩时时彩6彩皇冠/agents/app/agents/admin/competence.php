<?
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../../agents/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");
//print_r($_REQUEST);
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$id=$_REQUEST["id"];
$username=$_REQUEST['username'];
$type=$_REQUEST["type"];
include ("../../agents/include/online.php");
require ("../../agents/include/traditional.$langx.inc.php");
$sql = "select * from web_system_data where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$name=$row['UserName'];
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}

$loginfo='查看子帐号权限';
if ($type=='Y'){
	for($i=0;$i<=24;$i++){
		$no="OP".$i;
		$num=$_REQUEST[$no];
		if ($num!=1){
			$num=0;
		}
		$number.=$num.",";
	}
	$loginfo='修改子帐号:'.$username.'权限成功!';
	$mysql="update web_system_data set Competence='$number' where ID='$id'";
	mysql_query($mysql);
	echo "<script language=javascript>document.location='competence.php?uid=$uid&langx=$langx&id=$id&username=$username';</script>";
}
if ($type=='S'){
	$style=$_REQUEST["style"];
	$loginfo='修改子帐号:'.$username.'样式成功!';
	$mysql="update web_system_data set Style='$style' where ID='$id'";
	mysql_query($mysql);
	echo "<script language=javascript>document.location='competence.php?uid=$uid&langx=$langx&id=$id&username=$username';</script>";		
}
$mysql = "select * from web_system_data where ID='$id'";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$competence=$row['Competence'];
$style=$row['Style'];
$num=explode(",",$competence);
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_title {  background-color: #86C0A6; text-align: center; height:25px}
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr> 
     <td width="100%" class="m_tline">子账号权限设置</td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
   </tr>
   <tr> 
      <td colspan="2" height="4"></td>
   </tr>
</table>
<table width="500" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="320"><table width="300" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
      <form name="myFORM" action="" method=POST>
        <tr class="m_title">
          <td width="98">功能菜单</td>
          <td width="50">状态</td>
          <td width="97">功能菜单</td>
          <td width="50">状态</td>
        </tr>
        <tr class="m_cen" >
          <td>在线人数</td>
          <td><input type="checkbox" name="OP0" value="1" <?php if($num[0]==1) echo "checked";?>></td>
          <td>基本資料</td>
          <td><input type="checkbox" name="OP15" value="1" <?php if($num[15]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>系统参数</td>
          <td><input type="checkbox" name="OP1" value="1" <?php if($num[1]==1) echo "checked";?>></td>
          <td>子帳號</td>
          <td><input type="checkbox" name="OP16" value="1" <?php if($num[16]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>系统公告</td>
          <td><input type="checkbox" name="OP2" value="1" <?php if($num[2]==1) echo "checked";?>></td>
          <td>公司</td>
          <td><input type="checkbox" name="OP17" value="1" <?php if($num[17]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>系统短信</td>
          <td><input type="checkbox" name="OP3" value="1" <?php if($num[3]==1) echo "checked";?>></td>
          <td>股東</td>
          <td><input type="checkbox" name="OP18" value="1" <?php if($num[18]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>系统消息</td>
          <td><input type="checkbox" name="OP4" value="1" <?php if($num[4]==1) echo "checked";?>></td>
          <td>總代理</td>
          <td><input type="checkbox" name="OP19" value="1" <?php if($num[19]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>数据刷新</td>
          <td><input type="checkbox" name="OP5" value="1" <?php if($num[5]==1) echo "checked";?>></td>
          <td>代理商</td>
          <td><input type="checkbox" name="OP20" value="1" <?php if($num[20]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>幣值设置</td>
          <td><input type="checkbox" name="OP6" value="1" <?php if($num[6]==1) echo "checked";?>></td>
          <td>會員</td>
          <td><input type="checkbox" name="OP21" value="1" <?php if($num[21]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>联盟限制</td>
          <td><input type="checkbox" name="OP7" value="1" <?php if($num[7]==1) echo "checked";?>></td>
          <td>報表</td>
          <td><input type="checkbox" name="OP22" value="1" <?php if($num[22]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>数据操盘</td>
          <td><input type="checkbox" name="OP8" value="1" <?php if($num[8]==1) echo "checked";?>></td>
          <td>現金系統</td>
          <td><input type="checkbox" name="OP23" value="1" <?php if($num[23]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>审核比分</td>
          <td><input type="checkbox" name="OP9" value="1" <?php if($num[9]==1) echo "checked";?>></td>
          <td>軟件下載</td>
          <td><input type="checkbox" name="OP24" value="1" <?php if($num[24]==1) echo "checked";?>></td>
        </tr>
        <tr class="m_cen" >
          <td>滚球注单</td>
          <td><input type="checkbox" name="OP10" value="1" <?php if($num[10]==1) echo "checked";?>></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="m_cen" >
          <td>查询注单</td>
          <td><input type="checkbox" name="OP11" value="1" <?php if($num[11]==1) echo "checked";?>></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="m_cen" >
          <td>赔率设置</td>
          <td><input type="checkbox" name="OP12" value="1" <?php if($num[12]==1) echo "checked";?>></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="m_cen" >
          <td>开奖结果</td>
          <td><input type="checkbox" name="OP13" value="1" <?php if($num[13]==1) echo "checked";?>></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="m_cen" >
          <td>系统日志</td>
          <td><input type="checkbox" name="OP14" value="1" <?php if($num[14]==1) echo "checked";?>></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="m_cen" >
          <td colspan="4">
          <input type="hidden" name="id" id="id" value="<?=$id?>">
          <input type="hidden" name="type" id="type" value="Y">
          <input type="reset" name="Cancel" value="重置" class="za_button">
          <input type="submit" name="Submit" value="设置" class="za_button"></td>
        </tr>
      </form>
    </table></td>
    <td width="180" valign="top"><table width="180" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
      <form name="myFORM" action="" method=POST>
      <tr class="m_title">
        <td colspan="2">网站样式</td>
        </tr>
      <tr class="m_cen">
        <td width="100">皇冠</td>
        <td width="77"><input name="style" id="style" type="radio" <?=$style==1?"checked":""?> value="1"></td>
        </tr>
      <tr class="m_cen">
        <td>皇家</td>
        <td><input name="style" id="style" type="radio" <?=$style==2?"checked":""?> value="2"></td>
        </tr>
      <tr class="m_cen">
        <td>皇马</td>
        <td><input name="style" id="style" type="radio" <?=$style==3?"checked":""?> value="3"></td>
        </tr>
      <tr class="m_cen">
        <td>皇室</td>
        <td><input name="style" id="style" type="radio" <?=$style==4?"checked":""?> value="4"></td>
        </tr>
      <tr class="m_cen">
        <td colspan="2">
          <input type="hidden" name="id" id="id" value="<?=$id?>">
          <input type="hidden" name="type" id="type" value="S">
          <input type="reset" name="Cancel" value="重置" class="za_button">
          <input type="submit" name="Submit" value="设置" class="za_button"></td>
      </tr>
      </form>
    </table></td>
  </tr>
</table>
</body>
</html>
<?
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$name',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>