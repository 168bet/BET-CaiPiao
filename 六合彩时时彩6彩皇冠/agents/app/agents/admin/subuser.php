<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../../agents/include/address.mem.php");
require ("../../agents/include/config.inc.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];
include ("../../agents/include/online.php");
require ("../../agents/include/traditional.$langx.inc.php");
$addNew=$_REQUEST["addNew"];
$deluser=$_REQUEST["deluser"];
$edituser=$_REQUEST["edituser"];
$suspend=$_REQUEST["suspend"];
$username=$_REQUEST["username"];
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$name=$row['UserName'];

$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];
$page=$_REQUEST["page"];
if ($sort==""){
	$sort='USERNAME';
}
if ($orderby==""){
	$orderby='ASC';
}
if ($page==''){
	$page=0;
}
$loginfo='查看子帐号';
if ($suspend=='N'){
    $loginfo='停用子帐号:'.$username.'';	
    $mysql="update web_system_data set Status=2 where ID=".$_REQUEST["id"];
    mysql_db_query($dbname, $mysql);
}else if ($suspend=='Y'){
    $loginfo='启用子帐号:'.$username.'';	
    $mysql="update web_system_data set Status=0 where ID=".$_REQUEST["id"];
    mysql_db_query($dbname, $mysql);
}
if ($deluser=='Y'){
    $loginfo='删除子帐号:'.$username.'';	
	$mysql="delete from web_system_data where ID=".$_REQUEST["id"];
	$result = mysql_db_query($dbname,$mysql);
}
if ($edituser=='Y'){
	$e_user=substr($name,0,1).trim($_REQUEST["e_user"]);
	$e_pass=$_REQUEST["e_pass"];
	$e_alias=$_REQUEST["e_alias"];
	$mysql="update web_system_data set UserName='$e_user',PassWord='$e_pass',Alias='$e_alias' where ID=".$_REQUEST["id"];
	$result = mysql_db_query($dbname,$mysql);
	$loginfo='修改子帐号:'.$e_user.' 密码:'.$e_pass.' 名称:'.$e_alias.'';
	echo "<script language=javascript>document.location='subuser.php?uid=$uid&langx=$langx&lv=$lv';</script>";
}
if ($addNew=='Y'){
	$new_user=substr($name,0,1).trim($_REQUEST["new_user"]);
	$new_pass=$_REQUEST["new_pass"];
	$new_alias=$_REQUEST["new_alias"];
	$AddDate=date('Y-m-d H:i:s');
	$mysql="select * from web_system_data where UserName='$new_user'";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$mysql="insert into web_system_data(Level,UserName,LoginName,PassWord,Alias,Status,SubName,AddDate) values('$lv','$new_user','$new_user','$new_pass','$new_alias','0','$name','$AddDate')";
		echo $mysql;
		exit;
		mysql_db_query($dbname,$mysql) or die ("操作失败!");
		$loginfo='新增子帐号:'.$new_user.' 密码:'.$new_pass.' 名称:'.$new_alias.'';
		echo "<Script Language=javascript>self.location='subuser.php?uid=$uid&langx=$langx&lv=$lv';</script>";
	}else{
		$msg=wterror('您添加的子帐号已经存在，请重新输入！！');
		echo $msg;
	}	
}
$sql = "select * from web_system_data where subname='$name' order by ".$sort." ".$orderby;
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
$page_size=20;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_db_query($dbname,$mysql);
$cou=mysql_num_rows($result);
if ($cou==0){
	$page_count=1;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_title {  background-color: #86C0A6; text-align: center; height:25px}
-->
</style>
<SCRIPT Language="javaScript">

function show_win() {
	acc_window.style.top=document.body.scrollTop+event.clientY+15;
	acc_window.style.left=document.body.scrollLeft+event.clientX-20; 
	document.all["acc_window"].style.display = "block";
	document.addUSER.new_user.value= "";
	document.addUSER.new_pass.value= "";
	document.addUSER.new_alias.value= "";
	document.addUSER.new_user.focus();
}

function close_win() {
	document.all["acc_window"].style.display = "none";
}

function Chk_acc(){
	if(document.all.new_user.value==''){
		document.all.new_user.focus();
		alert("<?=$Mem_Input?><?=$Mem_Account?>!!");
		return false;
	}
	if(document.all.new_pass.value==''){
		document.all.new_pass.focus();
		alert("<?=$Mem_Input?><?=$Mem_Password?>!!");
		return false;
	}
	if(document.all.new_alias.value==''){
		document.all.new_alias.focus();
		alert("<?=$Mem_Input?><?=$Mem_Name?>!!");
		return false;
	}
	close_win();
	return true;
}

function ChkData(i){

	e_user="document.AG_"+i+".e_user.value";
	e_pass="document.AG_"+i+".e_pass.value";
	e_alias="document.AG_"+i+".e_alias.value";
	if(e_user=='')
	{
		alert('<?=$Mem_Input?><?=$Mem_Account?>');
		eval("document.AG_"+i+".e_user.focus()");
		return false;
	}
	if(e_pass=='')
	{
		alert('<?=$Mem_Input?><?=$Mem_Password?>');
		eval("document.AG_"+i+".e_pass.focus()");
		return false;
	}
	if(e_alias=='')
	{
		alert('<?=$Mem_Input?><?=$Mem_Name?>');
		eval("document.AG_"+i+".e_alias.focus()");
		return false;
	}	
	eval("document.AG_"+i+".submit()");
	return true;
}

function CheckDEL(str)
{
 if(confirm("<?=$Mem_Confirm?><?=$Mem_Delete?><?=$Mem_Account?>?"))
  document.location=str;
}

function CheckSUSPEND(str)
{
 if(confirm("<?=$Mem_Confirm?><?=$Mem_Disable?>/<?=$Mem_Enable?>?"))
  document.location=str;
}
function onLoad() {
    var obj_page = document.getElementById('page');
    obj_page.value = '<?=$page?>';
    var obj_sort=document.getElementById('sort');
    obj_sort.value='<?=$sort?>';
    var obj_orderby=document.getElementById('orderby');
    obj_orderby.value='<?=$orderby?>';
}
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()"; onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name="myFORM" action="subuser.php?&uid=<?=$uid?>&level=<?=$level?>&langx=<?=$langx?>" method=POST>
<tr> 
    <td width="100%" class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr> 
            <td>&nbsp;&nbsp;<?=$Mem_radio_Order_by?>:</td>
            <td> 
              <select name="sort" onChange="self.myFORM.submit();" class="za_select">
               <option label="<?=$Mem_Account?>" value="USERNAME" selected="selected"><?=$Mem_Account?></option>
               <option label="<?=$Mem_Add?><?=$Mem_Date?>" value="ADDDATE"><?=$Mem_Add?><?=$Mem_Date?></option>

              </select>
              <select name="orderby" onChange="self.myFORM.submit()" class="za_select">
               <option label="<?=$Mem_ASC?>" value="ASC" selected="selected"><?=$Mem_ASC?></option>
               <option label="<?=$Mem_DESC?>" value="DESC"><?=$Mem_DESC?></option>
              </select>
            </td>
            <td >-- <?=$Mem_Totalpage?> :</td>
            <td > 
              <select name="page" onChange="self.myFORM.submit()" class="za_select">
              <?
		      for($i=0;$i<$page_count;$i++){
			      echo "<option value='$i'>".($i+1)."</option>";
		         }
		      ?>              </select>
            </td>
            <td > / <?=$page_count?>  <?=$Mem_Page?>  -- </td>            
            <td> 
              <input type=BUTTON name="append" value="<?=$Mem_Add?>" onClick="show_win();" class="za_button">
            </td>
          </tr>
        </table>
    </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</form>
</table>


<table width="867" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
  <tr class="m_title"> 
    <td width="150"><?=$Mem_Account?></td>
    <td width="150"><?=$Mem_Password?></td>
    <td width="150"><?=$Mem_Name?></td>
    <td width="150"><?=$Mem_Date?></td>
    <td width="80"><?=$Mem_Account?><?=$Mem_Status?></td>
    <td width="180"><?=$Mem_Function?></td>
  </tr>
<?
$cou=mysql_num_rows($result);
if ($cou==0){
?>    
     <FORM NAME="AG_<?=$row['ID']?>" ACTION="" METHOD=POST target='_self'>
     <INPUT TYPE="HIDDEN" NAME="id" value="<?=$row['ID']?>">
     <INPUT TYPE="HIDDEN" NAME="edituser" value="Y">

    <tr  class="m_cen" > 
      <td> 
        <font color="Black"><?=substr($name,0,1)?></font><input type="text" name="e_user" value="<?=$sub_message?>" size="8" class="za_text" >      </td>
      <td> 
        <input type="text" name="e_pass" value="" size="8" class="za_text">      </td>
      <td> 
        <input type="text" name="e_alias" value="" size="8" class="za_text">      </td>
      <td></td>
      <td align="left"></td>
      <td align="left"></td>
    </tr>
	</FORM>
<?
}else{
while ($row = mysql_fetch_array($result)){
?> 
     <FORM NAME="AG_<?=$row['ID']?>" ACTION="" METHOD=POST target='_self'>
     <INPUT TYPE="HIDDEN" NAME="id" value="<?=$row['ID']?>">
     <INPUT TYPE="HIDDEN" NAME="edituser" value="Y">
    <tr  class="m_cen" > 
      <td> 
        <font color="Black"><?=substr($name,0,1)?></font><input type="text" name="e_user" value="<?=substr($row['UserName'],1,strlen($row['UserName']))?>" size="8" class="za_text" >
     </td>
      <td> 
        <input type="text" name="e_pass" value="<?=$row['PassWord']?>" size="8" class="za_text">      </td>
      <td> 
        <input type="text" name="e_alias" value="<?=$row['Alias']?>" size="8" class="za_text">      </td>
      <td><?=$row['AddDate']?></td>
      <td>
<?
if ($row['Status']==2){
?> 
		<SPAN STYLE='background-color: Red;'><?=$Mem_Disable?></SPAN>
<?
}else{
?>
		<?=$Mem_Enable?>
<?
}
?> 
	  </td>
      <td align="left">
	  <a onClick="javascript:ChkData('<?=$row['ID']?>')" style="cursor:hand;"><?=$Mem_Edit?></a> / 
<?
if ($row['Status']==0){
?>
	  <a href="javascript:CheckSUSPEND('subuser.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&suspend=N&id=<?=$row['ID']?>&username=<?=$row['UserName']?>')"><?=$Mem_Disable?></a> / 
<?
}else if ($row['Status']==2){
?>
	  <a href="javascript:CheckSUSPEND('subuser.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&suspend=Y&id=<?=$row['ID']?>&username=<?=$row['UserName']?>')"><?=$Mem_Enable?></a> / 
<?
}
?>	
      <a href="competence.php?uid=<?=$uid?>&langx=<?=$langx?>&id=<?=$row['ID']?>&username=<?=$row['UserName']?>">权限</a> /
	  <a href="javascript:CheckDEL('subuser.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&deluser=Y&id=<?=$row['ID']?>&username=<?=$row['UserName']?>')"><?=$Mem_Delete?></a> /</td>
    </tr>
  </FORM>
<?
}
}
?>
</table>
<div id=acc_window style="display: none;position:absolute">
  <FORM name="addUSER" action="" method=post target="_self" onSubmit="return Chk_acc();">
<table width="200" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
  <tr>
    <td bgcolor="#FFFFFF"><table width="200" border="0" cellspacing="0" cellpadding="0" bgcolor="#A4C0CE" class="m_tab_fix" >
      <tr bgcolor="0163A2">
        <td  id=r_title width="116" ><font color="#FFFFFF"><?=$Mem_Add?><?=$Mem_User?></font></td>
        <td  align="right" valign="top" ><a style="cursor:hand;" onClick="close_win();"><img src="/images/agents/top/edit_dot.gif" width="16" height="14"></a></td>
      </tr>
      <tr>
        <td colspan="2" height="1" bgcolor="#000000"></td>
      </tr>
      <tr>
        <td align="center" ><?=$Mem_Account?>&nbsp;&nbsp;<font color="Black"><?=substr($name,0,1)?></font>&nbsp;</td>
        <td ><input type=text name=new_user value="" class="za_text" size="12" maxlength="10"></td>
      </tr>
      <tr bgcolor="#000000">
        <td colspan="2" height="1"></td>
      </tr>
      <tr>
        <td align="center" ><?=$Mem_Password?>&nbsp;&nbsp; &nbsp;</td>
        <td ><input type=text name=new_pass value="" class="za_text" size="12" maxlength="10"></td>
      </tr>
      <tr bgcolor="#000000">
        <td colspan="2" height="1"></td>
      </tr>
      <tr>
        <td align="center" ><?=$Mem_Name?>&nbsp;&nbsp; &nbsp;</td>
        <td ><input type=text name=new_alias value="" class="za_text" size="12" maxlength="10"></td>
      </tr>
      <tr bgcolor="#000000">
        <td colspan="2" height="1"></td>
      </tr>
      <tr>
        <td colspan="2">◎<?=$Mem_Password_Guidelines?>：<?=$Mem_Pasread?></td>
      </tr>
      <tr bgcolor="#000000">
        <td colspan="2" height="1"></td>
      </tr>
      <tr align="center">
        <td colspan="2" ><input type=submit name=acc_ok value="<?=$Mem_Confirm?>" class="za_button">
              <input type="hidden" name="addNew" value="Y">        </td>
      </tr>
    </table></td>
  </tr>
</table>
  </FORM>
</div>
<!----------------------結帳視窗---------------------------->
</body>
</html>
<?
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$name',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>