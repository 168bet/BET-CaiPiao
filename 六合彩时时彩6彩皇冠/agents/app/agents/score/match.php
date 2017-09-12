<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$gid=$_REQUEST['gid'];
$date_start=$_REQUEST['date_start'];
$ggid=$_REQUEST['gid'];
$gtype=$_REQUEST['gtype'];
$page=$_REQUEST["page"];
$league=$_REQUEST["league"];
if ($gtype==''){
	$gtype='FT';
}
if ($date_start=='') {
	$date_start=date('Y-m-d');
}
if ($league==""){
	$sleague="";
}else{
    $sleague="and $m_league='".$league."'";
}
$action=$_REQUEST['action'];
$confirmed=$_REQUEST['confirmed'];

//$action==1 取消赛事和注单
if ($action==1){
	$rsql = "select M_Name,Pay_Type,BetScore,M_Result from web_report_data where MID='".$gid."' and Pay_Type=1";
	$rresult = mysql_query( $rsql);
	while ($rrow = mysql_fetch_array($rresult)){
		   $username=$rrow['M_Name'];
		   $betscore=$rrow['BetScore'];
		   $m_result=$rrow['M_Result'];
		   if ($rrow['Pay_Type']==1){//结算之后的现金返回
		       if ($m_result==''){
		           $u_sql = "update web_member_data set Money=Money+$betscore where UserName='".$username."' and Pay_Type=1";
		           mysql_query($u_sql) or die ("操作失败11!");				
		       }else{
		           $u_sql = "update web_member_data set Money=Money-$m_result where UserName='".$username."' and Pay_Type=1";
		           mysql_query($u_sql) or die ("操作失败11!");		   
		       }
		   }
	}
	$sql="update match_sports set MB_Inball='$confirmed',TG_Inball='$confirmed',TG_Inball_HR='$confirmed',MB_Inball_HR='$confirmed',Score=1,Cancel=1 where `Type`='".$gtype."' and `MID`='".$gid."'";
	mysql_query($sql) or die ("操作失败1");
	
	$sql1="update web_report_data set VGOLD=0,M_Result=0,A_Result=0,B_Result=0,C_Result=0,D_Result=0,T_Result=0,Confirmed='$confirmed',Danger=0,Cancel=1,Checked=1 where `Gtype`='".$gtype."' and `MID`='".$gid."'";

	mysql_query($sql1) or die ("操作失败2");
}

//$action==2 恢复赛事和注单
if ($action==2){
    $rsql = "select M_Name,Pay_Type,BetScore,M_Result,Checked from web_report_data where MID='".$gid."' and Pay_Type=1";
	$rresult = mysql_query( $rsql);
	while ($rrow = mysql_fetch_array($rresult)){
	   	   $username=$rrow['M_Name'];
		   $betscore=$rrow['BetScore'];
		   $m_result=$rrow['M_Result'];
		   if ($rrow['Pay_Type']==1){//结算之后的现金返回	   
		       if ($rrow['Checked']==1){//有结果
		           $cash=$betscore+$m_result;
		           $u_sql ="update web_member_data SET Money=Money-$cash where UserName='".$username."' and Pay_Type=1";
		           mysql_query($u_sql) or die ("操作失败1!");
		       }
		   }
	}
	$sql="update match_sports set MB_Inball='',TG_Inball='',TG_Inball_HR='',MB_Inball_HR='',Score=0,Cancel=0 where `Type`='".$gtype."' and `MID`='".$gid."'";
	mysql_query($sql) or die ("操作失败1");
	$rsql="update web_report_data set VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Confirmed=0,Danger=0,Cancel=0,Checked=0 where `Gtype`='".$gtype."' and `MID`='".$gid."'";
	mysql_query($rsql) or die ("操作失败2");	
}

//$action==3 关闭某一场赛事
if($action==3){
$gid=$_REQUEST['gid'];
$open=$_REQUEST['open'];
$sql="update match_sports set open='$open' where `Type`='".$gtype."' and `MID`='".$gid."'";
mysql_query($sql) or die ("操作失败3");
echo "<script languag='JavaScript'>self.location='match.php?uid=$uid&langx=$langx&gtype=$gtype&date_start=$date_start&page=$page&league=$league'</script>";
}
//$action==4 关闭全部赛事
if ($action==4){
$open=$_REQUEST['open'];
$sql="update match_sports set open='$open' where `Type`='".$gtype."' and `M_Date`='".$date_start."'";
mysql_query($sql) or die ("操作失败4");
echo "<script languag='JavaScript'>self.location='match.php?uid=$uid&langx=$langx&gtype=$gtype&date_start=$date_start&page=$page&league=$league'</script>";
}

$sql = "select MID,M_Date,M_Time,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR,Cancel,Checked,Open from `match_sports` where `Type`='".$gtype."' and M_Date='".$date_start."' ".$sleague." order by M_Start,$m_league,$mb_team asc";
$result = mysql_query($sql);
$count=mysql_num_rows($result);
$page_size=60;
$page_count=ceil($count/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_query($mysql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="javascript">
function onLoad(){
  var gtype = document.getElementById('gtype');
  gtype.value = '<?=$gtype?>';
  var league = document.getElementById('league');
  league.value = '<?=$league?>';
}
function CheckSTOP(str){
  if(confirm("确实要取消本场比赛吗?"))
  document.location=str;
}
function CheckCLOSE(str){
 if(confirm("确实要 关闭 或 开启 本场比赛所有投注项目吗?"))
  document.location=str;
}
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"  onload="onLoad()";>
<FORM NAME="myFORM" ACTION="" METHOD=POST>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="965">&nbsp;线上数据－<font color="#CC0000">审核比分&nbsp;</font>&nbsp;&nbsp;&nbsp;类别: 
       <select class=za_select onchange=document.myFORM.submit(); name=gtype>
          　<option value="FT">足球</option>
			<option value="BK">篮球</option>
			<option value="BS">棒球</option>
			<option value="TN">网球</option>
			<option value="VB">排球</option>
			<option value="OP">其它</option>
			<option value="FU">指数</option>
         	<option value="FS">特殊</option>
	    </select>
        比赛日期: 
        <select class=za_select onchange=document.myFORM.submit(); name=date_start>
				<option value=""></option> 
<?
$dd = 24*60*60;
$t = time();
$aa=0;
$bb=0;
for($i=0;$i<=15;$i++)
{
	$today=date('Y-m-d',$t);
	if ($date_start==date('Y-m-d',$t)){
		echo "<option value='$today' selected>".date('Y-m-d',$t)."</option>";	
	}else{
		echo "<option value='$today'>".date('Y-m-d',$t)."</option>";	
	}
$t -= $dd;
}
?>
		</select>
      -- 管理模式:WEB页面 -- <a href="javascript:history.go( -1 );">回上一頁</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="match.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&date_start=<?=$date_start?>&action=4&open=1" title="点击会全部显示">全部显示</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="match.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&date_start=<?=$date_start?>&action=4&open=0" title="点击会全部关闭"><font color=red>全部关闭</font></a></td>               
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td> 
    </tr> 
  </table> 
  <table width="774" border="0" cellspacing="0" cellpadding="0"> 
    <tr>  
      <td width="774" height="4"></td> 
    </tr> 
    <tr> 
      <td ></td> 
    </tr> 
  </table>
  <table id="glist_table" border="0" cellspacing="1" cellpadding="0" class="m_tab" width="975">
    <tr class="m_title">
      <td colspan="3" align="left">&nbsp;选择联盟:
	  <select class=za_select onchange=document.myFORM.submit(); name=league>
	  <option value="">全部</option>
	  <?
	  $league_mysql = "select distinct $m_league as M_League FROM `match_sports` WHERE `Type`='".$gtype."' and `M_Date`='".$date_start."'";
	  $league_result = mysql_query( $league_mysql);
	  while($league_row=mysql_fetch_array($league_result)){
		    echo "<OPTION value='$league_row[M_League]'>$league_row[M_League]</OPTION>";
	  }
	  ?>
	  </select>
	  </td>
      <td colspan="4" align="left">&nbsp;
      <?
	  for($i=0;$i<$page_count;$i++){
		 //$num=$i+1;
		 echo "<a href='match.php?uid=$uid&langx=$langx&gtype=$gtype&date_start=$date_start&page=$i&league=$league'><font color=red><b>".($i+1)."页</b></font></a>&nbsp;&nbsp;";
	  }
	  ?>
	  </td>
      <td colspan="4" align="center">功能</td>
	</tr>
    <tr class="m_title"> 
      <td align="middle" width="139" ><?=$date_start?>--赛事</td>
      <td align="middle" width="40">时间</td>
      <td align="middle" width="180">主场队伍</td>
      <td align="middle" width="90">全场比分</td>
      <td align="middle" width="180">客场队伍</td>
      <td align="middle" width="90">半场比分</td>
      <td align="middle" width="84">赛事取消</td>
      <td align="middle" width="40">注单</td>
      <td align="middle" width="40">操作</td>
      <td align="middle" width="40">显示</td>
	  <td align="middle" width="40">状态</td>
    </tr>
<?
if ($count<>0){
while ($row = mysql_fetch_array($result)){
if($row['MID']==$ggid){
?>
    <tr class="m_title" onmouseover=sbar(this) onmouseout=cbar(this)>
<?
}else{
?>
    <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)> 
<?
}
?>
      <td width="139"><?=$row["M_League"]?></td>
      <td width="40"><?=$row["M_Time"]?></td>
      <td width="180"><div align="right"><?=str_replace('[主]','',$row["MB_Team"])?></div></td>
      <td width="90"><a href="./showdata.php?uid=<?=$uid?>&gid=<?=$row['MID']?>&date_start=<?=$row['M_Date']?>&gtype=<?=$gtype?>&langx=<?=$langx?>">
<? if ($row["MB_Inball"]=='-1'){
?>
	<font color="red"><b><?=$Score1?></b></font>
<?	
}else if($row["MB_Inball"]=='-2'){
?>
	<font color="red"><b><?=$Score2?></b></font>
<?
}else if($row["MB_Inball"]=='-3'){
?>
	<font color="red"><b><?=$Score3?></b></font>
<?
}else if($row["MB_Inball"]=='-4'){
?>
	<font color="red"><b><?=$Score4?></b></font>
<?
}else if($row["MB_Inball"]=='-5'){
?>
	<font color="red"><b><?=$Score5?></b></font>
<?
}else if($row["MB_Inball"]=='-6'){
?>
	<font color="red"><b><?=$Score6?></b></font>
<?
}else if($row["MB_Inball"]=='-7'){
?>
	<font color="red"><b><?=$Score7?></b></font>
<?
}else if($row["MB_Inball"]=='-8'){
?>
	<font color="red"><b><?=$Score8?></b></font>	
<?
}else if($row["MB_Inball"]=='-9'){
?>
	<font color="red"><b><?=$Score9?></b></font>		
<?
}else if($row["MB_Inball"]=='-10'){
?>
	<font color="red"><b><?=$Score10?></b></font>	
<?
}else if($row["MB_Inball"]=='-11'){
?>
	<font color="red"><b><?=$Score11?></b></font>	
<?	
}else if($row["MB_Inball"]=='-12'){
?>
	<font color="red"><b><?=$Score12?></b></font>
<?	
}else if($row["MB_Inball"]=='-13'){
?>
	<font color="red"><b><?=$Score13?></b></font>	
<?	
}else if($row["MB_Inball"]=='-14'){
?>
	<font color="red"><b><?=$Score14?></b></font>
<?	
}else if($row["MB_Inball"]=='-15'){
?>
	<font color="red"><b><?=$Score15?></b></font>
<?	
}else if($row["MB_Inball"]=='-16'){
?>
	<font color="red"><b><?=$Score16?></b></font>
<?	
}else if($row["MB_Inball"]=='-17'){
?>
	<font color="red"><b><?=$Score17?></b></font>
<?	
}else if($row["MB_Inball"]=='-18'){
?>
	<font color="red"><b><?=$Score18?></b></font>
<?	
}else if($row["MB_Inball"]=='-19'){
?>
	<font color="red"><b><?=$Score19?></b></font>				
<?
}else{
?>
	<font color="red"><b><?=$row["MB_Inball"]?></b> - <b><?=$row["TG_Inball"]?></b></font>
<?
}
?>
</a></td>
      <td width="180"><div align="left"><?=$row["TG_Team"]?></div></td>
      <td width="90"><a href="./showdata.php?uid=<?=$uid?>&gid=<?=$row['MID']?>&date_start=<?=$row['M_Date']?>&gtype=<?=$gtype?>&langx=<?=$langx?>">
<? 
if ($row["MB_Inball_HR"]=='-1'){
?>
	<font color="red"><b><?=$Score1?></b></font>
<?	
}else if($row["MB_Inball_HR"]=='-2'){
?>
	<font color="red"><b><?=$Score2?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-3'){
?>
	<font color="red"><b><?=$Score3?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-4'){
?>
	<font color="red"><b><?=$Score4?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-5'){
?>
	<font color="red"><b><?=$Score5?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-6'){
?>
	<font color="red"><b><?=$Score6?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-7'){
?>
	<font color="red"><b><?=$Score7?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-8'){
?>
	<font color="red"><b><?=$Score8?></b></font>	
<?
}else if($row["MB_Inball_HR"]=='-9'){
?>
	<font color="red"><b><?=$Score9?></b></font>	
<?
}else if($row["MB_Inball_HR"]=='-10'){
?>
	<font color="red"><b><?=$Score10?></b></font>	
<?
}else if($row["MB_Inball_HR"]=='-11'){
?>
	<font color="red"><b><?=$Score11?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-12'){
?>
	<font color="red"><b><?=$Score12?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-13'){
?>
	<font color="red"><b><?=$Score13?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-14'){
?>
	<font color="red"><b><?=$Score14?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-15'){
?>
	<font color="red"><b><?=$Score15?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-16'){
?>
	<font color="red"><b><?=$Score16?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-17'){
?>
	<font color="red"><b><?=$Score17?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-18'){
?>
	<font color="red"><b><?=$Score18?></b></font>
<?
}else if($row["MB_Inball_HR"]=='-19'){
?>
	<font color="red"><b><?=$Score19?></b></font>
<?
}else{
?>
	<font color="red"><b><?=$row["MB_Inball_HR"]?></b> - <b><?=$row["TG_Inball_HR"]?></b></font>
<?
}
?>
</a></td>
     
     <td width="84"><SELECT onchange=javascript:CheckSTOP(this.options[this.selectedIndex].value) size=1 name=select1>
  <option>赛事处理</option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-1"><?=$Score1?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-2"><?=$Score2?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-3"><?=$Score3?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-4"><?=$Score4?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-5"><?=$Score5?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-6"><?=$Score6?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-7"><?=$Score7?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-8"><?=$Score8?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-9"><?=$Score9?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-10"><?=$Score10?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-11"><?=$Score11?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-12"><?=$Score12?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-13"><?=$Score13?></option>
  <!--option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-14"><?=$Score14?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-15"><?=$Score15?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-16"><?=$Score16?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-17"><?=$Score17?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-18"><?=$Score18?></option>
  <option value="match.php?uid=<?=$uid?>&langx=<?=$langx?>&action=1&gtype=<?=$gtype?>&gid=<?=$row[MID]?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&confirmed=-19"><?=$Score19?></option-->
  
</SELECT></td>
     <td width="40"><a href="./showdata.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&gid=<?=$row['MID']?>&date_start=<?=$row['M_Date']?>">注单</a></td>
     <td width="40"><a href="set_score.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&gid=<?=$row['MID']?>&date_start=<?=$row['M_Date']?>">结算</a><br>
	 <? 
	 if ($row['Checked']==1){
		 echo "<font color=red>二次<br>比分</font>";
	 }
	 ?></td>
     <td width="40">
	 <?
	 if ($row['MB_Inball']!=''){
	 ?>
	 <a href="match.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&gid=<?=$row['MID']?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&action=2"><font color=blue>恢复</font></a>
	 <?
	 }else{
	 ?>
	 正常
	 <?
	 }
	 ?></td>
     <td width="40">
	 <?
	 if ($row["Open"]==1){
	 ?>
	 <a href=javascript:CheckCLOSE("match.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&gid=<?=$row['MID']?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&action=3&open=0")>开盘</a>
	 <?
	 }else{
	 ?>
	 <a href=javascript:CheckCLOSE("match.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>&gid=<?=$row['MID']?>&date_start=<?=$row['M_Date']?>&page=<?=$page?>&league=<?=$league?>&action=3&open=1")><font color=red>关盘</font></a>
	 <?
	 }
	 ?>	 </td>
    </tr>
<?
}
}
?>
  </table>
</form>
</body>
</html>
<?
$loginfo='取消或者已取消了棒球MID'.$gid.'的球赛';
$agname=$username_log;
$ip_addr = get_ip();
$mysql_log="insert into web_mem_log_data(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_query($mysql_log);	
?>
