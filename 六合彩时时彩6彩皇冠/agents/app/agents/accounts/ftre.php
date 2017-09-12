<?
require ("../include/config.inc.php");
$mysql = "select * from web_system_data";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$fttiem=$row['udp_ft_time'];
$tiemft=$row['udp_time_ft'];
$time=date('Y-m-d H:i:s',time()-1*$fttiem);
$times=date('Y-m-d H:i:s',time()-1*$tiemft);
$datetime=date('Y-m-d H:i:s');
$date=date('Y-m-d');
$checksql="update match_sports set `type`='FT' where `TYPE`='FU' AND M_Start<now()";
mysql_query($checksql) or die ("操作失败1!");
$checksql="update match_sports set `type`='BK' where `TYPE`='BU' AND M_Start<now()";
mysql_query($checksql) or die ("操作失败2!");
$checksql="update match_sports set `type`='BS' where `TYPE`='BE' AND M_Start<now()";
mysql_query($checksql) or die ("操作失败3!");
$checksql="update match_sports set `type`='OP' where `TYPE`='OM' AND M_Start<now()";
mysql_query($checksql) or die ("操作失败4!");
$checksql="update match_sports set`type`='VB' where `TYPE`='VU' AND M_Start<now()";
mysql_query($checksql) or die ("操作失败5!");
$checksql="update match_sports set `type`='TN' where `TYPE`='TU' AND M_Start<now()";
mysql_query($checksql) or die ("操作失败6!");

$sql = "update web_report_data set Danger=0 where BetTime<'$times' and Active=1 and Danger=1 and (LineType=9 or LineType=19 or LineType=10 or LineType=20 or LineType=21 or LineType=31 and LineType=50) and M_Result='' and Cancel!=1";
mysql_query($sql) or die ("操作失败!");

$sqls = "select ID,MID,BetTime,Middle,BetScore,M_Name,M_Result,MB_Ball,TG_Ball from web_report_data  where BetTime<'$time' and Active=1 and Danger=1 and (LineType=9 or LineType=19 or LineType=10 or LineType=20 or LineType=21 or LineType=31 OR LineType=50) and M_Result='' and Cancel!=1";
$results = mysql_db_query ($dbname, $sqls) or die ("注单显示失败!!");
while ($rows = mysql_fetch_array ($results)){

$id=$rows['ID'];
$mid=$rows['MID'];
$username=$rows['M_Name'];
$betscore=$rows['BetScore'];
$m_result=$rows['M_Result'];
$mb_ball=$rows['MB_Ball'];
$tg_ball=$rows['TG_Ball'];

$sqlf = "select MB_Ball,TG_Ball from match_sports  where Type='FT' and MID='$mid'";
$resultf = mysql_db_query ($dbname, $sqlf);
$rowf = mysql_fetch_array ($resultf);

$ft_mb_ball=$rowf['MB_Ball'];
$ft_tg_ball=$rowf['TG_Ball'];

if ($mb_ball==$ft_mb_ball and  $tg_ball==$ft_tg_ball){
    $ft_sql = "update web_report_data set Danger=0 where ID='$id'";	
    mysql_db_query ($dbname, $ft_sql) or die ("通过操作失败!"); 
}else{
    $ft_sql = "update web_report_data set VGOLD=0,M_Result=0,A_Result=0,B_Result=0,C_Result=0,D_Result=0,T_Result=0,Cancel=1,MB_Ball='$ft_mb_ball',TG_Ball='$ft_tg_ball',Confirmed=-18,Danger=0 where ID='$id'";
    mysql_db_query ($dbname, $ft_sql) or die ("进球注销操作失败!!!");
    if ($m_result==''){
        $u_sql = "update web_member_data SET Money=Money+$betscore where UserName='$username' and Pay_Type=1";
        mysql_query($u_sql) or die ("现金恢复操作失败!");
		$mysql="insert  into web_report_logs (rid,username,money,gold,mtype) values('".$id."','".$username."',(select money from web_member_data where username='".$username."'),'".$betscore."','进球取消')";
		mysql_query($mysql);		
    }
}

}
?>
<html>
<head>
<title>足球滚球注单审核</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/style/agents/control_down.css" rel="stylesheet" type="text/css">
</head>
<script> 
<!-- 
var limit="10" 
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
		curtime=curmin+" 秒后自动更新本页！" 
	else 
		curtime=cursec+" 秒后自动更新本页！" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 

window.onload=beginrefresh 
file://--> 
</script>
<body>
<table width="300" height="300" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="300" height="300" align="center"><?=$datetime?><br><br><font color="#FFFFFF"><span style="background-color: #FF0000">足球走地注单确认中，请勿关闭窗口...</span></font><br><br><span id="timeinfo"></span><br><br>
      <input type=button name=button value="足球更新" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>