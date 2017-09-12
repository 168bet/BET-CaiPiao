<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
$uid=$_REQUEST['uid'];
$lv=$_REQUEST['lv'];
$mdate=$_REQUEST['mdate'];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_agents_data where Oid='$uid' and LoginName='$loginname' and Status<=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('/','_top')</script>";
}
$username=$row['UserName'];

$sdate1=date('Y-m-d');
$sdate2=date('Y-m-d',time()-24*60*60);
$sdate3=date('Y-m-d',time()-2*24*60*60);
$sdate4=date('Y-m-d',time()-3*24*60*60);
$sdate5=date('Y-m-d',time()-4*24*60*60);
$sdate6=date('Y-m-d',time()-5*24*60*60);
$sdate7=date('Y-m-d',time()-6*24*60*60);
$sdate8=date('Y-m-d',time()-7*24*60*60);
$sdate9=date('Y-m-d',time()-8*24*60*60);
$sdate10=date('Y-m-d',time()-9*24*60*60);

$tdate1=date('Y-m-d');
$tdate2=date('Y-m-d',time()-24*60*60);
$tdate3=date('Y-m-d',time()-2*24*60*60);
$tdate4=date('Y-m-d',time()-3*24*60*60);
$tdate5=date('Y-m-d',time()-4*24*60*60);
$tdate6=date('Y-m-d',time()-5*24*60*60);
$tdate7=date('Y-m-d',time()-6*24*60*60);
$tdate8=date('Y-m-d',time()-7*24*60*60);
$tdate9=date('Y-m-d',time()-8*24*60*60);
$tdate10=date('Y-m-d',time()-9*24*60*60);
	
if ($mdate=='' or $mdate==$sdate1){
	$sdate1='<font color=red size=2><b>'.$sdate1.'</b></font>';
}else if ($mdate==$sdate2){
	$sdate2='<font color=red size=2><b>'.$sdate2.'</b></font>';
}else if ($mdate==$sdate3){
	$sdate3='<font color=red size=2><b>'.$sdate3.'</b></font>';
}else if ($mdate==$sdate4){
	$sdate4='<font color=red size=2><b>'.$sdate4.'</b></font>';
}else if ($mdate==$sdate5){
	$sdate5='<font color=red size=2><b>'.$sdate5.'</b></font>';
}else if ($mdate==$sdate6){
	$sdate6='<font color=red size=2><b>'.$sdate6.'</b></font>';
}else if ($mdate==$sdate7){
	$sdate7='<font color=red size=2><b>'.$sdate7.'</b></font>';
}else if ($mdate==$sdate8){
	$sdate8='<font color=red size=2><b>'.$sdate8.'</b></font>';
}else if ($mdate==$sdate9){
	$sdate9='<font color=red size=2><b>'.$sdate9.'</b></font>';
}else if ($mdate==$sdate10){
	$sdate10='<font color=red size=2><b>'.$sdate10.'</b></font>';
}
if ($mdate==''){
	$mdate=date('Y-m-d');
}

?>
<html>
<head>
<title>show_marquee</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">

a:link {  text-decoration: none}
a:visited {  text-decoration: none}

<!--
tr {font-family: "Arial";font-size: 12px;}
.ad_title {
        color: #FFFFFF;
        background-color: #D9C332;
        border-top: 1px solid #707161;
        border-right: 1px solid #707161;
        border-bottom: 0px solid #707161;
        border-left: 1px solid #707161;
        padding-top: 4px;
        padding-right: 2px;
        padding-left: 8px;
}
.b_tab {
        padding-top: 4px;
        padding-bottom: 2px;
        padding-left: 4px;
        background-color: #707161;
        width: 745px;
}
.b_tbline {
        background-color: #BBB1A1;
        padding-top: 2px;
        padding-right: 2px;
        padding-bottom: 2px;
        padding-left: 2px;
        width: 750px;
        border-top: 0px solid #707161;
        border-right: 1px solid #707161;
        border-bottom: 1px solid #707161
        border-left: 1px solid #707161;}
-->
</style>

</head>

<body bgcolor="#FFFFFF" text="#000000" vlink="#0000FF" alink="#0000FF" onselectstart="return false;">


<table width="760" border="0" cellspacing="0" cellpadding="0" class="m_tab_ed" >
    <tr> 
        <td><?=$His_Date?>
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate1?>"><?=$sdate1?></a>&nbsp;&nbsp;
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate2?>"><?=$sdate2?></a>&nbsp;&nbsp;
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate3?>"><?=$sdate3?></a>&nbsp;&nbsp;
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate4?>"><?=$sdate4?></a>&nbsp;&nbsp;
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate5?>"><?=$sdate5?></a>&nbsp;&nbsp;
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate6?>"><?=$sdate6?></a>&nbsp;&nbsp;
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate7?>"><?=$sdate7?></a>&nbsp;&nbsp;
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate8?>"><?=$sdate8?></a>&nbsp;&nbsp;
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate9?>"><?=$sdate9?></a>&nbsp;&nbsp;
		<a href="/app/agents/other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&mdate=<?=$tdate10?>"><?=$sdate10?></a>&nbsp;&nbsp;		
        </td>
    </tr>
</table>
  <table border="0" cellpadding="0" cellspacing="0" class="b_title" width="750">
	<tr>
      <td class="ad_title"><b><?=$Marquee?>:</b></td>
	</tr>
  </table>
  <div class="b_tbline">
  <table border="0" cellpadding="0" cellspacing="1" class="b_tab" >  	
<!--  -->
	<?
	$sql="select Date,$message as Message from web_marquee_data where Date='".$mdate."' and Level='$lv' order by ID desc";
	$result = mysql_db_query($dbname,$sql);
	while ($row = mysql_fetch_array($result)){
	?>
	<tr>
      <td bgcolor="#FFFFFF" width="80" align="center"><?=$row['Date']?></td>
	  <td bgcolor="#FFFFFF"><?=$row['Message']?></td>
	</tr>
	<?
	}
	?>
<!--  -->
  </table>
</div>
</body>
</html>
<?
if($lv=='MEM'){
$loginfo='查询会员公告'.$mdate.'';
}else{
$loginfo='查询管理公告'.$mdate.'';
}
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$username',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>