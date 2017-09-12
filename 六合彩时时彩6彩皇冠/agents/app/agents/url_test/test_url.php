<?php
require_once("../../../include/conn_ft.php");
require_once("http.class.php");
mysql_select_db($dbname);
$uidSQL="select * from web_system";
$uidRES=mysql_query($uidSQL);
$uidARR=mysql_fetch_array($uidRES);
$uid=$uidARR['uid'];
$uid_tw=$uidARR['uid_tw'];
$uid_en=$uidARR['uid_en'];
//uid,uid_tw,uid_en,

$siteSQL="select * from URLsite order by id desc limit 15";
$siteRES=mysql_query($siteSQL);
$siteARR=mysql_fetch_array($siteRES);
$num_sitARR=mysql_num_rows($siteRES);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>皇冠接水时间测试</title>
</head>

<body>
<div align="center">
<form action="test_url.php" method="post">
<table width="80%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
<tr bgcolor="#FFFFFF"><td colspan="3" align="center" bgcolor="#416097">皇冠接水时间测试</td></tr>
<tr bgcolor="#FFFFFF">
  <td width="30%" align="center" bgcolor="#416097">网&nbsp;&nbsp;&nbsp;&nbsp;址</td><td align="center" width="30%" bgcolor="#416097">时&nbsp;&nbsp;&nbsp;&nbsp;间</td><td align="center" width="40%" bgcolor="#416097">操&nbsp;&nbsp;&nbsp;&nbsp;作</td></tr>
</table>
<?php
if(empty($_REQUEST['test']))
{
	while($siteARR)
	{
		echo "
		<table  width=\"80%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\">
		<tr bgcolor=\"#FFFFFF\"><td \"center\" width=\"30%\"><input type=\"text\" name=\"txt[]\" value=\"".$siteARR['URL']."\"/></td><td \"center\" width=\"30%\">".$mirsec."</td><td \"center\" width=\"40%\">&nbsp;</td></tr>
		</table>";
		$siteARR=mysql_fetch_array($siteRES);
	}
	$less=15-$num_sitARR;
	for($i=0;$i<$less;$i++)
	{
		echo "
		<table  width=\"80%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\">
		<tr bgcolor=\"#FFFFFF\"><td \"center\" width=\"30%\"><input type=\"text\" name=\"txt[]\" value=\"\"/></td><td \"center\" width=\"30%\">&nbsp;</td><td \"center\" width=\"40%\">&nbsp;</td></tr>
		</table>";
	}
}
else
{
	foreach($_REQUEST['txt'] as $key=>$value)
	{
		if(!empty($value) and preg_match("/^(http:\/\/(\d{1,2}|1\d{1,2}|2[0-5][0-4])[.](\d{1,2}|1\d{1,2}|2[0-5][0-4])[.](\d{1,2}|1\d{1,2}|2[0-5][0-4])[.](\d{1,2}|1\d{1,2}|2[0-5][0-4])|http:\/\/[\d|\w]+[.][\S]+)[^\/]$/",$value))
		{
			$urltmp=trim($value);
			$sqlTest="select * from URLsite where URL = '$value';";
			$ress=mysql_query($sqlTest);
			if(mysql_num_rows($ress)==0)
			{
				$sqlInsert="insert into URLsite(URL) values ('$value');";
				mysql_query($sqlInsert);
			}
		}
	}
	//print_r($_REQUEST['chk']);

	if(!empty($_REQUEST['chk']))
	{
		$tmp_idd="";
		foreach($_REQUEST['chk'] as $key=>$idd)
		{
			$tmp_idd=$tmp_idd.$idd.",";
		}
		$tmp_idd=$tmp_idd."-1";
		$sql_del="delete from URLsite where id in ($tmp_idd)";
	}
	mysql_query($sql_del);
    //echo $tmp_idd;
	
	$siteSQL="select * from URLsite order by id desc limit 15";
	$siteRES=mysql_query($siteSQL);
	$siteARR=mysql_fetch_array($siteRES);
	$num_sitARR=mysql_num_rows($siteRES);
	while($siteARR)
	{
		list($usec, $sec) = explode(" ", microtime());
		$mirsec=((float)$usec + (float)$sec);
		$base_url = "".$siteARR['URL']."/app/member/FT_browse/index.php?rtype=f&uid=$uid&langx=zh-cn&mtype=3";
		$thisHttp = new cHTTP();
		$thisHttp->setReferer($base_url);
		$filename="".$siteARR['URL']."/app/member/FT_browse/body_var.php?rtype=f&uid=$uid&langx=zh-cn&mtype=3";
		$thisHttp->getPage($filename);
		$msg  = $thisHttp->getContent();
//
//匹配：parent.uid='$uid';成功代表网址可用，失败代表不可用。
//gzinflate函数不可用也说明该网站不可用。
		$tmp=substr($msg,10);
		if(strlen($tmp)<200)
		{
			$mirsec="该网址不可用。";
		}
		else
		{
			$meg .= gzinflate(substr($msg,10));
			$a = array("if(self == top)","<script>","</script>","\n\n");
			$b = array("","","","");
			$msg = str_replace($a,$b,$msg);
			preg_match_all("/Array\((.+?)\);/is",$meg,$matches);
			//echo $meg;
			list($usec, $sec) = explode(" ", microtime());
			$mirsec1=((float)$usec + (float)$sec);
			$mirsec=$mirsec1-$mirsec;
			addcslashes($meg,'\"');
			if($mirsec>5 or !preg_match("/parent[.]uid=\'".$uid."\'/",$meg))
			{
				$mirsec="该网址不可用。请更换UID后再次测试。";
			}
		}

		/**************************/
		echo "
		<table  width=\"80%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\">
		<tr bgcolor=\"#FFFFFF\"><td \"center\" width=\"30%\"><input type=\"text\" name=\"txt[]\" value=\"".$siteARR['URL']."\"/></td><td \"center\" width=\"30%\">".$mirsec."</td><td \"center\" width=\"40%\"><label><input type=\"checkbox\" name=\"chk[]\" value=\"".$siteARR['id']."\"/>删除</label>&nbsp;/<a href=\"modify1.php?url=".base64_encode($siteARR['URL'])."\">使用</a></td></tr>
		</table>";
		flush();
		ob_flush();
		$siteARR=mysql_fetch_array($siteRES);
	}
	$less=15-$num_sitARR;
	for($i=0;$i<$less;$i++)
	{
		echo "
		<table  width=\"80%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\">
		<tr bgcolor=\"#FFFFFF\"><td \"center\" width=\"30%\"><input type=\"text\" name=\"txt[]\" value=\"\"/></td><td \"center\" width=\"30%\">&nbsp;</td><td \"center\" width=\"40%\">&nbsp;</td></tr>
		</table>";
	}
}
?>
<table width="80%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
<tr bgcolor="#FFFFFF"><td align="left"><font color="#FF0000">说明：<br />如果出现：Warning的乱码，请将Warning下的一条网址删除，该网址肯定不可用。<br />如果时间列全部显示为"该网址不可用。"，有可能是UID出错。请更换UID再次测试。<br />要添加地址，请直接把网址复制黏贴到文本框里，注意：地址的最后不要有"/"。</font></td></tr>
</table>
<div align="right" style="width:800px">
  <input type="submit" name="test" value="测  试"/>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
</form>
</div>
</body>
</html>