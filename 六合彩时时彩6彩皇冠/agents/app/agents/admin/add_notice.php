<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'\n;</script>";
require ("../include/config.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];
//include ("../include/online.php");
require ("../include/traditional.$langx.inc.php");

$sql = "select UserName from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$username=$row['UserName'];

$id=$_REQUEST['id'];
$action=$_REQUEST['action'];
$level=$_REQUEST['level'];
$date_start=$_REQUEST['date_start'];

if ($action==1){
	$msg=$_REQUEST['msg_system'];
	$msg_tw=$_REQUEST['msg_system_tw'];
	$msg_en=$_REQUEST['msg_system_en'];
	$date=date('y-m-d');
	$time=$_REQUEST['ntime'];	
	$m=$_REQUEST['member'];
	$d=$_REQUEST['agents'];
	$c=$_REQUEST['world'];
	$b=$_REQUEST['corprator'];
	$a=$_REQUEST['super'];

	if ($m==1){
		$mysql="insert into web_marquee_data (Level,Message,Message_tw,Message_en,Time,Date,Admin) values ('MEM','$msg','$msg_tw','$msg_en','$time','$date','$username')";
		mysql_db_query($dbname,$mysql);
	}
	if ($d==1){
		$mysql="insert into web_marquee_data (Level,Message,Message_tw,Message_en,Time,Date,Admin) values ('D','$msg','$msg_tw','$msg_en','$time','$date','$username')";
		mysql_db_query($dbname,$mysql);
	}
	if ($c==1){
		$mysql="insert into web_marquee_data (Level,Message,Message_tw,Message_en,Time,Date,Admin) values ('C','$msg','$msg_tw','$msg_en','$time','$date','$username')";
		mysql_db_query($dbname,$mysql);
	}
	if ($b==1){
		$mysql="insert into web_marquee_data (Level,Message,Message_tw,Message_en,Time,Date,Admin) values ('B','$msg','$msg_tw','$msg_en','$time','$date','$username')";
		mysql_db_query($dbname,$mysql);
	}
	if ($a==1){
		$mysql="insert into web_marquee_data (Level,Message,Message_tw,Message_en,Time,Date,Admin) values ('A','$msg','$msg_tw','$msg_en','$time','$date','$username')";
		mysql_db_query($dbname,$mysql);
	}
}

if ($level==''){
	$level='MEM';
}
if ($date_start=='') {
	$date_start=date('Y-m-d');
}
$date=$_REQUEST['date'];
$message=$_REQUEST['message'];
$message_tw=$_REQUEST['message_tw'];
$message_en=$_REQUEST['message_en'];

if ($_POST['update']){
	$mysql="update web_marquee_data set Date='$date',Message='$message',Message_tw='$message_tw',Message_en='$message_en' where id='$id'";
	$result=mysql_db_query($dbname,$mysql);			
}
if ($_POST['delete']){
	$mysql="delete from web_marquee_data where ID='$id'";
	mysql_db_query($dbname,$mysql);
}
$sql = "select * from web_system_data";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language=javascript>
function SubChk(){
  if (document.all.msg_system.value==''){
    document.all.msg_system.focus();
    alert("请输入简体公告!!");
    return false;
  }
  if (document.all.msg_system_tw.value==''){
    document.all.msg_system_tw.focus();
    alert("请输入繁体公告!!");
    return false;
  }
  if (document.all.msg_system_en.value==''){
    document.all.msg_system_en.focus();
    alert("请输入英文公告!!");
    return false;
  }
  if(!confirm("简体公告："+document.all.msg_system.value+"\n\n繁体公告："+document.all.msg_system_tw.value+"\n\n英文公告："+document.all.msg_system_en.value+"\n\n请确定输入是否正确?")){return false;}
}
function onLoad(){
  var gtype = document.getElementById('level');
  gtype.value = '<?=$level?>';
}
</script>
</head>
<body obgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<form name="MYFORM"  onSubmit="return SubChk();" action="add_notice.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&action=1" method=post>
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
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">

    <TR class="m_title"> 
      <td width=50>语种</td>
      <td width=925>公告内容</td>
    </TR>
    <TR class=m_cen> 
      <td align=center>简体</td>
      <td align=left><input class=za_text  maxLength=500 size=180 value="<?=$row['Msg_System']?>" name=msg_system></td>
    </TR>
    <TR class=m_cen> 
      <td align=center>繁体</td>
      <td align=left><input class=za_text  maxLength=500 size=180 value="<?=$row['Msg_System_tw']?>" name=msg_system_tw></td>
    </TR>
    <TR class=m_cen> 
      <td align=center>英文</td>
      <td align=left><input class=za_text  maxlength=500 size=180 value="<?=$row['Msg_System_en']?>" name=msg_system_en></td>
    </TR>
    <TR class=m_cen>
      <td align=center>发布时间</td>
      <td align=left><input class=za_text  maxlength=16 size=18 value="<?=date('Y-m-d H:i:s')?>" name=ntime></td>
    </TR>
    <TR class=m_cen> 
      <td align=center>选项</td>
      <td align=right><div align="left">
	      会员 
          <input name="member" type="checkbox" value="1" checked>
          代理 
          <input name="agents" type="checkbox" value="1">
          总代理 
          <input name="world" type="checkbox" value="1">
          股东 
          <input name="corprator" type="checkbox" value="1">
		  公司 
          <input name="super" type="checkbox" value="1">
        </div></td>
    </TR>
    <TR class=m_cen> 
      <td></td>
      <td >
          <input class=za_button type=submit value="提交" name=cmdsubmit>
          <input class=za_button type=reset value="取消" name=cmdcancel></td>
    </TR>
	
  </table>
</form>  
<br>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
	<tr class="m_title">
<form name="FrmData" method="post" action="add_notice.php?uid=<?=$uid?>&level=<?=$level?>&date_start=<?=$date_start?>&langx=<?=$langx?>">	
	   <td colspan="5" align="center">线上数据－<font color="#CC0000">公告管理&nbsp;</font>
	   <select class=za_select onchange=document.FrmData.submit(); name=level>
          　<option value="MEM">会员</option>
			<option value="D">代理</option>
			<option value="C">总代理</option>
			<option value="B">股东</option>
			<option value="A">公司</option>
	    </select>
		<select class=za_select onchange=document.FrmData.submit(); name=date_start>
				<option value=""></option> 
<?
$dd = 24*60*60;
$t = time();
$aa=0;
$bb=0;
for($i=0;$i<=10;$i++)
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
		</td>
		</form>
	</tr>
	<tr class="m_title">
	  <td>日期</td>
	  <td>简体訊息</td>
	  <td width="227">简体訊息</td>
	  <td width="227">简体訊息</td>
	  <td width="163">功能</td>
	</tr>
<?
$sql = "select ID,Date,Message,Message_tw,Message_en,Level,Time from web_marquee_data where Level='$level' and Date='$date_start' order by ID desc";
$result = mysql_db_query($dbname, $sql);
while ($row = mysql_fetch_array($result)){
?>

  <tr bgcolor="#FFFFFF"> 
<form name="FrmSubmit" method="post" action="add_notice.php?uid=<?=$uid?>&id=<?=$row['ID']?>&level=<?=$level?>&date_start=<?=$date_start?>&langx=<?=$langx?>">     
    <td width="87" align="center"><input name="date" type="text" id="date" value="<?=$row['Date']?>" maxlength=10 size="6"></td>
    <td width="245" align="center"><textarea name="message" cols="30" rows="5" id="message"><?=trim($row['Message'])?></textarea></td>
    <td align="center"><textarea name="message_tw" cols="30" rows="5" id="message"><?=trim($row['Message_tw'])?></textarea></td>
    <td align="left"><textarea name="message_en" cols="30" rows="5" id="message"><?=trim($row['Message_en'])?></textarea></td>
    <td width="163" align="center"><input class=za_button name="update" type="Submit" id="update" value="更新"><br><br><input class=za_button name="delete" type="Submit" id="delete" value="删除"><input name="id" type="hidden" id="id" value="<?=$row['ID']?>"></td>
</form> 
  </tr>
<?
}
?>  
</table>
</body>
</html>
