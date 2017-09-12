<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'\n;</script>";
require ("../include/config.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];
include ("../include/online.php");
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}

$type=$_REQUEST['type'];
$che=$_REQUEST['chk'];

if ($type=='add'){
	$address=$_REQUEST['Address'];//地址
	$business=$_REQUEST['Business'];//商户码
	$keys=$_REQUEST['Keys'];//密匙
	$mysql="insert into `web_payment_data`(`Address`,`Business`,`Keys`)values('$address','$business','$keys')";
	mysql_db_query($dbname,$mysql);
	echo "<script>alert('新增加一条内容');</script>";
}else if ($type=='edit'){
	if (empty($che)){
		echo "<script>alert('请选择要修改的内容');history.back(-1);</script>";
		exit;
	}
	foreach($che as $values){
		$address=$_REQUEST['Address'.$values];//地址
		$business=$_REQUEST['Business'.$values];//商户码
		$keys=$_REQUEST['Keys'.$values];//密匙
		$switch=$_REQUEST['Switch'.$values];//启用
		$pfront=$_REQUEST['pfront'.$values];//前台
		$pdomain=$_REQUEST['pdomain'.$values];//域名
		$mysql="update `web_payment_data` set `Address`='$address',`Business`='$business',`Keys`='$keys',`Switch`='$switch',`pfront`='$pfront',`pdomain`='$pdomain' where id='$values'";
		mysql_db_query($dbname,$mysql);
		echo "<script>alert('更新ID ".$values." 成功');</script>";
	}
}else if ($type=='del'){
	foreach($che as $values){
		$mysql="delete from `web_payment_data` where `ID`='$values'";
		mysql_db_query($dbname,$mysql);
		echo "<script>alert('删除ID ".$values." 成功');</script>";
	}
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script>
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}

function SubChk(){
	if (document.all.Address.value==''){
		document.all.Address.focus();
		alert("请输入返回地址!!");
		return false;
	}
	if (document.all.Business.value==''){
		document.all.Business.focus();
		alert("请输入商户号!!");
		return false;
	}
	if (document.all.Keys.value==''){
		document.all.Keys.focus();
		alert("请输入商户密匙!!");
		return false;
	}
}
function edit(){
	document.getElementById("type").value='edit';
}
function del(){
	if(!confirm("确认要删除吗")){
		return false;
	}
	document.getElementById("type").value='del';
	return true;
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;支付方式&nbsp;&nbsp;&nbsp;&nbsp;<a href="?uid=<?=$uid?>&langx=<?=$langx?>&type=Y">新增</a></td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
if ($type=='Y'){
?>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
<form name="myform" action="" method="post" onSubmit="return SubChk();">  
  <tr class="m_title"> 
    <td width=30>ID</td>
    <td width=80>支付公司</td>
    <td width=230>返回地址</td>
    <td width="100">商户号</td>
    <td width="529">商户密匙</td>
    </tr>
  <tr class=m_cen>
    <td>1</td>
    <td>YeePay</td>
    <td><input name="Address" id="Address" type="text" value="" style="width:230px;"></td>
    <td><input name="Business" id="Business" type="text" value="" style="width:100px;"></td>
    <td><input name="Keys" id="Keys" type="text" value="" style="width:525px;"></td>
  </tr>
  <tr class=m_cen>
    <td colspan="6"><input class="za_button" type="submit" value="提交" name="cmdsubmit">&nbsp;&nbsp;&nbsp;&nbsp;<input class="za_button" type="reset" value="取消" name="cmdcancel"><input type="hidden" name="type" value="add"></td>
    </tr>
</form>
</table>
<?
}else{
?>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
<form name="myform" action="" method="post">  
  <tr class="m_title"> 
    <td width=30>ID</td>
    <td width=30>选中</td>
    <td width=30>启用</td>
	<td width=30>前台</td>
	<td width=30>域名</td>
    <td width=80>支付公司</td>
    <td width=170>返回地址</td>
    <td width="100">商户号</td>
    <td width="465">商户密匙</td>
    </tr>
<?
$i=1;
$mysql="select * from web_payment_data";
$result=mysql_db_query($dbname,$mysql);
while($row=mysql_fetch_array($result)){
?>
  <tr class=m_cen>
    <td><?=$i?></td>
    <td><input type="checkbox" value="<?=$row['ID']?>" name="chk[]"></td>
    <td><input name="Switch<?=$row['ID']?>" type="checkbox" id="Switch<?=$row['ID']?>" value="1" <? if ($row['Switch']=='1'){echo 'checked';}?>></td>
	<td><input name="pfront<?=$row['ID']?>" type="checkbox" id="pfront<?=$row['ID']?>" value="1" <? if ($row['pfront']=='1'){echo 'checked';}?>></td>
	<td><input name="pdomain<?=$row['ID']?>" type="checkbox" id="pdomain<?=$row['ID']?>" value="1" <? if ($row['pdomain']=='1'){echo 'checked';}?>></td>
    <td>YeePay</td>
    <td><input name="Address<?=$row['ID']?>" id="Address<?=$row['ID']?>" type="text" value="<?=$row['Address']?>" style="width:170px;"></td>
    <td><input name="Business<?=$row['ID']?>" id="Business<?=$row['ID']?>" type="text" value="<?=$row['Business']?>" style="width:100px;"></td>
    <td><input name="Keys<?=$row['ID']?>" id="Keys<?=$row['ID']?>" type="text" value="<?=$row['Keys']?>" style="width:465px;"></td>  
  </tr>
<?
$i++;
}
?>
  <tr class=m_cen>
    <td colspan="9"><input type="hidden" name="type"><input type="submit" name="submit" value="修改选中" class="za_button" onClick="edit()">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="删除选中" class="za_button" onClick="return del();"></td>
    </tr>
</form>
</table>
<?
}
?>
</body>
</html>