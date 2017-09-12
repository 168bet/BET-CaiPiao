<?
require ("../include/config.inc.php");
$mysql = "select * from web_system_data";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
$optiem=$row['udp_op_time'];
$tiemop=$row['udp_time_op'];
$time=date('Y-m-d H:i:s',time()-1*$optiem);
$times=date('Y-m-d H:i:s',time()-1*$tiemop);
$datetime=date('Y-m-d H:i:s');
$date=date('Y-m-d');
$sql = "update web_report_data set Danger=0 where M_Date='$date' and BetTime<'$times' and Active=5 and Danger=1 and (LineType=9 or LineType=10) and M_Result='' and Cancel!=1";
mysql_db_query($dbname,$sql) or die ("操作失败!");

$sqls = "select ID,MID,Middle,BetScore,M_Name,M_Result,MB_Ball,TG_Ball from web_report_data  where M_Date='$date' and BetTime<'$time' and Active=5 and Danger=1 and (LineType=9 or LineType=10) and M_Result='' and Cancel!=1";
$results = mysql_db_query ($dbname, $sqls) or die ("注单显示失败!!");
while ($rows = mysql_fetch_array ($results)){
$id=$rows['ID'];
$mid=$rows['MID'];
$username=$rows['M_Name'];
$betscore=$rows['BetScore'];
$m_result=$rows['M_Result'];
$mb_ball=$rows['MB_Ball'];
$tg_ball=$rows['TG_Ball'];

$sqlf = "select MB_Ball,TG_Ball from match_sports  where Type='VB' and MID='$mid'";
$resultf = mysql_db_query ($dbname, $sqlf);
$rowf = mysql_fetch_array ($resultf);

$vb_mb_ball=$rowf['MB_Ball'];
$vb_tg_ball=$rowf['TG_Ball'];

if ($mb_ball==$vb_mb_ball and  $tg_ball==$vb_tg_ball){
    $ft_sql = "update web_report_data set Danger=0 where ID='$id'";	
    mysql_db_query ($dbname, $ft_sql) or die ("通过操作失败!"); 
}else{
    $ft_sql = "update web_report_data set VGOLD=0,M_Result=0,A_Result=0,B_Result=0,C_Result=0,D_Result=0,T_Result=0,Cancel=1,MB_Ball='$vb_mb_ball',TG_Ball='$vb_tg_ball',Confirmed=-18,Danger=0 where ID='$id'";
    mysql_db_query ($dbname, $ft_sql) or die ("进球注销操作失败!!!");
    if ($m_result==''){
        $u_sql = "update web_member_data SET Money=Money+$betscore where UserName='$username' and Pay_Type=1";
        mysql_db_query($dbname,$u_sql) or die ("现金恢复操作失败!");
    }
}

}
?>
<html>
<head>
<title>排球滚球注单审核</title>
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
    <td width="300" height="300" align="center"><?=$datetime?><br><br><font color="#FFFFFF"><span style="background-color: #FF0000">排球走地注单确认中，请勿关闭窗口...</span></font><br><br><span id="timeinfo"></span><br><br>
      <input type=button name=button value="排球更新" onClick="window.location.reload()"></td>
  </tr>
</table>
</body>
</html>