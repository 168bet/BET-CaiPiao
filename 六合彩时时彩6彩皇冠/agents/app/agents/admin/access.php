<?
include ("../include/address.mem.php");
require ("../include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST["langx"];
require ("../include/traditional.$langx.inc.php");

$sql = "select * from web_system_data where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}

$action=$_REQUEST['action'];
$page=$_REQUEST['page'];
if ($page==""){
	$page=0;
}
$active=$_REQUEST['active'];
$id=$_REQUEST['id'];
$username=$_REQUEST['username'];
if ($active=='Y'){
    $mysql="update web_sys800_data set Checked='1' where ID='$id'";
	mysql_db_query($dbname,$mysql);
	echo "<Script language=javascript>self.location='access.php?uid=$uid&langx=$langx&action=$action&page=$page';</script>";
}else if ($active=='del'){
	$mysql="delete from web_sys800_data where ID='$id'";
	mysql_db_query($dbname,$mysql);
	echo "<Script language=javascript>self.location='access.php?uid=$uid&langx=$langx&action=$action&page=$page';</script>";
}else if ($active=='res'){
	$gold=$_REQUEST['gold'];
	$mysql="update web_member_data set Money=Money+$gold,Credit=Credit+$gold where UserName='".$username."'";
	mysql_db_query($dbname,$mysql);
	$mysql="update web_sys800_data set Cancel='1' where ID='$id'";
	mysql_db_query($dbname,$mysql);
	echo "<Script language=javascript>self.location='access.php?uid=$uid&langx=$langx&action=$action&page=$page';</script>";
}
$search=$_REQUEST['search'];
if ($search!=''){
    $num=60;
    $search="and (UserName like '%$search%' or Date like '%$search%' or Bank_Account like '%$search%' or Phone like '%$search%' or Notes like '%$search%')";
}else{
    $num=100;
}
$sql = "select ID,Checked,Gold,Type,UserName,Date,Phone,Contact,Notes,Bank_Account,Bank_Address,Bank,Order_Code,Cancel from web_sys800_data where Type='$action' $search order by ID desc";
$result = mysql_db_query($dbname, $sql);
$cou=mysql_num_rows($result);
$page_size=$num;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_db_query($dbname, $mysql);
?>
<html>
<head>
<title>会员存取</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="javascript">
function onLoad(){
  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
}
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}
function resume(str)
{
 if(confirm("是否确定恢复金额?"))
  document.location=str;
}
function Delete(str)
{
 if(confirm("是否确定删除纪录?"))
  document.location=str;
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0"  onLoad="onLoad()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;
    <a href=system.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> target="main" title="系统参数" onMouseOver="window.status='系统参数'; return true;" onMouseOut="window.status='';return true;">系统参数</a>&nbsp;&nbsp;
    <a href=add_notice.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> target="main" title="系统公告" onMouseOver="window.status='系统公告'; return true;" onMouseOut="window.status='';return true;">系统公告</a>&nbsp;&nbsp;
    <a href=news.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&action=opennews target="main" title="系统短信" onMouseOver="window.status='系统短信'; return true;" onMouseOut="window.status='';return true;">系统短信</a>&nbsp;&nbsp;
    <a href=news.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&action=sitenews target="main" title="系统消息" onMouseOver="window.status='系统消息'; return true;" onMouseOut="window.status='';return true;">系统消息</a>&nbsp;&nbsp;
	<a href=../adminmsg/index.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> target="main" title="会员消息" onMouseOver="window.status='系统公告'; return true;" onMouseOut="window.status='';return true;">会员消息</a>&nbsp;&nbsp;
    <a href="access.php?uid=<?=$uid?>&langx=<?=$langx?>&action=S">会员存款</a>&nbsp;&nbsp;
    <a href="access.php?uid=<?=$uid?>&langx=<?=$langx?>&action=T">会员提款</a>
	</td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr> 
</table>
<table width="975" border="0" cellpadding="2" cellspacing="1" class="m_tab">

	<tr class="m_title">
	  <td colspan="10">存入资金</td>
  </tr>
	<tr class="m_title">
      <FORM id="myFORM" ACTION="" METHOD=POST name="FrmData">
	  <td colspan="9">关键字查找:
	  <input type=TEXT name="search" size=10 value="" maxlength=11 class="za_text">
      <input type=SUBMIT name="SUBMIT" value="确认" class="za_button">
	  </td>     
	  <td width="89">
	  <select name='page' onChange="self.myFORM.submit()">
	  
<?
if ($page_count==0){
    $page_count=1;
	}
	for($i=0;$i<$page_count;$i++){
		if ($i==$page){
			echo "<option selected value='$i'>".($i+1)."</option>";
		}else{
			echo "<option value='$i'>".($i+1)."</option>";
		}
	}
?>  
  </select> 共<?=$page_count?> 页 
	  </td></FORM>
	</tr>
	<tr class="m_title">
	  <td width="30">编号</td>
	  <td width="70">帐号</td>
	  <td width="70">金额</td>
	  <td width="115">日期时间</td>
	  <td width="80">联系电话</td>
	  <td width="160">开户银行</td>
	  <td width="135">银行账号</td>
	  <td width="80">用户名</td>
	  <td width="95">联系方式</td>
      <td>操作</td>
	</tr>
<?
$i=1;
while ($row = mysql_fetch_array($result)){
$id=$row['ID'];
?>
  <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)> 
      
    <td align="center"><?=$i?></td>
    <td align="center"><font color=red><?=$row['UserName']?></font></td>
    <td align="center"><?=$row['Gold']?></td>
	<td align="left"><?=$row['Date']?></td>
    <td align="center"><?=$row['Phone']?></td>
    <td align="center"><?=$row['Bank_Address']?><br><?=$row['Bank']?></td>
    <td align="center"><?=$row['Bank_Account']?></td>
    <td align="center"><?=$row['Notes']?></td>
    <td align="center"><?=$row['Contact']?></td>
	<td align="center">
<?
if ($row['Checked']==0){
?>
	<form  method=post target='_self'>
	<input type=submit name=send value='未处理' onClick="return confirm('確定審核此筆單')" class="za_button">
	<input type=hidden name=id value=<?=$row['ID']?>>
<input type=hidden name=mid value=<?=$row['UserName']?>>
<input type=hidden name=gold value=<?=$row['Gold']?>>
<input type=hidden name=type value=<?=$row['Type']?>>
<input type=hidden name=uid value=<?=$uid?>>
<input type=hidden name=active value=Y>
</form>
<?
}else{
?>  
<?
switch($row['Type']){
case 'S':
echo '已存入<br>';
break;
case 'T':
echo '已提出<br>';
break;
}
?>
<?
}
?>	<? if ($row['Cancel']==1){?>
    <div> 已恢复</div> 
    <? }else{?>
    <? if ($row['Type']=='T'){?>
    <a href="javascript:resume('access.php?uid=<?=$uid?>&id=<?=$row['ID']?>&active=res&username=<?=$row['UserName']?>&gold=<?=$row['Gold']?>&langx=<?=$langx?>&action=<?=$action?>&page=<?=$page?>')">恢复</a>
    <? }?>
    <? }?>
    &nbsp;
    <a href="javascript:Delete('access.php?uid=<?=$uid?>&id=<?=$row['ID']?>&active=del&langx=<?=$langx?>&action=<?=$action?>&page=<?=$page?>')">删除</a>
	</td>
    <?
$i=$i+1;
}
?>
  </tr>
</table>
</body>
</html>
