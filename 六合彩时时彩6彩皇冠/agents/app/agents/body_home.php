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

$uid=$_REQUEST['uid'];
$lv=$_REQUEST['lv'];
$langx=$_SESSION['langx'];

if ($lv=='M'){
    $data='web_system_data';
}else{
    $data='web_agents_data';
}
include ("./include/online.php");
require ("./include/traditional.$langx.inc.php");

$sql = "select * from $data where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}else{
$row = mysql_fetch_array($result);
$username=$row['UserName'];
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >
  <tr> 
    <td width="160" align="right"><?=$Notice?>：</td>
    <td ><marquee scrollDelay=200 onMouseOver='this.stop()' onMouseOut='this.start()'><a href="other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>"  onMouseEnter=marquee_str.style.color='#FF0000' onMouseLeave=marquee_str.style.color='#000000'><div id="marquee_str" style='color:#000000;font-weight: normal'><?=$Mem_msg?></div></a></marquee></td>
     <td width="70" align="right"><a href="other_set/show_marquee.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>">歷史訊息</a></td>
  </tr>
  <tr align="center" > 
    <td colspan="3" bgcolor="6EC13E">&nbsp; </td>
  </tr>
</table>
<br>
<br>
<table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >
  <tr> 
    <td width="160" align="right">會員公告：</td>
    <td ><marquee scrollDelay=200 onMouseOver='this.stop()' onMouseOut='this.start()'><a href="other_set/show_marquee.php?uid=<?=$uid?>&lv=MEM&langx=<?=$langx?>"  onMouseEnter=marquee_str_m.style.color='#FF0000' onMouseLeave=marquee_str_m.style.color='#000000'><div id="marquee_str_m" style='color:#000000;font-weight: normal'><?=$Mem_msg?></div></a></marquee></td>
     <td width="70" align="right"><a href="other_set/show_marquee.php?uid=<?=$uid?>&lv=MEM&langx=<?=$langx?>">歷史訊息</a></td>
  </tr>
</table>
</body>
</html>
<?
$sql = "select Message,Message_tw,Message_en from web_message_data where UserName='$username'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
   $sql='select Msg_Member,Msg_Member_tw,Msg_Member_en,Msg_Agents,Msg_Agents_tw,Msg_Agents_en,Msg_World,Msg_World_tw,Msg_World_en,Msg_Corprator,Msg_Corprator_tw,Msg_Corprator_en,Msg_Super,Msg_Super_tw,Msg_Super_en,Msg_Member_Alert,Msg_Agents_Alert,Msg_World_Alert,Msg_Corprator_Alert,Msg_Super_Alert from web_system_data';
   $result = mysql_db_query($dbname,$sql);
   $row = mysql_fetch_array($result);
   if($lv=='A'){
      switch($langx){
             case 'gb':
	             $talert=$row['Msg_Super'];
	             break;
	         case 'big5':
	             $talert=$row['Msg_Super_tw'];
	             break;
	         case 'en-us':
	             $talert=$row['Msg_Super_en'];
	             break;
      }
      if ($row['Msg_Super_Alert']==1 and $talert!=''){	
	      echo "<script>alert('$talert');</script>";
      }
   }else if($lv=='B'){
      switch($langx){
             case 'gb':
	             $talert=$row['Msg_Corprator'];
	             break;
	         case 'big5':
	             $talert=$row['Msg_Corprator_tw'];
	             break;
	         case 'en-us':
	             $talert=$row['Msg_Corprator_en'];
	             break;
      }
      if ($row['Msg_Corprator_Alert']==1 and $talert!=''){	
	      echo "<script>alert('$talert');</script>";
      }
   }else if($lv=='C'){
      switch($langx){
             case 'gb':
	             $talert=$row['Msg_World'];
	             break;
	         case 'big5':
	             $talert=$row['Msg_World_tw'];
	             break;
	         case 'en-us':
	             $talert=$row['Msg_World_en'];
	             break;
      }  
      if ($row['Msg_World_Alert']==1 and $talert!=''){	
	      echo "<script>alert('$talert');</script>";
      } 
   }else if($lv=='D'){
      switch($langx){
             case 'gb':
	             $talert=$row['Msg_Agents'];
	             break;
	         case 'big5':
	             $talert=$row['Msg_Agents_tw'];
	             break;
	         case 'en-us':
	             $talert=$row['Msg_Agents_en'];
	             break;
      } 
      if ($row['Msg_Agents_Alert']==1 and $talert!=''){	
	      echo "<script>alert('$talert');</script>";
      }
   }

}else{
	switch($langx){
	case 'gb':
		$talert=$row['Message'];
		break;
	case 'big5':
		$talert=$row['Message_tw'];
		break;
	case 'en_us':
		$talert=$row['Message_en'];
		break;
	}
	if ($talert!=''){	
		echo "<script>alert('$talert');</script>";
	}	
}
}
$ip_addr = get_ip();
$loginfo='查询公告';
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$username',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
mysql_close();
?>
