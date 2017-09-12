<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$id=$_REQUEST["id"];
$type=$_REQUEST['type'];
$page=$_REQUEST["page"];
$action=$_REQUEST["action"];
$league=$_REQUEST["league"];
require ("../../agents/include/traditional.$langx.inc.php");
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}

if ($type==''){
	$type='FT';
}
if ($page==''){
	$page=0;
}
if ($league!=''){
$n_sql="and M_League like '%$league%'";
}else{
$n_sql='';
}
if ($action=='del'){
	$sql="DELETE FROM `match_league` WHERE `ID` ='$id'";
	mysql_db_query($dbname,$sql) or die ("操作失败");
}

$sql = "select ID,$m_league as M_League,R,OU,M,EO,VR,VOU,VM,RB,ROU,VRB,VROU,PD,T,F,CS from match_league where $m_league!='' and Type='$type' $n_sql order by $m_league desc";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
$page_size=20;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if ($cou==0){
	$page_count=1;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
</head>
<SCRIPT>
<!--
function onLoad(){
  var type = document.getElementById('type');
  type.value = '<?=$type?>';
  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
}
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}
// -->
</script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"  onload="onLoad()";>
<FORM NAME="myFORM" ACTION="" METHOD=POST>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="975">&nbsp;联盟单注限制&nbsp;--&nbsp;&nbsp;类别: 
      <select class=za_select onchange=document.myFORM.submit(); name=type>
			<option value="FT">足球联盟</option>
			<option value="BK">篮球联盟</option>
			<option value="BS">棒球联盟</option>
			<option value="TN">网球联盟</option>
			<option value="VB">排球联盟</option>
			<option value="OP">其它联盟</option>
			<option value="FU">指数联盟</option>
         	<option value="FS">特殊联盟</option>
	  </select>&nbsp;--&nbsp;
	  <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
              <?
		      for($i=0;$i<$page_count;$i++){
			      echo "<option value='$i'>".($i+1)."</option>";
		         }
		      ?>
      </select> / <?=$page_count?>  <?=$Mem_Page?>&nbsp;--&nbsp;<A href="add_league.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&tpye=<?=$type?>">自动接新联盟</A>&nbsp;--联盟快速查找:&nbsp;<input name="league" type="text" id="memname" value="" size="15">&nbsp;&nbsp;&nbsp;<input class=za_button type="submit" name="Submit" value="提交">&nbsp;--&nbsp;<a href="javascript:history.go( -1 );">回上一頁</a></td>                
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
  <table id="glist_table" border="0" cellspacing="1" cellpadding="0" class="m_tab" width="975">
    <tr class="m_title"> 
        <td width="32">序号</td>
        <td width="230">联盟</td>
        <td width="70">让球</td>
        <td width="70">大小球</td>
        <td width="70">半场让球</td>
        <td width="70">半场大小</td>
        <td width="70">滚球让球</td>
        <td width="70">滚球大小球</td>
        <td width="70">上半滚球<br>让球</td>
        <td width="70">上半滚球<br>大小球</td>
        <td width="70">特殊类</td>
        <td width="70">操作</td>
    </tr>
<?
$i=1;
while ($row = mysql_fetch_array($result)){
?>
    <tr class="m_left" onmouseover=sbar(this) onmouseout=cbar(this)> 
      <td align="center"><?=$i?></td>
        <td><?=$row['M_League']?></td>
        <td><?=$row['R']?></td>
        <td><?=$row['OU']?></td>
        <td><?=$row['VR']?></td>
        <td><?=$row['VOU']?></td>
        <td><?=$row['RB']?></td>
        <td><?=$row['ROU']?></td>
        <td><?=$row['VRB']?></td>
        <td><?=$row['VROU']?></td>
        <td><?=$row['CS']?></td>
        <td align="center"><a href="league_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&langx=<?=$langx?>&type=<?=$type?>&page=<?=$page?>">变更</a>&nbsp;/&nbsp;&nbsp;<a href="league.php?uid=<?=$uid?>&id=<?=$row['ID']?>&langx=<?=$langx?>&type=<?=$type?>&action=del">删除</a></td>
    </tr>
<?
$i++;
}
?>
  </table>
</form>
</body>
</html>