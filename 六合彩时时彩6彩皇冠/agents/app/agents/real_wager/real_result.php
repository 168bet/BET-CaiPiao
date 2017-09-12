<?
session_start();
header("Expires: Mon, 26 Jul 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include "../../agents/include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");
//print_r($_REQUEST);
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
require ("../../agents/include/traditional.$langx.inc.php");

$sql = "select Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$web='web_system_data';
}else{
    $web='web_agents_data';
}
$sql = "select ID from $web where Oid='$uid' and LoginName='$loginname' and Status<2";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$gtype = $_REQUEST['gtype'];
$page  = $_REQUEST['page_no'];
$flag  = $_REQUEST['flag'];
$layer1 = $_REQUEST['layer1'];

if ($flag=='Y'){
	$bdate=date('Y-m-d',time()-24*60*60);
	$date=date('m-d',time()-24*60*60);
}else if($flag==''){
	$bdate=date('Y-m-d');
	$date=date('m-d');
}
if ($page==''){
	$page=0;
}
$sql="select $mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_League,M_Date,M_Time,MB_MID,TG_MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where Type='".$gtype."' and M_Date='".$bdate."' and MB_Inball!='' order by M_Start,MB_MID";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
$page_size=60;
$t_page=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size";
$result = mysql_db_query($dbname,$mysql);
?>
<script>
var pg='<?=$page?>';
var t_page='<?=$t_page?>';
var uid='<?=$uid?>';
var flag='<?=$flag?>';
var gtype='<?=$gtype?>';
var layer1='<?=$layer1?>';
</script>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="JavaScript"> 
function show_page(){
	var temp="";
	var pg_str=""
	for(var i=0;i<t_page;i++){
 
		if (pg!=i)
			pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'><font color='#000099'>"+(i+1)+"</font></a>&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			pg_str=pg_str+"<B><font color='#FF0000'>"+(i+1)+"</font></B>&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	txt_bodyP= bodyP.innerHTML;
	txt_bodyP =txt_bodyP.replace("*SHOW_P*",pg_str);
	pg_txt.innerHTML=txt_bodyP;
}
 
function onLoad(){
	show_page();
}
 
function chg_pg(pg){
	self.location = './real_result.php?uid='+uid+'&page_no='+pg+'&flag='+flag+'&gtype='+gtype+"&layer="+layer1;
}
</SCRIPT>
</head>
 
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="m_tline">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td nowrap>&nbsp;&nbsp;<? if ($flag==''){?><A HREF="./real_result.php?uid=<?=$uid?>&gtype=<?=$gtype?>&flag=Y&layer=ag" target="_self"><?=$Yesterday?></A><? }else if ($flag=='Y'){?><A HREF="./real_result.php?uid=<?=$uid?>&gtype=<?=$gtype?>&flag=&layer=ag" target="_self"><?=$Today?></A><? } ?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$Game?>&nbsp;:&nbsp;</td>
					<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./real_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=FT&layer=ag" target="_self">[<?=$soccer?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./real_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=BK&layer=ag" target="_self">[<?=$Basketball?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./real_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=TN&layer=ag" target="_self">[<?=$Tennis?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./real_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=VB&layer=ag" target="_self">[<?=$Volleyball?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./real_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=BS&layer=ag" target="_self">[<?=$Baseball?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./real_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=OP&layer=ag" target="_self">[<?=$Other?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;<span id="pg_txt"></span></td>
				</tr>
			</table>
		</td>
		<td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
	</tr>
	<tr>
		<td colspan="2" height="4"></td>
	</tr>
</table>
<table id="glist_table" border="0" cellspacing="1" cellpadding="0" class="m_tab_<?=$gtype?>" width="630">
	<tr class="m_title_<?=$gtype?>">
		<td width="50" height="20"><?=$Time?></td>
      <td width="50"><?=$No?></td>
		<td width="224"><?=$Home_Guest?></td>
		<td width="150"><?=$Half?></td>
		<td width="150"><?=$Final?></td>
	</tr>
<?
while ($row = mysql_fetch_array($result)){
$mb_inball=$row['MB_Inball'];
$tg_inball=$row['TG_Inball'];
$mb_inball_1st=$row['MB_Inball_HR'];
$tg_inball_1st=$row['TG_Inball_HR'];
$mb_inball_2nd=$row['MB_Inball']-$row['MB_Inball_HR'];
$tg_inball_2nd=$row['TG_Inball']-$row['TG_Inball_HR'];
if ($mb_inball=='-1' and $mb_inball_1st=='-1'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score1;
	$tg_inball_1st=$Score1;
	$tg_inball_2nd=$Score1;	
}else if ($mb_inball=='-2' and $mb_inball_1st=='-2'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score2;
	$tg_inball_1st=$Score2;
	$tg_inball_2nd=$Score2;	
}else if ($mb_inball=='-3' and $mb_inball_1st=='-3'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score3;
	$tg_inball_1st=$Score3;
	$tg_inball_2nd=$Score3;	
}else if ($mb_inball=='-4' and $mb_inball_1st=='-4'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score4;
	$tg_inball_1st=$Score4;
	$tg_inball_2nd=$Score4;	
}else if ($mb_inball=='-5' and $mb_inball_1st=='-5'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score5;
	$tg_inball_1st=$Score5;
	$tg_inball_2nd=$Score5;	
}else if ($mb_inball=='-6' and $mb_inball_1st=='-6'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score6;
	$tg_inball_1st=$Score6;
	$tg_inball_2nd=$Score6;	
}else if ($mb_inball=='-7' and $mb_inball_1st=='-7'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score7;
	$tg_inball_1st=$Score7;
	$tg_inball_2nd=$Score7;	
}else if ($mb_inball=='-8' and $mb_inball_1st=='-8'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score8;
	$tg_inball_1st=$Score8;
	$tg_inball_2nd=$Score8;	
}else if ($mb_inball=='-9' and $mb_inball_1st=='-9'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score9;
	$tg_inball_1st=$Score9;
	$tg_inball_2nd=$Score9;	
}else if ($mb_inball=='-10' and $mb_inball_1st=='-10'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score10;
	$tg_inball_1st=$Score10;
	$tg_inball_2nd=$Score10;	
}else if ($mb_inball=='-11' and $mb_inball_1st=='-11'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score11;
	$tg_inball_1st=$Score11;
	$tg_inball_2nd=$Score11;	
}else if ($mb_inball=='-12' and $mb_inball_1st=='-12'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score12;
	$tg_inball_1st=$Score12;
	$tg_inball_2nd=$Score12;	
}else if ($mb_inball=='-13' and $mb_inball_1st=='-13'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score13;
	$tg_inball_1st=$Score13;
	$tg_inball_2nd=$Score13;	
}else if ($mb_inball=='-14' and $mb_inball_1st=='-14'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score14;
	$tg_inball_1st=$Score14;
	$tg_inball_2nd=$Score14;	
}else if ($mb_inball=='-15' and $mb_inball_1st=='-15'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score15;
	$tg_inball_1st=$Score15;
	$tg_inball_2nd=$Score15;	
}else if ($mb_inball=='-16' and $mb_inball_1st=='-16'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score16;
	$tg_inball_1st=$Score16;
	$tg_inball_2nd=$Score16;	
}else if ($mb_inball=='-17' and $mb_inball_1st=='-17'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score17;
	$tg_inball_1st=$Score17;
	$tg_inball_2nd=$Score17;	
}else if ($mb_inball=='-18' and $mb_inball_1st=='-18'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score18;
	$tg_inball_1st=$Score18;
	$tg_inball_2nd=$Score18;	
}else if ($mb_inball=='-19' and $mb_inball_1st=='-19'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score19;
	$tg_inball_1st=$Score19;
	$tg_inball_2nd=$Score19;	
}else if ($mb_inball=='-20' and $mb_inball_1st=='-20'){
	$mb_inball='';
	$mb_inball_1st='';
	$mb_inball_2nd='';
	$tg_inball=$Score20;
	$tg_inball_1st=$Score20;
	$tg_inball_2nd=$Score20;	
}
?>
    <? if($m_league!=$row['M_League']){ ?>
    <tr class="m_cen">
        <td colspan="5"><?=$row['M_League']?></td>
    </tr>
    <? } ?>
	<tr class="m_cen">
		<td><?=$date?><BR><?=$row['M_Time']?></td>
		<td><?=$row['MB_MID']?><br><?=$row['TG_MID']?></td>
		<td align="left"><?=$row['MB_Team']?><br><?=$row['TG_Team']?></td>
		<td><font color="#CC0000"><b><span style="overflow:hidden;"><?=$mb_inball_1st?></span><br><span style="overflow:hidden;"><?=$tg_inball_1st?></span></b></font></td>
        <td><font color="#CC0000"><b><span style="overflow:hidden;"><?=$mb_inball?></span><br><span style="overflow:hidden;"><?=$tg_inball?></span></b></font></td>
	</tr>
<?
$m_league=$row['M_League'];
}
?> 
</table>
 
<span id="bodyP" style="position:absolute; display: none">&nbsp;<?=$PAGE?>&nbsp;:&nbsp;*SHOW_P*</span>
</body>
</html>

