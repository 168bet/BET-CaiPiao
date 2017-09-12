<?php
require ("../../include/config.inc.php");
require ("../../include/curl_http.php");

$mysql="select Uid,Uid_tw,Uid_en from web_system_data where ID=1";
$myresult=mysql_query($mysql);
$myrow=mysql_fetch_array($myresult);
$uid=$myrow['Uid'];
$uid_tw=$myrow['Uid_tw'];
$uid_en=$myrow['Uid_en'];

$sql="select ID,Url_Addr from web_url_data order by id desc limit 15";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>皇冠刷水时间测试</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
<form action="url.php" method="post">
<table width="600" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
   <tr bgcolor="#FFFFFF">
      <td height="25" colspan="3" align="center">皇冠刷水时间测试</td>
   </tr>
   <tr bgcolor="#FFFFFF">
      <td width="246" height="25" align="center">网&nbsp;&nbsp;&nbsp;&nbsp;址</td>
      <td width="200" align="center">时&nbsp;&nbsp;&nbsp;&nbsp;间</td>
      <td width="150" align="center">操&nbsp;&nbsp;&nbsp;&nbsp;作</td>
   </tr>
</table>
<?php
if(empty($_REQUEST['test'])){
	while($row){
		echo "
		<table  width=\"600\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\">
		<tr bgcolor=\"#FFFFFF\"><td \"center\" width=\"246\"><input type=\"text\" name=\"txt[]\" value=\"".$row['Url_Addr']."\"/></td><td \"center\" width=\"200\">".$mirsec."</td><td \"center\" width=\"150\">&nbsp;</td></tr>
		</table>";
		$row=mysql_fetch_array($result);
	}
	$less=15-$cou;
	for($i=0;$i<$less;$i++){
		echo "
		<table  width=\"600\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\">
		<tr bgcolor=\"#FFFFFF\"><td \"center\" width=\"246\"><input type=\"text\" name=\"txt[]\" value=\"\"/></td><td \"center\" width=\"200\">&nbsp;</td><td \"center\" width=\"150\">&nbsp;</td></tr>
		</table>";
	}
}else{
	foreach($_REQUEST['txt'] as $key=>$value){
		if(!empty($value) and preg_match("/^(http:\/\/(\d{1,2}|1\d{1,2}|2[0-5][0-4])[.](\d{1,2}|1\d{1,2}|2[0-5][0-4])[.](\d{1,2}|1\d{1,2}|2[0-5][0-4])[.](\d{1,2}|1\d{1,2}|2[0-5][0-4])|http:\/\/[\d|\w]+[.][\S]+)[^\/]$/",$value)){
			$urltmp=trim($value);
			$sqlTest="select * from web_url_data where Url_Addr = '$value';";
			$ress=mysql_query($sqlTest);
			if(mysql_num_rows($ress)==0){
				$sqlInsert="insert into web_url_data(Url_Addr) values ('$value');";
				mysql_query($sqlInsert);
			}
		}
	}

	if(!empty($_REQUEST['chk'])){
		$tmp_idd="";
		foreach($_REQUEST['chk'] as $key=>$idd){
			$tmp_idd=$tmp_idd.$idd.",";
		}
		$tmp_idd=$tmp_idd."-1";
		$sql_del="delete from web_url_data where id in ($tmp_idd)";
	}
	mysql_query($sql_del);
	
	$siteSQL="select * from web_url_data order by id desc limit 15";
	$result=mysql_query($siteSQL);
	$row=mysql_fetch_array($result);
	$cou=mysql_num_rows($result);
	while($row){
		list($usec, $sec) = explode(" ", microtime());
		$mirsec=((float)$usec + (float)$sec);
		$curl = &new Curl_HTTP_Client();
		$curl->store_cookies("cookies.txt"); 
		$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
		$curl->set_referrer("".$row['Url_Addr']."/app/member/FT_browse/index.php?rtype=f&uid=$uid&langx=zh-cn&mtype=3");
		$html_data=$curl->fetch_url("".$row['Url_Addr']."/app/member/FT_browse/body_var.php?rtype=r&uid=$uid&langx=zh-cn&mtype=3");
		$tmp=substr($html_data,10);
		if(strlen($tmp)<200){
			$mirsec="该网址不可用。";
		}else{
			$a = array("if(self == top)","<script>","</script>","\n\n");
			$b = array("","","","");
			$msg = str_replace($a,$b,$html_data);
			preg_match_all("/Array\((.+?)\);/is",$msg,$matches);
			//echo $meg;
			list($usec, $sec) = explode(" ", microtime());
			$mirsec1=((float)$usec + (float)$sec);
			$mirsec=$mirsec1-$mirsec;
			addcslashes($msg,'\"');
			if($mirsec>5 or !preg_match("/parent[.]uid=\'".$uid."\'/",$msg)){
				$mirsec="该网址不可用。请更换UID后再次测试。";
			}
		}
		/**************************/
		echo "
		<table  width=\"600\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\">
		<tr bgcolor=\"#FFFFFF\"><td \"center\" width=\"246\"><input type=\"text\" name=\"txt[]\" value=\"".$row['Url_Addr']."\"/></td><td \"center\" width=\"200\">".$mirsec."</td><td \"center\" width=\"150\"><label><input type=\"checkbox\" name=\"chk[]\" value=\"".$row['ID']."\"/>删除</label>&nbsp;/<a href=\"modify1.php?url=".base64_encode($row['Url_Addr'])."\">使用</a></td></tr>
		</table>";
		flush();
		ob_flush();
		$row=mysql_fetch_array($result);
	}
	$less=15-$cou;
	for($i=0;$i<$less;$i++){
		echo "
		<table  width=\"600\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\">
		<tr bgcolor=\"#FFFFFF\"><td \"center\" width=\"246\"><input type=\"text\" name=\"txt[]\" value=\"\"/></td><td \"center\" width=\"200\">&nbsp;</td><td \"center\" width=\"150\">&nbsp;</td></tr>
		</table>";
	}
}
?>
<table width="600" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
   <tr bgcolor="#FFFFFF">
      <td align="center"><input type="submit" name="test" value="测  试"/></td>
   </tr>
   <tr bgcolor="#FFFFFF">
      <td align="left"><font color="#FF0000">说明：<br />如果出现：Warning的乱码，请将Warning下的一条网址删除，该网址肯定不可用。<br />如果时间列全部显示为"该网址不可用。"，有可能是UID出错。请更换UID再次测试。<br />要添加地址，请直接把网址复制黏贴到文本框里，注意：地址的最后不要有"/"。</font></td>
   </tr>
</table>
</form>
</div>
</body>
</html>
