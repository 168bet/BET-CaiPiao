<?php
require ("../include/config.inc.php");
require ('../include/curl_http.php');
require ("../include/define_function.php");

$mysql = "select Uid_tw,datasite_tw,udp_ft_score,udp_ft_results from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$sid=$row['Uid_tw'];
$site=$row['datasite_tw'];
$settime=$row['udp_ft_score'];
$time=$row['udp_ft_results'];
$list_date=date('Y-m-d',time()-$time*60*60);
$date=date('Y-m-d',time()-$time*60*60);
$mDate=date('Y-m-d',time()-$time*60*60);

$curl = &new Curl_HTTP_Client();
$curl->store_cookies("cookies.txt"); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
$curl->set_referrer("".$site."/app/member/FT_browse/index.php?rtype=re&uid=$sid&langx=zh_tw&mtype=3");
$html_data=$curl->fetch_url("".$site."/app/member/FT_browse/body_var.php?rtype=re&uid=$sid&langx=zh_tw&mtype=3");
$a = array(
"<font style=background-color=red>",
"</font>"
);
$b = array(
"",
""
);
//echo $html_date;exit;
	preg_match_all("/new Array\((.+?)\);/is",$html_data,$matches);
	$cou1=sizeof($matches[0]);
	//print_r($matches);
	for($i=0;$i<$cou1;$i++){
		$messages=$matches[0][$i];
		$messages=str_replace("new Array(","",$messages);
		$messages = str_replace($a,$b,$messages);

	    $messages=str_replace(");","",$messages);
	    $messages=str_replace("'","",$messages);
	    $datainfo=explode(",",$messages);
		
		$mb_inball_hr=trim(strip_tags($datainfo[18]));
		$tg_inball_hr=trim(strip_tags($datainfo[19]));
		//print_r($datainfo);
		$thistime=date("Y-m-d H:i:s",(time()-25));
		$sql="select * from web_report_data where QQ83068506<>'' and BetTime>'$thistime' and MID='".(int)$datainfo[0]."' and M_Date='".$list_date."'";
		//$sql="select * from web_report_data where QQ83068506<>'' and BetTime>'$thistime' and MID='".(int)$datainfo[0]."' and M_Date='".$list_date."'";
		
	//	echo $sql."<br>";
		$result = mysql_query( $sql);
		while($rows=mysql_fetch_array($result)){
			$id=$rows['ID'];
			$mid=$rows['MID'];
			$username=$rows['M_Name'];
			$betscore=$rows['BetScore'];
			$m_result=$rows['M_Result'];			
			$inball=$mb_inball_hr.":".$tg_inball_hr;
			if($rows['QQ83068506']!=$inball){
				 $sql="update web_report_data set VGOLD='0',M_Result='0',D_Result='0',C_Result='0',B_Result='0',A_Result='0',T_Result='0',Cancel=1,Checked=1,Confirmed='-18' where MID='".$mid."'";
				 mysql_query( $sql);
				 //echo $sql."<br>";
				  if ($m_result==''){
					  $u_sql = "update web_member_data SET Money=Money+$betscore where UserName='$username' and Pay_Type=1";
					  //echo $u_sql."<br>";
					  mysql_query($u_sql) or die ("现金恢复操作失败!");
					  $mysql="insert  into web_report_logs (rid,username,money,gold,mtype) values('".$id."','".$username."',(select money from web_member_data where username='".$username."'),'".$betscore."','进球取消')";
					  mysql_query($mysql);
				  }

			}
		}

		
	}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>进球取消</title>
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
<script> 
<!-- 
var limit="8" 
if (document.images){ 
	var parselimit=limit
} 
function beginrefresh(){ 
if (!document.images) 
	return 
if (parselimit==1) 
	window.location.reload() 
else{ 
	parselimit-=1 
	curmin=Math.floor(parselimit) 
	if (curmin!=0) 
		curtime=curmin+"秒后自动获取最新数据！" 
	else 
		curtime=cursec+"秒后自动获取最新数据！" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 
window.onload=beginrefresh 
//--> 
</script>
<body>
<table width="220" height="190" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="220" height="190" align="center"><?=$date?><br><br><span id="timeinfo"></span><br>
	<input type=button name=button value="足球刷新" onClick="window.location.reload()"></td>  
  </tr>
</table>
</body>
</html>