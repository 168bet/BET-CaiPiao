<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include "./include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("./include/config.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$lv=$_REQUEST["lv"];
include "./include/online.php";
require ("./include/traditional.$langx.inc.php");

$sql = "select Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$data='web_system_data';
}else{
	$data='web_agents_data';
}
$sql = "select * from $data where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$row = mysql_fetch_array($result);
$name=$row['UserName'];
$points=$row['Points'];
$wager=$row['Wager'];
$competence=$row['Competence'];
$status=$row['Status'];
$subuser=$row['SubUser'];
$subname=$row['SubName'];

$num=split(",",$competence);
if ($num[1]==1){
	$Title.="<a href=admin/system.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"系统参数\" onMouseOver=\"window.status='系统参数'; return true;\" onMouseOut=\"window.status='';return true;\">系统参数</a> - ";
}
if ($num[5]==1){
	$Title.="<a href=admin/data.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"数据刷新\" onMouseOver=\"window.status='数据刷新'; return true;\" onMouseOut=\"window.status='';return true;\">数据刷新</a> - ";
}
if ($num[6]==1){
	$Title.="<a href=admin/show_currency.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"幣值设置\" onMouseOver=\"window.status='幣值设置'; return true;\" onMouseOut=\"window.status='';return true;\">幣值设置</a> - ";
}
if ($num[7]==1){
	$Title.="<a href=league/league.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"联盟限制\" onMouseOver=\"window.status='联盟限制'; return true;\" onMouseOut=\"window.status='';return true;\">联盟限制</a> - ";
}
if ($num[8]==1){
	$Title.="<a href=admin/play_game.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"数据操盘\" onMouseOver=\"window.status='数据操盘'; return true;\" onMouseOut=\"window.status='';return true;\">数据操盘</a> - ";
}
if ($num[9]==1){
	$Title.="<a href=score/match.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"审核比分\" onMouseOver=\"window.status='审核比分'; return true;\" onMouseOut=\"window.status='';return true;\">审核比分</a> - ";
}
if ($num[10]==1){
	$Title.="<a href=accounts/re_list.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"滚球注单\" onMouseOver=\"window.status='滚球注单'; return true;\" onMouseOut=\"window.status='';return true;\">滚球注单</a> - ";
}
if ($num[11]==1){
	$Title.="<a href=admin/query.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"查询注单\" onMouseOver=\"window.status='查询注单'; return true;\" onMouseOut=\"window.status='';return true;\">查询注单</a> - ";
}
if ($num[12]==1){
	$Title.="<a href=/admin/index.php?uid=$uid&lv=$lv&num=SCA&langx=$langx target=\"bb_mem_index\" title=\"六合彩管理\" onMouseOver=\"window.status='六合彩管理'; return true;\" onMouseOut=\"window.status='';return true;\">六合彩管理</a> - ";
}
if ($num[13]==1){
	$Title.="<a href=agents/ag_details.php?uid=$uid&langx=$langx target=\"main\" title=\"分红明细\" onMouseOver=\"window.status='分红明细'; return true;\" onMouseOut=\"window.status='';return true;\">分红明细</a> - ";
}
//if ($num[13]==1){
	//$Title.="<a href=score/number.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"开奖结果\" onMouseOver=\"window.status='开奖结果'; return true;\" onMouseOut=\"window.status='';return true;\">开奖结果</a> - ";
//}
if ($num[14]==1){
	$Title.="<a href=admin/syslog.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"系统日志\" onMouseOver=\"window.status='系统日志'; return true;\" onMouseOut=\"window.status='';return true;\">系统日志</a> - ";
}
if ($num[0]==1){
	$Title.="<a href=online/online.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"在线人数\" onMouseOver=\"window.status='在线人数'; return true;\" onMouseOut=\"window.status='';return true;\">在线人数(<span id=\"online\"></span>)</a>";
}
if ($num[15]==1){
	$Item.="<a href=agents/self_data.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"基本資料設定\" onMouseOver=\"window.status='基本資料設定'; return true;\" onMouseOut=\"window.status='';return true;\">基本資料設定</a> - ";
}
if ($num[16]==1){
	$Item.="<a href=agents/subuser.php?uid=$uid&langx=$langx&lv=$lv target=\"main\" title=\"$Mnu_Sub_Account\" onMouseOver=\"window.status='$Mnu_Sub_Account'; return true;\" onMouseOut=\"window.status='';return true;\">$Mnu_Sub_Account</a> - ";
}
if ($num[17]==1){
	$Item.="<a href=agents/user_browse.php?uid=$uid&langx=$langx&lv=A target=\"main\" title=\"$Mnu_Super\" onMouseOver=\"window.status='$Mnu_Super'; return true;\" onMouseOut=\"window.status='';return true;\">$Mnu_Super</a> - ";
}
if ($num[18]==1){
	$Item.="<a href=agents/user_browse.php?uid=$uid&langx=$langx&lv=B target=\"main\" title=\"$Mnu_Corprator\" onMouseOver=\"window.status='$Mnu_Corprator'; return true;\" onMouseOut=\"window.status='';return true;\">$Mnu_Corprator</a> - ";
}
if ($num[19]==1){
	$Item.="<a href=agents/user_browse.php?uid=$uid&langx=$langx&lv=C target=\"main\" title=\"$Mnu_World\" onMouseOver=\"window.status='$Mnu_World'; return true;\" onMouseOut=\"window.status='';return true;\">$Mnu_World</a> - ";
}
if ($num[20]==1){
	$Item.="<a href=agents/user_browse.php?uid=$uid&langx=$langx&lv=D target=\"main\" title=\"$Mnu_Agents\" onMouseOver=\"window.status='$Mnu_Agents'; return true;\" onMouseOut=\"window.status='';return true;\">$Mnu_Agents</a> - ";
}
if ($num[21]==1){
	$Item.="<a href=agents/user_browse.php?uid=$uid&langx=$langx&lv=MEM target=\"main\" title=\"$Mnu_Member\" onMouseOver=\"window.status='$Mnu_Member'; return true;\" onMouseOut=\"window.status='';return true;\">$Mnu_Member</a> - ";
}
if ($num[22]==1){
	$Item.="<a href=report_new/report.php?uid=$uid&langx=$langx&lever=$lv&casino=2 target=\"main\" title=\"$Mnu_Report\" onMouseOver=\"window.status='$Mnu_Report'; return true;\" onMouseOut=\"window.status='';return true;\">$Mnu_Report</a> - ";
}
if ($num[23]==1){
	$Item.="<a href=800/index.php?uid=$uid&langx=$langx&lv=$lv target=\"main\">$Mnu_System</a> - ";
}
if ($num[24]==1){
	$Item.="<a href=admin/payment.php?uid=$uid&langx=$langx&lv=$lv target=\"main\">支付方式</a> - ";
}
?>
<html>
<head>
<title>Agents</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_header.css" type="text/css">
</head>
<script> 
function subwin(){
window.open("/app/agents/other_set/readme.php","readme","width=320,height=160,scrollbars=yes");
}
function createXMLHttpRequest(http) {
  if(window.ActiveXObject) {
    eval(http+" = new ActiveXObject(\"Microsoft.XMLHTTP\")");
  }
  else if(window.XMLHttpRequest) {
    eval(http+" = new XMLHttpRequest()");
  }
}
function online(){
	createXMLHttpRequest("cHttp");
    cHttp.onreadystatechange = cChange;
    cHttp.open("post", "online/online.php?online=1", true);
    cHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
    cHttp.send(null);
function cChange(){
	if (cHttp.readyState == 4) {
		if (cHttp.status == 200){
			var cDoc = cHttp.responseText;
		    document.getElementById("online").innerHTML=cDoc;
		  }
	}  
}
//setTimeout("online();",3000);  
}
</script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C" <? if($row['Level']=='M'){?> onLoad="online()"<? } ?> onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<table width="1003" border="0" cellpadding="0" cellspacing="0" class="log_bg">
  <tr>
    <td width="183" rowspan="2"><img src="/images/agents/top_01.gif" width="183" height="44" border="0" alt=""></td>
    <td class="memu1"><?=$Title?></td>
  </tr>
  <tr>
<?
if ($row['Status']==0){
?>
    <td class="memu1"><?=$Item?>		
        <?
	if($Level=='D'){
	?>
    <a href=agents/ag_details1.php?uid=<?=$uid?>&langx=<?=$langx?> target="main" title="分细明细" onMouseOver="window.status='分细明细'; return true;" onMouseOut="window.status='';return true;">分细明细</a> - 
    <?	
	}
	?>
		<a href="logout.php?uid=<?=$uid?>" target="_top" onMouseOver="window.status='<?=$Mnu_Logout?>'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_Logout?></a></td>
<?
}else{
?> 
    <td class="memu1">
        <a href="agents/self_data.php?uid=<?=$uid?>&langx=<?=$langx?>&lv=<?=$lv?>" target="main" title="基本資料設" onMouseOver="window.status='基本資料設定'; return true;" onMouseOut="window.status='';return true;">基本資料設定</a> - 
        <a href="report_new/report.php?uid=<?=$uid?>&langx=<?=$langx?>&lever=<?=$lv?>&casino=2" target="main" title="<?=$Mnu_Report?>" onMouseOver="window.status='<?=$Mnu_Report?>'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_Report?></a> - 
		<a href="logout.php?uid=<?=$uid?>" target="_top" onMouseOver="window.status='<?=$Mnu_Logout?>'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_Logout?></a></td>
<?
}
?>   
  </tr>
  <tr>
    <td width="183" height="25" align="center" background="/images/agents/top_02.gif"><?=$row['UserName']?></td>
    <td class="memu2">
<?
if($row['Wager']!=0){
?>
		<span class="word">		
		<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=FT&ptype=S target="main" title="足球即時注單" onMouseOver="window.status='足球即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_Soccer?></a>[<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=FU&ptype=S target="main" title="足球早餐即時注單" onMouseOver="window.status='足球早餐即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_EarlyMarket?></a>] - 
		<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=BK&ptype=S target="main" title="籃球即時注單" onMouseOver="window.status='籃球即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_Bask?></a>[<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=BU&ptype=S target="main" title="籃球早餐即時注單" onMouseOver="window.status='籃球早餐即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_EarlyMarket?></a>] -  
		<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=BS&ptype=S target="main" title="棒球即時注單" onMouseOver="window.status='棒球即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_Base?></a>[<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=BE&ptype=S target="main" title="棒球早餐即時注單" onMouseOver="window.status='棒球早餐即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_EarlyMarket?></a>] -		
		<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=TN&ptype=S target="main" title="網球即時注單" onMouseOver="window.status='網球即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_Tennis?></a>[<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=TU&ptype=S target="main" title="棒球早餐即時注單" onMouseOver="window.status='棒球早餐即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_EarlyMarket?></a>] - 
		<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=VB&ptype=S target="main" title="棒球即時注單" onMouseOver="window.status='棒球即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_Voll?></a>[<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=VU&ptype=S target="main" title="棒球早餐即時注單" onMouseOver="window.status='棒球早餐即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_EarlyMarket?></a>] -
		<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=OP&ptype=S target="main" title="其他即時注單" onMouseOver="window.status='其他即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_Other?></a>[<a href=real_wager/index.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=OM&ptype=S target="main" title="其他早餐即時注單" onMouseOver="window.status='其他早餐即時注單'; return true;" onMouseOut="window.status='';return true;"><?=$Mnu_EarlyMarket?></a>] -  
        [<a href=real_wager/real_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=FT target="main" title="<?=$Rel_Game_result?>" onMouseOver="window.status='<?=$Rel_Game_result?>'; return true;" onMouseOut="window.status='';return true;"><?=$Rel_Game_result?></a>]
        </span>
<?
}
?> 
    </td>
  </tr>
</table>
</body>
</html>
