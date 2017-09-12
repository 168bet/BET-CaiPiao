<?
session_start();
include ("../include/address.mem.php");
require ("../include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$tpye=$_REQUEST['tpye'];
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
   echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="975">&nbsp;&nbsp;新增联盟&nbsp;--&nbsp;<a href="javascript:history.go( -1 );">回上一頁</a></td>                
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td> 
    </tr> 
  </table> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
    <tr>  
      <td width="100%" height="4"></td> 
    </tr> 
    <tr> 
      <td ></td> 
    </tr> 
  </table>
<?
$i=0;
$date=date("Y-m-d",time()+10*24*60*60);
$mysql = "select distinct M_League,M_League_tw,M_League_en FROM match_sports where Type='".$tpye."' and M_Date<='".$date."'";
$result = mysql_query($mysql);
while($row=mysql_fetch_array($result)){
$league=$row['M_League'];
$league_tw=$row['M_League_tw'];
$league_en=$row['M_League_en'];
$m_sql="select * from match_league where Type='".$tpye."' and M_League='".$league."'";

$m_result = mysql_query($m_sql);
if($m_cou=mysql_fetch_array($m_result)){
}else{
  if ($league!=""){
  $sql="insert into match_league set M_League='".$league."',M_League_tw='".$league_tw."',M_League_en='".$league_en."',Type ='".$tpye ."'";
  mysql_query($sql);
  echo "&nbsp;&nbsp;成功添加".$i."条".$league."<br>";
  $i++;
  }
}
}
if ($i==0){
echo "&nbsp;&nbsp;无新联盟";
}
?>
</body>
</html>