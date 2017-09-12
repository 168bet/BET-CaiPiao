<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$date_start=$_REQUEST['date_start'];
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
    $sleague="and $m_league='$league'";
}
$action=$_REQUEST['action'];
//关闭某一场赛事
if($action==1){
$gid=$_REQUEST['gid'];
$open=$_REQUEST['open'];
$sql="update `match_sports` set open='$open' where `Type`='".$gtype."' and `MID`='".$gid."'";
mysql_db_query($dbname,$sql) or die ("操作失败3");
echo "<script languag='JavaScript'>self.location='play_game.php?uid=$uid&gtype=$gtype&date_start=$date_start&langx=$langx'</script>";
}

$sql = "select MID,M_Type,M_Date,M_Time,M_Start,MB_MID,TG_MID,$mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,ShowTypeR,MB_Win_Rate,TG_Win_Rate,M_Flat_Rate,M_LetB,MB_LetB_Rate,TG_LetB_Rate,MB_Dime,TG_Dime,MB_Dime_Rate,TG_Dime_Rate,S_Single_Rate,S_Double_Rate,ShowTypeHR,M_LetB_H,MB_LetB_Rate_H,TG_LetB_Rate_H,MB_Dime_H,TG_Dime_H,MB_Dime_Rate_H,TG_Dime_Rate_H,MB_Win_Rate_H,TG_Win_Rate_H,M_Flat_Rate_H,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR,Cancel,Checked,Open from match_sports where Type='".$gtype."' and M_Date='".$date_start."' and MB_Inball='' ".$sleague." order by `M_Start`,`$m_league`,`$mb_team` asc";
$result = mysql_db_query($dbname, $sql);
$count=mysql_num_rows($result);
$page_size=50;
$page_count=ceil($count/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_db_query($dbname,$mysql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<SCRIPT>
<!--
function onLoad(){
  var gtype = document.getElementById('gtype');
  gtype.value = '<?=$gtype?>';
  var league = document.getElementById('league');
  league.value = '<?=$league?>';
}
function CheckCLOSE(str){
 if(confirm("确实要关闭本场比赛所有投注项目吗?"))
  document.location=str;
}
function CheckDELETE(str){
 if(confirm("确实要删除本场赛事吗?"))
  document.location=str;
}
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}
// -->
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"  onload="onLoad()";>

<FORM NAME="myFORM" ACTION="" METHOD=POST>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="975">&nbsp;线上数据－<font color="#CC0000">赛程数据&nbsp;</font>&nbsp;&nbsp;&nbsp;<a href="parlay.php?uid=<?=$uid?>&langx=<?=$langx?>">过关注单</a>&nbsp;&nbsp;&nbsp;<a href="data_add.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=<?=$gtype?>">赛程添加</a>&nbsp;&nbsp;&nbsp;类别: 
       <select class="za_select" onChange="document.myFORM.submit();" name="gtype">
          　<option value="FT">足球</option>
			<option value="BK">篮球</option>
			<option value="BS">棒球</option>
			<option value="TN">网球</option>
			<option value="VB">排球</option>
			<option value="OP">其它</option>
         	<option value="FS">特殊</option>
            <option value="FU">足球早餐</option>
			<option value="BU">篮球早餐</option>
			<option value="BE">棒球早餐</option>
			<option value="TU">网球早餐</option>
			<option value="VU">排球早餐</option>
			<option value="OM">其它早餐</option>
	    </select>
        日期: 
     <select class="za_select" onChange="document.myFORM.submit();" name="date_start">
	
<?
$date_sql = "select M_Date from `match_sports` WHERE Type='".$gtype."' and MB_Inball='' group by M_Date order by M_Date";
$date_result = mysql_db_query($dbname,$date_sql);
$cou=mysql_num_rows($date_result);
if ($cou==0){
	$m_date=date('Y-m-d');
	echo '<option value="$m_date">'.$m_date.'</option>';
}else{
	echo '<option value=""></option>';
}
while ($date_row = mysql_fetch_array($date_result)){
if ($date_row['M_Date']==''){
	$m_date=date('Y-m-d');
	$today=$m_date;
}else{
	$m_date=$date_row['M_Date'];
	$today=$date_row['M_Date'];
}
	$today=$date_row['M_Date'];
	if ($date_start==$today){
		echo "<option value='$today' selected>".$m_date."</option>";	
	}else{
		echo "<option value='$today'>".$m_date."</option>";	
	}
}
?>
</select>
    -- 管理模式:WEB页面 -- <a href="javascript:history.go( -1 );">回上一頁</a></td>                
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td> 
    </tr> 
  </table> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
    <tr>  
      <td width="100%"></td> 
    </tr> 
    <tr> 
      <td ></td> 
    </tr> 
  </table>
  <table id="glist_table" border="0" cellspacing="1" cellpadding="0" class="m_tab" width="975">
    <tr class="m_title">
      <td colspan="3" align="left">&nbsp;选择联盟:
	  <select class="za_select" onChange="document.myFORM.submit();" name="league">
	  <option value="">全部</option>
	  <?
	  $league_mysql = "select distinct $m_league as M_League FROM `match_sports` WHERE `Type`='".$gtype."' and `M_Date`='".$date_start."' and MB_Inball=''";
	  $league_result = mysql_db_query($dbname, $league_mysql);
	  while($league_row=mysql_fetch_array($league_result)){
		    echo "<OPTION value='$league_row[M_League]'>$league_row[M_League]</OPTION>";
	  }
	  ?>
	  </select>	  </td>
      <td colspan="7" align="left">&nbsp;
      <?
	  for($i=0;$i<$page_count;$i++){
		 //$num=$i+1;
		 echo "<a href='play_game.php?uid=$uid&langx=$langx&gtype=$gtype&date_start=$date_start&page=$i'><font color=red><b>".($i+1)."页</b></font></a>&nbsp;&nbsp;";
	  }
	  ?>	  </td>
      <td>&nbsp;</td>
    </tr>
    <tr class="m_title"> 
        <td width="70">时间</td>
        <td width="50">场次</td>
        <td width="173">队伍</td>
        <td width="60">全场独赢</td>
        <td width="90">全场让球</td>
        <td width="90">全场大小球</td>
        <td width="60">全场单双</td>
        <td width="60">半场独赢</td>
        <td width="90">半场让球</td>
        <td width="90">半场大小</td>
        <td width="130">操作</td>
    </tr>
<?
while ($row = mysql_fetch_array($result)){
	$MB_Win_Rate=num_rate($open,$row["MB_Win_Rate"]);
	$TG_Win_Rate=num_rate($open,$row["TG_Win_Rate"]);
	$M_Flat_Rate=num_rate($open,$row["M_Flat_Rate"]);
	$MB_LetB_Rate=change_rate($open,$row['MB_LetB_Rate']);
	$TG_LetB_Rate=change_rate($open,$row['TG_LetB_Rate']);
	$MB_Dime_Rate=change_rate($open,$row["MB_Dime_Rate"]);
	$TG_Dime_Rate=change_rate($open,$row["TG_Dime_Rate"]);
	
	$S_Single_Rate=num_rate($open,$row['S_Single_Rate']);
	$S_Double_Rate=num_rate($open,$row['S_Double_Rate']);
	
	$MB_Win_Rate_H=num_rate($open,$row["MB_Win_Rate_H"]);
	$TG_Win_Rate_H=num_rate($open,$row["TG_Win_Rate_H"]);
	$M_Flat_Rate_H=num_rate($open,$row["M_Flat_Rate_H"]);
	$MB_LetB_Rate_H=change_rate($open,$row['MB_LetB_Rate_H']);
	$TG_LetB_Rate_H=change_rate($open,$row['TG_LetB_Rate_H']);
	$MB_Dime_Rate_H=change_rate($open,$row["MB_Dime_Rate_H"]);
	$TG_Dime_Rate_H=change_rate($open,$row["TG_Dime_Rate_H"]);	
	if ($row['ShowTypeR']=='H'){
		$MB_LetB=$row['M_LetB'];
		$TG_LetB='';
	}else{
		$MB_LetB='';
		$TG_LetB=$row['M_LetB'];
	}
	if ($row['ShowTypeHR']=='H'){
		$MB_LetB_H=$row['M_LetB_H'];
		$TG_LetB_H='';
	}else{
		$MB_LetB_H='';
		$TG_LetB_H=$row['M_LetB_H'];
	}
	if ($S_Single_Rate==''){
		$Single='';
	}else{
		$Single=$Rel_Odd;
	}
	if ($S_Double_Rate==''){
		$Double='';
	}else{
		$Double=$Rel_Even;		
	}
	if ($row['M_Type']==1){
		$M_Type='<font color=red>(走地)</font>';
    }
    if ($row['Open']==0){
		$caption1="<font color=red>开启投注</font>";
		$mtype=1;
    }else{
		$caption1="关闭投注";
		$mtype=0;
    }
?>
    <? if($m_league!=$row['M_League']){ ?>
    <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)>
      <td colspan="10"><?=$row['M_League']?></td>
      <td></td>
    </tr>
    <? } ?>
    <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)> 
        <td><?=$row["M_Date"]?><br><?=$row['M_Time']?><br><?=$M_Type?></td>
        <td><?=$row['MID']?></td>
        <td align="left"><?=$row['MB_Team']?><br><?=$row['TG_Team']?></td>
        <td><font color=red><?=$MB_Win_Rate?><br><?=$TG_Win_Rate?><br><?=$M_Flat_Rate?></font></td>
        <td align="right"><?=$MB_LetB?>&nbsp;&nbsp;<font color=red><?=$MB_LetB_Rate?></font><BR><?=$TG_LetB?>&nbsp;&nbsp;<font color=red><?=$TG_LetB_Rate?></font></td>
        <td align="right"><?=$row['MB_Dime']?>&nbsp;&nbsp;<font color=red><?=$MB_Dime_Rate?></font><BR><?=$row['TG_Dime']?>&nbsp;&nbsp;<font color=red><?=$TG_Dime_Rate?></font></td>
        <td align="right"><?=$Single?>&nbsp;&nbsp;<font color=red><?=$S_Single_Rate?></font><BR><?=$Double?>&nbsp;&nbsp;<font color=red><?=$S_Double_Rate?></font></td>
        <td><font color=red><?=$MB_Win_Rate_H?><br><?=$TG_Win_Rate_H?><br><?=$M_Flat_Rate_H?></font></td>
        <td align="right"><?=$MB_LetB_H?>&nbsp;&nbsp;<font color=red><?=$MB_LetB_Rate_H?></font><BR><?=$TG_LetB_H?>&nbsp;&nbsp;<font color=red><?=$TG_LetB_Rate_H?></font></td>
        <td align="right"><?=$row['MB_Dime_H']?>&nbsp;&nbsp;<font color=red><?=$MB_Dime_Rate_H?></font><BR><?=$row['TG_Dime_H']?>&nbsp;&nbsp;<font color=red><?=$TG_Dime_Rate_H?></font></td>
        <td>
		<a href="retime.php?uid=<?=$uid?>&langx=<?=$langx?>&gid=<?=$row['MID']?>&gtype=<?=$gtype?>">变更赔率</a>&nbsp;/&nbsp;&nbsp;
		<a href=javascript:CheckCLOSE('play_game.php?uid=<?=$uid?>&langx=<?=$langx?>&gid=<?=$row['MID']?>&gtype=<?=$gtype?>&action=1&open=<?=$mtype?>&date_start=<?=$date_start?>')><?=$caption1?></a><br><br>
		<a href="../score/showdata.php?uid=<?=$uid?>&langx=<?=$langx?>&gid=<?=$row['MID']?>&gtype=<?=$gtype?>&date_start=<?=$date_start?>">相关注单</a>&nbsp;/&nbsp;&nbsp;
		<!--<a href="game_set.php?uid=<?=$uid?>&gid=<?=$row['MID']?>&gtype=<?=$gtype?>">赛事参数</a>-->
	    <a href=javascript:CheckDELETE('deletedata.php?gtype=<?=$gtype?>&gid=<?=$row['MID']?>&uid=<?=$uid?>&langx=<?=$langx?>&date_start=<?=$date_start?>')>删除赛事</a>
      </td>
    </tr>
<?
$m_league=$row['M_League'];
}
?>
  </table>
</form>
</body>
</html>